<?php

namespace Modeler\Generator\Html\Node;

use Modeler\Parser\Ui\Node as Parser;

class Form extends Parser\Form {

	use HtmlCommon;

	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, Parser\AbstractContainer $container) {

		$this->initHtmlCommon();

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);

	}

	// Method
	public function generate(array $variables) : string {

		$res = "<form ".$this->htmlAttributeAsString().' link="'.$this->getLink().'">';
		$res .= "</form>";

		return $res;
	}

}