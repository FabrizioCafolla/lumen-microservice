<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use App\Exceptions\LogsException;
	use Carbon\Carbon;
	use Monolog\Formatter\JsonFormatter;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use Illuminate\Support\Facades\Storage;
	use ResponseService;

	class LogService
	{
		/**
		 * Basic log
		 * get with function default()
		 *
		 * @var array
		 */
		private $default = [
			'lumen',
			'mails',
			'queries',
			'generics',

			//Add your basic logs here
		];

		/**
		 * Basic log of day
		 * get with function defaultDay()
		 *
		 * @var array
		 */
		private $defaultDay = [
			'lumen',
			'mails',
			'queries',
			'generics',

			//Add your basic logshere
		];

		/**
		 * Initialize the default logs with the instance of the Monolog class with today's date when the log file is created
		 *
		 * @throws \Exception
		 */
		public function __construct()
		{
			foreach ($this->default as $name) {
				$path = $this->path($name);
				$this->default[$name] = $this->logProcessor($path);
			}
			foreach ($this->defaultDay as $name) {
				$path = $this->path($name, 'today');
				$this->defaultDay[$name] = $this->logProcessor($path);
			}
		}

		/**
		 * Method used to initialize the logs, returns the Monolog object, you can define the name of the log file by adding the date to it and choose the format.
		 *
		 * @param $path
		 * @param string $formatter type of format log file
		 * @return Logger object Monolog
		 * @throws \Exception
		 */
		private function logProcessor($path, $formatter = JsonFormatter::class)
		{
			try {
				$create = new Logger(str_singular($path));
				return $create->pushHandler($this->stream($path, $formatter));
			} catch (LogsException $e) {
				$e->exception("Error process this log: " . $path, 500);
			}
		}

		/**
		 * Method to create path of Log
		 *
		 * @param $name
		 * @param $dataTime
		 * @return string
		 */
		private function path($name, $dataTime = null): string
		{
			$path = ($dataTime ? $name . '-' . Carbon::parse($dataTime)->toDateString() : $name).'.log';
			return $path;
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
			$stream = new StreamHandler(logger_path($path), Logger::DEBUG);
			$stream->setFormatter(new $formatter);
			return $stream;
		}

		/**
		 * Alias logProcessor
		 * Method to create a new Log file
		 *
		 * @param $name
		 * @param string $dataTime
		 * @param string $formatter (Moolog/Formatter class)
		 * @return Logger
		 * @throws \Exception
		 */
		public function new($name, $dataTime = null, $formatter = JsonFormatter::class)
		{
			$path = $this->path($name, $dataTime);
			return $this->logProcessor($path, $formatter);
		}

		/**
		 * Get an existing log
		 * Recovery log through his name.
		 * Log recovery by entering the date and the name of the desired log
		 *
		 * Example:
		 *  $this->log->get('name');                 //return log if exist storage/logs/name.log
		 *  $this->log->get('name', '2018-01-01');  //return log if exist storage/logs/name-2018-01-01.log
		 *
		 * @param string $name
		 * @param string|yy-mm-dd $data
		 * @return mixed|Logger|null
		 * @throws \Exception
		 */
		public function get($name = '', $dataTime = null)
		{
			$path = $this->path($name, $dataTime);
			if (Storage::disk('logs')->exists($path))
				return $this->logProcessor($path);

			ResponseService::errorException('Log required not exist: '.$name);
		}

		/**
		 * Get basic logs
		 * Example: $this->log->default('mails')->info('Example used');
		 *
		 * @param $name
		 * @return mixed
		 */
		public function default($name)
		{
			if (array_has($this->default, $name))
				return $this->default[$name];

			ResponseService::errorException('Default log required not exist: '.$name);
		}

		/**
		 * Get basic default day logs
		 * Example: $this->log->defaultDay('mails')->info('Example used');
		 *
		 * @param $name
		 * @return mixed
		 */
		public function defaultDay($name)
		{
			if (array_has($this->defaultDay, $name))
				return $this->defaultDay[$name];

			ResponseService::errorException('Default of day log required not exist: '.$name);
		}

		/**
		 * Get log only today
		 *
		 * @param $name
		 * @return mixed|Logger|null
		 * @throws \Exception
		 */
		public function today($name)
		{
			return $this->get($name, 'today');
		}

	}