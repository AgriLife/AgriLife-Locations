<?php

namespace AgLocations;


class Assets {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_javascript' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_css' ) );
	}

	public function load_javascript() {
		wp_enqueue_script(
			'google-maps',
			'https://maps.googleapis.com/maps/api/js?key=AIzaSyAwvTAlWZ9tj8b4-1QWHwFl3ILodM7u0jA&sensor=false',
			false,
			false,
			false
		);

		wp_enqueue_script('underscore');
		wp_enqueue_script('backbone');

		wp_enqueue_script(
			'location-map',
			get_stylesheet_directory_uri() . '/js/location-map.js',
			array( 'backbone', 'jquery' ),
			false,
			true
		);

	}

	public function load_css() {
		wp_enqueue_style(
			'location-map-style',
			get_stylesheet_directory_uri() . '/css/location-map.css',
			false,
			false,
			'all'
		);
	}
}