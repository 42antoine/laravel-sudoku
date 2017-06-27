<?php

namespace sudoku\Domain\Users\Users\Events;

use sudoku\Infractucture\Contracts\Events\EventAbstract;
use sudoku\Domain\Users\Users\User;

class UserDeletedEvent extends EventAbstract
{

	/**
	 * @var User|null
	 */
	public $user = null;

	/**
	 * UserDeletedEvent constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}
}
