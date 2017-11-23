<?php

namespace Modeler\Parser\Ui\Attribute;

use Modeler\Parser\Ui\Node\AbstractNode;

use Modeler\Parser;

abstract class AbstractResponsiveAttribute extends AbstractAttribute {


	// Attributes
	protected $node;

	// Constructor
	public function __construct($value, AbstractNode $node, string $screenSize) {

		$this->node = $node;
		$tmp = $node->getAttribute($this->getType());

		if ($tmp != null) {

			$tmp->value[Parser::$screenSuffix[$screenSize]] = $value."";

			if ($screenSize == "Medium" || $screenSize == "Small") {
				$tmp->value[Parser::$screenSuffix["Medium"]] = $value."";
				$tmp->value[Parser::$screenSuffix["Large"]] = $value."";
			}

		}
		else {

			$this->value = [];

			$this->value[Parser::$screenSuffix["Small"]] = $value."";
			$this->value[Parser::$screenSuffix["Medium"]] = $value."";
			$this->value[Parser::$screenSuffix["Large"]] = $value."";

			$node->addAttribute($this);
		}

	}


	// Method
	public function getResponsiveValue(string $screenSuffix) {
		return $this->value[$screenSuffix];
	}

	abstract public function generateByScreen(string $screenSuffix);

	public function generate() {

		foreach (Parser::$screenSuffix as $key => $value) {
			$this->generateByScreen($value);
		}

	}

}
