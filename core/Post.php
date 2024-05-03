<?php

namespace core;

/**
 * Клас надає методи роботи з даними, відправленими методом POST.
 */
class Post {

	use \core\traits\SetGet;

	// Містить масив $_POST
	private array $post;
	// Значення атрибуту name форми, яку обробляє поточний об'єкт.
	private string $formName;
	private array $formTypes;

	// Дозволені типи даних
	private array $allowedTypes = [
		'int', 'float', 'varchar', 'text', 'email'
	];

	private array $errors = [];

	/**
	 *
	 */
	public function __construct (string $formName, array $formTypes) {
		$this->formName = $formName;
		$this->get_post();
		$this->saveFormTypes($formTypes);
	}

	/**
	 * Ініціалізує та повертає властивість $this->post.
	 */
	private function get_post (): array {
		if (! isset($this->post)) $this->post = $_POST;

		return $this->post;
	}

	/**
	 * Зберігання дозволених імен POST масиву та їх типів для поточної форми.
	 */
	private function saveFormTypes (array $formTypes) {
		$post = $this->get_post();

		foreach ($formTypes as $name => $typeData) {
			if (in_array($typeData['type'], $this->allowedTypes)) {
				$checkMethod = 'check'. ucfirst($typeData['type']);

				// Перевірка типу даних отриманого поля.

				if (! $this->$checkMethod($name, $typeData)) {
					$this->errors[] = 'Поле '. $name .' не пройшло перевірку типу даних метода '. $checkMethod;
				}
			}
			else {
				$this->errors[] = 'Отримано недозволений тип даних: '. $typeData['type'];
			}

			unset($post[$name]);
		}

		foreach ($post as $name => $value) {
			$this->errors[] = 'Отримано непередбачене значення форми: $_POST["'. $name .'"] - '.
				var_export($value, true);
		}
	}

	/**
	 * Повертає очищене значення масиву $_POST, якщо воно існує.
	 * @return string
	 */
	public function sanitizeValue (string $name) {
		if (isset($this->post[$name])) {

			return htmlspecialchars(trim($this->post[$name]));
		}

		return null;
	}

	/**
	 * @return bool
	 */
	private function checkInt (string $name, array $typeData) {
		$this->get_post();

		return is_int(intval($this->post[$name]));
	}

	/**
	 * @return bool
	 */
	private function checkFloat (float $v) {

		return is_float($v);
	}

	/**
	 * Перевіряє чи є $v текстом, а також чи відповідиє довжина тексту величині $l.
	 * @return bool
	 */
	private function checkText (string $v, int|null $l=null) {
		$f = $l ? (strlen($v) <= $l) : true;

		return ($f && is_string($v));
	}

	/**
	 * @return bool
	 */
	private function checkVarchar (string $name, array $typeData) {
		$this->get_post();

		if (preg_match('/'. $typeData['pattern'] .'/', $this->post[$name])) {

			return $this->checkText($this->post[$name], 255);
		}

		return false;
	}
}
