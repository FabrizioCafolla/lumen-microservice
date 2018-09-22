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
		/** Arrays with the basic logs initialized by the manufacturer with the default date of the day.
		 * Add your basic logs here to be used immediately.
		 * Example: $this->log->default['mails']->info('Example used');
		 * @var array
		 */
		public $default = [
			'mails',
			'queries',
			'generics',
		];

		/**
		 * Initialize the default logs with the instance of the Monolog class with today's date when the log file is created
		 *
		 * @throws \Exception
		 */
		public function __construct()
		{
			foreach ($this->default as $log) {
				$this->default[$log] = $this->initializesLog($log, 'today');
			}
		}

		/**
		 * Method used to initialize the logs, returns the Monolog object, you can define the name of the log file by adding the date to it and choose the format.
		 *
		 * @param $log name log file
		 * @param bool $data data to add in file name
		 * @param string $formatter type of format log file
		 * @return Logger object Monolog
		 * @throws \Exception
		 */
		public function initializesLog($log, $data = false, $formatter = 'json')
		{
			try {
				$create = new Logger(str_singular($log));

				$path = $data ? $log . '-' . Carbon::parse($data)->toDateString() : $log;
				$create->pushHandler($this->stream($path, $formatter));

				return $create;
			} catch (LogsException $e) {
				return $e->response("internal","Error load Log");
			}

		}

		/**
		 * Method to retrieve an existing log file that is either a default or a created one, if it does not exist it returns a null value
		 * @param string $log
		 * @return mixed
		 * @throws \Exception
		 */
		public function getLog($log = '', $data = '')
		{
			if (array_has($this->default, $log) && !$data)
				return $this->default[$log];

			$path = $data ? $log . '-' . Carbon::parse($data)->toDateString() : $log;;
			if (Storage::disk('logs')->exists($path)) {
				return $this->initializesLog($path);
			}

			return null;
		}

		/**
		 * Private method to manage the log stream
		 *
		 * @param $path
		 * @param $formatter
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
	}