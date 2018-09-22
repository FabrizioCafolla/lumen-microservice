<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 16/09/18
	 * Time: 21.33
	 */
	namespace App\Exceptions;

	use App\Facades\ResponseFacade;
	use Exception;

	class ErrorsException extends Exception {
		public function response (string $type, $message) {
			return ResponseFacade::error($type, $message);
		}
	}