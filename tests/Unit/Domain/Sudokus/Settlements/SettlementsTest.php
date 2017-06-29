<?php

namespace Tests\Unit\Domain\Sudokus\Puzzles;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Sudokus\Settlements\
{
	Repositories\SettlementsRepositoryEloquent
};

class SettlementsTest extends TestCase
{

	/**
	 * @var null|SettlementsRepositoryEloquent
	 */
	protected $r_settlements = null;

	/**
	 * SettlementsTest constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->r_settlements = app()->make(SettlementsRepositoryEloquent::class);
	}

	/**
	 * Check if repository is correctly instantiated.
	 *
	 * @return void
	 */
	public function testCheckIfRepositoryIsCorrectlyInstantiated() {
		$this->assertTrue(
			$this->r_settlements instanceof SettlementsRepositoryEloquent
		);
	}
}
