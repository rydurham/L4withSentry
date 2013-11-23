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
    }

    /**
    * Tear down function for all tests
    *
    */
    public function teardown()
    {
        Mockery::close();
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

}
