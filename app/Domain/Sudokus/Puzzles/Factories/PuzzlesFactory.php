<?php

namespace sudoku\Domain\Sudokus\Puzzles\Factories;

use sudoku\Domain\Sudokus\Puzzles\
{
	Repositories\PuzzlesRepository
};

class PuzzlesFactory
{

	/**
	 * @return PuzzlesRepository
	 */
	public function createNewPuzzleRepository() {
		return app()->make(PuzzlesRepository::class);
	}
}
