<?php namespace NukaCode\Core\Commands\Session;

use Illuminate\Auth\AuthManager;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;

class RegistrationCommandHandler implements CommandHandler {

	use DispatchableTrait;

	/**
	 * @var UserRepositoryInterface
	 */
	private $user;

	/**
	 * @var AuthManager
	 */
	private $auth;

	/**
	 * @param UserRepositoryInterface $user
	 * @param AuthManager             $auth
	 */
	public function __construct(UserRepositoryInterface $user, AuthManager $auth)
	{
		$this->user = $user;
		$this->auth = $auth;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return boolean
     */
    public function handle($command)
    {
		// Create the new user
		$result = $this->user->create((array)$command);

		if ($result) {
			// Assign the guest role
			$this->user->addRole(\Config::get('core::roles.main.guest'));

			// Log the user in
			$this->auth->login($this->user->getEntity());
		}

		// Send the events for this process
		$this->dispatchEventsFor($this->user);

		return $result;
    }

}