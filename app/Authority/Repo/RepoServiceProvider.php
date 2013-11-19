<?php namespace Authority\Repo;

use Illuminate\Support\ServiceProvider;
use Authority\Repo\Session\SentrySession;
use Authority\Repo\User\SentryUser;
use Authority\Repo\Group\SentryGroup;
use Cartalyst\Sentry\Sentry;

class RepoServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 */
	public function register()
	{
		$app = $this->app;

		 // Bind the Session Repository
        $app->bind('Authority\Repo\Session\SessionInterface', function($app)
        {
            return new SentrySession(
            	$app['sentry']
            );
        });

        // Bind the User Repository
        $app->bind('Authority\Repo\User\UserInterface', function($app)
        {
            return new SentryUser(
            	$app['sentry']
            );
        });

        // Bind the Group Repository
        $app->bind('Authority\Repo\Group\GroupInterface', function($app)
        {
            return new SentryGroup(
                $app['sentry']
            );
        });
	}

}