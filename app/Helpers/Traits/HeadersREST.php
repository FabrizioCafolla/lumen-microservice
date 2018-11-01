<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 20/10/18
	 * Time: 16.54
	 */

	namespace App\Helpers\Traits;

	use Carbon\Carbon;

	trait HeadersREST
	{
		private $cacheHeaders;
		private $lastModified;
		private $etag;
		private $headers = [];

		public function withHeaders(array $headers)
		{
			$this->headers = $headers;
			return $this;
		}

		public function setCachePrivate()
		{
			$this->cacheProcesor('private');
			return $this;
		}

		private function cacheProcesor(string $name)
		{
			if ($this->cacheHeaders)
				$this->cacheHeaders .= ', ' . $name;
			else
				$this->cacheHeaders .= $name;
		}

		public function setCachePublic()
		{
			$this->cacheProcesor('public');
			return $this;
		}

		public function setCacheNoStore()
		{
			$this->cacheProcesor('no-store');
			return $this;
		}

		public function setCacheNoCache()
		{
			$this->cacheProcesor('no-cache');
			return $this;
		}

		public function setCacheMaxAge(int $time = 3600)
		{
			$this->cacheProcesor('max-age=' . $time);
			return $this;
		}

		public function setCache(string $cache)
		{
			$this->cacheProcesor($cache);
			return $this;
		}

		public function setLastModified(Carbon $data){
			$this->lastModified = $data->toRfc7231String();
			return $this;
		}

		public function setEtag(string $etag) {
			$this->etag = $etag;
			return $this;
		}

	}