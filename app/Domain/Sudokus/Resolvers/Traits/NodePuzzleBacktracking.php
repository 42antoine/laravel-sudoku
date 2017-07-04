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
	public function getSolutionPuzzleAsCollection() {
		$this->runBacktracking();

		return $this->solutionAsCollection();
	}

	/**
	 *
	 */
	protected function runBacktracking() {

	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	protected function solutionAsCollection() {
		$solution = collect();

		collect(range(1, 9))
			->each(function($row) use ($solution) {

				$row_values = [];

				$this
					->applyClosureOnNodesRowsStartingByFirstNodeInRow(
						$row,
						function(PuzzleCompartmentNode $current_node) use (&$row_values)
						{
							$row_values[] = $current_node->getValue();
						}
					);

				$solution->push($row_values);
			});

		return $solution;
	}
}
