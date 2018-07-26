<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.06
	 */

	namespace App\Repositories\Contracts;

	interface RepositoryInterface {

		public function all($columns = array('*'));

		public function paginate($perPage = 15, $columns = array('*'));

		public function create(array $data);

		public function update(array $data, $id);

		public function delete($id);

		public function find($id, $columns = array('*'));

		public function findBy($field, $value, $columns = array('*'));
	}