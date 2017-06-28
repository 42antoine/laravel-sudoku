<?php

namespace Tests\Feature\Frontend;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Users\Users\User;

class SudokuControllerTest extends TestCase
{
	/**
	 * A basic test example to access sudoku page.
	 *
	 * @return void
	 */
	public function testTryToAccessSudokuPageAsGuest()
	{
		$response = $this->get('/sudoku');

		$response->assertStatus(302);
	}

	/**
	 * An advanced test example to access sudoku page.
	 *
	 * @return void
	 */
	public function testTryToAccessSudokuPageAsLoggedInUser()
	{
		$user = factory(User::class)->create();

		$response = $this
			->actingAs($user)
			->get('/sudoku');

		$response->assertStatus(200);
	}
}
