<?php

use Authority\Repo\Session\SessionInterface;
use Authority\Service\Form\Login\LoginForm;

class SessionController extends BaseController {

	/**
	 * Member Vars
	 */
	protected $session;
	protected $loginForm;

	/**
	 * Constructor
	 */
	public function __construct(SessionInterface $session, LoginForm $loginForm)
	{
		$this->session = $session;
		$this->loginForm = $loginForm;
	}

	/**
	 * Show the login form
	 */
	public function create()
	{
		return View::make('sessions.login');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Form Processing
        $result = $this->loginForm->save( Input::all() );

        if( $result['success'] )
        {
            Event::fire('user.login', array(
            							'userId' => $result['sessionData']['userId'],
            							'email' => $result['sessionData']['email']
            							));

            // Success!
            return Redirect::to('/');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('login')
                ->withInput()
                ->withErrors( $this->loginForm->errors() );
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		$this->session->destroy();
		Event::fire('user.logout');
		return Redirect::to('/');
	}

}
