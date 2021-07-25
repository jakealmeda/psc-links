<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Add a block category for "Setup" if it doesn't exist already.
 *
 * @ param array $categories Array of block categories.
 *
 * @ return array
 */
add_filter( 'block_categories', 'psc_block_link_cats' );
function psc_block_link_cats( $categories ) {

    $category_slugs = wp_list_pluck( $categories, 'slug' );

    return in_array( 'setup', $category_slugs, TRUE ) ? $categories : array_merge(
        array(
            array(
                'slug'  => 'setup',
                'title' => __( 'Setup', 'mydomain' ),
                'icon'  => null,
            ),
        ),
        $categories
    );

}


/**
 * LOG (Custom Blocks)
 * Register Custom Blocks
 * 
 */
add_action( 'acf/init', 'psc_block_link_init' );
function psc_block_link_init() {

    $blocks = array(

        'links' => array(
            'name'                  => 'links',
            'title'                 => __('Links'),
            'render_template'       => psc_plugin_dir_path_links().'partials/blocks/block-links.php',
            'category'              => 'setup',
            'icon'                  => 'admin-links',
            'mode'                  => 'edit',
            'keywords'              => array( 'links', 'anchors' ),
            'supports'              => [
                'align'             => false,
                'anchor'            => true,
                'customClassName'   => true,
                'jsx'               => true,
            ],
        ),

    );

    // Bail out if function doesn’t exist or no blocks available to register.
    if ( !function_exists( 'acf_register_block_type' ) && !$blocks ) {
        return;
    }

    foreach( $blocks as $block ) {
        acf_register_block_type( $block );
    }

}