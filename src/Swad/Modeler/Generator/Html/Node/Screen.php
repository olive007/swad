<?php

namespace Modeler\Generator\Html\Node;

use Modeler\Parser\Ui\Node as Parser;

class Screen extends Parser\Screen {

	// Classmethod
	public static function createFromXmlFile($fileName) {

		Parser\AbstractNode::$namespace = "Modeler\\Generator\\Html";

		return parent::createFromXmlFile($fileName);

	}


	// Method
	public function generate(array $variables) : string {

		$res = "";

		for ($i = 0; $i < $this->getNbNode(); $i++) { 
			$res .= $this->getNode($i)->render($variables);
		}

		return $res;
	}

}