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
		private $data = [];
		private $links = [];
		private $subArray;

		public function response($content, $status, array $headers = [], $options = 0) {
			return response()->json($content, $status, $headers, $options);
		}

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

		/**
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function data($content = "", $status = 200, array $headers = [], $options = 0)
		{
			$message = $this->dataProcessor($content,$this->subArray);
			return $this->response($message, $status, $headers, $options);
		}

		/**
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function error($content = "Generic Error", int $status = 400, array $headers = [], $options = 0)
		{
			$message = $this->contentProcessor($content, "error");
			return $this->response($message, $status, $headers, $options);
		}

		public function errorBadRequest($content = "Bad Request", int $status = 400, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		public function errorUnauthorized($content = "Unauthorized", int $status = 401, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		public function errorForbidden($content = "Forbidden", int $status = 403, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		public function errorNotFound($content = "Not Found", int $status = 404, array $headers = [], $options = 0) {
			return $this->error($content,$status,$headers,$options);
		}

		public function errorMethodNotAllowed($content = "Method Not Allowed", int $status = 405, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		public function errorRequestTimeout($content = "Error Request Timeout", int $status = 408, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		public function errorMediaType($content = "Error Media Type", int $status = 415, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		public function errorInternal($content = "Internal Error", int $status = 500, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		public function errorServiceUnavailable($content = "Service Request is Unavailable", int $status = 500, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
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
		private function contentProcessor($content, $type)
		{
			$default = [
				$type => [
				],
				'data' => []
			];

			if ($this->subArray)
				$default[$type] = array_add($default[$type], $this->subArray, $content);
			else
				array_set($default, $type, $content);

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
		private function errorProcessor($content, $data = [], $subArray = '')
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