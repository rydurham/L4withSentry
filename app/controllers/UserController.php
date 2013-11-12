<?php

use Authority\Repo\User\UserInterface;
use Authority\Service\Form\Register\RegisterForm;

class UserController extends BaseController {

	protected $user;
	protected $registerForm;

	/**
	 * Instantiate a new UserController
	 */
	public function __construct(UserInterface $user, RegisterForm $registerForm)
	{
		$this->user = $user;
		$this->registerForm = $registerForm;

		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

		// Set up Auth Filters
		 $this->beforeFilter('auth', array('except' => array('create', 'store')));
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = $this->user->all();
        //Assemble an array of each user's status
    	$data['userStatus'] = array();
    	foreach ($users as $user) {
    		if ($user->isActivated()) 
    		{
    			$data['userStatus'][$user->id] = "Active";
    		} 
    		else 
    		{
    			$data['userStatus'][$user->id] = "Not Active";
    		}

    		//Pull Suspension & Ban info for this user
    		$throttle = Sentry::getThrottleProvider()->findByUserId($user->id);

    		//Check for suspension
    		if($throttle->isSuspended())
		    {
		        // User is Suspended
		        $data['userStatus'][$user->id] = "Suspended";
		    }

    		//Check for ban
		    if($throttle->isBanned())
		    {
		        // User is Banned
		        $data['userStatus'][$user->id] = "Banned";
		    }

    	}

        return View::make('users.index')->with('users', $users);
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('users.create');
	}

	/**
	 * Store a newly created user.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Form Processing
        $result = $this->registerForm->save( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('/');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@create')
                ->withInput()
                ->withErrors( $this->registerForm->errors() );
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = $this->user->byId($id);
        return View::make('users.show')->with('user', $user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = $this->user->byId($id);
        return View::make('users.edit')->with('user', $user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}



// ======================================================================================================

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	// public function index()
	// {
	// 	// Index - show the user details.

	// 	try
	// 	{
	// 	   	// Find the current user
	// 	    if ( Sentry::check())
	// 		{
	// 		    // Find the user using the user id
	// 		    $data['user'] = Sentry::getUser();

	// 		    if ($data['user']->hasAccess('admin')) {
	// 		    	$data['allUsers'] = Sentry::getUserProvider()->findAll();

	// 		    	
	// 		    } 

	// 		    return View::make('users.index')->with($data);
	// 		} else {
	// 			Session::flash('error', 'You are not logged in.');
	// 			return Redirect::to('/');
	// 		}
	// 	}
	// 	catch (Cartalyst\Sentry\UserNotFoundException $e)
	// 	{
	// 	    Session::flash('error', 'There was a problem accessing your account.');
	// 		return Redirect::to('/');
	// 	}
	// }

	/**
	 *  Display this user's details.
	 */
	
	// public function show($id)
	// {
	// 	try
	// 	{
	// 	    //Get the current user's id.
	// 		Sentry::check();
	// 		$currentUser = Sentry::getUser();

	// 	   	//Do they have admin access?
	// 		if ( $currentUser->hasAccess('admin') || $currentUser->getId() == $id)
	// 		{
	// 			//Either they are an admin, or:
	// 			//They are not an admin, but they are viewing their own profile.
	// 			$data['user'] = Sentry::getUserProvider()->findById($id);
	// 			$data['myGroups'] = $data['user']->getGroups();
	// 			return View::make('users.show')->with($data);
	// 		} else {
	// 			Session::flash('error', 'You don\'t have access to that user.');
	// 			return Redirect::to('/');
	// 		}

	// 	}
	// 	catch (Cartalyst\Sentry\UserNotFoundException $e)
	// 	{
	// 	    Session::flash('error', 'There was a problem accessing your account.');
	// 		return Redirect::to('/');
	// 	}
	// }


	
	}

	