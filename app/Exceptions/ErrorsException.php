<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 16/09/18
	 * Time: 21.33
	 */
	namespace App\Exceptions;

	use ResponseService;
	use Exception;

	class ErrorsException extends Exception {
		public function exception ($content, $status = 400, array $headers = [], $code = 0) {
			return ResponseService::errorException($content, $status, null, $headers, $code);
		}
	}