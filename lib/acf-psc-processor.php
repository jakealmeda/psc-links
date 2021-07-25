<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class PSCLinks {

	/**
	 * Get Template
	 */
	public function psc_get_link_view( $layout, $folder ) {

	    $layout_file = psc_plugin_dir_path_links().'partials/'.$folder.'/'.$layout;
	    
	    if( is_file( $layout_file ) ) {

	        ob_start();

	        include $layout_file;

	        return ob_get_clean();

	    } else {

	        //$output = FALSE;
	        return FALSE;

	    }

	}


	/**
	 * Reset Query
	 */
	public function psc_link_reset_query() {
		wp_reset_postdata();
		wp_reset_query();
	}


	/**
	 * Simple array & key validation
	 *
	 */
	public function psc_link_val_arr_key( $key, $array ) {

		if( array_key_exists( $key, $array ) && !empty( $array[ $key ] ) ) {
			return $array[ $key ];
		} else {
			return FALSE; // return nothing
		}

	}


	/**
	 * Process Link Entries
	 *
	 */
	public function psc_link_processor( $pid, $template ) {

		// get link
		$link_info = get_field( 'link', $pid );

		// validate URL
		if( is_array( $link_info ) && $this->psc_link_val_arr_key( 'url', $link_info ) ) {

			$link_title = $link_info[ 'title' ];
			$link_url = $link_info[ 'url' ];

			if( $this->psc_link_val_arr_key( 'target', $link_info ) ) {
				$link_target = ' target="'.$link_info[ 'target' ].'"';
			} else {
				$link_target = '';
			}

		} else {

			$link_title = '';
			$link_url = '';
			$link_target = '';

		}

		// get image size
		$pic_size = get_field( 'pic_size', $pid );

		// get image
		$link_pic = get_field( 'pic', $pid );
		if( empty( $link_pic ) ) {
			$img = '';
			$img_w = '';
			$img_h = '';
		} else {
			$img = $link_pic[ 'sizes' ][ $pic_size ];
			$img_w = $link_pic[ 'sizes' ][ $pic_size.'-width' ];
			$img_h = $link_pic[ 'sizes' ][ $pic_size.'-height' ];
		}

		// set variables
		$replace_array = array(
				'{@wp_title}'				=> get_the_title( $pid ),
				'{@link_title}'				=> $link_title,
				'{@link_url}'				=> $link_url,
				'{@link_target}'			=> $link_target,
				'{@pic_src}'				=> $img,
				'{@pic_width}'				=> $img_w,
				'{@pic_height}'				=> $img_h,
			);

		// OUTPUT | format/template | links (folder)
		return strtr( $this->psc_get_link_view( $template, 'links' ), $replace_array );

	}

}