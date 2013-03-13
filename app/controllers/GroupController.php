<?php

class GroupController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Index - show the user's group details.
		return View::make('groups.index');
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}