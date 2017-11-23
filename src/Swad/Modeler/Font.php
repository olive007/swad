<?php

namespace Modeler;

class Font {

	// Class Attribute
	public static $directory;
	private static $fonts;


	// Attribute
	private $id;
	private $fileNames;
	private $weights;
	private $styles;


	// Constructor
	private function __construct($id) {

		$this->id			= $id;
		$this->fileNames	= [];
		$this->weights		= [];
		$this->styles		= [];


		$json = json_decode(file_get_contents(self::$directory."/$id.json"), TRUE);

		foreach ($json as $style => $values) {
			$this->fileNames[$style]	= $values["fileName"];
			$this->weights[$style]		= $values["weight"];
			array_push($this->styles, $style);
		}

	}


	// Class Getter
	public static function get(string $id) {

		if (isset(self::$fonts[$id])) {
			return self::$fonts[$id];
		}

		$font = new font($id);

		self::$fonts[$id] = $font;

		return $font;
	}


	// Getter
	public function getId() : string {
		return $this->id;
	}

	public function getFileName(string $style) : string {
		return $this->fileNames[$style];
	}

	public function getWeight(string $style) : string {
		return $this->weights[$style];
	}

	public function getStyles() : array {
		return $this->styles;
	}

}
