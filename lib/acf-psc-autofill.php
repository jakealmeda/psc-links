<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'acf/load_field/name=pic_size', 'psc_image_sizes_links' );
function psc_image_sizes_links( $field ) {

	$field['choices'] = array();

	foreach( get_intermediate_image_sizes() as $value ) {
		$field['choices'][$value] = $value;
	}

	return $field;

}


add_filter( 'acf/load_field/name=link-template', 'psc_layout_link_select' );
function psc_layout_link_select( $field ) {
    
    $file_extn = 'php';
    $file_folder = 'links';

    // get all files found in VIEWS folder
    //$view_dir = get_stylesheet_directory().'/partials/views/';
    $view_dir = psc_plugin_dir_path_links().'partials/'.$file_folder.'/';

    $data_from_dir = setup_get_block_views( $view_dir, $file_extn );

    $field['choices'] = array();

    //Loop through whatever data you are using, and assign a key/value
    if( is_array( $data_from_dir ) ) {

        foreach( $data_from_dir as $field_key => $field_value ) {
            
            $field['choices'][$field_key] = $field_value;
        }

        return $field;

    }
    
}


/**
 * BLOCK | LINKS VIEW TEMPLATES
 * Pull all files found in $directory but get rid of the dots that scandir() picks up in Linux environments
 *
 */
if( !function_exists( 'setup_get_block_views' ) ) {

	function setup_get_block_views( $directory, $file_extn ) {

		$out = array();

		// get all files inside the directory but remove unnecessary directories
		$ss_plug_dir = array_diff( scandir( $directory ), array( '..', '.' ) );

		foreach( $ss_plug_dir as $filename ) {

			if( pathinfo( $filename, PATHINFO_EXTENSION ) == $file_extn ) {
				$out[ $filename ] = pathinfo( $filename, PATHINFO_FILENAME );
			}

		}

		// Return an array of files (without the directory)
		return $out;

	}

}