<?php

namespace Modeler\Parser\Ui\Node;

use Modeler\Parser\Exception\ParsingException;

abstract class Screen extends AbstractContainer {

	// Class method
	protected static function createFromXmlFile($fileName) {

		// Load the xml form the file
		$xmlNode = simplexml_load_file($fileName);

		if ($xmlNode->getName() != "Screen") {
			throw new ParsingException($xmlNode, $fileName, "Error first child is not Screen");
		}

		// Construct the object
		$className = AbstractNode::$namespace."\\Node\\Screen";

		// Construct the object
		$res = new $className($xmlNode, $fileName);

		return $res;
	}


	// Constructor
	protected function __construct(\SimpleXMLElement $xmlNode, string $xmlFileName) {

		// Call parent contructor
		parent::__construct($xmlNode, $xmlFileName, $this);

	}


	// Getter	
	public function getType() : string {
		return "Screen";
	}

	public function getContainer() : ?AbstractContainer {
		return null;
	}


}