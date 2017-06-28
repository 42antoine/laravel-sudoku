<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Users\Users\User;

class ForgotPasswordControllerTest extends TestCase
{

	/**
	 * A basic test example to access forgot password page.
	 *
	 * @return void
	 */
	public function testTryToAccessForgotPasswordPageAsGuest() {
		$response = $this->get('/password/reset');

		$response->assertStatus(200);
	}

	/**
	 * An advanced test example to access forgot password page.
	 *
	 * @return void
	 */
	public function testTryToAccessForgotPasswordPageAsLoggedInUser() {
		$user = factory(User::class)->create();

		$response = $this
			->actingAs($user)
			->get('/password/reset');

		$response->assertStatus(302);
	}
}
