<?php

class GroupController extends BaseController {

	/**
	 * Constructor
	 */
	public function __construct() 
	{
		$this->beforeFilter('admin_auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Index - show the user's group details.
		try
		{
		    // Find the current user
		    if ( ! Sentry::check())
			{
			    // User is not logged in, or is not activated
			    Session::flash('error', 'You must be logged in to perform that action.');
				return Redirect::to('/');
			}
			else
			{
			    // User is logged in
			    $user = Sentry::getUser();

			    // Get the user groups
			    $data['myGroups'] = $user->getGroups();

			    //Get all the available groups.
			    $data['allGroups'] = Sentry::getGroupProvider()->findAll();
				
				
				return View::make('groups.index', $data);
			}
		    
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    Session::flash('error', 'User was not found.');
			return Redirect::to('groups/');
		}
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Form for creating a new Group
		return View::make('groups.create');
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Store the new group in the db. 
		//Start with Data Validation
		// Gather Sanitized Input
		$input = array(
			'newGroup' => Input::get('newGroup')
			);

		// Set Validation Rules
		$rules = array (
			'newGroup' => 'required|min:4'
			);

		//Run input validation
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			// Validation has failed
			return Redirect::to('groups/create')->withErrors($v)->withInput();
		}
		else 
		{
			try
			{
			    // Create the group
			    $group = Sentry::getGroupProvider()->create(array(

					'name'        => $input['newGroup'],
				        'permissions' => array(
				            'admin' => Input::get('adminPermissions', 0),
				            'users' => Input::get('userPermissions', 0),
				        ),
				    ));

				
				if ($group) {
					Session::flash('success', 'New Group Created');
				    return Redirect::to('groups');
				} else {
					Session::flash('error', 'New Group was not created');
				    return Redirect::to('groups');
				}
		
			}
			catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
			{
			    Session::flash('error', 'Name field is required');
			    return Redirect::to('groups/create')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
			{
			    Session::flash('error', 'Group already exists');
			    return Redirect::to('groups/create')->withErrors($v)->withInput();
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		//Show a group and its permissions. 
		try
		{
		    // Find the group using the group id
		    $data['group'] = Sentry::getGroupProvider()->findById($id);

		    // Get the group permissions
		    $data['groupPermissions'] = $data['group']->getPermissions();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    Session::flash('error', 'Group does not exist.');
			return Redirect::to('groups');
		}


		return View::make('groups.show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		//Pull the selected group
		try
		{
		    // Find the group using the group id
		    $data['group'] = Sentry::getGroupProvider()->findById($id);

		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    Session::flash('error', 'Group does not exist.');
			return Redirect::to('groups');
		}

		return View::make('groups.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		// Update the Group.
		// Start with Data Validation
		// Gather Sanitized Input
		
		$input = array(
			'name' => Input::get('name')
			);

		// Set Validation Rules
		$rules = array (
			'name' => 'required|min:4'
			);

		//Run input validation
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			// Validation has failed
			return Redirect::to('groups/'. $id . '/edit')->withErrors($v)->withInput();
		}
		else 
		{

			try
			{
			    // Find the group using the group id
			    $group = Sentry::getGroupProvider()->findById($id);

			    // Update the group details
			    $group->name = $input['name'];
			    $group->permissions = array(
			       'admin' => Input::get('adminPermissions', 0),
				   'users' => Input::get('userPermissions', 0),
			    );

			    // Update the group
			    if ($group->save())
			    {
			        // Group information was updated
			        Session::flash('success', 'Group has been updated.');
					return Redirect::to('groups');
			    }
			    else
			    {
			        // Group information was not updated
			        Session::flash('error', 'There was a problem updating the group.');
					return Redirect::to('groups/'. $id . '/edit')->withErrors($v)->withInput();
			    }
			}
			catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
			{
			    Session::flash('error', 'Group already exists.');
				return Redirect::to('groups/'. $id . '/edit')->withErrors($v)->withInput();
			}
			catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
			{
			    Session::flash('error', 'Group was not found.');
				return Redirect::to('groups/'. $id . '/edit')->withErrors($v)->withInput();
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		
		try
		{
		    // Find the group using the group id
		    $group = Sentry::getGroupProvider()->findById($id);

		    // Delete the group
		    if ($group->delete())
		    {
		        // Group was successfully deleted
		        Session::flash('success', 'Group has been deleted.');
				return Redirect::to('groups/');
		    }
		    else
		    {
		        // There was a problem deleting the group
		        Session::flash('error', 'There was a problem deleting that group.');
				return Redirect::to('groups/');
		    }
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    Session::flash('error', 'Group was not found.');
			return Redirect::to('groups/');
		}
	}

}