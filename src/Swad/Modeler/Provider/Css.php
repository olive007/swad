<?php

namespace Modeler\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Modeler\Color;
use Modeler\Font;

class Css implements ServiceProviderInterface {


	// Attribute
	private $app;
	private $scssc;
	private $htmlClass;


	/**
	 * @param Container $container
	 */
	public function register(Container $container) {

		// Link the app and the provider
		$container['modeler.css'] = $this;
		$this->app = $container;

		// Initialize the scss compiler
		$this->scssc = new \scssc();
		// Add lib folder to allow compiler to include file from this folder
		$this->scssc->addImportPath($this->app["modeler.website.css.directory"]."/lib");
		$this->scssc->registerFunction("ucfirst", function($a) { return ucfirst($a[0][1]); } );

		// Add class variable
		$this->scssc->setVariables($container['modeler.website.html.class']);
		$tmp = [];
		foreach ($container['modeler.screen.prefix'] as $key => $value) {
			$tmp["screen$key"] = $value;
		}
		$this->scssc->setVariables($tmp);

		if ($this->app['debug'] == true) {
			$this->scssc->setFormatter("scss_formatter");
		}
		else {
			$this->scssc->setFormatter("scss_formatter_compressed");
		}

		$this->htmlClass = $container["modeler.website.html.class"];
		Color::$directory = $container["modeler.color.directory"];
		Font::$directory = $container["modeler.font.directory"];

	}

	public function generateFile($fileName) {

		// Initialize the resultat
		$res = "";

		// Get the extension of the file
		$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

		if ($fileExtension === "scss") {

			// Load the content of the file
			$fileContents = file_get_contents($this->app["modeler.website.css.directory"]."/$fileName");

			// Add the file contents compiled to the resultat
			$res .= $this->scssc->compile($fileContents);
		}
		else if ($fileExtension === "css") {

			// Load the content of the file
			$fileContents = file_get_contents($this->app["modeler.website.css.directory"]."/$fileName");

			// Add the file contents to the resultat
			$res .= $fileContents;

		}

		return $res;
	}

	private function generateColor($function) {

		// Initialize the resultat
		$res = "";

		// Open the directory
		if ($handle = opendir(Color::$directory)) {

			// Load the content of the file
			$fileContents = file_get_contents($this->app["modeler.website.css.directory"]."/color.scss");


			// List the file
			while (false !== ($file = readdir($handle))) {
			
				// Check if that's a real file
				if ($file == '.' || $file == '..' || is_dir($file)) {
					continue;
				}

				// Get the name of the file
				$fileName = pathinfo($file, PATHINFO_FILENAME);

				// Get the color
				$color = Color::get($fileName);

				// Get the color Value
				$colorValue = call_user_func($function, $color);

				// Add the file contents compiled to the resultat

				$variables = [];

				$variables["colorName"] = ucfirst($fileName);
				$variables["colorValue"] = call_user_func($function, $color);
				$variables["reverseColorValue"] = call_user_func($function, $color->getReverse());

				$this->scssc->setVariables($variables);
				$res .= $this->scssc->compile($fileContents);

					
				// $res .= ".".$this->htmlClass["backgroundColorPrefix"].ucfirst($fileName)."{background-color:".$colorValue."}";

				// // Add the color for the font to the resultat
				// $res .= ".".$this->htmlClass["fontColorPrefix"].ucfirst($fileName)."{color:".$colorValue."}";
				// $res .= ".".$this->htmlClass["inputColorPrefix"].ucfirst($fileName)." button {background-color:".$colorValue."}";

				// $res .= "p{color:black}";
				// $res .= "a:visited p {color:#222}";

			}

			// Close the dorectory
			closedir($handle);
		}

		// Return the resultat
		return $res;
	}


	private static function getLC($color) {

		return $color->getLight();

	}


	public function generateLightColor() {

		$rc = new \ReflectionClass($this);

		return $this->generateColor(['self', 'getLC']);

	}


	private static function getDC($color) {

		return $color->getDark();

	}

	public function generateDarkColor() {

		return $this->generateColor(['self', 'getDC']);

	}

	public function generateFont() {

		// Initialize the resultat
		$res = "";

		// Open the directory
		if ($handle = opendir(Font::$directory)) {

			// Load the content of the file
			$fileContents = file_get_contents($this->app["modeler.website.css.directory"]."/font.scss");


			// List the file
			while (false !== ($file = readdir($handle))) {
			
				// Check if that's a real file
				if ($file == '.' || $file == '..' || is_dir($file)) {
					continue;
				}

				// Get the name of the file
				$fileName = pathinfo($file, PATHINFO_FILENAME);

				// Get the font
				$font = Font::get($fileName);

				foreach ($font->getStyles() as $style) {
					
					$variables = [];

					$variables["fontName"]		= $font->getId($style);
					$variables["fontFileName"]	= $font->getFileName($style);
					$variables["fontWeight"]	= $font->getWeight($style);
					$variables["fontStyle"]		= $style;

					$this->scssc->setVariables($variables);

					// Add the file contents compiled to the resultat
					$res .= $this->scssc->compile($fileContents);
				}

			}

			// Close the dorectory
			closedir($handle);
		}

		// Return the resultat
		return $res;
	}

	public function generateLink() {

		// Initialize the resultat
		$res = "";

		$res .= "<link rel='stylesheet' type='text/css' href='".$this->app["website.path.root"]."/css/common' />";
		$res .= "<link rel='stylesheet' type='text/css' href='".$this->app["website.path.root"]."/css/lightColor' />";
		$res .= "<link rel='stylesheet' type='text/css' href='".$this->app["website.path.root"]."/css/font' />";

		return $res;
	}

}
