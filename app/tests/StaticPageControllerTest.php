<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StaticPageControllerTest extends TestCase {

    public function testIndex() {
        $response = $this->call('GET', '/');
        $this->assertTrue($response->isOk() || $response->isRedirect());
    }

    public function test404() {
        try {
            $this->call('GET', '/a-page-that-does-not-exist-for-shure');
            $this->fail();
        } catch(NotFoundHttpException $e) {
            // success!
        }
    }
}