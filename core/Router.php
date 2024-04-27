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
	private string $pageName;

	/**
	 * Ініціалізація singleton об'єкта.
	 */
	private function _init () {}

	/**
	 * @return array
	 */
	protected function get_URLParts () {
		if (! isset($this->URLParts)) {
			$this->URLParts = parse_url(URI);
		}

		return $this->URLParts;
	}

	/**
	 * @return string
	 */
	protected function get_URLPath () {
		if (! isset($this->URLPath)) {
			$this->get_URLParts();

			$this->URLPath = $this->URLParts['path'];
		}

		return $this->URLPath;
	}

	/**
	 * @return string
	 */
	protected function get_controllerURI () {
		if (! isset($this->controllerURI)) {
			$URLPath = $this->get_URLPath();

			if ($pos = strpos($URLPath, '/')) {
				$this->controllerURI = substr($URLPath, 0, $pos);
			}
			else {
				$this->controllerURI = $URLPath;
			}
		}

		return $this->controllerURI;
	}

	/**
	 *
	 */
	protected function get_controllerName (): string {
		if (! isset($this->controllerName)) {
			$controllerName = $this->get_controllerURI();

			if ($controllerName) {
				$controllerName = ucfirst($this->convertToCamelCase($controllerName)) .'Controller';
				$controllerClass = NamespaceControllers .'\\'. $controllerName;

				if (class_exists($controllerClass)) {
					$this->controllerName = $controllerName;
					$this->controllerClass = $controllerClass;
				}
				else {
					$this->controllerName = DefaultControllerName;
					$this->controllerClass = NamespaceControllers .'\\'. DefaultControllerName;
				}
			}
			else {
				$this->controllerName = DefaultControllerName;
				$this->controllerClass = NamespaceControllers .'\\'. DefaultControllerName;
			}
		}

		return $this->controllerName;
	}

	/**
	 * @return string
	 */
	protected function get_controllerClass () {
		if (! isset($this->controllerClass)) $this->get_controllerName();

		return $this->controllerClass;
	}

	/**
	 * @return string
	 */
	protected function get_pageURI () {
		if (! isset($this->pageURI)) {
			$controllerURI = $this->get_controllerURI();
			$temp = trim(str_replace($controllerURI, '', $this->URLPath), '/');

			if (($pos = strpos($temp, '/')) !== false) $this->pageURI = substr($temp, 0, $pos);
			else $this->pageURI = $temp;
		}

		return $this->pageURI;
	}

	/**
	 * Повертає метод контролера, який буде обробляти поточну сторінку.
	 */
	protected function get_pageName () {
		if (! isset($this->pageName)) {
			$pageURI = $this->get_pageURI();
			$temp = lcfirst($this->convertToCamelCase($pageURI));

			if ($temp) {
				if (method_exists($this->get_controllerClass(), $temp .'Page')) {
					$this->pageName = $temp .'Page';
				}
				else {
					$this->pageName = NotFoundPage;
				}
			}
			else {
				$this->pageName = DefaultPage;
			}
		}

		return $this->pageName;
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
