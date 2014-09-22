<?php namespace NukaCode\Core\Commands\Session;

class RegistrationCommand {

	/**
	 * @var string
	 */
	public $username;

	/**
	 * @var string
	 */
	public $password;

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @param string $username
	 * @param string $password
	 * @param string $email
	 */
	public function __construct($username, $password, $email)
	{
		$this->username = $username;
		$this->password = $password;
		$this->email    = $email;
	}

}