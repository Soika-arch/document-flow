<?php

namespace core;

/**
 *
 */
class Header {

	use traits\Singleton_SetGet;

	// Масив підготовлених до надсилання заголовків.
	private array $headers;

	/**
	 *
	 */
	private function get_headers () {
		if (! isset($this->headers)) {
			$this->headers = [];
		}

		return $this->headers;
	}

	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
	 *
	 */
	private function _init () {

	}

	/**
	 * @param string $content содержимое заголовка.
	 * @param string $file файл, где заголовок был добавлен.
	 * @param string $line строка файла, где заголовок был добавлен.
	 */
	public function addHeader ($content, string $file, int $line) {
		$this->headers[] = [$file .': '. $line, $content];

		return $this;
	}

	/**
	 *
	 */
	public function send (bool $isExit=true) {
		if (isset($this->headers)) {
			for ($i = 0; $i < count($this->headers); $i++) header($this->headers[$i][1]);
		}

		if ($isExit) exit;
	}
}
