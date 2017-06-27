<?php

namespace sudoku\Infrastructure\Contracts\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use sudoku\Infrastructure\Interfaces\Repositories\RepositoryInterface;

abstract class RepositoryEloquentAbstract extends BaseRepository implements RepositoryInterface
{

	/**
	 * RepositoryEloquentAbstract constructor.
	 */
	public function __construct(Application $app) {
		parent::__construct($app);
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

	/**
	 * Count all item, based on active criterias.
	 *
	 * @param array $columns
	 *
	 * @return int
	 */
	public function count($columns = ['*']) {
		$this->applyCriteria();
		$this->applyScope();

		if ($this->model instanceof Builder)
		{
			$results = $this->model->get($columns)->count();
		}
		else
		{
			$results = $this->model->count($columns);
		}

		$this->resetModel();
		$this->resetScope();

		return $results;
	}

	/**
	 * Set the current page for paginated request.
	 *
	 * @param integer $currentPage
	 *
	 * @return $this
	 */
	public function paginationOffset($currentPage) {
		Paginator::currentPageResolver(function() use ($currentPage)
		{
			return $currentPage;
		});

		return $this;
	}

	/**
	 * Get params to set the current page for a paginated request.
	 *
	 * @param integer $currentPage
	 *
	 * @return $this
	 */
	public function paginationOffsetFromRequestParams($currentPageParams = 'page') {
		Paginator::currentPageResolver(function() use ($currentPageParams)
		{
			return request()->input($currentPageParams);
		});

		return $this;
	}
}
