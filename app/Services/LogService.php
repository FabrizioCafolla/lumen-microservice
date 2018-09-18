<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use App\Exceptions\LogsException;
	use App\Facades\ResponseFacade;
	use Carbon\Carbon;
	use Monolog\Formatter\JsonFormatter;
	use Monolog\Formatter\MongoDBFormatter;
	use Monolog\Formatter\HtmlFormatter;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use Illuminate\Support\Facades\Storage;

	class LogService
	{
		/** Primary logs if you add new element in array
		 *  use it without invoke create method
		 * @var array
		 */
		private $logs = [
			'mails',
			'queries',
			'generics',
		];

		/**
		 * HelpersService constructor.
		 * @throws \Exception
		 */
		public function __construct()
		{
			foreach ($this->logs as $log) {
				$this->logs[$log] = $this->createLog($log, true);
			}
		}

		/**
		 * @param $log
		 * @return mixed
		 * @throws \Exception
		 */
		private function initializesLog($log, $data, $formatter)
		{
			$create = new Logger(str_singular($log));

			$path = $data ? $log . '-' . Carbon::now()->toDateString() : $log;
			$create->pushHandler($this->stream($path, $formatter));

			return $create;
		}

		/**
		 * @param $path
		 * @param string $formatter
		 * @return StreamHandler
		 * @throws \Exception
		 */
		private function stream($path, $formatter)
		{
			switch ($formatter) {
				case 'json':
					$formatter = new JsonFormatter();
					break;
				case 'html':
					$formatter = new HtmlFormatter();
					break;
				case 'mongoDB':
					$formatter = new MongoDBFormatter();
					break;
			}
			$stream = new StreamHandler(logger_path($path), Logger::DEBUG);
			$stream->setFormatter($formatter);
			return $stream;
		}

		/**
		 * @param string $log
		 * @return mixed
		 * @throws \Exception
		 */
		public function getLog($log = '')
		{
			if (array_has($this->logs, $log))
				return $this->logs[$log];

			if (Storage::disk('logs')->exists($log)) {
				return $this->initializesLog($log);
			}

			return ResponseFacade::error("generic", "Not found Log", 500);
		}

		/**
		 * @param $log
		 * @param $data
		 * @return mixed
		 * @throws \Exception
		 */
		public function createLog($log, $data = false, $formatter = 'json')
		{
			try {
				return $this->initializesLog($log, $data, $formatter);
			} catch (LogsException $exception) {
				return $exception->response("Failed get Log", 500);
			}
		}

	}