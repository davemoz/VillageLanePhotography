<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package villagelanephotography
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function villagelanephotography_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'villagelanephotography_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function villagelanephotography_jetpack_setup
add_action( 'after_setup_theme', 'villagelanephotography_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function villagelanephotography_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function villagelanephotography_infinite_scroll_render
