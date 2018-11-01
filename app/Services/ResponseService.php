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

		/**
		 * Method response
		 *
		 * @param $content
		 * @param $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function response($content, $status, array $headers = [], $options = 0) {
			return response()->json($content, $status, $headers, $options);
		}

		/**
		 * Method for successful responses
		 * If you add data use method ->withData($data);
		 * If you add links use method ->withLinks($links);
		 * return response with content:
		 * [
		 *   "success": $content,
		 *   "data": [] //Always
		 *   "links": [] //if you use method withLinks()
		 * ]
		 *
		 * @param mixed $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function success($content, $status = 200, array $headers = [], $options = 0)
		{
			$message = $this->contentProcessor($content,'success');
			return $this->response($message, $status, $headers, $options);
		}

		/**
		 * Method for data responses
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function data($content = "", $status = 200, array $headers = [], $options = 0)
		{
			$message = $this->contentProcessor($content,'data');
			return $this->response($message, $status, $headers, $options);
		}

		/**
		 * Method for error responses
		 * If you add data use method ->withData($data);
		 * If you add links use method ->withLinks($links);
		 * return response with content:
		 * [
		 *   "error": $content,
		 *   "data": [] //Always
		 *   "links": [] //if you use method withLinks()
		 * ]
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function error($content = "Generic Error", int $status = 400, array $headers = [], $options = 0)
		{
			$message = $this->contentProcessor($content, 'error');
			return $this->response($message, $status, $headers, $options);
		}

		/**
		 * Alias error for badRequest
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorBadRequest($content = "Bad Request", int $status = 400, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for unauthorized
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorUnauthorized($content = "Unauthorized", int $status = 401, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for forbidden
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorForbidden($content = "Forbidden", int $status = 403, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for notFound
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorNotFound($content = "Not Found", int $status = 404, array $headers = [], $options = 0) {
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for Method Not Allowed
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorMethodNotAllowed($content = "Method Not Allowed", int $status = 405, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for Request Timeout
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorRequestTimeout($content = "Error Request Timeout", int $status = 408, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for MediaType
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorMediaType($content = "Error Media Type", int $status = 415, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for Internal
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorInternal($content = "Internal Error", int $status = 500, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Alias error for ServiceUnavailable
		 *
		 * @param string $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function errorServiceUnavailable($content = "Service Request is Unavailable", int $status = 500, array $headers = [], $options = 0){
			return $this->error($content,$status,$headers,$options);
		}

		/**
		 * Metod for error exception
		 *
		 * @param $content
		 * @param int $status
		 * @param array $headers
		 * @param int $code
		 */
		public function errorException($content, $status = 400, array $headers = [], $code = 0){
			throw new HttpException($status, $content, null, $headers, $code);
		}

		/**
		 * Method for process response content
		 *
		 * @param $content
		 * @param string $type
		 * @return array
		 */
		private function contentProcessor($content, string $type)
		{
			$default = $this->array($type);

			if ($this->subArray)
				$default[$type] = array_add($default[$type], $this->subArray, $content);
			else
				array_set($default, $type, $content);

			return $default;
		}

		/**
		 * Method make array REST response
		 *
		 * @param string $type
		 * @return array
		 */
		private function array(string $type) {
			$default = [];

			if($type === 'data')
				$default = ['data' => []];
			else
				$default = [$type => [],'data' => $this->data];

			if ($this->links)
				$default += ["links" => $this->links];

			return $default;
		}

		/**
		 * Method to add Data to error or success response
		 *
		 * @param array $data
		 * @return $this
		 */
		public function withData(array $data)
		{
			$this->data = $data;
			return $this;
		}

		/**
		 * Method to add Links to error or success response
		 * $hateoas make $links to standard of Rest Api
		 *
		 * //Example links array
		 * links = [['self','localhost/user','GET'],['post','localhost/posts','GET']]
		 *
		 * @param array $links
		 * @param bool $hateoas
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
		 * Method to add sub array in error or success
		 *
		 * @param string $subArray
		 * @return $this
		 */
		public function withSubArray(string $subArray){
			$this->subArray = $subArray;
			return $this;
		}
	}