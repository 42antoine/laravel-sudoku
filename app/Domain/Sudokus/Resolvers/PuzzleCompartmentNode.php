<?php

namespace sudoku\Domain\Sudokus\Resolvers;

class PuzzleCompartmentNode
{

	/**
	 * @var int
	 */
	protected $value = 0;

	/**
	 * @var bool
	 */
	protected $isValueLocked = false;

	/**
	 * @var int
	 */
	protected $position = 0;

	/*
	 * The Grid could be display as a simple line (no line, no row)
	 */

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $previous_node_inline = null;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $next_node_inline = null;

	/*
	 * A Grid represent the total 81 compartment in puzzle
	 */

	/**
	 * X position in puzzle grid
	 * @var int
	 */
	protected $grid_x = 0;

	/**
	 * Y position in puzzle grid
	 * @var int
	 */
	protected $grid_y = 0;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $grid_left_node = null;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $grid_top_node = null;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $grid_right_node = null;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $grid_bottom_node = null;

	/*
	 * A SubGrid is an internal grid of 9 compartment
	 */

	/**
	 * X position in puzzle subgrid
	 * @var int
	 */
	protected $subgrid_x = 0;

	/**
	 * Y position in puzzle subgrid
	 * @var int
	 */
	protected $subgrid_y = 0;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $subgrid_left_node = null;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $subgrid_top_node = null;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $subgrid_right_node = null;

	/**
	 * @var null|PuzzleCompartmentNode
	 */
	protected $subgrid_bottom_node = null;

	/**
	 * PuzzleCompartmentNode constructor.
	 *
	 * @param integer $compartment_value
	 * @param integer $grid_x
	 * @param integer $grid_y
	 * @param bool    $locked_value
	 */
	public function __construct(
		$compartment_value,
		$grid_x,
		$grid_y,
		$locked_value = false
	) {
		$this->value = $compartment_value;
		$this->grid_x = $grid_x;
		$this->grid_y = $grid_y;
		$this->isValueLocked = $locked_value;
	}

	/**
	 * @return int
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param integer $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * xABE Todo : Optimize position calculation
	 *
	 * @return int
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * xABE Todo : Optimize position calculation
	 *
	 * @param integer $value
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * @return int
	 */
	public function isValueLocked() {
		return $this->isValueLocked;
	}

	/**
	 * @return int
	 */
	public function getGridX() {
		return $this->grid_x;
	}

	/**
	 * @return int
	 */
	public function getGridY() {
		return $this->grid_y;
	}

	/**
	 * @param PuzzleCompartmentNode $previous_node
	 *
	 * @return $this
	 */
	public function setPreviousNodeInline(PuzzleCompartmentNode &$previous_node) {
		$this->previous_node_inline = $previous_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getPreviousNodeInline() {
		return $this->previous_node_inline;
	}

	/**
	 * @param PuzzleCompartmentNode $next_node
	 *
	 * @return $this
	 */
	public function setNextNodeInline(PuzzleCompartmentNode &$next_node) {
		$this->next_node_inline = $next_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getNextNodeInline() {
		return $this->next_node_inline;
	}

	/**
	 * @param PuzzleCompartmentNode $grid_left_node
	 *
	 * @return $this
	 */
	public function setLeftNodeInGrid(PuzzleCompartmentNode &$grid_left_node) {
		$this->grid_left_node = $grid_left_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getLeftNodeInGrid() {
		return $this->grid_left_node;
	}

	/**
	 * @param PuzzleCompartmentNode $grid_top_node
	 *
	 * @return $this
	 */
	public function setTopNodeInGrid(PuzzleCompartmentNode &$grid_top_node) {
		$this->grid_top_node = $grid_top_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getTopNodeInGrid() {
		return $this->grid_top_node;
	}

	/**
	 * @param PuzzleCompartmentNode $grid_right_node
	 *
	 * @return $this
	 */
	public function setRightNodeInGrid(PuzzleCompartmentNode &$grid_right_node) {
		$this->grid_right_node = $grid_right_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getRightNodeInGrid() {
		return $this->grid_right_node;
	}

	/**
	 * @param PuzzleCompartmentNode $grid_bottom_node
	 *
	 * @return $this
	 */
	public function setBottomNodeInGrid(PuzzleCompartmentNode &$grid_bottom_node) {
		$this->grid_bottom_node = $grid_bottom_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getBottomNodeInGrid() {
		return $this->grid_bottom_node;
	}

	/**
	 * @param PuzzleCompartmentNode $subgrid_left_node
	 *
	 * @return $this
	 */
	public function setLeftNodeInSubGrid(PuzzleCompartmentNode &$subgrid_left_node) {
		$this->subgrid_left_node = $subgrid_left_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getLeftNodeInSubGrid() {
		return $this->subgrid_left_node;
	}

	/**
	 * @param PuzzleCompartmentNode $subgrid_top_node
	 *
	 * @return $this
	 */
	public function setTopNodeInSubGrid(PuzzleCompartmentNode &$subgrid_top_node) {
		$this->subgrid_top_node = $subgrid_top_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getTopNodeInSubGrid() {
		return $this->subgrid_top_node;
	}

	/**
	 * @param PuzzleCompartmentNode $subgrid_right_node
	 *
	 * @return $this
	 */
	public function setRightNodeInSubGrid(PuzzleCompartmentNode &$subgrid_right_node) {
		$this->subgrid_right_node = $subgrid_right_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getRightNodeInSubGrid() {
		return $this->subgrid_right_node;
	}

	/**
	 * @param PuzzleCompartmentNode $subgrid_bottom_node
	 *
	 * @return $this
	 */
	public function setBottomNodeInSubGrid(PuzzleCompartmentNode &$subgrid_bottom_node) {
		$this->subgrid_bottom_node = $subgrid_bottom_node;

		return $this;
	}

	/**
	 * @return null|PuzzleCompartmentNode
	 */
	public function getBottomNodeInSubGrid() {
		return $this->subgrid_bottom_node;
	}
}
