<?php namespace Authority\Repo\User;

use Mail;
use Cartalyst\Sentry\Sentry;
use Authority\Repo\RepoAbstract;

class SentryUser extends RepoAbstract implements UserInterface {
	
	protected $sentry;

	/**
	 * Construct a new SentryUser Object
	 */
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
		try {
			//Attempt to register the user. 
			$user = $this->sentry->register(array('email' => e($data['email']), 'password' => e($data['password'])));

			//Get the activation code & prep data for email
			$data['activationCode'] = $user->GetActivationCode();
			$data['userId'] = $user->getId();

			//send email with link to activate.
			Mail::send('emails.auth.welcome', $data, function($m) use($data)
			{
			    $m->to(e($data['email']))->subject('Welcome to Laravel4 With Sentry');
			});

			//success!
	    	$result['success'] = true;
	    	$result['message'] = 'Your account has been created. Check your email for the confirmation link.';
		}
		catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $result['success'] = false;
	    	$result['message'] = 'Login field required.';
		}
		catch (\Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    $result['success'] = false;
	    	$result['message'] = 'User already exists.';
		}

		return $result;
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
		    // Find the user using the user id
		    $user = $this->sentry->findUserById(1);

		    // Delete the user
		    $user->delete();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    return false;
		}
		return true;
	}

	/**
	 * Return a specific user from the given id
	 * 
	 * @param  integer $id
	 * @return User
	 */
	public function byId($id)
	{
		try
		{
		    $user = $this->sentry->findUserById($id);
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    return false;
		}
		return $user;
	}

	/**
	 * Return all the registered users
	 *
	 * @return stdObject Collection of users
	 */
	public function all()
	{
		return $this->sentry->findAllUsers();
	}
}
