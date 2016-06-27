<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RootTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testAPIRoot()
    {
        $this->visit('/')
            ->see('Welcome!')
            ->dontSee('Laravel 5');
    }
}
