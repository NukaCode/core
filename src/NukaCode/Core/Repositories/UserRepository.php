<?php namespace NukaCode\Core\Repositories;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Session;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use NukaCode\Core\Requests\Ajax;
use NukaCode\Core\Servicing\Crud;

class UserRepository extends CoreRepository implements UserRepositoryInterface {

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \NukaCode\Core\Requests\Ajax
     */
    protected $ajax;

    /**
     * @var \NukaCode\Core\Servicing\Crud
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
        $user->email     = $input['email'];
        $user->firstName = $input['firstName'];
        $user->lastName  = $input['lastName'];
        $user->status_id = 1;

        $this->entity = $user;

        $result = $this->save();

        return $result;
    }

    /**
     * @param array $input
     */
    public function update($input)
    {
        $this->checkEntity();

        $input = e_array($input);

        if ($input != null) {
            $this->entity->displayName = $input['displayName'];
            $this->entity->firstName   = $input['firstName'];
            $this->entity->lastName    = $input['lastName'];
            $this->entity->email       = $input['email'];
            $this->entity->location    = $input['location'];
            $this->entity->url         = $input['url'];

            $this->save();
        }
    }

    public function delete()
    {
        $this->entity->delete();
    }

    public function updatePassword($input)
    {
        $this->checkEntity();

        $input = e_array($input);

        try {
            $this->entity->verifyPassword($input);
        } catch (\Exception $e) {
            $this->ajax->addError('password', $e->getMessage());

            return false;
        }

        // Save the new password
        $this->entity->password = $input['newPassword'];

        $this->save();
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