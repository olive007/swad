<?php 

namespace Swad\Parser;

use Swad\Exception\ParserException;

abstract class AbstractParser {

	// Class variable
	static private $rules;
	static private $components;


	// Initialization
	static public function init() {


		// Initialize class attributes
		self::$rules		= [];
		self::$components	= [];

		// Access to reflection with child class. Thank to function: "get_called_class" ;)
		$itself = new \ReflectionClass(get_called_class());

		foreach ($itself->getMethods() as $method) {

			// Use only the function which its name finish by Rule. !!! Case sensitive !!!
			if (preg_match("/Rule$/", $method->getName())) {

				// Get the grammar form the document string.
				$grammar = preg_replace('/^[\/\* \t]+/m', '', $method->getDocComment());

				if (!preg_match("/^\s*([a-z]+[a-z_0-9]*)\s*:\s*(.+)\s*$/m", $grammar, $matches)) {
					throw new ParserException("Error in grammar");
				}
					
				// Save the name of the rule into tmp variable
				$name = $matches[1];

				// Check if rule is already defined.
				if (array_key_exists($name, self::$rules)) {
					throw new ParserException("Duplicate rule: $name", 1);					
				}

				// Initialize the array
				self::$rules[$name] = [];

				// Set method accessible in case of the developer set function in protected.
				$method->setAccessible(True);
				$actions = $method->invoke(NULL);
				$i = 0;

				// Add first components of the rules
				array_push(self::$rules[$name], new Rule($name, $matches[2], $actions[$i]));

				// Search for optional other components.
				if (preg_match_all("/^\|\s*(.*)\s*$/m", $grammar, $matches)) {
					foreach ($matches[1] as $match) {
						$i++;
						array_push(self::$rules[$name], new Rule($name, $match, $actions[$i]));
					}
				}
			}
		}

		foreach (self::$rules as $name => $rule) {

			usort(self::$rules[$name], function($a, $b) {
				return $a->getNbComponent() < $b->getNbComponent();
			});

			for ($i = count($rule); --$i >= 0;) {
				array_push(self::$components, $rule[$i]);
			}
		}

		// usort(self::$components, function($a, $b) {
		// 	return $a->getNbComponent() < $b->getNbComponent();
		// });
	}


	// Class function
	static protected function parse($tokens, $config) {

		foreach (self::$rules as $rule) {
			
			$rule = self::rulesMatch($rule, $tokens, $config, 0);
			if ($rule != NULL) {
				$action = $rule->getAction();
				print_r($tokens);
				return $action($tokens, $config);
			}
		}

		throw new ParserException("Error during parsing");
	}

	static private function rulesMatch(array $rules, &$tokens, $config, int $offset) {

		foreach ($rules as $rule) {

			if (self::ruleMatch($rule, $tokens, $config, $offset)) {
				
				return $rule;
			}

		}
		return NULL;
	}

	/*
	static private function ruleMatch(array $rule, &$tokens, $config) {

		for ($i = $rule->getNbComponent(); --$i >= 0;) {
			return self::grammarMatch($rule->getComponent($i), $rule->getAction($i), $tokens, $config);

			if ($action != NULL) {
				return $action;//(array_slice($tokens, $rules->getNbComponent()), $config);
			}
			else {
				return NULL;
			}
		}
		return NULL;
	}*/

	static private function ruleMatch(Rule $rule, &$tokens, $config, int $offset) {

		print_r($rule->getName().": ".$rule->getNbComponent(1)."\n");

		for ($i = 0; $i < $rule->getNbComponent() && $i + $offset < count($tokens); $i++) {

			if (!$tokens[$offset + $i]->matchComponent($rule->getComponent($i))) {

				if (preg_match("/^[a-z]/", $rule->getComponent($i))) {

					$secondRule = self::rulesMatch(self::$rules[$rule->getComponent($i)], $tokens, $config, $offset + $i);

					if ($secondRule != NULL) {
						print_r("offset: ".($offset + $i));
						$secondRule->execute($tokens, $config, $offset + $i);

						continue;
					}
				}
				//print("test1");
				return FALSE;
			}
		}
		return TRUE;
		if ($i = $rule->getNbComponent()) {
			//print("test2");
			return TRUE;
		}
		//print("test3");
		return FALSE;
	}

}