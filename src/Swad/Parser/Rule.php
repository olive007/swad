<?php

namespace Swad\Parser;

use Swad\Exception\ParserException;

class Rule {


	// Attribute
	private $name;
	private $components;
	private $actions;


	// Constructor
	function __construct(string $name, array $components, array $actions) {
		if (count($components) != count($actions)) {
			throw new ParserException("Error Processing Request", 1);
			
		}

		// Initialize attribute
		$this->name = $name;
		$this->components = [];
		foreach ($components as $component) {
			array_push($this->components, preg_split("/\s+/", $component));
		}
		$this->actions = $actions;
	}


	// Getter
	public function getName() : string {
		return $this->name;
	}

	public function getComponent(int $index) : array {
		return $this->components[$index];
	}

	public function getNbComponent() : int {
		return count($this->components);
	}

	public function getAction(int $index) : callable {
		return $this->actions[$index];
	}


}