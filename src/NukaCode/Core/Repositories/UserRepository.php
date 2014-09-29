<?php namespace NukaCode\Core\Repositories;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Session;
use Laracasts\Commander\Events\EventGenerator;
use NukaCode\Core\Events\UserWasCreated;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use NukaCode\Core\Requests\Ajax;
use NukaCode\Core\Services\Crud;
use NukaCode\Core\View\Image;

class UserRepository extends CoreRepository implements UserRepositoryInterface {

	use EventGenerator;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \NukaCode\Core\Requests\Ajax
     */
    protected $ajax;

    /**
     * @var \NukaCode\Core\Services\Crud
     */
    private $crud;

    public function __construct(\User $user, Dispatcher $events, Ajax $ajax, Crud $crud)
    {
        $this->model  = $user;
        $this->events = $events;
        $this->ajax   = $ajax;
        $this->crud   = $crud;
    }

    public function set($user)
    {
        if ($user instanceof \User) {
            $this->entity = $user;
        } else {
            throw new \InvalidArgumentException('Invalid user passed.');
        }
    }

    public function create($input)
    {
        $user            = new \User;
        $user->username  = $input['username'];
        $user->password  = $input['password'];
        $user->email     = $input['email'];
        $user->status_id = 1;

        if (isset($input['firstName'])) {
            $user->firstName = $input['firstName'];
        }

        if (isset($input['lastName'])) {
            $user->lastName  = $input['lastName'];
        }

        $this->entity = $user;

		$result = $this->save();

		if ($result) {
			// Send out the event
			$this->raise(new UserWasCreated($this->getEntity()));
		}

        return $result;
    }

    /**
     * @param array $input
     */
    public function update($input)
    {
        $this->checkEntity();
        $this->requireSingle();

        $input = e_array($input);

        if ($input != null) {
            $this->entity->displayName = $this->arrayOrEntity('displayName', $input);
            $this->entity->firstName   = $this->arrayOrEntity('firstName', $input);
            $this->entity->lastName    = $this->arrayOrEntity('lastName', $input);
            $this->entity->email       = $this->arrayOrEntity('email', $input);
            $this->entity->location    = $this->arrayOrEntity('location', $input);
            $this->entity->url         = $this->arrayOrEntity('url', $input);

            $this->save();
        }
    }

    public function addRole($roleId)
    {
        $this->checkEntity();
        $this->requireSingle();

        try {
            $this->entity->roles()->attach($roleId);

            $this->save();
        } catch (\Exception $e) {
            $this->ajax->setStatus('error');
            $this->ajax->addError('role', $e->getMessage());

            return false;
        }
    }

    public function removeRole($roleId)
    {
        $this->checkEntity();
        $this->requireSingle();

        try {
            $this->entity->roles()->detach($roleId);

            $this->save();
        } catch (\Exception $e) {
            $this->ajax->setStatus('error');
            $this->ajax->addError('role', $e->getMessage());

            return false;
        }
    }

    public function setRoles($roleIds = array())
    {
        $this->checkEntity();
        $this->requireSingle();

        try {
            $this->entity->roles()->detach();

            if (count($roleIds) > 0) {
                $this->entity->roles()->attach($roleIds);
            }

            $this->save();
        } catch (\Exception $e) {
            $this->ajax->setStatus('error');
            $this->ajax->addError('roles', $e->getMessage());

            return false;
        }
    }

    public function updatePassword($input)
    {
        $this->checkEntity();
        $this->requireSingle();

        $input = e_array($input);

        try {
            $this->entity->verifyPassword($input);
        } catch (\Exception $e) {
            $this->ajax->setStatus('error');
            $this->ajax->addError('password', $e->getMessage());

            return false;
        }

        // Save the new password
        $this->entity->password = $input['new_password'];

        $this->save();
    }

	public function uploadAvatar($avatar, $username)
	{
		$image = new Image;
		$results = $image->addImage(public_path('img/avatars/User'), $avatar, \Str::studly($username));

		return $results;
	}

    public function crud()
    {
        // Set up the one page crud main details
        $this->crud->setTitle('Users')
            ->setSortProperty('username')
            ->setDeleteLink('/admin/users/user-delete/')
            ->setDeleteProperty('id')
//               ->setPaginationFlag(true)
            ->setResources($this->paginate(20));

        // Add the display columns
        $this->crud->addDisplayField('username', '/user/view/', 'id')
            ->addDisplayField('email', 'mailto');

        // Add the form fields
        $this->crud->addFormField('username', 'text', null, true)
            ->addFormField('email', 'email', null, true)
            ->addFormField('firstName', 'text')
            ->addFormField('lastName', 'text');

        $this->crud->make();
    }

    protected function checkEntity()
    {
        if ($this->entity == null) {
            $this->entity = Session::get('activeUser');
        }
    }

}