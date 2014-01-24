<?php

/**
 * Class TestCase
 */
class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * @var bool
     */
    protected $useDatabase = true;

    /**
     * @var string
     */
    protected $userEmail = 'user@user.com';

    /**
     * @var string
     */
    protected $adminEmail = 'admin@admin.com';

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__ . '/../../bootstrap/start.php';
    }

    /**
     * Set up function for all tests
     *
     */
    public function setUp()
    {
        parent::setUp();

        if ($this->useDatabase) {
            $this->setUpDb();
            $this->createSentryUsersAndGroups();
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
    }

    /**
     * createSentryUsers
     */
    public function createSentryUsersAndGroups()
    {
        $this->createSentryGroups();
        $this->createAdminUser();
        $this->createGuestUser();
    }

    /**
     * createSentryGroups
     */
    public function createSentryGroups()
    {
        $this->createGuestGroup();
        $this->createAdminGroup();
    }

    /**
     * createGuestGroup
     */
    public function createGuestGroup()
    {
        Sentry::getGroupProvider()->create(
            array(
                'name'        => 'Users',
                'permissions' => array(
                    'admin' => 0,
                    'users' => 1,
                )
            )
        );
    }

    /**
     * createAdminGroup
     */
    public function createAdminGroup()
    {
        Sentry::getGroupProvider()->create(
            array(
                'name'        => 'Admins',
                'permissions' => array(
                    'admin' => 1,
                    'users' => 1,
                )
            )
        );
    }

    /**
     * createGuestUser
     */
    public function createGuestUser()
    {
        // Create the user
        $user = Sentry::createUser(
            array(
                'email'     => $this->userEmail,
                'password'  => 'test',
                'activated' => true,
            )
        );

        $userGroup = Sentry::getGroupProvider()->findByName('Users');

        // Assign the group to the user
        $user->addGroup($userGroup);
    }

    /**
     * createAdminUser
     */
    public function createAdminUser()    {

        // Create the user
        $user = Sentry::createUser(
            array(
                'email'     => $this->adminEmail,
                'password'  => 'test',
                'activated' => true,
            )
        );

        // Find the group using the group id
        $adminGroup = Sentry::getGroupProvider()->findByName('Admins');

        // Assign the group to the user
        $user->addGroup($adminGroup);
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
        $user = Sentry::findUserByLogin($this->userEmail);
        Sentry::setUser($user);
        Session::put('userId', 2);
        Session::put('email', $this->userEmail);
    }

    /**
     * Impersonate an admin
     *
     */
    public function beAdmin()
    {
        $admin = Sentry::findUserByLogin($this->adminEmail);
        Sentry::setUser($admin);
        Session::put('userId', 1);
        Session::put('email', $this->adminEmail);
    }
}
