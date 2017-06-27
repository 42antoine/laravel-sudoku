<?php namespace sudoku\Infrastructure\Contracts\Repositories;

use sudoku\Infrastructure\Interfaces\Repositories\ResourceInterface;

abstract class AbstractResourceRepository implements ResourceInterface
{

	protected $model;

	/**
	 * Retrieve all data from repository with optional columns names
	 *
	 * @param  array $columns
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all() {
		return $this->model->all();
	}

	/**
	 * Save a new entity in repository
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function save() {
		return $this->model->save();
	}

	/**
	 * Save a new entity in repository
	 *
	 * @param array $data
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function create(array $data) {
		return $this->model->create($data);
	}

	/**
	 * Update an entity from repository
	 *
	 * @param int   $id
	 * @param array $data
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function update($id, array $data) {
		return $this->model->findOrFail($id)->update($data);
	}

	/**
	 * Update or Create an entity in repository
	 *
	 * @param array $attributes
	 * @param array $values
	 *
	 * @return int
	 */
	public function updateOrCreate(array $attributes, array $values = []) {
		return $this->model->updateOrCreate($attributes, $values);
	}

	/**
	 * Delete an entity from repository
	 *
	 * @param       int / array $id
	 * @param array $data
	 *
	 * @return int
	 */
	public function destroy($id) {
		return $this->model->destroy($id);
	}

	/**
	 * Find data in repository by id with optional columns names
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function find($id, $columns = ['*']) {
		return $this->model->findOrFail($id, $columns);
	}

	/**
	 * Find data in repository by field and value with optional columns names
	 *
	 * @param  string $field
	 * @param         $value
	 * @param  array  $columns
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findByField($field, $value = null, $columns = ['*']) {
		return $this->model->where($field, '=', $value)->get($columns);
	}

	/**
	 * Find data in repository by multiple fields with optional columns names
	 *
	 * @param array $where
	 * @param array $columns
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findWhere(array $where, $columns = ['*']) {
		return $this->model->where($where)->get($columns);
	}

	/**
	 * Find data in repository by multiple values in one field with optional
	 * columns names
	 *
	 * @param string $field
	 * @param array  $values
	 * @param array  $columns
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findWhereIn($field, array $values, $columns = ['*']) {
		return $this->model->whereIn($field, $values)->get($columns);
	}

	/**
	 * Find data in repository by excluding multiple values in one field with
	 * optional columns names
	 *
	 * @param string $field
	 * @param array  $values
	 * @param array  $columns
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findWhereNotIn($field, array $values, $columns = ['*']) {
		return $this->model->whereNotIn($field, $values)->get($columns);
	}

	/**
	 * Order data in repository by one column with default optional direction
	 *
	 * @param string $column
	 * @param string $direction
	 *
	 * @return $this through \Illuminate\Database\Eloquent\Builder
	 */
	public function orderBy($column, $direction = 'asc') {
		$this->model->orderBy($column, $direction);
		return $this;
	}

	/**
	 * Check if entity has relation
	 *
	 * @param  string $relation
	 *
	 * @return $this through \Illuminate\Database\Eloquent\Builder
	 */
	public function has($relation) {
		$this->model->has($relation);
		return $this;
	}

	/**
	 * Easy load relations
	 *
	 * @param  array|string $relations
	 *
	 * @return $this through \Illuminate\Database\Eloquent\Builder
	 */
	public function with($relations) {
		$this->model->with($relations);
		return $this;
	}

	/**
	 * Filter relation with closure
	 *
	 * @param string  $relation
	 * @param closure $closure
	 *
	 * @return $this through \Illuminate\Database\Eloquent\Builder
	 */
	public function whereHas($relation, $closure) {
		$this->model->whereHas($relation, $closure);
		return $this;
	}

	/**
	 * Retrieve all data from repository and simple-paginate them
	 *
	 * @param int $number
	 *
	 * @return \Illuminate\Pagination\LengthAwarePaginator
	 */
	public function simplePaginate($number) {
		return $this->model->simplePaginate($number);
	}

	/**
	 * Retrieve all data from repository and paginate them
	 *
	 * @param int $number
	 *
	 * @return \Illuminate\Pagination\LengthAwarePaginator
	 */
	public function paginate($number) {
		return $this->model->paginate($number);
	}

	/**
	 * Retrieve all data from repository, order them by one column with default
	 * optional direction and paginate them
	 *
	 * @param string $column
	 * @param int    $number
	 * @param string $direction
	 *
	 * @return $this through \Illuminate\Database\Eloquent\Builder
	 */
	public function orderByAndPaginate($column, $direction, $number) {
		return $this->model->orderBy($column, $direction)->paginate($number);
	}
}
