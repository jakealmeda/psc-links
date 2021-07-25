<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$not_in = array();

$r = 'link_entries_repeater';

if( have_rows( $r ) ):

    while ( have_rows( $r ) ) : the_row();

		// ----------------------------------
		// VARIABLES
		// ----------------------------------    	
    	$out = ''; // declare empty

		// ----------------------------------
		// TEMPLATE
		// ----------------------------------
        $lay_group = get_sub_field( 'link-layout' );

        // ----------------------------------
        // STYLE | CLASS
        // ----------------------------------
        $class = ' class="'.$lay_group[ 'link-container-class' ].'"';

        // ----------------------------------
		// STYLE | INLINE
		// ----------------------------------
		$css_inline = $lay_group[ 'link-container-style' ];
		if( empty( $css_inline ) ) :
			$inline = '';
		else :
			$inline = ' style="'.$css_inline.'"';
		endif;

		// ----------------------------------
		// VALUE GROUP
		// ----------------------------------
		$val_group = get_sub_field( 'link-entries' );

		// ----------------------------------
		// VALUE | INDIVIDUAL
		// ----------------------------------
		if( array_key_exists( 'link-entry', $val_group ) && !empty( $val_group[ 'link-entry' ] ) ) {

			foreach( $val_group[ 'link-entry' ] as $pid ) {
				
				// collate post IDs for exclusion
				$not_in[] = $pid;

				// set output
				$out .= psc_link_processor( $pid, $lay_group[ 'link-template' ] );

			}

		}
		
		// ----------------------------------
        // VALUE | TAXONOMY
        // ----------------------------------
		if( array_key_exists( 'link_tag', $val_group ) && !empty( $val_group[ 'link_tag' ] ) ) {

			// post_per_page (max entries to show)
			if( array_key_exists( 'max_links_to_display', $val_group ) && !empty( $val_group[ 'max_links_to_display' ] ) ) {
				$ppp = $val_group[ 'max_links_to_display' ];
			} else {
				$ppp = 10;
			}

			$tagged = $val_group[ 'link_tag' ];
			for( $t = 0; $t <= ( count( $tagged ) - 1 ); $t++ ) {
				
				$args = array(
					'post_type' 				=> 'link',
					'post_status' 				=> 'publish',
					//'posts_per_page' 			=> $ppp,
					'post__not_in' 				=> $not_in,
					'orderby' 					=> $val_group[ 'order_by' ],
		    		'order'   					=> $val_group[ 'order' ],
					'tax_query' 				=> array(
						array( 'taxonomy' => 'link_tag', 'field' => 'term_id', 'terms' => $tagged[ $t ] )
					),
				);
				/*echo '<h1>Count should be: '.$ppp.'</h1>';
				$loop = query_posts(
					array(
						'posts_per_page' 		=> 2,
						//'showposts'			=> $ppp,
						'post_type' 			=> 'link',
						'tax_query' 			=> array(
							array(
								'taxonomy' 	=> 'link_tag',
								'field' 	=> 'term_id',
								'terms' 	=> $tagged[ $t ],
							)
						),
						'exclude'				=> $not_in,
						'orderby' 				=> $val_group[ 'order_by' ],
		    			'order'   				=> $val_group[ 'order' ],
		    			'post_status' 			=> 'publish',
					)
				);
				echo '<h1>Actual count is: '.count( $loop ).'</h1><hr />';
				*/

				/*
				// THIS DOESN'T SEEM TO WORK. WP STALLS
				global $wp_query;
				$args = array_merge( $wp_query->query_vars, ['posts_per_page' => $ppp ] );
				query_posts( $args );

				if( have_posts() ){
					while( have_posts() ) { the_post();
						var_dump( get_the_ID() );
						echo '<br />';
					}
				}*/

				// query
				$loop = new WP_Query( $args );
				
				// loop
				if( $loop->have_posts() ):

					$c=1; // loop counter | post_per_page is not working

					// get all post IDs
					while( $loop->have_posts() ): $loop->the_post();

						// collate post IDs for exclusion
						$not_in[] = get_the_ID();
						
						// set output
						$out .= psc_link_processor( get_the_ID(), $lay_group[ 'link-template' ] );

						// exit loop if counter is satisfied
						if( $c == $ppp ) {
							break;
						}

						$c++; // increment

					endwhile;

					// reset WP Query
					psc_link_reset_query();

				endif;
				


				/*for( $b=0; $b<=( count( $loop ) - 1 ); $b++ ) {
					echo '<h2>JAKE: '.$loop[ $b ]->ID.'</h2>';
					var_dump( $loop[ $b ] );
					echo '<hr />';
				}*/

			}

        }

        // ----------------------------------
        // SET CONTAINER AND STYLES
        // ----------------------------------
		$outs .= '<div'.$class.$inline.'>'.$out.'</div>';
        
    endwhile;

    echo $outs;

endif;

