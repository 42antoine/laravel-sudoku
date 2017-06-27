<?php

namespace sudoku\Domain\Users\Users\Presenters;

use sudoku\Infrastructure\Contracts\Presenters\PresenterAbstract;
use sudoku\Domain\Users\Users\Transformers\UsersListTransformer;

class UsersListPresenter extends PresenterAbstract
{

	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer()
	{
		return new UsersListTransformer();
	}
}
