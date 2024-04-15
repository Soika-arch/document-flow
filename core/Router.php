<?php

namespace core;

use core\traits\Singleton;
use core\traits\SetGet;

class Router {

	use traits\Singleton;
	use traits\SetGet;

	// Всі наявні частини URI.
	private array $URLParts;
	// Підрядок в URI без GET-параметрів.
	private string $URLPath;
	// Підрядок в URI, який містить ім'я контролера.
	private string $controllerURI;
	// Підрядок в URI, який містить ім'я екшена контролера.
	private string $actionURI;
	// Повне ім'я класу контролера.
	private string $controllerClassName;
	private string $actionName;

	/**
	 * Ініціалізація singleton об'єкта.
	 */
	private function _init () {
		// dd($this->get_controllerClassName(), __FILE__, __LINE__,1);
	}

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
	 * @return string
	 */
	protected function get_controllerClassName () {
		if (! isset($this->controllerClassName)) {
			$controllerURI = $this->get_controllerURI();
			$temp = $this->convertToCamelCase($controllerURI);

			$temp = NamespaceControllers .'\\'. ucfirst($temp) .'Controller';

			if (class_exists($temp)) {
				$this->controllerClassName = $temp;
			}
			else {
				$this->controllerClassName = DefaultControllerClassName;
			}
		}

		return $this->controllerClassName;
	}

	/**
	 * @return string
	 */
	protected function get_actionURI () {
		if (! isset($this->actionURI)) {
			$controllerURI = $this->get_controllerURI();
			$temp = trim(str_replace($controllerURI, '', $this->URLPath), '/');

			if (($pos = strpos($temp, '/')) !== false) $this->actionURI = substr($temp, 0, $pos);
			else $this->actionURI = $temp;
		}

		return $this->actionURI;
	}

	/**
	 * @return
	 */
	protected function get_actionName () {
		if (! isset($this->actionName)) {
			$actionURI = $this->get_actionURI();
			$temp = lcfirst($this->convertToCamelCase($actionURI));

			if ($temp) {
				if (method_exists($this->get_controllerClassName(), $temp .'Action')) {
					$this->actionName = $temp .'Action';
				}
				else {
					$this->actionName = NotFoundAction;
				}
			}
			else {
				$this->actionName = DefaultAction;
			}
		}

		return $this->actionName;
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
