<?php
/**
 * The template for displaying the homepage.
 *
 * Template Name: Homepage
 *
 * @package villagelanephotography
 */

get_header(); ?>

<?php
	global $post;
	$featured_img_url = get_the_post_thumbnail_url($post->ID, 'large');
?>

<?php the_content(); ?>

<?php get_footer(); ?>
