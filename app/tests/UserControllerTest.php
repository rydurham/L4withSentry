<?php

class UserControllerTest extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->mock = Mockery::mock('User');

    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testUserCreateViewMake()
    {
        // Our first test!
        $this->call('get', URL::action('UserController@create'));
    }

}