<?php

namespace Devolive;

use Devolive\Routing\Router;
use Devolive\Routing\Request;
use Devolive\Routing\Response;

class Application {

	use Router;

	// Constructor
	public function __construct($config) {

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
			
				// Check if that's a real file
				if ($file === '.' || $file === '..' || $file === 'AbstractBase.php') {
					continue;
				}

				// Get the name of the file
				$fileName = pathinfo($file, PATHINFO_FILENAME);
				
				// Get the name of the class
				$className = "Api\\Controller\\".$fileName;

				// Construct the class controller
				$ctrl = new $className;

				// Get the reflection
				$r = new \ReflectionClass($ctrl);

				// Get the annotations class
				$annotations = $annotationReader->getClassAnnotations($r);

				foreach ($annotations as $annotation) {
					$annotation->action($app, $ctrl);
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
