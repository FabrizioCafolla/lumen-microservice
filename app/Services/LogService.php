<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use App\Facades\ResponseFacade;
	use Monolog\Formatter\JsonFormatter;
	use Monolog\Formatter\MongoDBFormatter;
	use Monolog\Formatter\HtmlFormatter;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class LogService
	{
		private $logs = [
			'mails',
			'queries',
			'generics',
		];

		private $customLogs = [];

		/**
		 * HelpersService constructor.
		 * @throws \Exception
		 */
		public function __construct()
		{
			foreach ($this->logs as $log) {
				$this->logs[$log] = new Logger(str_singular($log));
				$this->logs[$log]->pushHandler($this->stream($log));
			}
		}

		/**
		 * @param $path
		 * @param string $formatter
		 * @return StreamHandler
		 * @throws \Exception
		 */
		private function stream($path, $formatter = 'json')
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

		public function getLogs($log = '')
		{
			if (array_has($this->logs, $log))
				return $this->logs[$log];
			return ResponseFacade::error("generic", "Not found Logs", 500);
		}

		public function getCustomLogs($log = '')
		{
			if (array_has($this->customLogs, $log))
				return $this->customLogs[$log];
			return ResponseFacade::error("generic", "Not found Logs", 500);
		}

		public function createCustomLog($log)
		{
			$this->customLogs[$log] = new Logger(str_singular($log));
			$this->customLogs[$log]->pushHandler($this->stream($log));

			return $this->customLogs[$log];
		}
	}