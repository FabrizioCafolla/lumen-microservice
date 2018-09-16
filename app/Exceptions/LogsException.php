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

	class LogsException extends Exception {
		public function response ($message = 'Error log') {
			return ResponseFacade::error("generic", $message, 500);
		}
	}