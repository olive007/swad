<?php

namespace Modeler\Generator\Html\Node;

use Modeler\Parser\Ui\Node as Parser;

use Modeler\Generator\Html;

trait HtmlCommon {

	// Method
	public function initHtmlCommon() {
		$this->htmlClass = [];
		$this->htmlAttribute = [];
	}


	public function addHtmlClass(string $newClass) {
		array_push($this->htmlClass, $newClass);
	}

	public function addHtmlAttribute(string $newAttr, string $value) {
		$this->htmlAttribute[$newAttr] = $value;
	}

	public function htmlAttributeAsString() : string {
		$res = "";

		foreach ($this->htmlAttribute as $key => $value) {
			$res .= $key.'="'.$value.'" ';
		}

		if (count($this->htmlClass) > 0) {
			$res .= 'class="';

			for ($i = 0; $i < count($this->htmlClass); $i++) { 
				$res .= $this->htmlClass[$i]." ";
			}
		
			$res = substr($res, 0, -1);

			$res .= '"';
		}

		return $res;
	}

}