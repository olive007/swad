<?php

namespace Modeler\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use MatthiasMullie\Minify;

use Modeler\Locale;

class Js implements ServiceProviderInterface {


	// Attribute
	private $app;
	private $twigOptions;
	private $mimifier;


	/**
	 * @param Container $container
	 */
	public function register(Container $container) {

		// Link the app and the Provider
		$container['modeler.js'] = $this;
		$this->app = $container;

		$colors	= [];

		foreach (glob($this->app["modeler.color.directory"]."/*.json", GLOB_NOCHECK) as $file) {
			$colors[] = basename($file, ".json");
		}

		$fonts = [];

		foreach (glob($this->app["modeler.font.directory"]."/*.json", GLOB_NOCHECK) as $file) {
			$fonts[] = basename($file, ".json");
		}

		$this->twigOptions = array_merge(
			$this->app["modeler.website.js.attribute"],
			$this->app["modeler.attribute.value"],
			["screen" => $this->app["modeler.screen.prefix"]],
			["html" => $this->app["modeler.website.html.class"]],
			["color" => $colors],
			["font" => $fonts]
		);

		if (!$this->app["debug"]) {
			$this->twigOptions['debug'] = true;
		}

		$this->minifier = new Minify\JS();

	}


	public function generateCommon() {

		// Initialize variable
		$res = '"use strict";';
		$files = [];

		// Open the directory
		if ($handle = opendir($this->app["modeler.website.js.directory"])) {

			// List the file
			while (false !== ($file = readdir($handle))) {

				// Create the relative file path to identify corectly the file
				$fileName = $this->app["modeler.website.js.directory"]."/$file";

				// Check if that's a real file
				if ($file != '.' && $file != '..' && !is_dir($fileName)) {
					$files[] = $file;
				}

			}

			// Close the dorectory
			closedir($handle);
		}


		// Sort the file by alphabetical order
		natsort($files);


		// List all files sorted by name
		foreach ($files as $file) {
			
			// Get the extension of the file
			$fileExtend = pathinfo($file, PATHINFO_EXTENSION);

			// File need to be generated
			if ($fileExtend == "twig") {

				// translate the template to js script and add it into result
				$res .= $this->app['twig']->render("js/$file", $this->twigOptions)."\n";

			}
			else {
				// Create the relative file path to identify corectly the file
				$fileName = $this->app["modeler.website.js.directory"]."/$file";

				// Load the content of the file add add it directly into result
				$res .= file_get_contents($fileName)."\n";
			}

		}


		if (!$this->app["debug"]) {

			// Compress js code
			$this->minifier->add($res);

			return $this->minifier->minify();
		}

		return $res;
	}


	public function generateLink() {

		$res = "";

		$res .= "<script src='".$this->app["website.path.root"]."/js/common' type='text/javascript'></script>";

		return $res;
	}

	public function generateMessage(Locale $locale) {

		$res = "<script type='text/javascript'>var messageGeneric={";

		foreach ($this->app['translator']->trans($locale, "messageGeneric")["translation"] as $key => $value) {
			$res .= "'$key': '".addslashes($value)."',";
		}

		$res = substr($res, 0, -1);

		$res .= "};</script>";

		return $res;

	}




}
