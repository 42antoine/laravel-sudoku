<?php

namespace sudoku\Domain\Sudokus\Settlements\Repositories;

use sudoku\Infrastructure\Contracts\
{
	Repositories\RepositoryEloquentAbstract,
	Request\RequestAbstract
};
use sudoku\Domain\Sudokus\Settlements\
{
	Settlement,
	Repositories\SettlementsRepositoryInterface
};

class SettlementsRepositoryEloquent extends RepositoryEloquentAbstract implements SettlementsRepositoryInterface
{

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return Settlement::class;
	}

	/**
	 * Create sudoku.
	 *
	 * @param array $attributes
	 *
	 * @return \sudoku\Domain\Sudokus\Settlements\Settlement
	 */
	public function create(array $attributes) {
		$settlement = parent::create($attributes);

		return $settlement;
	}

	/**
	 * Update sudoku.
	 *
	 * @param array   $attributes
	 * @param integer $settlement_id
	 *
	 * @return \sudoku\Domain\Sudokus\Settlements\Settlement
	 */
	public function update(array $attributes, $settlement_id) {
		$settlement = parent::update($attributes, $settlement_id);

		return $settlement;
	}

	/**
	 * Delete sudoku.
	 *
	 * @param array   $attributes
	 * @param integer $settlement_id
	 *
	 * @return \sudoku\Domain\Sudokus\Settlements\Settlement
	 */
	public function delete($settlement_id) {
		$settlement = $this->find($settlement_id);

		parent::delete($settlement->id);

		return $settlement;
	}
}
