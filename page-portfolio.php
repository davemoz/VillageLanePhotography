<?php
/**
 * The template for displaying the portfolio page.
 *
 * Template Name: Portfolio
 *
 * @package villagelanephotography
 */

get_header(); ?>

	<div id="primary" class="content-area portfolio">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<!--
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->
					
					<div class="entry-content full-width-grid">
						<?php
							// only start if we are on a single page
						    if ( is_page() ) {
						
						        // get the ID of the current (parent) page
						        $current_page_id = get_the_ID();
						
						        // get all the children of the current page
						        $child_pages = get_pages( array( 
						            'child_of' => $current_page_id,  
						        ) );
						
						        // start only if we have some childpages
						        if ($child_pages) {
						
						            // loop trough each portfolio page 
						            foreach ($child_pages as $child_page) {
						
						                $page_id    = $child_page->ID; // get the ID of the childpage
						                $page_link  = get_permalink( $page_id ); // returns the link to childpage
						                $page_img   = get_the_post_thumbnail( $page_id, 'medium' ); // returns the featured image <img> element
						                $page_title = $child_page->post_title; // returns the title of the child page
						
						                ?>
						                
						                    <a class="portfolio-link" href="<?php echo $page_link; ?>">
						
						                        <h4><?php echo $page_title; ?></h4>
												<?php echo $page_img; ?>
												
						                    </a>
						
						                <?php
						
						            }//END foreach ($child_pages as $child_page)
						
						        }//END if ($child_pages)    
						
						    }//END if (is_page())
						?>
						<!--
						<a class="portfolio-link newborn" href="/portfolio/newborn" style="background-image: url(<?php ?>)"><span>Newborn</span></a>
						<a class="portfolio-link little-ones" href="/portfolio/little-ones"><span>Little Ones</span></a>
						<a class="portfolio-link family" href="/portfolio/family"><span>Family</span></a>
						<a class="portfolio-link engagement" href="/portfolio/engagement"><span>Engagement</span></a>
						<a class="portfolio-link portraits" href="/portfolio/portraits"><span>Portraits</span></a>
						-->
					</div><!-- .entry-content -->
				
					<footer class="entry-footer">
						<?php edit_post_link( esc_html__( 'Edit', 'villagelanephotography' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
