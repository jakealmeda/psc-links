<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
'{@wp_title}'				=> get_the_title( get_the_ID() ),
'{@link_title}'				=> $link_title,
'{@link_url}'				=> $link_url,
'{@link_target}'			=> $link_target,
'{@pic_src}'				=> $link_pic,
'{@pic_width}'				=> $link_pic_w,
'{@pic_height}'				=> $link_pic_h,
 */
?>


<div class="item-wp-title"><h2>{@wp_title}</h2></div>

<div class="item-link"><a href="{@link_url}"{@link_target}>{@link_title}</a></div>

<div class="item-pic">
	<img src="{@pic_src}" width="{@pic_width}" height="{@pic_height}" border="0" />
</div>



<?php
// EOF