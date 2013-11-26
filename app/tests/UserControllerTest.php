<?php

class UserControllerTest extends TestCase {

    public function setUp() {
        
        // Call the parent setup method
        parent::setUp();

    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
    * Test the two basic user types
    *
    */
    public function testBasicUserTypes() 
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
    }

    public function testUserControllerIndexAsGuest()
    {
        $this->beGuest();
        $this->call('GET', URL::action('UserController@index'));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerIndexAsUser()
    {
        $this->beUser();
        $this->call('GET', URL::action('UserController@index'));
        $this->assertRedirectedToRoute('home');
    }

    public function testUserControllerIndexAsAdmin()
    {
        $this->beAdmin();
        $this->call('GET', URL::action('UserController@index'));
        $this->assertResponseOk();
    }

    public function testUserControllerCreateAsGuest()
    {
        $this->beGuest();
        $this->call('get', URL::action('UserController@create'));
        $this->assertResponseOk();
    }

    public function testUserControllerCreateAsUser()
    {
        $this->beUser();
        $this->call('get', URL::action('UserController@create'));
        $this->assertResponseOk();
    }

    public function testUserControllerCreateAsAdmin()
    {
        $this->beAdmin();
        $this->call('get', URL::action('UserController@create'));
        $this->assertResponseOk();
    }

    public function testUserControllerShowUserAsGuest()
    {
        $this->beGuest();
        $this->call('get', URL::action('UserController@show', array('2')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerShowUserAsUser()
    {
        $this->beUser();
        $this->call('get', URL::action('UserController@show', array('2')));
        $this->assertResponseOk();
    }

    public function testUserControllerShowUserAsAdmin()
    {
        $this->beAdmin();
        $this->call('get', URL::action('UserController@show', array('2')));
        $this->assertResponseOk();
    }

    public function testUserControllerShowAdminAsGuest()
    {
        $this->beGuest();
        $this->call('get', URL::action('UserController@show', array('1')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerShowAdminAsUser()
    {
        $this->beUser();
        $this->call('get', URL::action('UserController@show', array('1')));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('error','You are not allowed to do that.');
    }

    public function testUserControllerShowAdminAsAdmin()
    {
        $this->beAdmin();
        $this->call('get', URL::action('UserController@show', array('1')));
        $this->assertResponseOk();
    }

    public function testUserControllerDestroyInvalidIdAsGuest()
    {
        $this->beGuest();
        $this->call('delete', URL::action('UserController@destroy', array('-1')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerDestroyInvalidIdAsUser()
    {
        $this->beUser();
        $this->call('delete', URL::action('UserController@destroy', array('-1')));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('error','You are not allowed to do that.');
    }

    public function testUserControllerDestroyInvalidIdAsAdmin()
    {
        $this->beAdmin();
        $this->call('delete', URL::action('UserController@destroy', array('-1')));
        $this->assertRedirectedToAction('UserController@index');
        $this->assertSessionHas('error','Unable to Delete User');
    }

    public function testUserControllerDestroyValidIdAsGuest()
    {
        $this->beGuest();
        $this->call('delete', URL::action('UserController@destroy', array('2')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerDestroyValidIdAsUser()
    {
        $this->beUser();
        $this->call('delete', URL::action('UserController@destroy', array('1')));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('error','You are not allowed to do that.');
    }

    public function testUserControllerDestroyValidIdAsAdmin()
    {
        $this->beAdmin();
        $this->call('delete', URL::action('UserController@destroy', array('2')));
        $this->assertRedirectedToAction('UserController@index');
        $this->assertSessionHas('success','User Deleted');
    }


}