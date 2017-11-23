<?php

namespace Modeler\Exception;

class TranslationException extends \Exception {
	
	function __construct(\SimpleXmlElement $xml, string $filename, string $id) {

		$node = dom_import_simplexml($xml);
		$nbLine = $node->getLineNo();

		parent::__construct("Error in translating template: $filename in text $id at line $nbLine", 500);

	}
}