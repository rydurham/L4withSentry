<?php namespace Authority\Repo\Group;

use Cartalyst\Sentry\Sentry;
use Authority\Repo\RepoAbstract;

class SentryGroup extends RepoAbstract implements GroupInterface {
	
	protected $sentry;

	/**
	 * Construct a new SentryGroup Object
	 */
	public function __construct(Sentry $sentry)
	{
		$this->sentry = $sentry;
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
	public function update($data)
	{
		try
		{
			// Find the group using the group id
		    $group = Sentry::findGroupById($data['id']);

		    // Update the group details
		    $group->name = $data['name'];
		    $group->permissions = array(
		        'admin' => $data['adminPermissions'],
				'users' => $data['userPermissions'],
		    );

		    // Update the group
		    if ($group->save())
		    {
		        // Group information was updated
		        $result['success'] = true;
				$result['message'] = 'Group has been updated.';
		    }
		    else
		    {
		        // Group information was not updated
		        $result['success'] = false;
				$result['message'] = 'There was a problem updating the group.';
		    }
		}
		catch (\Cartalyst\Sentry\Groups\NameRequiredException $e)
		{
			$result['success'] = false;
			$result['message'] = 'You must provide a group name.';
		}
		catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			$result['success'] = false;
			$result['message'] = 'That group already exists.';
		}
		catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			$result['success'] = false;
			$result['message'] = 'Group not found.';
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
		    // Find the group using the group id
		    $group = $this->sentry->findGroupById($id);

		    // Delete the group
		    $group->delete();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    return false;
		}
		return true;
	}

	/**
	 * Return a specific group by a given id
	 * 
	 * @param  integer $id
	 * @return Group
	 */
	public function byId($id)
	{
		try
		{
		    $group = $this->sentry->findGroupById($id);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    return false;
		}
		return $group;
	}

	/**
	 * Return a specific group by a given name
	 * 
	 * @param  string $name
	 * @return Group
	 */
	public function byName($name)
	{
		try
		{
		    $group = $this->sentry->findGroupByName($name);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    return false;
		}
		return $group;
	}

	/**
	 * Return all the registered groups
	 *
	 * @return stdObject Collection of groups
	 */
	public function all()
	{
		return $this->sentry->getGroupProvider()->findAll();
	}
}
