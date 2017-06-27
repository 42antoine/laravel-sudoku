<?php

namespace sudoku\Http\Controllers\Frontend;

use sudoku\Infrastructure\Contracts\Controllers\ControllerAbstract;
use Xeeeveee\Sudoku\Puzzle;

class SudokuController extends ControllerAbstract
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		// Is the puzzle solvable ?
		$isSolvable = false;

		// Puzzle size
		$cellSize = 3;

		// New puzzle
		$puzzle = new Puzzle();

		// Execute until a resolvable puzzle is generated
		do
		{
			// Create new puzzle
			$puzzle->generatePuzzle($cellSize);
			// Get the solution and check it
			$isSolvable = $puzzle->isSolvable();
		} while (false === $isSolvable);

		// Get puzzle as array
		$thePuzzle = $puzzle->getPuzzle();
		// Get puzzle solution as array
		$theSolution = $puzzle->getSolution();

		//		var_dump($thePuzzle);
		//		var_dump($theSolution);
		//		var_dump($isSolvable);

		return view(
			'frontend.sudoku.index',
			[
				'thePuzzle'   => $thePuzzle,
				'theSolution' => $theSolution,
				'isSolvable'  => $isSolvable
			]
		);
	}
}
