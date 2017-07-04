<?php

namespace sudoku\Domain\Sudokus\Resolvers\Traits;

use sudoku\Domain\Sudokus\Resolvers\
{
	PuzzleCompartmentNode
};

trait NodePuzzleBacktracking
{

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getSolutionPuzzleAsCollection()
	{
		return collect();
	}
}
