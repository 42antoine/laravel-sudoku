<?php

namespace sudoku\Domain\Sudokus\Resolvers\Traits;

use sudoku\Domain\Sudokus\Resolvers\
{
	PuzzleCompartmentNode
};

trait NodeManager
{

	/**
	 * @var PuzzleCompartmentNode
	 */
	protected $root_node = null;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	protected $puzzleNodesStack = null;

	/**
	 * NodeManager constructor.
	 */
	public function __construct() {
		$this->puzzleNodesStack = collect();
	}

	/**
	 * Create instance of PuzzleCompartmentNode.
	 *
	 * @param      $compartment_value
	 * @param      $grid_x
	 * @param      $grid_y
	 * @param bool $locked_value
	 *
	 * @return PuzzleCompartmentNode
	 */
	public function createAPuzzleCompartmentNode(
		$compartment_value,
		$grid_x,
		$grid_y,
		$locked_value = false
	) {
		return new PuzzleCompartmentNode(
			$compartment_value,
			$grid_x,
			$grid_y,
			$locked_value
		);
	}

	/**
	 * Initialize Nodes and links between nodes.
	 *
	 * - Create links to access Nodes as inline
	 * - Create links to access Nodes as a grid
	 * - Create links to access Nodes as a subgrid
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

						$current_node = $this
							->createAPuzzleCompartmentNode(
								$compartment_value,
								$current_row_number,
								$current_column_number,
								($compartment_value !== 0) // lock if value
							);

						$this
							->setOrientationOfNewNode(
								$current_node,
								$current_row_number,
								$current_column_number,
								$previous_row_number,
								$previous_column_number
							);

						if (is_null($this->root_node))
						{
							$this->root_node = &$current_node;
						}

						$this->puzzleNodesStack->push($current_node);
					});
			});

		$this->setOrientationOfNodesAsSubGrid();
	}

	/**
	 * Create links between nodes in sub grid context.
	 *
	 * @param PuzzleCompartmentNode $node
	 */
	protected function isolateNodeToSubGridContext(PuzzleCompartmentNode $current_node) {

		$modulo_rest_X = $current_node->getGridX() % 3;
		$modulo_rest_Y = $current_node->getGridY() % 3;

		$is_node_have_right_node_in_subgrid = ($modulo_rest_X !== 0) || ($modulo_rest_Y !== 0);

		if ($is_node_have_right_node_in_subgrid)
		{
			$this
				->applyClosureOnNodesInLineStartingByRootNode(
					function(PuzzleCompartmentNode $node) use ($current_node)
					{
						if (
							is_null($current_node->getRightNodeInSubGrid())
							&& (
							(
									// Identify the previous compartment on same row
									$current_node->getGridY() % 3 !== 0
									&& $node->getGridX() === $current_node->getGridX()
									&& $node->getGridY() === ($current_node->getGridY() + 1)
								)
								|| (
									// Identify the last compartment on previous row
									($current_node->getGridY() % 3 === 0 && $current_node->getGridX() % 3 !== 0)
									&& ($node->getGridX() % 3 !== 1 && $node->getGridY() % 3 === 1)
									&& $node->getGridX() === ($current_node->getGridX() + 1)
									&& $node->getGridY() === ($current_node->getGridY() - 2)
								)
							)
						)
						{
							$current_node->setRightNodeInSubGrid($node);
						}
					}
				);
		}
	}

	/**
	 *
	 */
	protected function setOrientationOfNodesAsSubGrid() {
		$this
			->applyClosureOnNodesInLineStartingByRootNode(function($node)
			{
				$this->isolateNodeToSubGridContext($node);
			});
	}

	/**
	 * Find a Node located to top of this Node.
	 *
	 * @param PuzzleCompartmentNode $node
	 *
	 * @return PuzzleCompartmentNode
	 */
	protected function retrieveTopNodeOf(PuzzleCompartmentNode $node) {
		$root_node = $this->root_node;

		do
		{
			if (
				($root_node->getGridY() === $node->getGridY())
				&& ($root_node->getGridX() === ($node->getGridX() - 1))
			)
			{
				break;
			}
		} while (($root_node = $root_node->getNextNodeInline()) instanceof PuzzleCompartmentNode);

		return $root_node;
	}

	/**
	 * Set foreign node for a node.
	 *
	 * @param PuzzleCompartmentNode $current_node
	 * @param integer               $current_row_number
	 * @param integer               $current_column_number
	 * @param integer               $previous_row_number
	 * @param integer               $previous_column_number
	 */
	protected function setOrientationOfNewNode(
		PuzzleCompartmentNode $current_node,
		$current_row_number,
		$current_column_number,
		$previous_row_number,
		$previous_column_number
	) {

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
			 * Look for previous top node, if found set current node as bottom
			 * one for the previous top node
			 */
			$current_node_top = $this->retrieveTopNodeOf($current_node);

			if ($current_node_top instanceof PuzzleCompartmentNode)
			{
				$current_node_top->setBottomNodeInGrid($current_node);
				$current_node->setTopNodeInGrid($current_node_top);
			}
		}
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
	 * Help method to display nodes values in subgrid mode.
	 *
	 * @param integer $subgrid_id [1-9]
	 */
	public function displayPuzzleSubGrid($subgrid_id) {

		$current_node = null;

		$coordinates = collect([
			1 => ['x' => 1, 'y' => 1],
			2 => ['x' => 1, 'y' => 4],
			3 => ['x' => 1, 'y' => 7],
			4 => ['x' => 4, 'y' => 1],
			5 => ['x' => 4, 'y' => 4],
			6 => ['x' => 4, 'y' => 7],
			7 => ['x' => 7, 'y' => 1],
			8 => ['x' => 7, 'y' => 4],
			9 => ['x' => 7, 'y' => 7],
		]);

		$parent_subgrid_node = $this
			->puzzleNodesStack
			->filter(function(PuzzleCompartmentNode $node) use ($subgrid_id, $coordinates)
			{
				return $coordinates->get($subgrid_id)['x'] === $node->getGridX()
					&& $coordinates->get($subgrid_id)['y'] === $node->getGridY();
			})
			->first();

		do
		{

			echo $parent_subgrid_node->getValue();
			echo(is_null($parent_subgrid_node->getRightNodeInSubGrid()) ? PHP_EOL : '');

		} while (($parent_subgrid_node = $parent_subgrid_node->getRightNodeInSubGrid()) instanceof PuzzleCompartmentNode);
	}

	/**
	 * Help method to display nodes values in column mode.
	 *
	 * @param int $column
	 */
	public function displayColumnOfPuzzleAsString($column) {
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
	public function displayRowOfPuzzleAsString($row) {
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
	public function displayPuzzleAsInlineString() {
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
