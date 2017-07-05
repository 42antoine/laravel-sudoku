<?php

namespace sudoku\Domain\Sudokus\Resolvers\Traits;

use sudoku\Domain\Sudokus\Resolvers\
{
	PuzzleCompartmentNode
};

trait NodePuzzleBacktracking
{

	/**
	 * @var null|\Illuminate\Support\Collection
	 */
	protected $subgrids = null;

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getSolutionPuzzleAsCollection() {

		if (81 !== $this->puzzleNodesStack->count())
		{
			throw new \Exception('Impossible to resolve puzzle, grid not complete!');
		}

		$this->subgrids = collect([
			1 => collect([1, 2, 3, 10, 11, 12, 19, 20, 21]),
			2 => collect([4, 5, 6, 13, 14, 15, 22, 23, 24]),
			3 => collect([7, 8, 9, 16, 17, 18, 25, 26, 27]),
			4 => collect([28, 29, 30, 37, 38, 39, 46, 47, 48]),
			5 => collect([31, 32, 33, 40, 41, 42, 49, 50, 51]),
			6 => collect([34, 35, 36, 43, 44, 45, 52, 53, 54]),
			7 => collect([55, 56, 57, 64, 65, 66, 73, 74, 75]),
			8 => collect([58, 59, 60, 67, 68, 69, 76, 77, 78]),
			9 => collect([61, 62, 63, 70, 71, 72, 79, 80, 81]),
		]);

		if (!$this->runBacktracking($this->root_node))
		{
			throw new \Exception('Unable to solve the puzzle');
		}

		return $this->solutionAsCollection();
	}

	/**
	 * @param PuzzleCompartmentNode $node
	 *
	 * @return bool
	 */
	protected function runBacktracking(PuzzleCompartmentNode $node) {

		$returnValue = false;

		if (
			$node->isValueLocked()
			&& $node->getNextNodeInline() instanceof PuzzleCompartmentNode
		)
		{
			return $this
				->runBacktracking(
					$node->getNextNodeInline()
				);
		}
		else if (
			$node->isValueLocked()
			&& is_null($node->getNextNodeInline())
		)
		{

			/*
			 * End of puzzle grid, we did it!
			 */

			return true;
		}

		collect(range(1, 9))
			->each(function($value) use ($node, &$returnValue)
			{

				// xABE Todo : Optimize position calculation
				$position_in_grid = $node->getPosition(); // ($node->getGridX() * 9) + ($node->getGridY());

				$subgrid = $this
					->subgrids
					->filter(function($item) use ($position_in_grid)
					{
						return $item->containsStrict($position_in_grid)
							? $item
							: null;
					})
					->keys()
					->first();

				if (
					!$this->isValueExistOnRow($value, $node->getGridX())
					&& !$this->isValueExistOnColumn($value, $node->getGridY())
					&& !$this->isValueExistOnSubGrid($value, $subgrid)
				)
				{
					$node->setValue($value);

					if (is_null($node->getNextNodeInline()))
					{

						/*
						 * End of puzzle grid, we did it!
						 */

						$returnValue = true;
					}
					else if ($node->getNextNodeInline() instanceof PuzzleCompartmentNode)
					{
						$returnValue = $this
							->runBacktracking(
								$node->getNextNodeInline()
							);
					}

					if ($returnValue)
					{
						// break;
						return false;
					}
				}
			});

		// No working solution, reset the node value and step back
		if (false === $returnValue)
		{
			$node->setValue(0);
		}

		return $returnValue;
	}

	/**
	 * @param $value
	 * @param $row
	 *
	 * @return bool
	 */
	public function isValueExistOnRow($value, $row) {
		$valueExists = false;

		$this
			->applyClosureOnNodesRowsStartingByFirstNodeInRow(
				$row,
				function(PuzzleCompartmentNode $node) use ($value, &$valueExists)
				{
					if ($value === $node->getValue())
					{
						$valueExists = true;
					}
				}
			);

		return $valueExists;
	}

	/**
	 * @param $value
	 * @param $column
	 *
	 * @return bool
	 */
	public function isValueExistOnColumn($value, $column) {
		$valueExists = false;

		$this
			->applyClosureOnNodesColumnStartingByFirstNodeInColumn(
				$column,
				function(PuzzleCompartmentNode $node) use ($value, &$valueExists)
				{
					if ($value === $node->getValue())
					{
						$valueExists = true;
					}
				}
			);

		return $valueExists;
	}

	/**
	 * @param $value
	 * @param $subgrid
	 *
	 * @return bool
	 */
	public function isValueExistOnSubGrid($value, $subgrid) {
		$valueExists = false;

		$this
			->applyClosureOnNodesSubGridStartingByFirstNodeInSubGrid(
				$subgrid,
				function(PuzzleCompartmentNode $node) use ($value, &$valueExists)
				{
					if ($value === $node->getValue())
					{
						$valueExists = true;
					}
				}
			);

		return $valueExists;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	protected function solutionAsCollection() {
		$solution = collect();

		collect(range(1, 9))
			->each(function($row) use ($solution)
			{

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
