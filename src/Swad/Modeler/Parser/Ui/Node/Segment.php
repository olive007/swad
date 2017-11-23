<?php

namespace Modeler\Parser\Ui\Node;

use Modeler\Parser\Ui\Attribute\AbstractAttribute;

abstract class Segment extends AbstractNode {


	// Class variable
	static public $directory;


	// Attributes
	private $node;


	// Constructor
	public function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName, AbstractContainer $container) {

		$id = $xmlNode->attributes()["Id"]->__toString();

		$newXmlFileName = self::$directory."$id.xml";

		$segmentXmlNode = simplexml_load_file($newXmlFileName);

		// Get the class name of the child
		$className = AbstractNode::$namespace."\\Node\\".$segmentXmlNode->getName();

		// Construct the child object and add it into this container
		$this->node = new $className($segmentXmlNode, $newXmlFileName, $container);

	}

	// Getter	
	public function getType() : string {
		return "Segment";
	}

	public function getContainer() : ?AbstractContainer {
		return $this->node->getContainer();
	}

	public function getAttribute(string $id) : ?AbstractAttribute {
		return $this->node->getAttribute($id);
	}



	// Method
	public function addAttribute(AbstractAttribute $attr) {
		$this->node->addAttribute($attr);
	}

	public function render(array $variables) : string {
		return $this->node->render($variables);
	}

	public function generate(array $variables) : string {
		print_r("<br>Never Called");
	}
}
