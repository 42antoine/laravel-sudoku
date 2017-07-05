<?php

namespace sudoku\Http\Controllers\Frontend;

use sudoku\Infrastructure\Contracts\Controllers\ControllerAbstract;
use sudoku\Domain\Sudokus\Sudokus\Repositories\SudokusRepositoryEloquent;
use sudoku\Http\Request\Frontend\Sudokus\
{
	SudokuIndexFormRequest
};

class SudokuController extends ControllerAbstract
{

	/**
	 * @var null|SudokusRepositoryEloquent
	 */
	protected $r_sudoku = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(SudokusRepositoryEloquent $r_sudoku) {
		$this->middleware('auth');

		$this->r_sudoku = $r_sudoku;
	}

	/**
	 * Show the sudoku application.
	 *
	 * @param SudokuIndexFormRequest $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(SudokuIndexFormRequest $request) {
		return $this
			->r_sudoku
			->frontendIndexDisplaySudokuView($request);
	}
}
