<?php
/**
 * The template for displaying the Clients page.
 *
 * Template Name: Clients
 *
 * @package villagelanephotography
 */

get_header(); ?>

<?php if($post->post_parent !== 0) : ?>
	
<?php else : ?>
	<div id="primary" class="content-area client-access">
		<main id="main" class="site-main" role="main">
<?php endif; ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				
					<footer class="entry-footer">
						<?php edit_post_link( esc_html__( 'Edit', 'villagelanephotography' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->

			<?php endwhile; // End of the loop. ?>

<?php if($post->post_parent !== 0) : ?>
	
<?php else : ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php endif; ?>

<?php get_footer(); ?>
