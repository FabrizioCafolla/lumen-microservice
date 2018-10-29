<?php
	namespace App\Repositories\Eloquent;

	use App\Repositories\Contracts\RepositoryInterface;
	use App\Repositories\Exceptions\RepositoryException;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Container\Container as App;

	/**
	 * Class Repository
	 * @package Bosnadev\Repositories\Eloquent
	 */
	abstract class RepositoryAbstract implements RepositoryInterface {

		/**
		 * @var App
		 */
		private $app;

		/**
		 * @var Model
		 */
		public $model;

		/**
		 * @var ResponseService
		 */
		protected $response;

		/**
		 * @param App $app
		 */
		public function __construct(App $app) {
			$this->app = $app;
			$this->response = app('service.response');
			$this->implementsModel();
		}

		/**
		 * Specify Model class name
		 *
		 * @return mixed
		 */
		abstract function model();

		/**
		 * @param array $columns
		 * @return mixed
		 */
		public function all($columns = array('*')) {
			return $this->model->get($columns);
		}

		/**
		 * @param int $perPage
		 * @param array $columns
		 * @return mixed
		 */
		public function paginate($perPage = 15, $columns = array('*'), $query = "", $value = null) {
			return $this->model->paginate($perPage, $columns, $query, $value);
		}

		/**
		 * @param array $data
		 * @return mixed
		 */
		public function create(array $data) {
			return $this->model->create($data);
		}

		/**
		 * @param array $data
		 * @param $id
		 * @param string $attribute
		 * @return mixed
		 */
		public function update(array $data, $id, $attribute="id") {
			return $this->model->where($attribute, '=', $id)->update($data);
		}

		/**
		 * @param $id
		 * @return mixed
		 */
		public function delete($id) {
			return $this->model->destroy($id);
		}

		/**
		 * @param $id
		 * @param array $columns
		 * @return mixed
		 */
		public function find($id, $columns = array('*')) {
			return $this->model->find($id, $columns);
		}

		/**
		 * @param $attribute
		 * @param $value
		 * @param array $columns
		 * @return mixed
		 */
		public function findBy($attribute, $value, $columns = array('*')) {
			return $this->model->where($attribute, '=', $value)->first($columns);
		}

		/**
		 * @return Model
		 */
		public function implementsModel() {
			$model = $this->app->make($this->model());

			if (!$model instanceof Model)
				throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

			return $this->model = $model;
		}
	}