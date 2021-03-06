<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package villagelanephotography
 */

get_header(); ?>

<?php if($post->post_parent !== 0) : ?>
	
<?php else : ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php endif; ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php if($post->post_parent !== 0){
						get_template_part( 'template-parts/content', 'page-child' );
					} else {
						get_template_part( 'template-parts/content', 'page' );
					}
				?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

<?php if($post->post_parent !== 0) : ?>
	
<?php else : ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php endif; ?>

<?php get_footer(); ?>
