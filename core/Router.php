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
	// URI поточного модуля до якого робе запит користувач.
	private string $moduleURI;
	// Поточний URI без URI $this->moduleURI.
	private string $URIWithoutModule;
	// Контроллер за замовчуванням для поточного модуля.
	private string $defaultControllerName;
	private string $namespaceControllers;
	private string $defaultControllerClass;
	// Наявність зайвого рядка в URIPath.
	private bool $isExtraLineInURLPath;

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
	 * Визначає поточний модуль.
	 */
	protected function get_moduleURI (): string {
		if (! isset($this->moduleURI)) {
			// Отримання частини URIPath до першого символа '/'.

			if ($pos = strpos(URIPath, '/')) {
				$moduleURI = substr(URIPath, 0, $pos);
			}
			else {
				$moduleURI = URIPath;
			}

			if (isset(Modules[$moduleURI])) {
				$this->moduleURI = $moduleURI;
			}
			else {
				$this->moduleURI = '';
			}
		}

		return $this->moduleURI;
	}

	/**
	 *
	 */
	protected function get_URIWithoutModule (): string {
		if (! isset($this->URIWithoutModule)) {
			$this->URIWithoutModule = trim(str_replace($this->get_moduleURI(), '', URI), '/');
		}

		return $this->URIWithoutModule;
	}

	/**
	 * Отримання контроллера за замовчуванням для поточного модуля.
	 */
	protected function get_defaultControllerName (): string {
		if (! isset($this->defaultControllerName)) {
			$this->defaultControllerName = Modules[$this->get_moduleURI()]['defaultControllerName'];
		}

		return $this->defaultControllerName;
	}

	/**
	 * Отримання імені класу контроллера за замовчуванням для поточного модуля.
	 */
	protected function get_defaultControllerClass (): string {
		if (! isset($this->defaultControllerClass)) {
			$this->defaultControllerClass = $this->get_namespaceControllers() .'\\'.
				Modules[$this->get_moduleURI()]['defaultControllerName'];
		}

		return $this->defaultControllerClass;
	}

	/**
	 * Визначення даних для обробки метода сторінки контролера з URI запита.
	 */
	protected function setPageData () {
		if (! isset($this->pageMethod)) {
			$temp = $this->get_URIWithoutModule();

			$temp = trim(str_replace($this->get_controllerURI(), '', $temp), '/');
			$temp = lcfirst($this->convertToCamelCase($temp));

			if ($temp) {
				if (method_exists($this->get_controllerClass(), $temp .'Page')) {
					$this->pageURI = $temp;
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
	 * Встановлення даних контроллера за замовчуванням для поточного модуля.
	 */
	protected function setDefaultControllelrData () {
		$this->controllerURI = '';
		$this->controllerName = $this->get_defaultControllerName();
		$this->controllerClass = $this->get_defaultControllerClass();
	}

	/**
	 * Визначення даних контролера з URI запита.
	 */
	protected function setControllerData () {
		if (! isset($this->controllerName)) {
			$URIPath = $this->get_URIWithoutModule();

			if ($pos = strpos($URIPath, '/')) {
				$controllerURI = substr($URIPath, 0, $pos);
			}
			else {
				$controllerURI = $URIPath;
			}

			if ($controllerURI) {
				$controllerName = ucfirst($this->convertToCamelCase($controllerURI)) .'Controller';
				$controllerClass = $this->get_namespaceControllers() .'\\'. $controllerName;

				if (class_exists($controllerClass)) {
					$this->controllerURI = $controllerURI;
					$this->controllerName = $controllerName;
					$this->controllerClass = $controllerClass;
				}
				else {
					$this->setDefaultControllelrData();
				}
			}
			else {
				$this->setDefaultControllelrData();
			}
		}
	}

	/**
	 * Отримання namespace контроллерів для поточного модуля.
	 */
	protected function get_namespaceControllers (): string {
		if (! isset($this->namespaceControllers)) {
			$this->namespaceControllers = Modules[$this->get_moduleURI()]['namespaceControllers'];
		}

		return $this->namespaceControllers;
	}

	/**
	 * Ініціалізує та повертає властивість $this->isExtraLineInURLPath.
	 */
	protected function get_isExtraLineInURLPath (): bool {
		if (! isset($this->isExtraLineInURLPath)) {
			$str = trim($this->moduleURI .'/'. $this->controllerURI .'/'. $this->pageURI, '/');
			$str = trim(substr(URIPath, (strpos(URIPath, $str) + strlen($str))), '/');

			$this->isExtraLineInURLPath = ($str !== '') ? true : false;
		}

		return $this->isExtraLineInURLPath;
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
