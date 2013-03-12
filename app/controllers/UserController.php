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
		
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		// Index - show the user details.
		return View::make('users.index');
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
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation')
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
			return Redirect::to('user/register')->withErrors($v)->withInput();
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
			    	return Redirect::to('user/register')->withErrors($v)->withInput();
			    }

			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
			    Session::flash('error', 'Login field required.');
			    return Redirect::to('user/register')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    Session::flash('error', 'User already exists.');
			    return Redirect::to('user/register')->withErrors($v)->withInput();
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
		        Session::flash('success', 'Your account has been activated.');
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
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'rememberMe' => Input::get('rememberMe')
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
			return Redirect::to('user/login')->withErrors($v)->withInput();
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
				return Redirect::to('user/login')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
			{
			    echo 'User not activated.';
			    Session::flash('error', 'You have not yet activated this account.');
				return Redirect::to('user/login')->withErrors($v)->withInput();
			}

			// The following is only required if throttle is enabled
			catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
			{
			    Session::flash('error', 'Your account has been suspended.');
				return Redirect::to('user/login')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
			{
			    Session::flash('error', 'You have been banned.');
				return Redirect::to('user/login')->withErrors($v)->withInput();
			}

			//Login was succesful.  
			return Redirect::to('user');
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
	 * Reset the password. 
	 */
	public function getChangepassword() {
		// Show the change password
		return View::make('users.change');
	}

	public function postChangepassword () {
		// Gather Sanitized Input
		$input = array(
			'oldPassword' => Input::get('oldPassword'),
			'newPassword' => Input::get('newPassword'),
			'newPassword_confirmation' => Input::get('newPassword_confirmation')
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
			return Redirect::to('user/changepassword')->withErrors($v)->withInput();
		}
		else 
		{
			try
			{
			    if (Sentry::check()) 
			    {
			    	$user = Sentry::getUser();

			    	if ($user->checkHash($input['oldPassword'], $user->getPassword())) 
			    	{
				    	//The oldPassword matches the current password in the DB. Proceed.
				    	$user->password = $input['newPassword'];

				    	if ($user->save())
					    {
					        // User saved
					        Session::flash('success', 'Your password has been changed.');
							return Redirect::to('user');
					    }
					    else
					    {
					        // User not saved
					        Session::flash('error', 'Your password could not be changed.');
							return Redirect::to('user/changepassword');
					    }
					} else {
						// The oldPassword did not match the password in the database. Abort. 
						Session::flash('error', 'You did not provide the correct password.');
						return Redirect::to('user/changepassword');
					}

			    	
			    } else {
			    	// The user is not currently logged in. 
			    	Session::flash('error', 'You must be logged in.');
					return Redirect::to('/');
			    }

			   			    
			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
			    Session::flash('error', 'Login field required.');
				return Redirect::to('user/changepassword');
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
			    Session::flash('error', 'User already exists.');
				return Redirect::to('user/changepassword');
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    Session::flash('error', 'User was not found.');
				return Redirect::to('user/changepassword');
			}
		}
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
			'email' => Input::get('email')
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
			return Redirect::to('user/resetpassword')->withErrors($v)->withInput();
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
			    	return Redirect::to('user/resetpassword')->withErrors($v)->withInput();
			    }

			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    echo 'User does not exist/';
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
			       setSubject('New Password Infortmaion | Laravel4 With Sentry')->
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
			    return Redirect::to('user/resetpassword');
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