<?php

namespace sudoku\Domain\Sudokus\Sudokus\Repositories;

use Illuminate\Container\Container as Application;
use sudoku\Domain\Sudokus\Puzzles\Factories\PuzzlesFactory;
use sudoku\Infrastructure\Contracts\
{
	Repositories\RepositoryEloquentAbstract,
	Request\RequestAbstract
};
use sudoku\Domain\Sudokus\Sudokus\
{
	Sudoku,
	Repositories\SudokusRepositoryInterface
};

class SudokusRepositoryEloquent extends RepositoryEloquentAbstract implements SudokusRepositoryInterface
{

	/**
	 * @var null|PuzzlesFactory
	 */
	protected $f_puzzles = null;

	/**
	 * SudokusRepositoryEloquent constructor.
	 *
	 * @param Application       $application
	 * @param PuzzlesFactory $r_puzzles
	 */
	public function __construct(
		Application $application,
		PuzzlesFactory $f_puzzles
	) {
		parent::__construct($application);

		$this->f_puzzles = $f_puzzles;
	}

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return Sudoku::class;
	}

	/**
	 * Create sudoku.
	 *
	 * @param array $attributes
	 *
	 * @return \sudoku\Domain\Sudokus\Sudokus\Sudoku
	 */
	public function create(array $attributes) {
		$sudoku = parent::create($attributes);

		return $sudoku;
	}

	/**
	 * Update sudoku.
	 *
	 * @param array   $attributes
	 * @param integer $sudoku_id
	 *
	 * @return \sudoku\Domain\Sudokus\Sudokus\Sudoku
	 */
	public function update(array $attributes, $sudoku_id) {
		$sudoku = parent::update($attributes, $sudoku_id);

		return $sudoku;
	}

	/**
	 * Delete sudoku.
	 *
	 * @param array   $attributes
	 * @param integer $sudoku_id
	 *
	 * @return \sudoku\Domain\Sudokus\Sudokus\Sudoku
	 */
	public function delete($sudoku_id) {
		$sudoku = $this->find($sudoku_id);

		parent::delete($sudoku->id);

		return $sudoku;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function frontendIndexDisplaySudokuView(RequestAbstract $request) {

		// Puzzle size
		$cellSize = 25;

		if ($request->has('cell_size'))
		{
			// str to int - in 5, 15, 25
			$cellSize = intval($request->get('cell_size'));
		}

		$puzzle = $this->generatePuzzleFromConstraints($cellSize);

		/*
		 * Register puzzle
		 */

		$sudoku = $this->create([
			'user_id'  => \Auth::user()->id,
			'puzzle'   => $puzzle->getPuzzleAsJson(),
			'solution' => $puzzle->getSolutionAsJson(),
		]);

		return view(
			'frontend.sudoku.index',
			[
				'thePuzzle'        => $sudoku->puzzle_collection,
				'theSolution'      => $sudoku->solution_collection,
				'isSolvable'       => $puzzle->isSolvable(),
				'selectedCellSize' => $cellSize,
			]
		);
	}

	/**
	 * Get a new PuzzlesRepository from PuzzlesFactory then generate the
	 * solvable puzzle, solve it and return it.
	 *
	 * @param integer $cellSize default 15
	 *
	 * @return \sudoku\Domain\Sudokus\Puzzles\Repositories\PuzzlesRepository
	 */
	protected function generatePuzzleFromConstraints($cellSize = 15) {
		// Is the puzzle solvable ?
		$isSolvable = false;

		$puzzle = $this->f_puzzles->createNewPuzzleRepository();

		// Execute until a resolvable puzzle is generated
		do
		{

			// Create new puzzle
			$puzzle->generatePuzzle($cellSize);

			// Get the solution and check it
			$isSolvable = $puzzle->isSolvable();

		} while (false === $isSolvable);

		$puzzle->solve();

		return $puzzle;
	}
}
