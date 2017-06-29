<?php

namespace Tests\Unit\Domain\Sudokus\Puzzles;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Sudokus\Puzzles\
{
	Factories\PuzzlesFactory,
	Repositories\PuzzlesRepository
};

class PuzzlesTest extends TestCase
{

	const PUZZLE_NB_LINE = 9;
	const PUZZLE_NB_COLUMN = 9;

	/**
	 * @var null|PuzzlesRepository
	 */
	protected $r_puzzles = null;

	/**
	 * @var null|PuzzlesFactory
	 */
	protected $f_puzzles = null;

	public function __construct() {
		parent::__construct();

		$this->r_puzzles = app()->make(PuzzlesRepository::class);
		$this->f_puzzles = app()->make(PuzzlesFactory::class);
	}

	/**
	 * Check if repository is correctly instantiated.
	 *
	 * @return void
	 */
	public function testCheckIfRepositoryIsCorrectlyInstantiated() {
		$this->assertTrue(
			$this->r_puzzles instanceof PuzzlesRepository
		);
	}

	/**
	 * Check if factory return a puzzle repository correctly instantiated.
	 *
	 * @return void
	 */
	public function testCheckIfFactoryReturnRepositoryCorrectlyInstantiated() {
		$this->assertTrue(
			$this->f_puzzles->createNewPuzzleRepository() instanceof PuzzlesRepository
		);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCheckBaseGenerationOfAPuzzle() {
		$this->r_puzzles->generatePuzzle();

		$this
			->assertTrue(
				self::PUZZLE_NB_LINE === $this->r_puzzles->getPuzzleAsCollection()->count()
			);

		$this
			->r_puzzles
			->getPuzzleAsCollection()
			->each(function(array $column_in_line)
			{

				$this
					->assertTrue(
						self::PUZZLE_NB_COLUMN === count($column_in_line)
					);

			});
	}
}
