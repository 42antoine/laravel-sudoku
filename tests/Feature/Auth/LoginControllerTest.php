<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Users\Users\User;

class LoginControllerTest extends TestCase
{

	/**
	 * A basic test example to access login page.
	 *
	 * @return void
	 */
	public function testTryToAccessLoginPageAsGuest() {
		$response = $this->get('/login');

		$response->assertStatus(200);
	}

	/**
	 * An advanced test example to access login page.
	 *
	 * @return void
	 */
	public function testTryToAccessLoginPageAsLoggedInUser() {
		$user = factory(User::class)->create();

		$response = $this
			->actingAs($user)
			->get('/login');

		$response->assertStatus(302);
	}
}
