<?php

namespace Modeler\Parser\Ui\Node;

abstract class AbstractContainer extends AbstractNode {


	// Attributes
	private $nodes = [];


	// Constructor
	protected function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		// Call parent contructor
		parent::__construct($xmlNode, $xmlFileName, $container);

		// Loop thru child
		foreach ($xmlNode->children() as $child) {

			// Get the class name of the child
			$className = AbstractNode::$namespace."\\Node\\".$child->getName();

			// Construct the child object and add it into this container
			$this->addNode(new $className($child, $xmlFileName, $this));
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
