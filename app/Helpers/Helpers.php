<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 03/08/18
	 * Time: 14.02
	 */
	if ( ! function_exists('config_path'))
	{
		/**
		 * Get the configuration path.
		 *
		 * @param  string $path
		 * @return string
		 */
		function config_path($path = '')
		{
			return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
		}
	}