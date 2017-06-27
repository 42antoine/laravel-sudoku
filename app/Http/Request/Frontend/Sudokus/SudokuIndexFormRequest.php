<?php

namespace sudoku\Http\Request\Frontend\Sudokus;

use sudoku\Infrastructure\Contracts\Request\RequestAbstract;

class SudokuIndexFormRequest extends RequestAbstract
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$rules = [
			'cell_size' => 'in:5,15,25',
		];

		return $rules;
	}
}
