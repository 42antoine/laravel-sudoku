<?php

namespace sudoku\Infrastructure\Interfaces\Repositories;

interface PuzzleInterface
{

	/**
	 * Get puzzle as collection.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getPuzzleAsCollection();

	/**
	 * Get solution as collection.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getSolutionAsCollection();

	/**
	 * Get puzzle as json.
	 *
	 * @return string
	 */
	public function getPuzzleAsJson();

	/**
	 * Get solution as collection.
	 *
	 * @return string
	 */
	public function getSolutionAsJson();
}
