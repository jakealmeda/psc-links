<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class PSCShortCode {


	public function psc_pull_link_entries() {

		echo get_the_ID();

	}


	/**
	 * Handle the display
	 */
	public function __construct() {

		// Enqueue scripts
		if ( !is_admin() ) {

			//add_action( 'wp_enqueue_scripts', array( $this, 'setup_sfmenux_enqueue_scripts' ), 20 );

			add_shortcode( 'pull_links', array( $this, 'psc_pull_link_entries' ) );

		}

	}

}