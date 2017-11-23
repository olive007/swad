<?php

namespace Modeler\Parser\Ui\Attribute;

use Modeler\Parser\Ui\Node\AbstractNode;

abstract class Color extends AbstractAttribute {


	// Attributes
	private $color;


	// Constructor
	public function __construct($value, AbstractNode $node) {

		parent::__construct($value, $node);

		$this->color = \Modeler\Color::get($value."");

	}


	// Getter
	public function getColor() : \Modeler\Color {
		return $this->color;
	}


}
