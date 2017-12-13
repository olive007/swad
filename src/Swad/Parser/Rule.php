<?php

namespace Swad\Parser;

use Swad\Exception\ParserException;

class Rule {


	// Attribute
	private $name;
	private $components;
	private $action;


	// Constructor
	function __construct(string $name, string $components, callable $action) {

		// Initialize attribute
		$this->name = $name;
		$this->components = preg_split("/\s+/", $components);
		$this->action = $action;
	}


	// Getter
	public function getName() : string {
		return $this->name;
	}

	public function getComponent(int $index) : string {
		return $this->components[$index];
	}

	public function getNbComponent() : int {
		return count($this->components);
	}

	public function getAction() : callable {
		return $this->action;
	}


	// Method
	public function execute(array &$tokens, $config, int $offset) {

		$action = $this->action;

		$tmp = $action(array_slice($tokens, $offset, $this->getNbComponent()), $config);

		$tokens = array_merge(
			array_slice($tokens, 0, $offset + 1),
			array_slice($tokens, $offset + $this->getNbComponent())
		);
		$tokens[$offset] = new TokenParsed($this, $tmp);

	}

}