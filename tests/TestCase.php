<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use CreatesApplication, TestHelpers, DetectRepeatedQueries;

    protected $defaultData;

    protected function setUp() : void
    {
        parent::setUp();
        $this->addTestResponseMacros();
        $this->withoutExceptionHandling();

        $this->enableQueryLog();
    }

    protected function tearDown() : void
    {
        $this->flushQueryLog();
        parent::tearDown();
    }

    public function addTestResponseMacros() :void
    {
        TestResponse::macro('viewData', function ($key) {
            $this->ensureResponseHasView();

            $this->assertViewHas($key);

            return $this->original->$key;
        });

        TestResponse::macro('assertViewCollection', function ($var) {
            return new TestCollectionData($this->viewData($var));
        });
    }
}
