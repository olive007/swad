<?php

namespace Modeler\HtmlNode;

use Modeler\Exception\MandatoryAttributeException;

class Image extends AbstractNode {

	// Attribute
	private $id;
	private $color;
	private $encoding;
	private $description;



	// Constructor
	public function __construct(\SimpleXMLElement $xml, string $xmlFileName, callable $attrInherited, AbstractContainer $container = null) {

		parent::__construct($xml, $xmlFileName, $attrInherited, $container);

		$tmp = $xml->attributes()["id"];
		if (isset($tmp)) {
			$this->id = $tmp->__toString();
		}
		else {
			throw new MandatoryAttributeException($xml, $xmlFileName, "id");
		}

		$tmp = $xml->attributes()["encoding"];
		if (isset($tmp)) {
			$this->encoding = $tmp->__toString();
		}
		else {
			throw new MandatoryAttributeException($xml, $xmlFileName, "encoding");
		}

		$tmp = $xml->attributes()["color"];
		if (isset($tmp)) {
			$this->color = $tmp->__toString();
		}
		else {
			$this->color = null;
		}
		$this->description = "";

		$this->addHtmlAttr("alt", "");
		
	}


	// Getter
	public function getType() : string {
		return "Image";
	}


	// Method
	public function renderHtml(\Pimple\Container $container) {

		$path = $container["website.path.root"]."/".$this->encoding."/".$this->id;
		if (isset($this->color)) {
			$path .= "/".$this->color;
		}
		$this->addHtmlAttr("src", $path);

		$res = '<img '.$this->generateAttributes().'/>';

		return $res;
	}


}
