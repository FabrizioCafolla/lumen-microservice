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
	use Illuminate\Support\Facades\Storage;

	class LogService
	{
		/**
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
				$this->logs[$log] =  $this->initializesLog($log);
			}
		}

		/**
		 * @param string $log
		 * @return mixed
		 */
		public function getLog($log = '')
		{
			if (array_has($this->logs, $log))
				return $this->logs[$log];

			if (Storage::disk('logs')->exists($log))
				return $this->initializesLog($log);

			return ResponseFacade::error("generic", "Not found Log", 500);
		}

		public function createLog($log) {
			return $this->initializesLog($log);
		}


		/**
		 * @param $log
		 * @return mixed
		 * @throws \Exception
		 */
		private function initializesLog($log)
		{
			$create = new Logger(str_singular($log));
			$create->pushHandler($this->stream($log));
			return $create;
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

	}