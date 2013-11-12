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
	 * @param  array $data
	 * @return Response
	 */
	public function update($data)
	{
		try
		{
		    // Find the user using the user id
		    $user = $this->sentry->findUserById($data['id']);

		    // Update the user details
		    $user->first_name = $data['firstName'];
		    $user->last_name = $data['lastName'];

		    // Update group memberships
		    $allGroups = $this->sentry->getGroupProvider()->findAll();
		    foreach ($allGroups as $group)
		    {
		    	if (isset($data['groups'][$group->id])) 
                {
                    //The user should be added to this group
                    $user->addGroup($group);
                } else {
                    // The user should be removed from this group
                    $user->removeGroup($group);
                }
		    }

		    // Update the user
		    if ($user->save())
		    {
		        // User information was updated
		        $result['success'] = true;
	    		$result['message'] = 'Profile updated';
		    }
		    else
		    {
		        // User information was not updated
		        $result['success'] = false;
	    		$result['message'] = 'Unable to update profile';
		    }
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    $result['success'] = false;
	    	$result['message'] = 'User already exists.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    $result['success'] = false;
	    	$result['message'] = 'User not found';
		}

		return $result;
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
		    $user = $this->sentry->findUserById($id);

		    // Delete the user
		    $user->delete();
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
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
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
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
		$users = $this->sentry->findAllUsers();

		foreach ($users as $user) {
			if ($user->isActivated()) 
    		{
    			$user->status = "Active";
    		} 
    		else 
    		{
    			$user->status = "Not Active";
    		}

    		//Pull Suspension & Ban info for this user
    		$throttle = $this->throttleProvider->findByUserId($user->id);

    		//Check for suspension
    		if($throttle->isSuspended())
		    {
		        // User is Suspended
		        $user->status = "Suspended";
		    }

    		//Check for ban
		    if($throttle->isBanned())
		    {
		        // User is Banned
		        $user->status = "Banned";
		    }
		}

		return $users;
	}
}
