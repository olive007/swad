<?php

namespace Swad;

use Swad\Routing\Router;
use Swad\Routing\Request;
use Swad\Routing\Response;

abstract class AbstractApplication {

	use Router;

	// Constructor
	public function __construct($config) {

		AnnotationFactory::init();

		// Get the type of value of the controller configuration
		$valueType = gettype($config['controller.directory']);


		// Load controllers from one directory
		if ($valueType == 'string') {
			$this->loadControllerFromDirectory($config['controller.directory']);
		}
		// Load controllers from many directory
		else if ($valueType == 'array') {
			foreach ($config['controller.directory'] as $dir) {
				$this->loadControllerFromDirectory($dir);
			}
		}

	}

	private function loadControllerFromDirectory($directoryName) {

		// Open the directory
		if ($handle = opendir($directoryName)) {

			// List the file
			while (false !== ($file = readdir($handle))) {
			
				// Check if file is not a directory or that isn't a Abstract class
				if ($file === '.' || $file === '..' || preg_match('/Abstract\w*.php/', $file)) {
					continue;
				}

				// Get the name of the file
				$fileName = pathinfo($file, PATHINFO_FILENAME);
				
				// Get the name of the class
				$className = "Controller\\".$fileName;

				// Construct the class controller
				$ctrl = new $className;

				// Get the reflection
				$reflect = new \ReflectionClass($ctrl);

				// Get the annotations class
				$annotations = AnnotationFactory::getAnnotations($reflect);

				print_r($annotations);

				foreach ($annotations as $annotation) {
					$annotation->action($ctrl);
				}

			}
				// Close the dorectory
			closedir($handle);
		}

	}


	// Method
	public function run() {
		$request = Request::CreateFormGlobal();
		$GLOBALS = null;

		print($request->getUri());

	}

}
