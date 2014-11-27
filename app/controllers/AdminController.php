<?php

use \SammyK\FacebookQueryBuilder\FacebookQueryBuilderException;
use SammyK\FacebookQueryBuilder\FQB;
use Symfony\Component\Console\Output\BufferedOutput;

class AdminController extends BaseController {

    public function __construct() {
        if($this->hasAccessToken()) {
            Facebook::setAccessToken(Auth::user()->access_token);
            FQB::setAccessToken(Auth::user()->access_token);
        }
    }

    protected function hasAccessToken() {
        return Auth::check() && Auth::user()->access_token;
    }

    public function dashboard() {
        return Response::view('admin.dashboard');
    }

    public function facebook() {
        $pages = FbPage::orderBy('updated_at', 'desc')->get();;

        return Response::view('admin.facebook', [
            'fb_login_url' => Facebook::getLoginUrl(),
            'pages' => $pages
        ]);
    }

    public function facebookAfterRedirect() {
        try {
            $token = Facebook::getTokenFromRedirect();

            if(!$token) {
                return Redirect::action('AdminController@facebook')->withError('Cannot get token.');
            }

            if (!$token->isLongLived()) {
                // Extend the short-lived token
                $token = $token->extend();
            }

            Facebook::setAccessToken($token);
            FQB::setAccessToken($token);

            $fb = (new FQB())->object('me')->fields('id, name, accounts')->get();
            $selectablePages = [];
            $unselectablePages = [];

            foreach($fb['accounts'] as $page) {
                if(array_search('CREATE_CONTENT', $page['perms']->toArray()) !== false) {
                    $selectablePages[$page['access_token']] = $page['name'];
                } else {
                    $unselectablePages[$page['access_token']] = $page['name'];
                }
            }

            return Response::view('admin.facebook-select-page', [
                'pages' => $selectablePages,
                'unselectablePages' => $unselectablePages
            ]);
        } catch (FacebookQueryBuilderException $e) {
            return Redirect::action('AdminController@facebook')->withError($e->getMessage());
        }
    }

    public function facebookSelectPage() {
        if(Input::has('fb_access_token')) {
            $page = new FbPage;
            $page->fb_access_token = Input::get('fb_access_token');
            $page->loadFacebookId();

            $existing = FbPage::where('fb_page_id', '=', $page->fb_page_id)->first();
            if($existing) {
                $existing->fb_access_token = $page->fb_access_token;
                $page = $existing;
            }

            $page->user_id = Auth::user()->id;

            if($page->save()) {
                return Redirect::action('AdminController@facebook');
            }
        }

        return Redirect::back();
    }

}
