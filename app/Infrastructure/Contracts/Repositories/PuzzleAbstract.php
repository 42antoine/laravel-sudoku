<?php

namespace sudoku\Infrastructure\Contracts\Repositories;

use Xeeeveee\Sudoku\Puzzle;
use sudoku\Infrastructure\Interfaces\Repositories\PuzzleInterface;

abstract class PuzzleAbstract extends Puzzle implements PuzzleInterface
{

	/**
	 * Get puzzle as collection.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getPuzzleAsCollection()
	{
		return collect($this->getPuzzle());
	}

	/**
	 * Get solution as collection.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getSolutionAsCollection()
	{
		return collect($this->getSolution());
	}

	/**
	 * Get puzzle as json.
	 *
	 * @return string
	 */
	public function getPuzzleAsJson()
	{
		return $this->getPuzzleAsCollection()->toJson();
	}

	/**
	 * Get solution as collection.
	 *
	 * @return string
	 */
	public function getSolutionAsJson()
	{
		return $this->getSolutionAsCollection()->toJson();
	}
}
