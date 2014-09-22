<?php namespace NukaCode\Core\Events;

class UserWasCreated {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

} 