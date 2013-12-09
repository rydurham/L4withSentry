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

    /**
     * INDEX
     *
     */
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

    /**
     * CREATE
     *
     */
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

    /**
     * SHOW
     *
     */
    public function testUserControllerShowValidUserAsGuest()
    {
        $this->beGuest();
        $this->call('get', URL::action('UserController@show', array('2')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerShowValidUserAsUser()
    {
        $this->beUser();
        $this->call('get', URL::action('UserController@show', array('2')));
        $this->assertResponseOk();
    }

    public function testUserControllerShowValidUserAsAdmin()
    {
        $this->beAdmin();
        $this->call('get', URL::action('UserController@show', array('2')));
        $this->assertResponseOk();
    }

    public function testUserControllerShowInvalidUserAsGuest()
    {
        $this->beGuest();
        $this->call('get', URL::action('UserController@show', array('3')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerShowInvalidUserAsUser()
    {
        $this->beUser();
        $this->call('get', URL::action('UserController@show', array('3')));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('error','You are not allowed to do that.');
    }

    public function testUserControllerShowInvalidUserAsAdmin()
    {
        $this->beAdmin();
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
        $this->call('get', URL::action('UserController@show', array('3')));
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

    /**
     * DESTROY
     *
     */
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

    /**
     * EDIT
     *
     */
    public function testUserControllerEditValidIdAsGuest()
    {
        $this->beGuest();
        $this->call('get', URL::action('UserController@edit', array('2')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerEditValidIdAsUser()
    {
        $this->beUser();
        $this->call('get', URL::action('UserController@edit', array('1')));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('error','You are not allowed to do that.');
    }

    public function testUserControllerEditValidIdAsAdmin()
    {
        $this->beAdmin();
        $crawler = $this->client->request('get', URL::action('UserController@edit', array('2')));
        $this->assertResponseOk();
        $this->assertCount(1, $crawler->filter('h4:contains("user@user.com")'));
    }

    public function testUserControllerEditInvalidIdAsGuest()
    {
        $this->beGuest();
        $this->call('get', URL::action('UserController@edit', array('3')));
        $this->assertRedirectedToRoute('login');
    }

    public function testUserControllerEditInvalidIdAsUser()
    {
        $this->beUser();
        $this->call('get', URL::action('UserController@edit', array('3')));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('error','You are not allowed to do that.');
    }

    public function testUserControllerEditInvalidIdAsAdmin()
    {
        $this->beAdmin();
        $this->setExpectedException('Symfony\Component\HttpKernel\Exception\NotFoundHttpException');
        $this->call('get', URL::action('UserController@edit', array('3')));
    }
    
    /**
     * STORE
     *
     */
    public function testUserControllerStoreBadCSRFTokenAsGuest()
    {
        $this->setExpectedException('Illuminate\Session\TokenMismatchException');
        $this->beGuest();
        $this->call('post', URL::action('UserController@store'));
    }

    public function testUserControllerStoreBadCSRFTokenAsUser()
    {
        $this->setExpectedException('Illuminate\Session\TokenMismatchException');
        $this->beUser();
        $this->call('post', URL::action('UserController@store'));
    }

    public function testUserControllerStoreBadCSRFTokenAsAdmin()
    {
        $this->setExpectedException('Illuminate\Session\TokenMismatchException');
        $this->beAdmin();
        $this->call('post', URL::action('UserController@store'));
    }

    public function testUserControllerStoreInvalidBlankInputAsGuest()
    {
        $this->beGuest();
        $this->call('post', URL::action('UserController@store'), array('IgnoreCSRFTokenError' => true));
        $this->assertRedirectedToAction('UserController@create');
        $this->assertSessionHasErrors();
    }

    public function testUserControllerStoreInvalidBlankInputAsUser()
    {
        $this->beUser();
        $this->call('post', URL::action('UserController@store'), array('IgnoreCSRFTokenError' => true));
        $this->assertRedirectedToAction('UserController@create');
        $this->assertSessionHasErrors();
    }

    public function testUserControllerStoreInvalidBlankInputAsAdmin()
    {
        $this->beAdmin();
        $this->call('post', URL::action('UserController@store'), array('IgnoreCSRFTokenError' => true));
        $this->assertRedirectedToAction('UserController@create');
        $this->assertSessionHasErrors();
    }

    public function testUserControllerStoreValidAsGuest()
    {
        $this->beGuest();
        Input::replace($input = array(
            'IgnoreCSRFTokenError' => true,
            'email' => 'test@test.com',
            'password' => 'testtest',
            'password_confirmation' => 'testtest'
        ));

        $userSignupEventFired = false;
        Event::listen('user.signup', function() use (&$userSignupEventFired) {
            $userSignupEventFired = true;
        });

        $this->call('post', URL::action('UserController@store'), $input);

        $this->assertTrue($userSignupEventFired, 'The user.signup event never fired during UserController@store');
        $this->assertRedirectedToRoute('home');
    }

}