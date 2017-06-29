<?php

namespace Tests\Unit\Domain\Sudokus\Puzzles;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Sudokus\Sudokus\
{
	Repositories\SudokusRepositoryEloquent
};
use sudoku\Domain\Sudokus\Puzzles\
{
	Factories\PuzzlesFactory
};

class SudokusTest extends TestCase
{

	/**
	 * @var null|SudokusRepositoryEloquent
	 */
	protected $r_sudokus = null;

	/**
	 * SettlementsTest constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->r_sudokus = app()
			->makeWith(
				SudokusRepositoryEloquent::class,
				[
					app(),
					new PuzzlesFactory(app())
				]
			);
	}

	/**
	 * Check if repository is correctly instantiated.
	 *
	 * @return void
	 */
	public function testCheckIfRepositoryIsCorrectlyInstantiated() {
		$this->assertTrue(
			$this->r_sudokus instanceof SudokusRepositoryEloquent
		);
	}
}
