<?php

namespace Api\Annotation;

use Silex\ControllerCollection;

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;


abstract class HttpMethod {

	// Attribute
	private $path;
	private $parameters;
	protected $methodType;

	public function __construct(array $values) {
		$this->path = isset($values['value']) ? $values['value'] : "";
		$this->parameters = isset($values['parameters']) ? $values['parameters'] : array();
	}

	public function action(ControllerCollection $factory, \ReflectionMethod $method, $ctrl) {

		$parameters = $this->parameters;

		$tmp = $this->methodType;

		$factory->$tmp($this->path, function(Application $app, Request $request) use ($method, $ctrl, $parameters) {

			$arg = [];

			foreach ($method->getParameters() as $parameter) {
				if ($parameter->getType()->getName() == "Symfony\Component\HttpFoundation\Request") {
					$arg[$parameter->getName()] = $request;
				}
			}

			foreach ($parameters as $parameter) {
				$arg[$parameter->getName()] = $request->get($parameter->getName());
			}

			return $method->invokeArgs($ctrl, $arg);
		});

		foreach ($parameters as $parameter) {

			$factory->assert($parameter->getName(), $parameter->getRegex());

			if (! $parameter->isRequired()) {
				$factory->value($parameter->getName(), $parameter->getDefault());
			}
		}

	}

}
