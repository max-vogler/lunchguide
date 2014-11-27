<?php

/**
 * A controller for static pages, like "imprint", "privacy" and "about".
 * 
 * @author Max Vogler
 */
class StaticPageController extends BaseController {

    /**
     * When calling the main url "/", the user is being redirected to today's menu.
     */
    public function index() {
        return Redirect::action('DailyMenuController@today');
    }

    /**
     * Displays static pages, like "imprint" or "privacy".
     * 
     * All templates from /views/static/ can be displayed, e.g.
     * GET /imprint tries to display /views/static/imprint.*
     */
    public function display($page) {
        if(in_array($page, $this->getPages())) {
            return Response::view("static.$page", []);
        } else {
            App::abort(404);
        }
    }

    protected function getPages() {
        return array_map(function ($file) {
            $parts = explode('.', basename($file));
            return $parts[0];
        }, glob(app_path() . '/views/static/*'));
    }

}
