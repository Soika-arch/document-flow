<?php

class A {
	public function __construct () {
		$cl = get_called_class();
	}
}

class B extends A {
	public function __construct () {
		parent::__construct();
	}
}

class C extends B {
	public function __construct () {
		parent::__construct();
	}
}

$obj = new C();
