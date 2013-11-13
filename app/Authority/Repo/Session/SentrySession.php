<?php namespace Authority\Repo\Session;

use Cartalyst\Sentry\Sentry;
use Authority\Repo\RepoAbstract;

class SentrySession extends RepoAbstract implements SessionInterface {

	protected $sentry;
	protected $throttleProvider;


	public function __construct(Sentry $sentry)
	{
		$this->sentry = $sentry;

		// Get the Throttle Provider
		$this->throttleProvider = $this->sentry->getThrottleProvider();

		// Enable the Throttling Feature
		$this->throttleProvider->enable();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($data)
	{
		$result = array();
		try
			{
			    // Check for 'rememberMe' in POST data
			    if (!array_key_exists('rememberMe', $data)) $data['rememberMe'] = 0;

			    //Check for suspension or banned status
				$user = $this->sentry->getUserProvider()->findByLogin($data['email']);
				$throttle = $this->throttleProvider->findByUserId($user->id);
			    $throttle->check();

			    // Set login credentials
			    $credentials = array(
			        'email'    => e($data['email']),
			        'password' => e($data['password'])
			    );

			    // Try to authenticate the user
			    $user = $this->sentry->authenticate($credentials, e($data['rememberMe']));

			    $result['success'] = true;
			}
			catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    // Sometimes a user is found, however hashed credentials do
			    // not match. Therefore a user technically doesn't exist
			    // by those credentials. Check the error message returned
			    // for more information.
			    $result['success'] = false;
			    $result['message'] = 'Invalid username or password.';
			}
			catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e)
			{
			    $result['success'] = false;
			    $url = route('resendActivationForm');
			    $result['message'] = "You have not yet activated this account. <a href='$url' class='alert-link'>Resend Activation Email?</a>";
			}

			// The following is only required if throttle is enabled
			catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
			{
			    $time = $throttle->getSuspensionTime();
			    $result['success'] = false;
			    $result['message'] = "Your account has been suspended for $time minutes.";
			}
			catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
			{
			    $result['success'] = false;
			    $result['message'] = 'You have been banned.';
			}

			//Login was succesful.  
			return $result;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		$this->sentry->logout();
	}


}