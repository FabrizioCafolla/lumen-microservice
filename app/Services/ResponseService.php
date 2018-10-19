<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use Symfony\Component\HttpKernel\Exception\HttpException;

	class ResponseService
	{
		/**
		 * Method for successful responses, the content parameter is processed by a function that returns the json response message.
		 * The message will be:
		 * ["success":["data" or "message": $content, "status_code": $ status]]
		 *
		 * @param mixed $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function success($content = "", $status = 200, array $headers = [], $options = 0)
		{
			$message = $this->contentProcessor('success', $content, $status);
			return $this->response($message, $status, $headers, $options);
		}

		/**
		 *
		 * @param $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function response($content, $status, array $headers = [], $options = 0)
		{
			return response()->json($content, $status, $headers, $options);
		}

		/**
		 * Method for error responses, the content parameter is processed by a function that returns the json response message.
		 * The message will be:
		 * ["error":["data" or "message": $content, "status_code": $ status]]
		 * The parameter $ type is a string used to discriminate the type of error to be returned in the response, it can assume the following values:
		 * error, errorValidator, errorNotFound, errorBadRequest, errorBadRequest, errorForbidden, errorInternal, errorUnauthorized, errorMethodNotAllowed
		 *
		 * @param string $type
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function error($type = "error", $content = "", $status = 400, array $headers = [], $options = 0)
		{
			switch ($type) {
				case "errorValidator":
					$message = $this->contentProcessor('error', $content, $status, 'validator');
					break;
				case "errorNotFound":
					$message = $this->contentProcessor('error', $content ? $content:'Not Found', 404);
					break;
				case "errorBadRequest":
					$message = $this->contentProcessor('error', $content ? $content:'Bad Request', 400);
					break;
				case "errorForbidden":
					$message = $this->contentProcessor('error', $content ? $content:'Forbidden', 403);
					break;
				case "errorInternal":
					$message = $this->contentProcessor('error', $content ? $content:'Internal Error', 500);
					break;
				case "errorUnauthorized":
					$message = $this->contentProcessor('error', $content ? $content:'Unauthorized', 401);
					break;
				case "errorMethodNotAllowed":
					$message = $this->contentProcessor('error', $content ? $content:'Method Not Allowed', 405);
					break;
				case "error":
					$message = $this->contentProcessor('error', $content ? $content:'Generic Error', $status);
					break;
			}
			if(!$message)
				$this->errorException('Internal Error response, message not found', $status);

			return $this->response($message, $status, $headers, $options);
		}

		/**
		 * Method for Exception Errors
		 *
		 * @param $message
		 * @param $status
		 */
		public function errorException($content, $status = 400, array $headers = [], $code = 0){
			throw new HttpException($status, $content, null, $headers, $code);
		}

		/**
		 * Method for processing the message, used to standardize the basic template facilitating access to the response data.
		 * If data is array or object add key 'data' else 'message'
		 * $subArray is a parameter used for multidimensional management of the 'data' key, it is simply a string (which also recognizes the "dot" notation)
		 *
		 * @param string $type
		 * @param $data
		 * @param null $status
		 * @param string|null $subArray
		 * @return array
		 */
		private function contentProcessor(string $type, $data, $status = null, string $subArray = null)
		{
			$message = [
				$type => [
				],
			];

			if (is_array($data) || is_object($data) && !$subArray)
				$message[$type] = array_add($message[$type], 'data', $data);
			elseif (is_array($data) || is_object($data) && $subArray)
				$message[$type] = array_add($message[$type], 'data.'.$subArray, $data);
			else
				$message[$type] = array_add($message[$type], 'message', $data);

			if($status)
				$message[$type] = array_add($message[$type], 'status_code', $status);

			return $message;
		}
	}