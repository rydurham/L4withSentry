<?php namespace Authority\Service\Form;

use Illuminate\Support\ServiceProvider;
use Authority\Service\Form\Login\LoginForm;
use Authority\Service\Form\Login\LoginFormLaravelValidator;
use Authority\Service\Form\Register\RegisterForm;
use Authority\Service\Form\Register\RegisterFormLaravelValidator;
use Authority\Service\Form\Group\GroupForm;
use Authority\Service\Form\Group\GroupFormLaravelValidator;
use Authority\Service\Form\User\UserForm;
use Authority\Service\Form\User\UserFormLaravelValidator;

class FormServiceProvider extends ServiceProvider {

    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // Bind the Login Form
        $app->bind('Authority\Service\Form\Login\LoginForm', function($app)
        {
            return new LoginForm(
                new LoginFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\Session\SessionInterface')
            );
        });

        // Bind the Register Form
        $app->bind('Authority\Service\Form\Register\RegisterForm', function($app)
        {
            return new RegisterForm(
                new RegisterFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\User\UserInterface')
            );
        });

        // Bind the Group Form
        $app->bind('Authority\Service\Form\Group\GroupForm', function($app)
        {
            return new GroupForm(
                new GroupFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\Group\GroupInterface')
            );
        });

        // Bind the User Form
        $app->bind('Authority\Service\Form\User\UserForm', function($app)
        {
            return new UserForm(
                new UserFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\User\UserInterface')
            );
        });

    }

}