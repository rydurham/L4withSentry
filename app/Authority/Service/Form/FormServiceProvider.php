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
use Authority\Service\Form\ResendActivation\ResendActivationForm;
use Authority\Service\Form\ResendActivation\ResendActivationFormLaravelValidator;
use Authority\Service\Form\ForgotPassword\ForgotPasswordForm;
use Authority\Service\Form\ForgotPassword\ForgotPasswordFormLaravelValidator;
use Authority\Service\Form\ChangePassword\ChangePasswordForm;
use Authority\Service\Form\ChangePassword\ChangePasswordFormLaravelValidator;
use Authority\Service\Form\SuspendUser\SuspendUserForm;
use Authority\Service\Form\SuspendUser\SuspendUserFormLaravelValidator;

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

        // Bind the Resend Activation Form
        $app->bind('Authority\Service\Form\ResendActivation\ResendActivationForm', function($app)
        {
            return new ResendActivationForm(
                new ResendActivationFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\User\UserInterface')
            );
        });

        // Bind the Forgot Password Form
        $app->bind('Authority\Service\Form\ForgotPassword\ForgotPasswordForm', function($app)
        {
            return new ForgotPasswordForm(
                new ForgotPasswordFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\User\UserInterface')
            );
        });

        // Bind the Change Password Form
        $app->bind('Authority\Service\Form\ChangePassword\ChangePasswordForm', function($app)
        {
            return new ChangePasswordForm(
                new ChangePasswordFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\User\UserInterface')
            );
        });

        // Bind the Suspend User Form
        $app->bind('Authority\Service\Form\SuspendUser\SuspendUserForm', function($app)
        {
            return new SuspendUserForm(
                new SuspendUserFormLaravelValidator( $app['validator'] ),
                $app->make('Authority\Repo\User\UserInterface')
            );
        });

    }

}