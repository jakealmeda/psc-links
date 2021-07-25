<?php
/**
 * Plugin Name: PSC Links
 * Description: Handles the data collection and display of Links.
 * Version: 1.0
 * Author: Jake Almeda
 * Author URI: http://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


// simply return this plugin's main directory
function psc_plugin_dir_path_links() {

    return plugin_dir_path( __FILE__ );

}


include_once( 'lib/acf-psc-autofill.php' );
//include_once( 'lib/acf-psc-shortcode.php' );
//include_once( 'lib/acf-psc-hook.php' );
include_once( 'lib/acf-psc-processor.php' );
include_once( 'lib/acf-psc-func.php' );
include_once( 'lib/acf-psc-block.php' );


//$a = new PSCLinks();
//$z = new PSCShortCode();