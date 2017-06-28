<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use sudoku\Domain\Users\Users\User;

class HomePageTest extends TestCase
{
    /**
     * A basic test example to access home page.
     *
     * @return void
     */
    public function testTryToAccessHomePageAsGuest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

	/**
	 * An advanced test example to access home page.
	 *
	 * @return void
	 */
	public function testTryToAccessHomePageAsLoggedInUser()
	{
		$user = factory(User::class)->create();

		$response = $this
			->actingAs($user)
			->get('/');

		$response->assertStatus(200);
	}
}
