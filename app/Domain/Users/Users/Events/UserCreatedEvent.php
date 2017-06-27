<?php

namespace sudoku\Domain\Users\Users\Events;

use sudoku\Infractucture\Contracts\Events\EventAbstract;
use sudoku\Domain\Users\Users\User;

class UserCreatedEvent extends EventAbstract
{

	/**
	 * @var User|null
	 */
	public $user = null;

	/**
	 * UserCreatedEvent constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}
}
