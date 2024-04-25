<?php

namespace core;

/**
 * Єдиний реєстр об'єктів доступних для всього застосунку.
 */
class Registry {

	use traits\Singleton;

	// Масив-реєстр об'єктів (даних)
	private array $reg;

	private function _init () {}

	/**
	 * Додає вказаний об'єкт до реєстру.
	 * @param string $name назва об'єкта (даних), що зберігається до реєстра.
	 * @return bool
	 */
	public function add (string $name, mixed $data) {
		if (! isset($this->reg[$name])) {
			$this->reg[$name] = $data;

			return true;
		}

		return false;
	}

	/**
	 * Отримання об'єкта з реєстра.
	 * @param string $name назва об'єкта (даних), що зберігається до реєстра.
	 */
	public function get (string $name) {
		if (isset($this->reg[$name])) return $this->reg[$name];
	}

	/**
	 * Заміна об'єкта в реєстрі.
	 * @param mixed
	 */
	public function replace (string $name, mixed $data) {
		if (isset($this->reg[$name])) {
			$this->reg[$name] = $data;

			return $this->reg[$name];
		}

		return false;
	}
}
