<?php

use Authority\Repo\User\UserInterface;
use Authority\Repo\Group\GroupInterface;
use Authority\Service\Form\Register\RegisterForm;
use Authority\Service\Form\User\UserForm;

class UserController extends BaseController {

	protected $user;
	protected $group;
	protected $registerForm;
	protected $userForm;

	/**
	 * Instantiate a new UserController
	 */
	public function __construct(UserInterface $user, GroupInterface $group, RegisterForm $registerForm, UserForm $userForm)
	{
		$this->user = $user;
		$this->group = $group;
		$this->registerForm = $registerForm;
		$this->userForm = $userForm;

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
        $currentGroups = $user->getGroups()->toArray();
        $userGroups = array();
        foreach ($currentGroups as $group) {
        	array_push($userGroups, $group['name']);
        }
        $allGroups = $this->group->all();

        return View::make('users.edit')->with('user', $user)->with('userGroups', $userGroups)->with('allGroups', $allGroups);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Form Processing
        $result = $this->userForm->update( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@edit', array($id))
                ->withInput()
                ->withErrors( $this->userForm->errors() );
        }
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

	