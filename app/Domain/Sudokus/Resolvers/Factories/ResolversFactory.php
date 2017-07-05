<?php

namespace sudoku\Domain\Sudokus\Resolvers\Factories;

use sudoku\Domain\Sudokus\Resolvers\
{
	Repositories\ResolversRepository
};

class ResolversFactory
{

	/**
	 * @return ResolversRepository
	 */
	public function createNewResolverRepository() {
		return app()->make(ResolversRepository::class);
	}
}
