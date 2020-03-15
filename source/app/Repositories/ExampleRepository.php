<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.19
	 */

	namespace App\Repositories;

	use App\Models\Example;
	use Kosmosx\Framework\Repository\Eloquent\RepositoryAbstract;

	class ExampleRepository extends RepositoryAbstract
	{
		public function model() {
			return Example::class;
		}
	}