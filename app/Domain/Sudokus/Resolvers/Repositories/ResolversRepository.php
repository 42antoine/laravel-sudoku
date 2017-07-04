<?php

namespace sudoku\Domain\Sudokus\Resolvers\Repositories;

use sudoku\Domain\Sudokus\Resolvers\
{
	Traits\NodeManager,
	Traits\NodePuzzleBacktracking
};

class ResolversRepository
{

	use NodeManager;
	use NodePuzzleBacktracking;

	const PUZZLE_NB_LINE = 9;
	const PUZZLE_NB_COLUMN = 9;
	const PUZZLE_MIN_VALUE = 1;
	const PUZZLE_MAX_VALUE = 9;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	protected $puzzle = null;

	/**
	 * @var array
	 */
	protected $solution = [];

	/**
	 * @param array $puzzle
	 */
	public function setPuzzle(array $puzzle) {

		$this->puzzle = collect($puzzle);

		$this->initializeGraphForPuzzle();

//		$this->displayColumnOfPuzzleAsString(2);
//		$this->displayRowOfPuzzleAsString(2);
//		$this->displayPuzzleSubGrid(5);
//		$this->displayPuzzleAsInlineString();
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getSolutionAsCollection() {

		if (is_null($this->root_node))
		{
			throw new \Exception('First node is empty!');
		}

		return $this->getSolutionPuzzleAsCollection();
	}
}
