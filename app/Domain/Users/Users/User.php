<?php

namespace sudoku\Domain\Users\Users;

use Illuminate\Notifications\Notifiable;
use sudoku\Infrastructure\Contracts\Model\AuthenticatableModelAbstract;

class User extends AuthenticatableModelAbstract
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'email',
		'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
		'remember_token',
    ];

	/**
	 * Get the sudokus record associated with the user.
	 */
	public function sudokus()
	{
		return $this->hasMany(
			\sudoku\Domain\Sudokus\Sudokus\Sudoku::class
		);
	}

	/**
	 * Get the settlements record associated with the user.
	 */
	public function settlements()
	{
		return $this->hasMany(
			\sudoku\Domain\Sudokus\Settlements\Settlement::class
		);
	}
}
