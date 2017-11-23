<?php

namespace Modeler;

class Color {


	// Class Attribute
	public static $default;
	public static $directory;
	private static $colors;



	// Attribute
	private $id;
	private $light;
	private $dark;
	private $reverse;



	// Constructor
	private function __construct($id) {

		$this->id = $id;

		$json = json_decode(file_get_contents(self::$directory."/$id.json"), TRUE);

		$this->light = $json["light"];
		$this->dark = $json["dark"];
		$this->reverse = $json["reverse"];

	}


	// Class Getter
	public static function get(string $id) {

		if (isset(self::$colors[$id])) {
			return self::$colors[$id];
		}

		$color = new Color($id);

		self::$colors[$id] = $color;

		return $color;
	}


	// Getter
	public function getId() : string {
		return $this->id;
	}

	public function getLight() : string {
		return $this->light;
	}

	public function getDark() : string {
		return $this->dark;
	}

	public function getReverse() : Color {
		if ($this->reverse[0] == '@') {
			return self::get(substr($this->reverse, 1));
		}
		return $this;
	}


}
