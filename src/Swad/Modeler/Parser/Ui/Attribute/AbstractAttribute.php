<?php

namespace Modeler\Parser\Ui\Attribute;

use Modeler\Parser\Ui\Node\AbstractNode;

abstract class AbstractAttribute {


	// Attributes
	protected $node;	
	protected $value;

	// Constructor
	public function __construct($value, AbstractNode $node) {

		$this->node = $node;
		$node->addAttribute($this);
		$this->value = $value;

	}


	// Getter
	abstract public function getType() : string;

	public function getValue() {
		return $this->value;
	}

	// Method
	abstract public function generate();

}
