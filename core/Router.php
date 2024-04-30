<?php

namespace core;

class Router {

	use traits\Singleton_SetGet;

	// Всі наявні частини URI.
	private array $URLParts;
	// Підрядок в URI без GET-параметрів.
	private string $URLPath;
	// Підрядок в URI, який містить ім'я контролера.
	private string $controllerURI;
	// Підрядок в URI, який містить ім'я метода контролера (сторінки).
	private string $pageURI;
	// Неповне ім'я контролера.
	private string $controllerName;
	// Повне ім'я класу контролера.
	private string $controllerClass;
	// Ім'я метода поточного контролера (сторінки).
	private string $pageMethod;

	/**
	 * Ініціалізація singleton об'єкта.
	 */
	private function _init () {}

	/**
	 * Ініціалізує, якщо не визначене та повертає властивість $this->URLParts.
	 */
	protected function get_URLParts (): array {
		if (! isset($this->URLParts)) {
			$this->URLParts = parse_url(URI);
		}

		return $this->URLParts;
	}

	/**
	 * Ініціалізує, якщо не визначене та повертає властивість $this->URLPath.
	 */
	protected function get_URLPath (): string {
		if (! isset($this->URLPath)) {
			$this->get_URLParts();

			$this->URLPath = $this->URLParts['path'];
		}

		return $this->URLPath;
	}

	/**
	 * Ініціалізує, якщо не визначене та повертає властивість $this->controllerURI.
	 */
	protected function get_controllerURI (): string {
		if (! isset($this->controllerURI)) $this->setControllerData();

		return $this->controllerURI;
	}

	/**
	 * Ініціалізує, якщо не визначене та повертає властивість $this->controllerClass.
	 */
	protected function get_controllerClass (): string {
		if (! isset($this->controllerClass)) $this->setControllerData();

		return $this->controllerClass;
	}

	/**
	 * Ініціалізує, якщо не визначене та повертає властивість $this->pageURI.
	 */
	protected function get_pageURI (): string {
		if (! isset($this->pageURI)) $this->setPageData();

		return $this->pageURI;
	}

	/**
	 * Ініціалізує, якщо не визначене та повертає властивість $this->pageMethod.
	 */
	protected function get_pageMethod (): string {
		if (! isset($this->pageMethod)) $this->setPageData();

		return $this->pageMethod;
	}

	/**
	 * Визначення даних для обробки метода сторінки контролера з URI запита.
	 */
	protected function setPageData () {
		if (! isset($this->pageMethod)) {
			$controllerURI = $this->get_controllerURI();
			$temp = trim(str_replace($controllerURI, '', $this->URLPath), '/');

			if (($pos = strpos($temp, '/')) !== false) $pageURI = substr($temp, 0, $pos);
			else $pageURI = $temp;

			$temp = lcfirst($this->convertToCamelCase($pageURI));

			if ($temp) {
				if (method_exists($this->get_controllerClass(), $temp .'Page')) {
					$this->pageURI = $pageURI;
					$this->pageMethod = $temp .'Page';
				}
				else {
					$this->pageURI = '';
					$this->pageMethod = NotFoundPage;
				}
			}
			else {
				$this->pageURI = '';
				$this->pageMethod = DefaultPage;
			}
		}
	}

	/**
	 * Визначення даних контролера з URI запита.
	 */
	protected function setControllerData () {
		if (! isset($this->controllerName)) {
			$URLPath = $this->get_URLPath();

			if ($pos = strpos($URLPath, '/')) {
				$controllerURI = substr($URLPath, 0, $pos);
			}
			else {
				$controllerURI = $URLPath;
			}

			if ($controllerURI) {
				$controllerName = ucfirst($this->convertToCamelCase($controllerURI)) .'Controller';
				$controllerClass = NamespaceControllers .'\\'. $controllerName;

				if (class_exists($controllerClass)) {
					$this->controllerURI = $controllerURI;
					$this->controllerName = $controllerName;
					$this->controllerClass = $controllerClass;
				}
				else {
					$this->controllerURI = '';
					$this->controllerName = DefaultControllerName;
					$this->controllerClass = NamespaceControllers .'\\'. DefaultControllerName;
				}
			}
			else {
				$this->controllerURI = '';
				$this->controllerName = DefaultControllerName;
				$this->controllerClass = NamespaceControllers .'\\'. DefaultControllerName;
			}
		}
	}

	/**
	 * @return string
	 */
	private function convertToCamelCase (string $str) {
		if (strpos($str, '-') !== false) {
			$arr = explode('-', $str);
			$arr = array_map('ucfirst', $arr);

			$str = implode('', $arr);
		}

		return $str;
	}
}
