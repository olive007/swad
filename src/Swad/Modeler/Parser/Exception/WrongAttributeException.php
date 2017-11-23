<?php

namespace Modeler\Exception;

class WrongAttributeException extends \Exception {
	
	function __construct(\SimpleXmlElement $xml, string $filename, string $attributeName) {

		$node = dom_import_simplexml($xml);
		$nbLine = $node->getLineNo();

		parent::__construct("Error in template: $attributeName is wrong in file: $filename at line $nbLine", 500);

	}
}