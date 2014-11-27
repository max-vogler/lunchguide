<?php

use \SammyK\FacebookQueryBuilder\FacebookQueryBuilderException;
use \SammyK\FacebookQueryBuilder\FQB;

/**
 * A simple representation of a Facebook page.
 * 
 * @property int $id The internal ID
 * @property int $fb_page_id the Facebook page ID
 * @property int $fb_access_token the Facebook page access token
 * @property int $user The associated administrator
 * @property int $user_id The internal user ID of the associated administrator
 * 
 * @author Max Vogler
 */
class FbPage extends Eloquent {

    private $facebook_data = null;

    protected $hidden = ['fb_access_token'];

    /**
     * @return Builder QueryBuilder for the associated administrator
     */
    public function user() {
        return $this->belongsTo('User');
    }

    /**
     * @return null|string The Facebook name, if a valid access token is present
     */
    public function getName() {
        return $this->getFacebookData()['name'];
    }

    /**
     * @return boolean Checks if permissions for posting are present.
     */
    public function hasValidPermissions() {
        // TODO: Check if access token provides posting permissions
        return (boolean) $this->getFacebookData();
    }

    /**
     * Loads and assigns the Facebook id to this FbPage, if a valid access token is present.
     * $page->save() still needs to be called in order to persist the ID.
     */
    public function loadFacebookId() {
        $this->fb_page_id = $this->getFacebookData()['id'];
        return $this->fb_page_id;
    }

    /**
     * Posts the supplied message to the Facebook page.
     *
     * @param string $message
     * @return Post
     */
    public function postMessage($message) {
        // Set FQB access token
        $this->getFacebookData();

        $fqb = new FQB;
        return $fqb->object('me/feed')->with(['message' => $message])->post();
    }

    /**
     * Posts the supplied message and image to the Facebook page.
     *
     * @param string $message
     * @param string $imageFile
     * @return Post
     */
    public function postMessageWithImage($message, $imageFile) {
        // Set FQB access token
        $this->getFacebookData();

        $fqb = new FQB;
        return $fqb->object('me/photos')->with([
            'source' => new CURLFile($imageFile), 
            'message' => $message
        ])->post();
    }

    protected function getFacebookData() {
        try {
            if(! $this->facebook_data && $this->fb_access_token) {
                Facebook::setAccessToken($this->fb_access_token);
                FQB::setAccessToken($this->fb_access_token);

                $this->facebook_data = (new FQB())->object('me')->fields('id, name')->get();
            }
        } catch(FacebookQueryBuilderException $exception) {
            $this->facebook_data = null;
        }

        return $this->facebook_data;
    }

}
