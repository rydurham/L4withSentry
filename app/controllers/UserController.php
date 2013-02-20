<?php

class UserController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		//
		return "Indexing Users";
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

			$data['token'] = "ThisIsTheToken";
			$user['email'] = $input['email'];

			//Validation has passed
			Mail::send('emails.auth.welcome', $data, function($m) use ($user)
			{
			    $m->from('demo@l4sentry.com', 'Sentry Demo');
			    $m->to($user['email'])->subject('Welcome!');
			});

			echo "Mail Sent"; die();
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
		return "Post: Register user";
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		//
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