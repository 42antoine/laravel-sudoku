<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Users\Users\User;

class RegisterControllerTest extends TestCase
{

	/**
	 * A basic test example to access register page.
	 *
	 * @return void
	 */
	public function testTryToAccessRegisterPageAsGuest() {
		$response = $this->get('/register');

		$response->assertStatus(200);
	}

	/**
	 * An advanced test example to access register page.
	 *
	 * @return void
	 */
	public function testTryToAccessRegisterPageAsLoggedInUser() {
		$user = factory(User::class)->create();

		$response = $this
			->actingAs($user)
			->get('/register');

		$response->assertStatus(302);
	}
}
