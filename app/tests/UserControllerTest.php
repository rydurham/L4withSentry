<?php

class UserControllerTest extends TestCase {

    public function setUp() {
        
        // Call the parent setup method
        parent::setUp();

        // Let mockery know what we're going to mock
        //$this->mock = Mockery::mock('User');
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
    * Test the two basic user types
    *
    */
    /* public function testBasicUserTypes() 
    {
        $this->assertTrue(Sentry::getUser() == NULL, 'User should not be logged in initially.');
        
        $admin = Sentry::findUserByLogin('admin@admin.com');
        $this->assertTrue($admin != NULL, 'Admin account not found.');

        $user = Sentry::findUserByLogin('user@user.com');
        $this->assertTrue($user != NULL, 'User account not found.');

        Sentry::setUser($user);
        $this->assertTrue(Sentry::check(),'User not logged in.');

        Sentry::setUser($admin);
        $this->assertTrue(Sentry::check(),'Admin not logged in.');

        Sentry::logout();
    } */

    public function testUserControllerIndexAsUser()
    {
        $this->beUser();
        $response = $this->call('GET', URL::action('UserController@index'));
        $this->assertRedirectedToRoute('home');
    }

    public function testUserControllerIndexAsAdmin()
    {
        $this->beAdmin();
        $this->call('GET', URL::action('UserController@index'));
        $this->assertResponseOk();
    }    

    public function testUserControllerCreate()
    {
        $this->call('get', URL::action('UserController@create'));
    }

}