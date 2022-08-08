<?php

namespace controllers;

use libraries\Controller;
use models\_Product;

class Product extends Controller {

	private $p;

	function __construct() {
		$this->p = new _Product();
	}

	public function details($h) {
		$pd = $this->p->details($h);
		
		$this->return($pd);
	}
}

?>