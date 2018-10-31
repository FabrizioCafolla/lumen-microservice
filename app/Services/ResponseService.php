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
		private $data;
		private $links;
		private $subArray;

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
		public function success($content, $status = 200, array $headers = [], $options = 0)
		{
			$message = $this->successProcessor($content,$this->subArray, $this->data);
			return $this->response($message, $status, $headers, $options);
		}

		public function data($content = "", $status = 200, array $headers = [], $options = 0)
		{
			$message = $this->dataProcessor($content);
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
		public function error($type = "error", $content = "", $status = 400, $data = [], array $headers = [], $options = 0)
		{
			switch ($type) {
				case "errorValidator":
					$message = $this->errorProcessor($content,'validator');
					break;
				case "errorNotFound":
					$message = $this->errorProcessor($content ? $content:'Not Found');
					break;
				case "errorBadRequest":
					$message = $this->errorProcessor($content ? $content:'Bad Request');
					break;
				case "errorForbidden":
					$message = $this->errorProcessor($content ? $content:'Forbidden');
					break;
				case "errorInternal":
					$message = $this->errorProcessor($content ? $content:'Internal Error');
					break;
				case "errorUnauthorized":
					$message = $this->errorProcessor($content ? $content:'Unauthorized');
					break;
				case "errorMethodNotAllowed":
					$message = $this->errorProcessor($content ? $content:'Method Not Allowed');
					break;
				case "error":
					$message = $this->errorProcessor($content ? $content:'Generic Error');
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
		 * @param $content
		 * @param string $subArray
		 * @return array
		 */
		private function dataProcessor($content, $subArray = '')
		{
			$default = [
				'data' => [
				],
			];

			if ($subArray)
				array_set($default, 'data', $content);
			else
				$default['data'] = array_add($default['data'], $subArray, $content);

			if ($this->links)
				$default += ["links" => $this->links];

			return $default;
		}

		/**
		 * @param $content
		 * @param string $subArray
		 * @param array $data
		 * @return array
		 */
		private function errorProcessor($content, $subArray = '', $data = [])
		{
			$default = [
				'error' => [
				]
			];
			$default += $this->dataProcessor($data);

			if ($subArray)
				$default['error'] = array_add($default['error'], $subArray, $content);
			else
				array_set($default, 'error', $content);

			return $default;
		}

		/**
		 * @param $content
		 * @param string $subArray
		 * @param array $data
		 * @return array
		 */
		private function successProcessor($content, $subArray = '', $data = [])
		{
			$default = [
				'success' => [
				]
			];
			$default += $this->dataProcessor($data);

			if ($subArray)
				$default['success'] = array_add($default['success'], $subArray, $content);
			else
				array_set($default, 'success', $content);

			return $default;
		}

		/**
		 * @param array $data
		 * @return $this
		 */
		public function withData(array $data)
		{
			$this->data = $data;
			return $this;
		}

		/**
		 * @param array $links
		 * @param bool $generate
		 * @return $this
		 */
		public function withLinks(array $links, bool $hateoas = true)
		{
			if ($hateoas) {
				foreach ($links as $key => $link)
					array_set($filtered, $key, [
						"rel" => $link[0],
						"href" => $link[1],
						"method" => $link[2],
					]);
				$this->links = $filtered;
			} else
				$this->links = $links;

			return $this;
		}

		/**
		 * @param string $subArray
		 * @return $this
		 */
		public function withSubArray(string $subArray){
			$this->subArray = $subArray;
			return $this;
		}
	}