<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * by default exception handling is disabled
     */
    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }

    /**
     * accespts or creaates a new user and signs him/her in
     * @param  [type] $user [description]
     */
    public function signIn($user = null)
    {
    	$user = $user ?: factory('App\User')->create();
    	$this->be($user);
    }

    /**
     * disables exception handling for an api call
     */
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }

    /**
     * calls an api with exception handling
     * @return $this
     */
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }

}
