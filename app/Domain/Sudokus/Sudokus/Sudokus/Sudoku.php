<?php

namespace sudoku\Domain\Sudokus\Sudokus;

use sudoku\Infrastructure\Contracts\Model\ModelAbstract;

class Sudoku extends ModelAbstract
{

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'puzzle',
		'solution',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [

	];

	/**
	 * Get the user record associated with the sudoku.
	 */
	public function user()
	{
		return $this->belongsTo(
			\sudoku\Domain\Users\Users\User::class
		);
	}
}
