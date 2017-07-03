<?php

namespace sudoku\Domain\Sudokus\Resolvers\Repositories;

use sudoku\Domain\Sudokus\Resolvers\
{
	PuzzleCompartmentNode
};

class ResolversRepository
{

	const PUZZLE_NB_LINE = 9;
	const PUZZLE_NB_COLUMN = 9;
	const PUZZLE_MIN_VALUE = 1;
	const PUZZLE_MAX_VALUE = 9;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	protected $puzzle = null;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	protected $puzzleNodesStack = null;

	/**
	 * @var array
	 */
	protected $solution = [];

	/**
	 * @var PuzzleCompartmentNode
	 */
	protected $root_node = null;

	/**
	 * @param array $puzzle
	 */
	public function setPuzzle(array $puzzle) {
		$this->puzzle = collect($puzzle);
		$this->puzzleNodesStack = collect();

		$this->initializeGraphForPuzzle();
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getSolutionAsCollection() {
		if (is_null($this->root_node))
		{
			throw new \Exception('First node is empty!');
		}

		return collect();
	}

	/**
	 *
	 */
	protected function initializeGraphForPuzzle() {
		$this->validateBasicsOfThisPuzzle();

		$this
			->puzzle
			->each(function($row, $row_number)
			{

				collect($row)
					->each(function($compartment_value, $column_number) use ($row_number)
					{

						$current_row_number = $row_number + 1;
						$current_column_number = $column_number + 1;
						$previous_row_number = $current_row_number - 1;
						$previous_column_number = $current_column_number - 1;

						$current_node = new PuzzleCompartmentNode(
							$compartment_value,
							$current_row_number,
							$current_column_number,
							($compartment_value !== 0) // lock the value
						);

						if ($this->puzzleNodesStack->count())
						{
							$previous_node = $this->puzzleNodesStack->last();

							/*
							 * Set the next Node for the previous one
							 */
							$previous_node->setNextNodeInline($current_node);

							if (1 !== $current_column_number && 0 !== $previous_row_number)
							{
								$previous_node->setRightNodeInGrid($current_node);
							}

							/*
							 * Set the previous Node for the current one
							 */
							$current_node->setPreviousNodeInline($previous_node);

							if (1 !== $current_column_number)
							{
								$current_node->setLeftNodeInGrid($previous_node);
							}

							/*
							 * Look for previous top node
							 */
							$current_node_top = $this->retrieveTopNodeOf($current_node);

							if ($current_node_top instanceof PuzzleCompartmentNode)
							{
								$current_node_top->setBottomNodeInGrid($current_node);
								$current_node->setTopNodeInGrid($current_node_top);
							}
						}

						if (is_null($this->root_node))
						{
							$this->root_node = &$current_node;
						}

						$this->puzzleNodesStack->push($current_node);
					});
			});
	}

	/**
	 * @param PuzzleCompartmentNode $node
	 *
	 * @return PuzzleCompartmentNode
	 */
	protected function retrieveTopNodeOf(PuzzleCompartmentNode $node)
	{
		$root_node = $this->root_node;

		do
		{
			if (
				($root_node->getGridY() === $node->getGridY())
				&& ($root_node->getGridX() === ($node->getGridX() - 1))
			) {
				break;
			}
		} while (($root_node = $root_node->getNextNodeInline()) instanceof PuzzleCompartmentNode);

		return $root_node;
	}

	/**
	 * @throws \Exception
	 */
	protected function validateBasicsOfThisPuzzle() {
		// Check correct numbers of lines
		if (self::PUZZLE_NB_LINE !== $this->puzzle->count())
		{
			throw new \Exception('Error numbers of lines!');
		}

		// Check correct numbers of columns peer lines
		$this
			->puzzle
			->each(function($row)
			{
				if (self::PUZZLE_NB_COLUMN !== count($row))
				{
					throw new \Exception('Error numbers of columns!');
				}

				// Check is contained value are not 0 AND not between PUZZLE_MIN_VALUE & PUZZLE_MAX_VALUE
				collect($row)
					->each(function($compartment_value)
					{
						if (
							(0 !== $compartment_value)
							&& (self::PUZZLE_MIN_VALUE > $compartment_value || self::PUZZLE_MAX_VALUE < $compartment_value)
						)
						{
							throw new \Exception('Error compartment value error!');
						}
					});
			});
	}

	/*
	 ***************************************************************************
	 * HELPERS
	 ***************************************************************************
	 */

	/**
	 * Help method to display nodes values in column mode.
	 *
	 * @param int $column
	 */
	public function displayColumnOfPuzzleAsString($column)
	{
		$this
			->applyClosureOnNodesColumnStartingByFirstNodeInColumn(
				$column,
				function(PuzzleCompartmentNode $current_node)
				{
					echo $current_node->getValue();
					echo(is_null($current_node->getBottomNodeInGrid()) ? PHP_EOL : '');
				}
			);
	}

	/**
	 * Help method to walk through nodes in column mode.
	 *
	 * @param int      $column
	 * @param \Closure $callable
	 */
	public function applyClosureOnNodesColumnStartingByFirstNodeInColumn(
		$column,
		\Closure $callable
	) {

		$node = $this->root_node;

		do
		{
			if ($node->getGridY() === $column)
			{
				break;
			}
		} while (($node = $node->getNextNodeInline()) instanceof PuzzleCompartmentNode);

		do
		{
			$callable($node);
		} while (($node = $node->getBottomNodeInGrid()) instanceof PuzzleCompartmentNode);
	}

	/**
	 * Help method to display nodes values in row mode.
	 *
	 * @param int $row
	 */
	public function displayRowOfPuzzleAsString($row)
	{
		$this
			->applyClosureOnNodesRowsStartingByFirstNodeInRow(
				$row,
				function(PuzzleCompartmentNode $current_node)
				{
					echo $current_node->getValue();
					echo(is_null($current_node->getRightNodeInGrid()) ? PHP_EOL : '');
				}
			);
	}

	/**
	 * Help method to walk through nodes in row mode.
	 *
	 * @param int      $row
	 * @param \Closure $callable
	 */
	public function applyClosureOnNodesRowsStartingByFirstNodeInRow(
		$row,
		\Closure $callable
	) {

		$node = $this->root_node;

		do
		{
			if ($node->getGridX() === $row)
			{
				break;
			}
		} while (($node = $node->getNextNodeInline()) instanceof PuzzleCompartmentNode);

		do
		{
			$callable($node);
		} while (($node = $node->getRightNodeInGrid()) instanceof PuzzleCompartmentNode);
	}

	/*
	 * Help method to display nodes values in inline mode.
	 */
	public function displayPuzzleAsInlineString()
	{
		$this
			->applyClosureOnNodesInLineStartingByRootNode(
				function(PuzzleCompartmentNode $current_node)
				{
					echo $current_node->getValue();
					echo(is_null($current_node->getNextNodeInline()) ? PHP_EOL : '');
				}
			);
	}

	/**
	 * Help method to walk through nodes in inline mode.
	 *
	 * @param \Closure $callable
	 */
	public function applyClosureOnNodesInLineStartingByRootNode(\Closure $callable) {

		$node = $this->root_node;

		do
		{
			$callable($node);
		} while (($node = $node->getNextNodeInline()) instanceof PuzzleCompartmentNode);
	}
}
