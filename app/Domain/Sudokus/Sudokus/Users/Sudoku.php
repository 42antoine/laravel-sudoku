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

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [

	];
}
