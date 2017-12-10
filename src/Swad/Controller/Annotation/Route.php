<?php

namespace Swad\Controller\Annotation;

use Swad\Annotation\AbstractAnnotation;
use Swad\Controller\AbstractController;

/**
 * @Target({"CLASS"})
 */
class Route extends AbstractAnnotation {


	// Attribute
	private $prefix;

	public function __construct(string $prefix = "") {
		$this->prefix = $prefix;
	}


	// Method
	public function action(AbstractController $ctrl) {
		print($this->prefix);
		$ctrl->setPrefix($this->prefix);
	}

}
