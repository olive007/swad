<?php

namespace Modeler\Parser\Exception;

class MandatoryAttributeException extends ParsingException {
	
	function __construct(\SimpleXmlElement $xml, string $filename, string $attributeName) {

		$node = dom_import_simplexml($xml);
		$nbLine = $node->getLineNo();

		parent::__construct("Error in template: $attributeName not defined in file: $filename at line $nbLine", 500);

	}
}