<?php

namespace sudoku\Domain\Sudokus\Settlements;

use sudoku\Infrastructure\Contracts\Model\ModelAbstract;

class Settlement extends ModelAbstract
{

	const STATE_IN_PROGRESS = 'in_progress';
	const STATE_SOLVED = 'solved';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'sudoku_id',
		'state',
		'nb_solution_unveiled',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [

	];

	/**
	 * Get the user record associated with the settlements.
	 */
	public function user() {
		return $this->belongsTo(
			\sudoku\Domain\Users\Users\User::class
		);
	}

	/**
	 * Get the sudoku record associated with the settlements.
	 */
	public function sudoku() {
		return $this->belongsTo(
			\sudoku\Domain\Sudokus\Sudokus\Sudoku::class
		);
	}
}
