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
	 * Puzzle mutator to obtain a variable "puzzle_collection".
	 * This method get puzzle as JSON from database and return the puzzle
	 * as a collection.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getPuzzleCollectionAttribute()
	{
		return collect(json_decode($this->puzzle));
	}

	/**
	 * Solution mutator to obtain a variable "solution_collection".
	 * This method get puzzle as JSON from database and return the solution
	 * as a collection.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getSolutionCollectionAttribute()
	{
		return collect(json_decode($this->solution));
	}

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
