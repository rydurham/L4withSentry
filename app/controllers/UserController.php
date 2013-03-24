<?php

class UserController extends BaseController {

	protected $sendgrid;

	/**
	 * Instantiate a new UserController
	 */
	public function __construct()
	{
		// This file contains my own private sendGrid key.  
		// You can put your own sendGrid details here, as such:
		// $this->sendgrid = new SendGrid('USERNAME', 'PASSWORD');

		include('../app/config/sendGridConfig.php');

		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));
		
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		// Index - show the user details.

		try
		{
		   	// Find the current user
		    if ( Sentry::check())
			{
			    // Find the user using the user id
			    $data['user'] = Sentry::getUser();

			    if ($data['user']->hasAccess('admin')) {
			    	$data['allUsers'] = Sentry::getUserProvider()->findAll();
			    } 

			    return View::make('users.index')->with($data);
			} else {
				Session::flash('error', 'You are not logged in.');
				return Redirect::to('/');
			}
		}
		catch (Cartalyst\Sentry\UserNotFoundException $e)
		{
		    Session::flash('error', 'There was a problem accessing your account.');
			return Redirect::to('/');
		}
	}

	/**
	 *  Display this user's details.
	 */
	
	public function getShow($id)
	{
		try
		{
		    //Get the current user's id.
			Sentry::check();
			$currentUser = Sentry::getUser();

		   	//Do they have admin access?
			if ( $currentUser->hasAccess('admin') || $currentUser->getId() == $id)
			{
				//Either they are an admin, or:
				//They are not an admin, but they are viewing their own profile.
				$data['user'] = Sentry::getUserProvider()->findById($id);
				$data['myGroups'] = $data['user']->getGroups();
				return View::make('users.show')->with($data);
			} else {
				Session::flash('error', 'You don\'t have access to that user.');
				return Redirect::to('/');
			}

		}
		catch (Cartalyst\Sentry\UserNotFoundException $e)
		{
		    Session::flash('error', 'There was a problem accessing your account.');
			return Redirect::to('/');
		}
	}


	/**
	 * Register a new user. 
	 *
	 * @return Response
	 */
	public function getRegister()
	{
		// Show the register form
		return View::make('users.register');
	}

	public function postRegister() 
	{
	
		// Gather Sanitized Input
		$input = array(
			'email' => Binput::get('email'),
			'password' => Binput::get('password'),
			'password_confirmation' => Binput::get('password_confirmation')
			);

		// Set Validation Rules
		$rules = array (
			'email' => 'required|min:4|max:32|email',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required'
			);

		//Run input validation
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			// Validation has failed
			return Redirect::to('users/register')->withErrors($v)->withInput();
		}
		else 
		{

			try {
				//Attempt to register the user. 
				$user = Sentry::register(array('email' => $input['email'], 'password' => $input['password']));

				//Get the activation code & prep data for email
				$data['activationCode'] = $user->GetActivationCode();
				$data['email'] = $input['email'];
				$data['userId'] = $user->getId();

				//Prepare Activation Email
				$body = View::make('emails.auth.welcome')->with($data)->render();

				//send email with link to activate.
				$mail = new SendGrid\Mail();
				$mail->addTo($input['email'])->
			       setFrom('support@mercut.io')->
			       setSubject('Welcome to Laravel4 With Sentry')->
			       setHtml($body);

			    if ($this->sendgrid->smtp->send($mail)) {
			    	//success!
			    	Session::flash('success', 'Your account has been created. Check your email for the confirmation link.');
			    	return Redirect::to('/');
			    } else {
			    	//There was a problem sending the activation email.
			    	Session::flash('error', 'There was a problem.  Please contact the system administrator.');
			    	return Redirect::to('users/register')->withErrors($v)->withInput();
			    }

			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
			    Session::flash('error', 'Login field required.');
			    return Redirect::to('users/register')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    Session::flash('error', 'User already exists.');
			    return Redirect::to('users/register')->withErrors($v)->withInput();
			}

		}
	}

	/**
	 * Activate a new User
	 */
	public function getActivate($userId = null, $activationCode = null) {
		try 
		{
		    // Find the user
		    $user = Sentry::getUserProvider()->findById($userId);

		    // Attempt user activation
		    if ($user->attemptActivation($activationCode))
		    {
		        // User activation passed
		        Session::flash('success', 'Your account has been activated. <a href="/users/login">Click here</a> to log in.');
				return Redirect::to('/');
		    }
		    else
		    {
		        // User activation failed
		        Session::flash('error', 'There was a problem activating this account. Please contact the system administrator.');
				return Redirect::to('/');
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    Session::flash('error', 'User does not exist.');
			return Redirect::to('/');
		}
		catch (Cartalyst\SEntry\Users\UserAlreadyActivatedException $e)
		{
		    Session::flash('error', 'You have already activated this account.');
			return Redirect::to('/');
		}


	}

	/**
	 * Login
	 *
	 * @return Response
	 */
	public function getLogin()
	{
		// Show the register form
		return View::make('users.login');
	}

	public function postLogin() 
	{
		// Gather Sanitized Input
		$input = array(
			'email' => Binput::get('email'),
			'password' => Binput::get('password'),
			'rememberMe' => Binput::get('rememberMe')
			);

		// Set Validation Rules
		$rules = array (
			'email' => 'required|min:4|max:32|email',
			'password' => 'required|min:6'
			);

		//Run input validation
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			// Validation has failed
			return Redirect::to('users/login')->withErrors($v)->withInput();
		}
		else 
		{
			try
			{
			    // Set login credentials
			    $credentials = array(
			        'email'    => $input['email'],
			        'password' => $input['password']
			    );

			    // Try to authenticate the user
			    $user = Sentry::authenticate($credentials, $input['rememberMe']);
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    // Sometimes a user is found, however hashed credentials do
			    // not match. Therefore a user technically doesn't exist
			    // by those credentials. Check the error message returned
			    // for more information.
			    Session::flash('error', $e->getMessage() );
				return Redirect::to('users/login')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
			{
			    echo 'User not activated.';
			    Session::flash('error', 'You have not yet activated this account.');
				return Redirect::to('users/login')->withErrors($v)->withInput();
			}

			// The following is only required if throttle is enabled
			catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
			{
			    Session::flash('error', 'Your account has been suspended.');
				return Redirect::to('users/login')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
			{
			    Session::flash('error', 'You have been banned.');
				return Redirect::to('users/login')->withErrors($v)->withInput();
			}

			//Login was succesful.  
			return Redirect::to('/');
		}
	}

	/**
	 * Logout
	 */
	
	public function getLogout() 
	{
		Sentry::logout();
		return Redirect::to('/');
	}


	

	/**
	 * Forgot Password / Reset
	 */
	public function getResetpassword() {
		// Show the change password
		return View::make('users.reset');
	}

	public function postResetpassword () {
		// Gather Sanitized Input
		$input = array(
			'email' => Binput::get('email')
			);

		// Set Validation Rules
		$rules = array (
			'email' => 'required|min:4|max:32|email'
			);

		//Run input validation
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			// Validation has failed
			return Redirect::to('users/resetpassword')->withErrors($v)->withInput();
		}
		else 
		{
			try
			{
			    $user      = Sentry::getUserProvider()->findByLogin($input['email']);
			    $data['resetCode'] = $user->getResetPasswordCode();
			    $data['userId'] = $user->getId();

			    // Email the reset code to the user

			    //Prepare Reset Message Body
				$body = View::make('emails.auth.reset')->with($data)->render();

				//send email with link to activate.
				$mail = new SendGrid\Mail();
				$mail->addTo($input['email'])->
			       setFrom('support@mercut.io')->
			       setSubject('Password Reset Confirmation | Laravel4 With Sentry')->
			       setHtml($body);

			    if ($this->sendgrid->smtp->send($mail)) {
			    	//success!
			    	Session::flash('success', 'Check your email for password reset information.');
			    	return Redirect::to('/');
			    } else {
			    	//There was a problem sending the activation email.
			    	Session::flash('error', 'There was a problem.  Please contact the system administrator.');
			    	return Redirect::to('users/resetpassword')->withErrors($v)->withInput();
			    }

			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    echo 'User does not exist';
			}
		}

	}


	/**
	 * Reset User's password
	 */
	public function getReset($userId = null, $resetCode = null) {
		try
		{
		    // Find the user
		    $user = Sentry::getUserProvider()->findById($userId);
		    $newPassword = $this->_generatePassword(8,8);

		    // Attempt to reset the user password
		    if ($user->attemptResetPassword($resetCode, $newPassword))
		    {
		        // Password reset passed
		        // 
		        // Email the reset code to the user

			    //Prepare New Password body
			    $data['newPassword'] = $newPassword;
				$body = View::make('emails.auth.newpassword')->with($data)->render();

				//send email with link to activate.
				$mail = new SendGrid\Mail();
				$mail->addTo($user->getLogin())->
			       setFrom('support@mercut.io')->
			       setSubject('New Password Information | Laravel4 With Sentry')->
			       setHtml($body);

			    if ($this->sendgrid->smtp->send($mail)) {
			    	//success!
			    	Session::flash('success', 'Your password has been changed. Check your email for the new password.');
			    	return Redirect::to('/');
			    } else {
			    	//There was a problem sending the activation email.
			    	Session::flash('error', 'There was a problem.  Please contact the system administrator.');
			    	return Redirect::to('/')->withErrors($v)->withInput();
			    }
		        
		    }
		    else
		    {
		        // Password reset failed
		    	Session::flash('error', 'There was a problem.  Please contact the system administrator.');
			    return Redirect::to('users/resetpassword');
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    echo 'User does not exist.';
		}
	}


	public function getClearreset($userId = null) {
		try
		{
		    // Find the user
		    $user = Sentry::getUserProvider()->findById($userId);

		    // Clear the password reset code
		    $user->clearResetPassword();

		    echo "clear.";
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    echo 'User does not exist';
		}
	}


	/**
	 *  Edit / Update User Profile
	 */
	
	public function getEdit($id) {
		try
		{
		    //Get the current user's id.
			Sentry::check();
			$currentUser = Sentry::getUser();

		   	//Do they have admin access?
			if ( $currentUser->hasAccess('admin'))
			{
				$data['user'] = Sentry::getUserProvider()->findById($id);
				$data['userGroups'] = $data['user']->getGroups();
				$data['allGroups'] = Sentry::getGroupProvider()->findAll();
				return View::make('users.edit')->with($data);
			} 
			elseif ($currentUser->getId() == $id)
			{
				//They are not an admin, but they are viewing their own profile.
				$data['user'] = Sentry::getUserProvider()->findById($id);
				$data['userGroups'] = $data['user']->getGroups();
				return View::make('users.edit')->with($data);
			} else {
				Session::flash('error', 'You don\'t have access to that user.');
				return Redirect::to('/');
			}

		}
		catch (Cartalyst\Sentry\UserNotFoundException $e)
		{
		    Session::flash('error', 'There was a problem accessing your account.');
			return Redirect::to('/');
		}



	}


	public function postEdit($id) {
		// Gather Sanitized Input
		$input = array(
			'firstName' => Binput::get('firstName'),
			'lastName' => Binput::get('lastName')
			);

		// Set Validation Rules
		$rules = array (
			'firstName' => 'alpha',
			'lastName' => 'alpha',
			);

		//Run input validation
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			// Validation has failed
			return Redirect::to('users/edit/' . $id)->withErrors($v)->withInput();
		}
		else 
		{
			try
			{
				//Get the current user's id.
				Sentry::check();
				$currentUser = Sentry::getUser();

			   	//Do they have admin access?
				if ( $currentUser->hasAccess('admin')  || $currentUser->getId() == $id)
				{
					// Either they are an admin, or they are changing their own password. 
					// Find the user using the user id
					$user = Sentry::getUserProvider()->findById($id);	
					
				    // Update the user details
				    $user->first_name = $input['firstName'];
				    $user->last_name = $input['lastName'];

				    // Update the user
				    if ($user->save())
				    {
				        // User information was updated
				        Session::flash('success', 'Your password has been changed.');
						return Redirect::to('users/show/'. $id);
				    }
				    else
				    {
				        // User information was not updated
				        Session::flash('error', 'Your password could not be changed.');
						return Redirect::to('users/edit/' . $id);
				    }

				} else {
					Session::flash('error', 'You don\'t have access to that user.');
					return Redirect::to('/');
				}			   			    
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    Session::flash('error', 'User already exists.');
				return Redirect::to('users/edit/' . $id);
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    Session::flash('error', 'User was not found.');
				return Redirect::to('users/edit/' . $id);
			}
		}
	}

	/**
	 * Process changepassword form. 
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function postChangepassword($id) 
	{
		// Gather Sanitized Input
		$input = array(
			'oldPassword' => Binput::get('oldPassword'),
			'newPassword' => Binput::get('newPassword'),
			'newPassword_confirmation' => Binput::get('newPassword_confirmation')
			);

		// Set Validation Rules
		$rules = array (
			'oldPassword' => 'required|min:6',
			'newPassword' => 'required|min:6|confirmed',
			'newPassword_confirmation' => 'required'
			);

		//Run input validation
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			// Validation has failed
			return Redirect::to('users/edit/' . $id)->withErrors($v)->withInput();
		}
		else 
		{
			try
			{
			    
				//Get the current user's id.
				Sentry::check();
				$currentUser = Sentry::getUser();

			   	//Do they have admin access?
				if ( $currentUser->hasAccess('admin')  || $currentUser->getId() == $id)
				{
					// Either they are an admin, or they are changing their own password. 
					$user = Sentry::getUserProvider()->findById($id);	
					if ($user->checkHash($input['oldPassword'], $user->getPassword())) 
			    	{
				    	//The oldPassword matches the current password in the DB. Proceed.
				    	$user->password = $input['newPassword'];

				    	if ($user->save())
					    {
					        // User saved
					        Session::flash('success', 'Your password has been changed.');
							return Redirect::to('users/show/'. $id);
					    }
					    else
					    {
					        // User not saved
					        Session::flash('error', 'Your password could not be changed.');
							return Redirect::to('users/edit/' . $id);
					    }
					} else {
						// The oldPassword did not match the password in the database. Abort. 
						Session::flash('error', 'You did not provide the correct password.');
						return Redirect::to('users/edit/' . $id);
					}
				} else {
					Session::flash('error', 'You don\'t have access to that user.');
					return Redirect::to('/');
				}			   			    
			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
			    Session::flash('error', 'Login field required.');
				return Redirect::to('users/edit/' . $id);
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    Session::flash('error', 'User already exists.');
				return Redirect::to('users/edit/' . $id);
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    Session::flash('error', 'User was not found.');
				return Redirect::to('users/edit/' . $id);
			}
		}
	}

	/**
	 * Process changes to user's group memberships
	 * @param  int 		$id The affected user's id
	 * @return [type]     [description]
	 */
	public function postUpdatememberships($id)
	{
		try 
		{
			//Get the current user's id.
			Sentry::check();
			$currentUser = Sentry::getUser();

		   	//Do they have admin access?
			if ( $currentUser->hasAccess('admin'))
			{
				$user = Sentry::getUserProvider()->findById($id);
				$allGroups = Sentry::getGroupProvider()->findAll();
				$permissions = Input::get('permissions');
				
				$statusMessage = '';
				foreach ($allGroups as $group) {
					
					if (isset($permissions[$group->id])) 
					{
						//The user should be added to this group
						if ($user->addGroup($group))
					    {
					        $statusMessage .= "Added to " . $group->name . "<br />";
					    }
					    else
					    {
					        $statusMessage .= "Could not be added to " . $group->name . "<br />";
					    }
					} else {
						// The user should be removed from this group
						if ($user->removeGroup($group))
					    {
					        $statusMessage .= "Removed from " . $group->name . "<br />";
					    }
					    else
					    {
					        $statusMessage .= "Could not be removed from " . $group->name . "<br />";
					    }
					}
					
				}
				Session::flash('info', $statusMessage);
				return Redirect::to('users/show/'. $id);
			} 
			else 
			{
				Session::flash('error', 'You don\'t have access to that user.');
				return Redirect::to('/');
			}
	
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    Session::flash('error', 'User was not found.');
			return Redirect::to('users/edit/' . $id);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    Session::flash('error', 'Trying to access unidentified Groups.');
			return Redirect::to('users/edit/' . $id);
		}
	}


	/**
	 * Generate password - helper function
	 * From http://www.phpscribble.com/i4xzZu/Generate-random-passwords-of-given-length-and-strength
	 * 
	 */
	
	private function _generatePassword($length=9, $strength=4) {
		$vowels = 'aeiouy';
		$consonants = 'bcdfghjklmnpqrstvwxz';
		if ($strength & 1) {
			$consonants .= 'BCDFGHJKLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEIOUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}

}