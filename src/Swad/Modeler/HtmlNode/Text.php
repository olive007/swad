<?php

namespace Modeler\HtmlNode;

use Modeler\Exception\MandatoryAttributeException;

class Text extends AbstractNode {


	// Attribute
	private $content;
	protected $fontSize;
	private $id;


	// Constructor
	public function __construct(\SimpleXMLElement $xml, string $xmlFileName, callable $attrInherited, AbstractContainer $container = null) {

		parent::__construct($xml, $xmlFileName, $attrInherited, $container);

		$this->content = $xml->__toString();

		if ($this->setModelerAttr($xml, "fontSize")) {
			if ($this->fontSize == "filled") {
				$this->addScriptClass("filled");
			}
		}
		else {
			throw new MandatoryAttributeException($xml, $xmlFileName, "fontSize");
			
		}

		$tmp = $xml->attributes()["id"];
		if (isset($tmp)) {
			$this->id = $tmp."";
		}
		// else {
		// 	throw new MandatoryAttributeException($xml, $xmlFileName, "id");
		// }

	}


	// Getter
	public function getType() : string {
		return "Text";
	}



	// Method
	protected function generateAttributes() {
		$this->addModelerAttr("Text-fontSize", $this->fontSize);

		return parent::generateAttributes();
	}

	public function renderHtml(\Pimple\Container $container) {

		$ld = $this->getLinkDest();

		// if (isset($ld)) {

		// 	$res = '<a href="'.$ld.'" '.$this->generateAttributes()."><p ".$this->generateAttributes().">";

		// 	$res .= $this->content."</p></a>";
		// }
		// else {
			$res = "<p ".$this->generateAttributes().">";

			$res .= nl2br($this->transText($container, $this->id))."</p>";
//		}

		return $res;
	}


}
