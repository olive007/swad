<?php

namespace Modeler\Generator\Html\Node;

use Modeler\Generator\Html;

use Modeler\Generator\Html\Attribute\Weight;

use Modeler\Parser\Ui\Node as Parser;

class LinearLayout extends Parser\LinearLayout {

	use HtmlCommon;

	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, Parser\AbstractContainer $container) {

		$this->initHtmlCommon();

		// Call contructor from parent class
		parent::__construct($xmlNode, $xmlFileName, $container);

		$this->addHtmlClass(Html::$class["linearLayout"]);

	}

	// Method
	public function generate(array $variables) : string {

		$res = "<div ".$this->htmlAttributeAsString().">";

		for ($i = 0; $i < $this->getNbNode(); $i++) { 
			$res .= $this->getNode($i)->render($variables);
		}

		$res .= "</div>";

		return $res;
	}

}