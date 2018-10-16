<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use HelpersService;

	class ResponseService
	{
		/**
		 * @param string $content
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function success($content = "", $status = 200, array $headers = [], $options = 0)
		{
			$message = $this->responseData('success',$content, $status);
			return $this->custom($message, $status, $headers, $options);
		}

		/**
		 * @param $content
		 * @param int $status
		 * @param array $headers
		 * @param int $options
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function custom($content, $status, array $headers = [], $options = 0)
		{
			return response()->json($content, $status, $headers, $options);
		}

		/**
		 * @param string $type
		 * @param string $content
		 * @param int $status
		 * @return \Illuminate\Http\JsonResponse|void
		 */
		public function error($type, $content = "", $status = 400, array $headers = [], $options = 0)
		{
			switch ($type) {
				case "validator":
					$message = $this->responseData('validator', $content, $status);
					return $this->custom($message, $status, $headers, $options);
					break;
				case "custom":
					$message = $this->responseData('error', $content, $status);
					return $this->custom($message, $status, $headers, $options);
					break;
				case "error":
					return HelpersService::factory()->{$type}($content, $status);
					break;
				default:
					return HelpersService::factory()->{$type}($content);
					break;
			}
		}

		private function responseData(string $type, $data, $status){
			$message = [
				$type => [
					'status_code' => $status
				],
			];

			if (is_array($data) || is_object($data))
				$message[$type] = array_add($message[$type], 'data', $data);
			else
				$message[$type] = array_add($message[$type], 'message', $data);

			return $message;
		}
	}