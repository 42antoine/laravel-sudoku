<?php

namespace sudoku\Domain\Users\Users\Repositories;

use Illuminate\
{
	Support\Facades\Validator
};
use sudoku\Infrastructure\Contracts\
{
	Repositories\RepositoryEloquentAbstract,
	Request\RequestAbstract
};
use sudoku\Domain\Users\Users\
{
	User,
	Repositories\UsersRepositoryInterface,
	Events\UserCreatedEvent,
	Events\UserUpdatedEvent,
	Events\UserDeletedEvent,
	Presenters\UsersListPresenter,
	Criterias\EmailLikeCriteria
};

class UsersRepositoryEloquent extends RepositoryEloquentAbstract implements UsersRepositoryInterface
{

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return User::class;
	}

	/**
	 * Create user and fire event "UserCreatedEvent".
	 *
	 * @param array $attributes
	 *
	 * @event sudoku\Domain\Users\Users\Events\UserUpdatedEvent
	 * @return \sudoku\Domain\Users\Users\User
	 */
	public function create(array $attributes) {
		$user = parent::create($attributes);

		event(new UserCreatedEvent($user));

		return $user;
	}

	/**
	 * Update user and fire event "UserUpdatedEvent".
	 *
	 * @param array   $attributes
	 * @param integer $user_id
	 *
	 * @event sudoku\Domain\Users\Users\Events\UserUpdatedEvent
	 * @return \sudoku\Domain\Users\Users\User
	 */
	public function update(array $attributes, $user_id) {
		$user = parent::update($attributes, $user_id);

		event(new UserUpdatedEvent($user));

		return $user;
	}

	/**
	 * Delete user and fire event "UserDeletedEvent".
	 *
	 * @param array   $attributes
	 * @param integer $user_id
	 *
	 * @event sudoku\Domain\Users\Users\Events\UserDeletedEvent
	 * @return \sudoku\Domain\Users\Users\User
	 */
	public function delete($user_id) {
		$user = $this->find($user_id);

		parent::delete($user->id);

		event(new UserDeletedEvent($user));

		return $user;
	}

	/**
	 * Filter users by emails.
	 *
	 * @param string $email
	 *
	 * @return $this
	 */
	public function filterByEmail($email) {

		if (!is_null($email) && !empty($email))
		{
			$this->pushCriteria(new EmailLikeCriteria($email));
		}

		return $this;
	}
}
