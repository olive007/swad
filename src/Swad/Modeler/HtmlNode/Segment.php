<?php

namespace Modeler\HtmlNode;

class Segment extends AbstractNode {

	private $content;

	public function __construct(\SimpleXMLElement $xml, string $xmlFileName, callable $attrInherited, AbstractContainer $container = null) {

		parent::__construct($xml, $xmlFileName, function() {}, $container);

		$name = $xml->attributes()["name"]->__toString();

		$newXmlFileName = AbstractNode::$segmentDirectory.$name.".xml";
		$segmentXml = simplexml_load_file($newXmlFileName) or die("Error: Cannot load file: ".AbstractNode::$segmentDirectory."$name.xml");

		$name = "Modeler\\HtmlNode\\".$segmentXml->getName();

		$this->content = new $name($segmentXml, $newXmlFileName, $attrInherited, $this->getContainer());
		$this->content->setTransResource($newXmlFileName);

		// Linear Layout
		$this->marginTop = &$this->content->marginTop;
		$this->marginBottom = &$this->content->marginBottom;
		$this->marginLeft = &$this->content->marginLeft;
		$this->marginRight = &$this->content->marginRight;

		// Relative Layout
		$this->positionHorizontal = &$this->content->positionHorizontal;
		$this->anchorTop = &$this->content->anchorTop;
		$this->anchorBottom = &$this->content->anchorBottom;
		$this->positionVertical = &$this->content->positionVertical;
		$this->anchorLeft = &$this->content->anchorLeft;
		$this->anchorRight = &$this->content->anchorRight;

	}



	// Getter
	public function getType() : string {
		return "Segment";
	}

	public function getWidth(string $prefix) : int {
		return $this->content->getWidth($prefix);
	}

	public function getHeight(string $prefix) : int {
		return $this->content->getHeight($prefix);
	}



	// Method
	public function renderHtml(\Pimple\Container $container) {
		return $this->content->renderHtml($container);
	}

}
