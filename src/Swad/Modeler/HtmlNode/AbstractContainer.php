<?php

namespace Modeler\HtmlNode;

abstract class AbstractContainer extends AbstractNode {

	private $nodes = [];

	public function __construct(
		\SimpleXMLElement $xml,
		string $xmlFileName,
		callable $attrInherited,
		callable $attrAdditional,
		AbstractContainer $container = null) {


		parent::__construct($xml, $xmlFileName, $attrInherited, $container);

		foreach ($xml->children() as $child) {

			$name = "Modeler\\HtmlNode\\".$child->getName();
			
			$this->addNode(new $name($child, $xmlFileName, $attrAdditional, $this));
		}
	}



	// Getter
	public function getNode(int $i) : AbstractNode {
		return $this->nodes[$i];
	}

	public function getNbNode() : int {
		return count($this->nodes);
	}




	// Method
	public function addNode(AbstractNode $n) {
		array_push($this->nodes, $n);
	}


}
