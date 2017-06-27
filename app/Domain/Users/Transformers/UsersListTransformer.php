<?php

namespace sudoku\Domain\Users\Users\Transformers;

use sudoku\Infrastructure\Contracts\Transformers\TransformerAbstract;
use sudoku\Domain\Users\Users\User;

class UsersListTransformer extends TransformerAbstract
{

	/**
	 * Transform the User entity
	 *
	 * @param User $model
	 *
	 * @return array
	 */
	public function transform(User $model) {
		$profile_id = 0;

		if ($model->is_customer)
		{
			$profile_id = $model->profilecustomer->id;
		}
		else if ($model->is_trainer)
		{
			$profile_id = $model->profiletrainer->id;
		}

		$data = [
			'id'              => (int)$model->id,
			'profile_id'      => (int)$profile_id,
			'civility'        => [
				'value' => $model->civility,
				'trans' => trans('users.civilities.' . $model->civility)
			],
			'last_name'       => $model->last_name,
			'first_name'      => $model->first_name,
			'full_name'       => $model->full_name,
			'email'           => $model->email,
			'mail_signature'  => $model->profile->mail_signature,
			'department_id'   => $model->departments()->pluck('id')->implode(','),
			'department_name' => $model->departments()->pluck('title')->implode(', '),
		];

		/**
		 * Roles list
		 */

		$roles = [];
		foreach ($model->roles as $role)
		{
			$roles[] = trans($role->display_name);
			$data['roles']['ids'][] = $role->id;
		}
		sort($roles);
		$data['roles']['as_string'] = implode(',' . PHP_EOL, $roles);
		$data['roles']['is_superadmin'] = (bool)$model->is_superadmin;
		$data['roles']['is_admin'] = (bool)$model->is_admin;
		$data['roles']['is_customer'] = (bool)$model->is_customer;
		$data['roles']['is_trainer'] = (bool)$model->is_trainer;

		return $data;
	}

}
