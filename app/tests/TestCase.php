<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    protected $useDatabase = true;

	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	/**
    * Set up function for all tests
    *
    */
    public function setUp()
    {
        parent::setUp();

        if($this->useDatabase)
        {
            $this->setUpDb();
        }
        // To test auth, we must re-enable filters on the routes
        // By default, filters are disabled in testing
        Route::enableFilters();
    }

    /**
    * Tear down function for all tests
    *
    */
    public function teardown()
    {
        Mockery::close();
        Sentry::logout();
        Session::flush();
    }

    /**
    * Set up the database for tests
    *
    */
    public function setUpDb()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
    * Tear down the database for tests
    *
    */
    public function teardownDb()
    {
        Artisan::call('migrate:reset');
    }

    /**
    * Impersonate a guest
    *
    */
    public function beGuest() 
    {
        Sentry::logout();
        Session::flush();
    }

    /**
    * Impersonate a user
    *
    */
    public function beUser() 
    {
        $user = Sentry::findUserByLogin('user@user.com');
        Sentry::setUser($user);
        Session::put('userId',2);
        Session::put('email','user@user.com');
    }

    /**
    * Impersonate an admin
    *
    */
    public function beAdmin() 
    {
        $admin = Sentry::findUserByLogin('admin@admin.com');
        Sentry::setUser($admin);
        Session::put('userId',1);
        Session::put('email','admin@admin.com');

    }

}
