<?php

namespace core;

/**
 * Клас надає методи роботи з даними, відправленими методом GET.
 */
class Get {

	use \core\traits\SetGet;

	/**
	 * @var array $_GET
	 */
	private array $get;

	/**
	 * @var string значення атрибуту name форми, яку обробляє поточний об'єкт
	 */

	private array $types;

	// Дозволені типи даних
	private array $allowedTypes = [
		'int', 'float', 'varchar', 'text', 'email'
	];

	private array $errors = [];

	/**
	 *
	 */
	public function __construct (array $types) {
		$this->get_get();
		$this->validateAndProcessGetParameters($types);
	}

	/**
	 * Ініціалізує та повертає властивість $this->post.
	 */
	private function get_get () {
		if (! isset($this->get)) $this->get = $_GET;

		return $this->get;
	}

	/**
   * Перевіряє та обробляє параметри, передані через масив $_GET, ґрунтуючись на описаних типах
	 * даних та їх правилах валідації.
   * @param array $types Масив, що містить інформацію про типи даних та їх правила перевірки.
   * @return void
   */
	private function validateAndProcessGetParameters (array $types) {
		// Отримуємо поточні параметри з масиву $_GET.
		$get = $this->get_get();

		// Проходимо по всіх зазначених типах даних для перевірки та обробки.
		foreach ($types as $name => $typeData) {
			// Перевіряємо, чи існує параметр у масиві $_GET.
			$issetParam = isset($get[$name]);

			// Перевіряємо, чи належить тип даних до дозволених типів.
			if (in_array($typeData['type'], $this->allowedTypes)) {
				// Перевіряємо, чи є параметр обов'язковим
				if (isset($typeData['isRequired']) && $typeData['isRequired']) {
					// Якщо параметр обов'язковий, але відсутній, додаємо повідомлення про помилку.
					if (! $issetParam) {
						$this->errors[] = 'Відсутній обов\'язковий параметр $_GET["'. $name .'"]';

						continue;
					}
				}

				// Формуємо ім'я методу перевірки типу даних.
				$checkMethod = 'check'. ucfirst($typeData['type']);

				// Перевіряємо параметр за допомогою відповідного методу, якщо він існує.
				if ($issetParam && (! $this->$checkMethod($name, $typeData))) {
					$this->errors[] = 'Параметр '. $name .' не пройшов перевірку типу даних метода '.
						$checkMethod;
				}
			}
			else {
				// Якщо тип даних не є дозволеним, додаємо повідомлення про помилку.
				$this->errors[] = 'Отримано недозволений тип даних: '. $typeData['type'];
			}

			// Видаляємо оброблений параметр із масиву $get.
			unset($get[$name]);
		}

		// Перевіряємо, чи є непередбачені параметри в масиві $_GET.
		foreach ($get as $name => $value) {
			$this->errors[] = 'Отримано непередбачене значення параметру: $_GET["'. $name .'"] - '.
				var_export($value, true);
		}
	}

	/**
	 * Повертає очищене значення масиву $_POST, якщо воно існує.
	 * @return string
	 */
	public function sanitizeValue (string $name) {
		if (isset($this->get[$name])) {

			return htmlspecialchars(trim($this->get[$name]));
		}

		return null;
	}

	/**
	 * @return bool
	 */
	private function checkInt (string $name, array $typeData) {
		if (isset($typeData['pattern'])) {
			if (! preg_match('/'. $typeData['pattern'] .'/', $this->get[$name])) {
				$this->errors[] = 'Параметр: $_GET["'. $name .'"] - не відповідає шаблону [ '.
					$typeData['pattern'] .' ]';
			}
		}

		return ctype_digit($this->get[$name]);
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
		if (preg_match('/'. $typeData['pattern'] .'/', $this->get[$name])) {

			return $this->checkText($this->get[$name], 255);
		}

		return false;
	}
}
