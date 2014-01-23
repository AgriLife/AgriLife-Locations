<?php

namespace AgLocations;


class Init {

	public function __construct() {
		$this->load_assets();
	}

	private function load_assets() {
		new Assets;
	}
}