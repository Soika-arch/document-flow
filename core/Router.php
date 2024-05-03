<?php

namespace core;

class Router {

	use traits\Singleton_SetGet;

	/** @var array всі наявні частини URI. */
	private array $URLParts;
	/** @var string підрядок в URI без GET-параметрів. */
	private string $URLPath;
	/** @var string підрядок в URI, який містить ім'я контролера. */
	private string $controllerURI;
	/** @var string підрядок в URI, який містить ім'я метода контролера (сторінки). */
	private string $pageURI;
	/** @var string ім'я контролера. */
	private string $controllerName;
	/** @var string ім'я класу контролера. */
	private string $controllerClass;
	/** @var string ім'я метода поточного контролера (сторінки). */
	private string $pageMethod;
	/** @var string URI поточного модуля до якого робе запит користувач. */
	private string $moduleURI;
	/** @var string поточний URI без URI $this->moduleURI. */
	private string $URIWithoutModule;
	/** @var string контроллер за замовчуванням для поточного модуля. */
	private string $defaultControllerName;
	/** @var string namespace поточного модуля за замовчуванням. */
	private string $namespaceControllers;
	/** @var string клас контролера поточного модуля за замовчуванням. */
	private string $defaultControllerClass;
	/** @var string наявність зайвого рядка в URIPath. */
	private bool $isExtraLineInURLPath;

	/**
	 * Ініціалізація singleton об'єкта.
	 */
	private function _init () {}

	/**
	 * Ініціалізує та повертає властивість $this->URLParts.
	 * @return array
	 */
	protected function get_URLParts () {
		if (! isset($this->URLParts)) {
			$this->URLParts = parse_url(URI);
		}

		return $this->URLParts;
	}

	/**
	 * Ініціалізує та повертає властивість $this->URLPath.
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
	 * Ініціалізує та повертає властивість $this->controllerURI.
	 * @return string
	 */
	protected function get_controllerURI () {
		if (! isset($this->controllerURI)) $this->setControllerData();

		return $this->controllerURI;
	}

	/**
	 * Ініціалізує та повертає властивість $this->controllerClass.
	 * @return string
	 */
	protected function get_controllerClass () {
		if (! isset($this->controllerClass)) $this->setControllerData();

		return $this->controllerClass;
	}

	/**
	 * Ініціалізує та повертає властивість $this->pageURI.
	 * @return string
	 */
	protected function get_pageURI () {
		if (! isset($this->pageURI)) $this->setPageData();

		return $this->pageURI;
	}

	/**
	 * Ініціалізує, якщо не визначене та повертає властивість $this->pageMethod.
	 * @return string
	 */
	protected function get_pageMethod () {
		if (! isset($this->pageMethod)) $this->setPageData();

		return $this->pageMethod;
	}

	/**
	 * Ініціалізує та повертає властивість $this->moduleURI.
	 * @return string
	 */
	protected function get_moduleURI () {
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
	 * Ініціалізує та повертає властивість $this->URIWithoutModule.
	 * @return string
	 */
	protected function get_URIWithoutModule () {
		if (! isset($this->URIWithoutModule)) {
			$this->URIWithoutModule = trim(str_replace($this->get_moduleURI(), '', URI), '/');
		}

		return $this->URIWithoutModule;
	}

	/**
	 * Ініціалізує та повертає властивість $this->defaultControllerName.
	 * @return string
	 */
	protected function get_defaultControllerName () {
		if (! isset($this->defaultControllerName)) {
			$this->defaultControllerName = Modules[$this->get_moduleURI()]['defaultControllerName'];
		}

		return $this->defaultControllerName;
	}

	/**
	 * Ініціалізує та повертає властивість $this->defaultControllerClass.
	 * @return string
	 */
	protected function get_defaultControllerClass () {
		if (! isset($this->defaultControllerClass)) {
			$this->defaultControllerClass = $this->get_namespaceControllers() .'\\'.
				Modules[$this->get_moduleURI()]['defaultControllerName'];
		}

		return $this->defaultControllerClass;
	}

	/**
	 * Ініціалізує та повертає властивість $this->namespaceControllers.
	 * @return string
	 */
	protected function get_namespaceControllers () {
		if (! isset($this->namespaceControllers)) {
			$this->namespaceControllers = Modules[$this->get_moduleURI()]['namespaceControllers'];
		}

		return $this->namespaceControllers;
	}

	/**
	 * Ініціалізує та повертає властивість $this->isExtraLineInURLPath.
	 * @return bool
	 */
	protected function get_isExtraLineInURLPath () {
		if (! isset($this->isExtraLineInURLPath)) {
			// Рядок, URLPath, який точно не може бути зайвим.
			$str = trim($this->moduleURI .'/'. $this->controllerURI .'/'. $this->pageURI, '/');
			// Підрядок, який можливо іде за $str, він і є зайвий, якщо є.
			$str = trim(substr(URIPath, (strpos(URIPath, $str) + strlen($str))), '/');

			// Якщо URLPath містить зайвий підрядок - приймає значення true.
			$this->isExtraLineInURLPath = ($str !== '') ? true : false;
		}

		return $this->isExtraLineInURLPath;
	}

	/**
	 * Визначення даних для обробки метода сторінки контролера з URI запита.
	 */
	protected function setPageData () {
		if (! isset($this->pageMethod)) {
			$temp = $this->get_URIWithoutModule();
			// Видалення рядка GET-параметрів разом із знаком питання, якщо вони є.
			$temp = str_replace('?'. URIParams, '', $temp);

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
			$controllerFile = DirRoot .'/'. str_replace('\\', '/', $controllerClass) .'.php';

			if (is_file($controllerFile)) {
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

	/**
	 * Конвертує отриманий рядок у CamelCase формат.
	 */
	private function convertToCamelCase (string $str): string {
		if (strpos($str, '-') !== false) {
			$arr = explode('-', $str);
			$arr = array_map('ucfirst', $arr);

			$str = implode('', $arr);
		}

		return $str;
	}
}
