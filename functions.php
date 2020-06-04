<?php
/**
 * Village Lane Photography functions and definitions
 *
 * @package vlp
 */

if ( ! function_exists( 'vlp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function vlp_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'vlp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'vlp' ),
		'social' => esc_html__( 'Social Menu', 'vlp' ),
	) );

	/**
	* Custom Nav Walker (with social media icons) by Aurooba Ahmed
	* This uses Font Awesome and adds in the correct icon by detecting the URL of the menu item.
	* You can use this by doing a custom wp_nav_menu query:
	* wp_nav_menu(array('items_wrap'=> '%3$s', 'walker' => new VL_Walker_Nav_Menu(), 'container'=>false, 'menu_class' => '', 'theme_location'=>'social', 'fallback_cb'=>false ));
	*/
	class VL_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent\n";
		}
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent\n";
		}
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$title = $item->title;
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			$item_output = $args->before;
	        if (strpos($item->url, 'facebook') !== false) {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-facebook-f"></i>';
	            $item_output .= '</a>';
	            $item_output .= $args->after;
	        } elseif (strpos($item->url, 'twitter') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-twitter">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;
	        } elseif (strpos($item->url, 'instagram') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-instagram">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;
	        } elseif (strpos($item->url, 'pinterest') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-pinterest-p">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;
			} elseif (strpos($item->url, 'linkedin') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-linkedin-in">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;
	        }  elseif (strpos($item->url, 'snapchat') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-snapchat-ghost">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;
	        }  elseif (strpos($item->url, 'plus.google') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-google-plus-g">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;	            
	        } elseif (strpos($item->url, 'youtube') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-youtube">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;
	        } elseif (strpos($item->url, 'vimeo') !== false)  {
	            $item_output .= '<a'. $attributes .'><i class="fab fa-vimeo-v">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;	
	        } elseif (stripos($item->title, 'cart') !== false)  {
	            $item_output .= '<a'. $attributes .' class="menu-item-cart"><i class="fas fa-shopping-cart">';
	            $item_output .= '</i></a>';
	            $item_output .= $args->after;
			} elseif (stripos($item->title, 'clients') !== false)  {
	            $item_output .= '<a'. $attributes .' class="menu-item-clients">'. $item->title .' <i class="fas fa-lock"></i>';
	            $item_output .= '</a>';
	            $item_output .= $args->after;
	        } else {
			
				$item_output .= '<a'. $attributes .'>'. $title;
	            $item_output .= '</a>';
	            $item_output .= $args->after;
			
			}
			
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
		function end_el( &$output, $item, $depth = 0, $args = array() ) {
			$output .= "\n";
		}
	}

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
      * Add Editor Style for adequate styling in text editor.
      *
      * @link http://codex.wordpress.org/Function_Reference/add_editor_style
      */
	add_editor_style( 'editor-style.css' );

}
endif; // vlp_setup
add_action( 'after_setup_theme', 'vlp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vlp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vlp_content_width', 640 );
}
add_action( 'after_setup_theme', 'vlp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function vlp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'vlp' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'vlp_widgets_init' );

/**
 * Add WooCommerce support to theme
 */
function vlp_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'vlp_add_woocommerce_support' );

/**
 * Enqueue scripts and styles.
 */
function vlp_scripts() {
	
	wp_enqueue_style( 'lity-style' , 'https://cdnjs.cloudflare.com/ajax/libs/lity/2.3.1/lity.min.css', array(), '2.3.1', 'all' );
	
	wp_enqueue_style( 'flickity-style', 'https://unpkg.com/flickity@2/dist/flickity.min.css', array(), null );
	
	wp_enqueue_script( 'font-awesome-font', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', array(), null );
	
	wp_enqueue_style( 'vlp-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
	
	wp_enqueue_script( 'font-awesome', 'https://use.fontawesome.com/releases/v5.2.0/js/all.js', array(), null );
	
	wp_enqueue_script( 'lity-script', 'https://cdnjs.cloudflare.com/ajax/libs/lity/2.3.1/lity.min.js', array('jquery'), '2.3.1', true );
	
	wp_enqueue_script( 'flickity-script', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array(), '2.1', true );
	
	wp_enqueue_script( 'masonry', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js', array(), '4.2.2', true );
	
	wp_enqueue_script( 'images-loaded', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', array('masonry'), '1.0.0', true );

	if( is_page() ){ //Check if we are viewing a page
		global $wp_query;

		//Check which template is assigned to current page we are looking at
		$template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
		if($template_name == 'page-home.php'){
			wp_enqueue_script( 'vlp-home-scripts', get_template_directory_uri() . '/js/scripts-home-min.js', array('jquery', 'flickity-script'), filemtime( get_template_directory() . '/js/scripts-home-min.js' ), true );
		}
	}

	wp_enqueue_script( 'vlp-scripts', get_template_directory_uri() . '/js/scripts-min.js', array( 'jquery', 'images-loaded' ), filemtime( get_template_directory() . '/js/scripts-min.js' ), true );

	wp_enqueue_script( 'vlp-navigation', get_template_directory_uri() . '/js/navigation-min.js', array(), filemtime( get_template_directory() . '/js/navigation-min.js' ), true );

	wp_enqueue_script( 'vlp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), filemtime( get_template_directory() . '/js/skip-link-focus-fix.js' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vlp_scripts' );


/**
 * Filter the HTML script tags to add attributes.
 *
 * @param string $tag    The <script> tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @param string $src    The script's uri source.
 *
 * @return   Filtered HTML script tag.
 */
add_filter( 'script_loader_tag', 'add_attribs_to_scripts', 10, 3 );

function add_attribs_to_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$async_scripts = array(
		'',
	);

	$defer_scripts = array( 
		'',
	);

	$fontawesome = array(
		'font-awesome',
	);
	
	$fontawesomefont = array(
		'font-awesome-font',
	);

	$jquery = array(
		'jquery'
	);

    if ( in_array( $handle, $defer_scripts ) ) {
		return '<script defer src="' . $src . '" type="text/javascript"></script>' . "\n";
	}
	if ( in_array( $handle, $async_scripts ) ) {
		return '<script async src="' . $src . '" async="async" type="text/javascript"></script>' . "\n";
	}
	if ( in_array( $handle, $fontawesome ) ) {
		return '<script defer src="' . $src . '" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>' . "\n";
	}
	if ( in_array( $handle, $fontawesomefont ) ) {
		return '<link rel="stylesheet" src="' . $src . '" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">' . "\n";
	}
	if ( in_array( $handle, $jquery ) ) {
		return '<script src="' . $src . '" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous" type="text/javascript"></script>' . "\n";
	}
	return $tag;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * HTML Replacement - Support for a custom class attribute in the native gallery shortcode
 */
add_filter( 'post_gallery', function( $html, $attr, $instance )
{
    add_filter( 'gallery_style', function( $html ) use ( $attr )
    {
        if( isset( $attr['class'] ) && $class = $attr['class'] )
        {
            unset( $attr['class'] );

            // Modify & replace the current class attribute
            $html = str_replace( 
                "class='gallery ",
                sprintf( 
                    "class='gallery %s ",
                    esc_attr( $class )
                ),
                $html
            );
        }
        return $html;
    } );

    return $html;
}, 10 ,3 );

/**
 * Remove wpautop
 */
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Place a Booking button after nav menu
 *
 * Source: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 */
 /*
add_filter('wp_nav_menu_items','vl_menucart', 10, 2);
function vl_menucart($menu, $args) {

	// Check if WooCommerce is active and add a new item to a menu assigned to the Shop Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'shop-menu' !== $args->theme_location )
		return $menu;

	ob_start();
		global $woocommerce;
		$viewing_cart = __('View your shopping cart', 'vlp');
		$start_shopping = __('Start shopping', 'vlp');
		$cart_url = $woocommerce->cart->get_cart_url();
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		//$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'vl'), $cart_contents_count);
		$cart_total = $woocommerce->cart->get_cart_total();
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// if ( $cart_contents_count > 0 ) {
			if ($cart_contents_count == 0) {
				$menu_item = '<li class="cart-menu-link"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
			} else {
				$menu_item = '<li class="cart-menu-link"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
			}

			$menu_item .= '<i class="fa fa-shopping-cart"></i> ';

			if ($cart_contents_count == 0) {
			} else {
				$menu_item .= '<div class="cart-count-total">'.$cart_contents_count.'</div>';
				//$menu_item .= $cart_contents.' - '. $cart_total;
			}
			$menu_item .= '</a></li>';
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// }
		echo $menu_item;
	$social = ob_get_clean();
	return $menu . $social;

}

/**
 * Filter image gallery links output
 */
add_filter( 'post_gallery', 'vl_gallery_output', 10, 3);
function vl_gallery_output($output, $attr, $instance ) {
global $post, $wp_locale;
$html5 = current_theme_supports( 'html5', 'gallery' );
$atts = shortcode_atts( array(
	'order'      => 'ASC',
	'orderby'    => 'menu_order ID',
	'id'         => $post ? $post->ID : 0,
	'itemtag'    => $html5 ? 'figure'     : 'dl',
	'icontag'    => $html5 ? 'div'        : 'dt',
	'captiontag' => $html5 ? 'figcaption' : 'dd',
	'columns'    => 3,
	'size'       => 'thumbnail',
	'include'    => '',
	'exclude'    => '',
	'link'       => ''
), $attr, 'gallery' );
$id = intval( $atts['id'] );
if ( ! empty( $atts['include'] ) ) {
	$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	$attachments = array();
	foreach ( $_attachments as $key => $val ) {
		$attachments[$val->ID] = $_attachments[$key];
	}
} elseif ( ! empty( $atts['exclude'] ) ) {
	$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
} else {
	$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
}
if ( empty( $attachments ) ) {
	return '';
}
if ( is_feed() ) {
	$output = "\n";
	foreach ( $attachments as $att_id => $attachment ) {
		$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
	}
	return $output;
}
$itemtag = tag_escape( $atts['itemtag'] );
$captiontag = tag_escape( $atts['captiontag'] );
$icontag = tag_escape( $atts['icontag'] );
$valid_tags = wp_kses_allowed_html( 'post' );
if ( ! isset( $valid_tags[ $itemtag ] ) ) {
	$itemtag = 'dl';
}
if ( ! isset( $valid_tags[ $captiontag ] ) ) {
	$captiontag = 'dd';
}
if ( ! isset( $valid_tags[ $icontag ] ) ) {
	$icontag = 'dt';
}
$columns = intval( $atts['columns'] );
$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
$float = is_rtl() ? 'right' : 'left';
$selector = "gallery-{$instance}";
$gallery_style = '';

/**
 * Filter whether to print default gallery styles.
 *
 * @since 3.1.0
 *
 * @param bool $print Whether to print default gallery styles.
 *                    Defaults to false if the theme supports HTML5 galleries.
 *                    Otherwise, defaults to true.
 */
if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
	$gallery_style = "
	<style type='text/css'>
		#{$selector} {
			margin: auto;
		}
		#{$selector} .gallery-item {
			float: {$float};
			margin-top: 10px;
			text-align: center;
			width: {$itemwidth}%;
		}
		#{$selector} img {
			border: 2px solid #cfcfcf;
		}
		#{$selector} .gallery-caption {
			margin-left: 0;
		}
		/* see gallery_shortcode() in wp-includes/media.php */
	</style>\n\t\t";
}
$size_class = sanitize_html_class( $atts['size'] );
$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

/**
 * Filter the default gallery shortcode CSS styles.
 *
 * @since 2.5.0
 *
 * @param string $gallery_style Default CSS styles and opening HTML div container
 *                              for the gallery shortcode output.
 */
$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );
$i = 0;
foreach ( $attachments as $id => $attachment ) {
	$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
	if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
		$image_output = "<a href='" . wp_get_attachment_url( $id ) . "' data-lity> " . wp_get_attachment_image($id, $atts['size'], false, $attr ) . "</a>";
	} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
		$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
	} else {
		$image_output = "<a href='" . wp_get_attachment_url( $id ) . "' data-lity> " . wp_get_attachment_image($id, $atts['size'], false, $attr ) . "</a>";
	}
	$image_meta  = wp_get_attachment_metadata( $id );
	$orientation = '';
	if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
		$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
	}
	$output .= "<{$itemtag} class='gallery-item'>";
	$output .= "
		<{$icontag} class='gallery-icon {$orientation}'>
			$image_output
		</{$icontag}>";
	if ( $captiontag && trim($attachment->post_excerpt) ) {
		$output .= "
			<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
			" . wptexturize($attachment->post_excerpt) . "
			</{$captiontag}>";
	}
	$output .= "</{$itemtag}>";
	if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
		$output .= '<br style="clear: both" />';
	}
}
if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
	$output .= "
		<br style='clear: both' />";
}
$output .= "
	</div>\n";
return $output;
}

/**
 * SVG sprite
 */
function vlp_svg_sprites(){
	echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">';
	echo '<symbol id="village-lane-photography-logo" viewBox="0 0 164.97 72"><g data-name="Layer 2"><path d="M19.47 68.83h-.21s-.1 0-.1-.06.07-.08.27-.08a1.59 1.59 0 0 0 1.14-.41A1.43 1.43 0 0 0 21 67.2a1.67 1.67 0 0 0-.47-1.27 1.73 1.73 0 0 0-1.37-.49 1.5 1.5 0 0 0-.37 0c-.06 0-.07.1-.07.17v5.53c0 .35.08.46.38.49h.44s.07 0 .07.06-.05.08-.16.08h-2.21c-.1 0-.15 0-.15-.08s0-.06.08-.06h.28c.2 0 .25-.24.29-.49s.05-1.13.05-1.9v-3.43a.45.45 0 0 0-.42-.49h-.43s0-.08.15-.08h2.39a2.52 2.52 0 0 1 1.8.5 1.54 1.54 0 0 1 .49 1.17 2.09 2.09 0 0 1-.74 1.49 2.29 2.29 0 0 1-1.65.52zm17.68 3H34.9c-.11 0-.16 0-.16-.07s0-.07.12-.07h.25c.19 0 .24-.26.27-.5a15.18 15.18 0 0 0 .06-1.91v-.95s0-.05-.07-.05h-4-.05v.95a15.24 15.24 0 0 0 .06 1.91.41.41 0 0 0 .37.47h.4c.08 0 .13 0 .13.08s0 .07-.14.07h-2.29c-.11 0-.17 0-.17-.07s0-.08.12-.08h.26c.2 0 .24-.24.28-.47a15.23 15.23 0 0 0 .05-1.91v-3.36a.43.43 0 0 0-.42-.49h-.3c-.07 0-.12 0-.12-.06s.06-.08.17-.08h2.15c.11 0 .17 0 .17.08s0 .06-.11.06h-.22c-.28 0-.34.21-.37.5s0 .51 0 1.9V68c0 .06 0 .06.07.06h4s.07 0 .07-.06v-2.12c0-.28-.07-.43-.43-.48h-.28c-.07 0-.13 0-.13-.07s.06-.08.16-.08H37c.11 0 .18 0 .18.08s0 .07-.13.07h-.22c-.29 0-.34.2-.36.49s0 .52 0 1.9v3.48c0 .37.09.45.38.49h.38c.09 0 .15 0 .15.08s-.06.06-.17.06zm11.59.17A3.71 3.71 0 0 1 46 71a3.36 3.36 0 0 1-1.09-2.54A3.49 3.49 0 0 1 46.1 66a3.88 3.88 0 0 1 2.7-1c2.19 0 3.85 1.24 3.85 3.34A3.43 3.43 0 0 1 51.52 71a3.83 3.83 0 0 1-2.78 1zm0-6.66A2.62 2.62 0 0 0 46 68.18a3.13 3.13 0 0 0 3 3.41c.74 0 2.59-.35 2.59-3a3 3 0 0 0-2.88-3.27zm17.18 1c0 .09 0 .12-.08.12s-.07 0-.07-.12v-.15c0-.42-.18-.53-1.29-.54h-1.09v5.65c0 .36.06.4.33.46a1.55 1.55 0 0 0 .43 0c.09 0 .13 0 .13.07s0 .08-.14.08h-2.2c-.12 0-.17 0-.17-.07s0-.08.12-.08h.25c.21 0 .24-.16.28-.51s0-1.13 0-1.9v-3.8h-1.4c-.7 0-.86.11-1 .33a2.48 2.48 0 0 0-.17.32c0 .08 0 .09-.09.09s-.06 0-.06-.1.15-.75.22-1c0-.13.07-.16.1-.16a4.08 4.08 0 0 0 .48.11 5.32 5.32 0 0 1 .71 0h3.61a7.31 7.31 0 0 0 .8 0h.21s.06.06.06.1v1.07zm11 5.71A3.71 3.71 0 0 1 74.18 71a3.33 3.33 0 0 1-1.1-2.54A3.46 3.46 0 0 1 74.24 66a3.88 3.88 0 0 1 2.7-1c2.19 0 3.85 1.24 3.85 3.34A3.49 3.49 0 0 1 79.66 71a3.87 3.87 0 0 1-2.77 1zm0-6.66a2.62 2.62 0 0 0-2.76 2.85 3.13 3.13 0 0 0 3.05 3.41c.74 0 2.59-.35 2.59-3a3 3 0 0 0-2.88-3.27zm18.84 3.34h-.18c-.27 0-.33.22-.36.52s0 .56 0 1v1c0 .42 0 .43-.13.5a5.33 5.33 0 0 1-2 .39 5.12 5.12 0 0 1-3.23-1 3.18 3.18 0 0 1-1.19-2.54 3.31 3.31 0 0 1 1.67-2.95 4.85 4.85 0 0 1 2.41-.65 9.28 9.28 0 0 1 1.58.14 6 6 0 0 0 .84.09c.09 0 .09.05.09.09a10.24 10.24 0 0 0-.08 1.36c0 .14 0 .19-.09.19s-.06-.07-.08-.12a1.38 1.38 0 0 0-.2-.66 3 3 0 0 0-2.29-.73 3.11 3.11 0 0 0-2 .56 2.63 2.63 0 0 0-.92 2.23 3.34 3.34 0 0 0 3.5 3.38 2.87 2.87 0 0 0 1-.18.36.36 0 0 0 .19-.31v-1.5c0-.69 0-.82-.44-.88h-.25c-.09 0-.14 0-.14-.08s0-.06.17-.06h2.12c.11 0 .16 0 .16.06s0 .08-.14.08zm15.13 3.19h-.79a2.6 2.6 0 0 1-1-.13c-.47-.19-.8-.65-1.37-1.36-.43-.5-.88-1.06-1.07-1.28a.21.21 0 0 0-.13-.07h-1.14s-.06 0-.06.06v.14a16.37 16.37 0 0 0 .06 2c0 .25.06.46.43.5h.32c.1 0 .14 0 .14.07s0 .08-.15.08h-2.24c-.11 0-.16 0-.16-.08s.07-.07.13-.07h.25c.18 0 .25-.15.28-.4v-5.57c0-.26-.1-.43-.44-.49h-.26q-.12 0-.12-.06s0-.07.13-.07h2.3a3.23 3.23 0 0 1 1.82.4 1.56 1.56 0 0 1 .66 1.27 2.56 2.56 0 0 1-1.18 2c.81 1 1.47 1.71 2 2.27a1.8 1.8 0 0 0 1.16.64h.34c.09 0 .12 0 .12.08s0 .06-.19.06h.13zm-3.22-4.65a1.57 1.57 0 0 0-1.67-1.83 2.78 2.78 0 0 0-.64.06.1.1 0 0 0-.07.09v2.86s0 .1.06.12a2.82 2.82 0 0 0 1 .14 1.31 1.31 0 0 0 .73-.16 1.45 1.45 0 0 0 .57-1.33zm16.14 4.64h-1.67c-.21 0-.28 0-.28-.08s0-.06.08-.07.11-.07 0-.22l-.94-2.18h-2.08s-.08 0-.11.08l-.48 1.3a2.44 2.44 0 0 0-.19.75c0 .19.12.27.37.27h.07c.1 0 .14 0 .14.08s-.09.07-.17.07h-1.85c-.12 0-.18 0-.18-.07s0-.08.13-.08h.22c.48 0 .67-.39.86-.83l2.2-5.51c.12-.31.15-.36.23-.36s.1 0 .22.34 1.66 4 2.24 5.31c.37.82.68 1 .84 1a.93.93 0 0 0 .37.06c.08 0 .13 0 .13.08s0 .06-.16.06zM120 66.56c-.06-.16-.07-.16-.12 0l-.83 2.31v.06h1.76v-.06l-.81-2.31zm13.27 2.24h-.17s-.09 0-.09-.06.06-.08.27-.08a1.59 1.59 0 0 0 1.14-.41 1.43 1.43 0 0 0 .46-1.08 1.68 1.68 0 0 0-.48-1.27 1.72 1.72 0 0 0-1.36-.49 1.58 1.58 0 0 0-.38 0 .44.44 0 0 0-.06.17v5.53c0 .35.09.46.39.5h.49c0 .05 0 .08-.15.08h-2.25c-.1 0-.16 0-.16-.08s0 0 .08 0h.29c.21 0 .26-.25.29-.5 0-.63.07-1.27.06-1.9v-3.42a.45.45 0 0 0-.42-.5 2 2 0 0 0-.35 0s-.07 0-.07-.05.06-.08.15-.08h2.4a2.55 2.55 0 0 1 1.81.5 1.51 1.51 0 0 1 .48 1.17 2 2 0 0 1-.74 1.5 2.28 2.28 0 0 1-1.65.51zm17.69 3h-2.25c-.11 0-.17 0-.17-.08s0-.07.12-.07h.26c.18 0 .24-.26.27-.5a15.08 15.08 0 0 0 .06-1.9v-1h-4.07-.05v1a18.67 18.67 0 0 0 .05 1.9c.05.37.09.44.38.47h.4c.08 0 .14 0 .14.08s-.05.07-.15.07h-2.27c-.11 0-.18 0-.18-.07s0-.08.12-.08a1.22 1.22 0 0 0 .27 0c.19 0 .24-.24.27-.47a15.08 15.08 0 0 0 .06-1.9v-3.41a.42.42 0 0 0-.41-.49h-.3c-.08 0-.12 0-.12-.06s0-.08.16-.08h2.16c.11 0 .16 0 .16.08s0 .06-.11.06h-.22c-.28 0-.35.22-.37.5s0 .52 0 1.9v.19H149.31v-2.09c0-.27-.06-.43-.43-.48h-.27c-.08 0-.13 0-.13-.07s.05-.08.15-.08h2.17c.11 0 .17 0 .17.08s0 .07-.12.07h-.22c-.3 0-.34.21-.36.49s0 .52 0 1.9v3.48c0 .37.09.45.37.49h.39c.09 0 .14 0 .14.08s-.05.06-.16.06zm13.92-6.54a1.19 1.19 0 0 0-.56.14 1.68 1.68 0 0 0-.41.43 27.69 27.69 0 0 0-1.87 2.91 1.82 1.82 0 0 0-.11.83v1.6c0 .38 0 .43.39.49a2.81 2.81 0 0 0 .41 0c.08 0 .12 0 .12.07s0 .08-.13.08h-2.27c-.11 0-.15 0-.15-.08s0-.07.11-.07a1.22 1.22 0 0 0 .27 0c.19 0 .27-.25.29-.5s0-.75 0-.84v-.76a1.67 1.67 0 0 0-.24-1c-.07-.12-1.35-2.09-1.69-2.54a2.48 2.48 0 0 0-.57-.64.93.93 0 0 0-.51-.16c-.07 0-.12 0-.12-.08s0-.06.13-.06h1.84c.11 0 .14 0 .14.06s0 .06-.12.08-.18.08-.18.17a.87.87 0 0 0 .15.34c.14.27 1.6 2.49 1.77 2.75.17-.37 1.41-2.28 1.56-2.55a1.55 1.55 0 0 0 .25-.55c0-.11-.13-.13-.25-.16s-.12 0-.12-.08 0-.06.13-.06h1.68c.1 0 .13 0 .13.06s0 .08-.13.08zM85.24 40.63c-.61.38-1.24.74-1.85 1.11a7.67 7.67 0 0 0-2.47 2.83c-1.57 2.5-3.2 5-5 7.31-.52.7-1 1.43-1.55 2.11-.83 1-2.76 3.55-4.39 2.95-1.84-.69-.93-3.16-.29-4.34a15.93 15.93 0 0 1 1.64-2.43A8.2 8.2 0 0 0 73 48l.07.08 1.67-1.4.1.11-.1-.14 1.45-1.15.1.1-.14-.21c2-1.28 4.32-2.36 5.86-4.2-.94.36-3.43 2-4 .5.73-1.46-1.28.05-1.74.26v-.83c.88-.43 1.74-.88 2.6-1.36 1.11-.63 1.95-1.6 3-2.25a3.46 3.46 0 0 1 1.87-.69c.87.11.63.56 0 1-1.62 1.23-3.54 1.51-4.63 3.42 1.16.48 2-.94 3-1.19l-.1-.26c.86-.07 1.5-1.23 1.91-1.9.76.34 1 0 .54 1-.31.65-.79 1.18-1.11 1.82a5.59 5.59 0 0 0 1.85-1c.42-.38.66-1 1.07-1.42a6.27 6.27 0 0 1 1.86-1.41c1-.47 1.24-.18 2.17 0a3.09 3.09 0 0 1-2.21 2.33l.14.21a3 3 0 0 0-1.52.85c-.34.41 0 .19-.32.76h.07a2.25 2.25 0 0 0 1.88.12c.19-.08.3-.29.5-.39a19.1 19.1 0 0 0 2-.9v.85a9.78 9.78 0 0 1-2 1.09 7.85 7.85 0 0 1-2.15.52 1.56 1.56 0 0 1-1.57-1.68zM67.31 41c.1-.5 1.16-2.22 1.63-2.1l.15-.33c.64.38 1.32-.46 1.85-.7a7.16 7.16 0 0 1 1.73-.33c.43-.07 1.12-.27 1.55 0a.55.55 0 0 1 .24.83c-.29.53-.66.3-1.14.32l.62.4c-.06 1-1.75 1.9-1 2.94a6.66 6.66 0 0 1 1.73-.36 9.27 9.27 0 0 0 1.53-.54v.74c-1.35.87-4.59 2.28-4.68-.63A9.54 9.54 0 0 1 69 42.69c-1.06.29-1.52.43-1.69-.88a10.49 10.49 0 0 1-3.47 1.37 3 3 0 0 1-3.6-2.29c-.12-.38-.12-.85-.45-.87s-1 .59-1.24.74a14.85 14.85 0 0 1-2.3 1.37c-2.25.81-5.63 2.25-6.78-.82-.07-.17-.22-1.21-.43-1.3s-.58.28-.75.38a22.3 22.3 0 0 1-2.77 1.66c-.73.3-1.54.56-2.3.85a3.8 3.8 0 0 1-2.18.3 1.57 1.57 0 0 1-.89-1.13c-.17-.64.12-1 .4-1.61a9.39 9.39 0 0 0-2.43 1.32l-.21-.78c1.45-.54 3.75-2 4.52-3.34.94.16.72.66.33 1.26-.27.41-.58.8-.83 1.22a10.4 10.4 0 0 0-.77 2.26c1.73.2 2.91-.88 4.45-1.42h.13v.09c.95-.42 2.47-.87 3.11-1.72s.59-2.23.93-3.18A24.76 24.76 0 0 1 54 28.88a31.44 31.44 0 0 1 4.75-4.69 18.38 18.38 0 0 1 2.51-1.87A22.71 22.71 0 0 0 64.12 21c.6.38 1.43.84.91 1.62h.09A28.72 28.72 0 0 1 63.3 26c-.7.92-1.3 1.91-2 2.81-.87 1.07-1.85 2-2.79 3a50.18 50.18 0 0 1-4.16 4c-1.09.93-2.54 2.49-4 2.93-.62 2.11.34 3.88 2.7 3.49A15.38 15.38 0 0 0 58.24 40l.09.21a4.3 4.3 0 0 0 1.55-1 5.19 5.19 0 0 0 .29-1.49 13.66 13.66 0 0 1 1.21-3.17 30.8 30.8 0 0 1 4.84-7.11 57.25 57.25 0 0 1 4.23-3.86 11 11 0 0 1 2-1.36A19.37 19.37 0 0 0 75 21c.59.37 1.45.85.91 1.62H76A28 28 0 0 1 74.19 26c-.67.87-1.25 1.82-1.94 2.68-.86 1.07-1.83 2-2.77 3a47.15 47.15 0 0 1-3.4 3.38c-1.44 1.22-3 3.06-4.82 3.63-.38 1.29-.36 3 1.22 3.52S66 41.68 67.31 41zm-20.74-7.32c-.33.68-1.17.54-1.09-.22 0-.34.52-.63.76-.87l.69.21a2.42 2.42 0 0 1-.4.88zm17.54-11.83c-1.3 0-2.6 1.08-3.6 1.84-.65.49-5.14 4.1-4.7 4.87l-.65.26c.19.73-1.81 2.77-2.17 3.35-1.07 1.71-2.37 3.83-2.47 5.83l1.77-1.15-.14-.25c1.26-.37 2.62-2 3.55-2.93s1.7-1.81 2.63-2.66a33.69 33.69 0 0 0 3.53-4.26c.32-.4 3.48-4.92 2.17-4.92zm10.88 0c-1.68.08-3.53 1.69-4.67 2.77-.59.56-4 3.22-3.63 3.94l-.66.26c.18.59-.79 1.46-1.12 1.88a21.44 21.44 0 0 0-1.53 2.23 11.88 11.88 0 0 0-2 5.11l1.77-1.15-.15-.25c1.25-.37 2.61-2 3.53-2.93s1.65-1.77 2.6-2.56a27.85 27.85 0 0 0 3.65-4.36 24.17 24.17 0 0 0 1.85-2.65c.19-.32 1.21-2.37.32-2.28zm-1.83 16.91c-.68 0-5.43 2.15-4.39 2.83s3.71-2.4 4.39-2.83zm4.66 6.18l.11.21a4.46 4.46 0 0 0-2.68 2.15c-.57 0-3.17 2.28-2.85 2.85-.67.12-1.43 1.57-1.82 2.13a4.3 4.3 0 0 0-.72 3.47 2.92 2.92 0 0 0 2.56-.67 24 24 0 0 0 2.84-3.56c.91-1.17 1.53-2.43 2.33-3.67s2.13-2.77 2.54-4.26L77.78 45v-.05zM87.55 39c.5-.32 2.06-1.08 1.63-1.78-.75.56-2 1-2.1 2.12l.51-.34zM62.68 6.93l-.12-.17c2.17-.63 4.1-2.59 6.19-3.5 1.84-.82 3.72-1.47 5.59-2.2 1.31-.52 3.83-2 4.83-.23-.22.37-.31.81-.66 1.09a5.71 5.71 0 0 1-1.78.57c-.76.23-1.52.45-2.27.71-1.15.4-2.22.85-3.35 1.28a18.36 18.36 0 0 0-3.81 1.91 16.7 16.7 0 0 1-4.13 2.24l.12.36c-1.53.33-2.77 1.71-3.91 2.69-.69.59-2.26 2.57-3.23 2.57l.18.18c-1.31 1.41-2.6 2.82-4 4.17.3 1.18-2.8 2-2.22 3.42h-.51c.19.58-1.18 2-1.47 2.45-.88 1.21-1.8 2.38-2.74 3.54s-1.72 2.1-2.59 3.14a87.62 87.62 0 0 1-6.86 7.55 42 42 0 0 1-5.18 4.53c-.86.57-1.78 1-2.68 1.54-1.51.85-3.85 1.9-5.65 1.55S19.61 44.8 19.1 43c-.77-2.74.55-5.9 1.88-8.26.51-.92.85-2.05 1.36-2.91.41-.68 1.07-.79 1.15-1.7H24l.79-1.8.48-.06-.27-.16 2.58-3.17-.18-.18h.55c-.41-.69 2.16-3 2.68-3.56.79-.9 1.35-2 2.17-2.85.5-.53 2.66-1.74 2.21-2.63l.19.18 3.8-4.55a21.14 21.14 0 0 0-4.16 2.11c-2.1 1.15-4.21 2.25-6.4 3.22-1.66.73-3.35 1.33-5.05 2s-3.91.82-5 2.41c-1.88-.77-4.81.43-6.69.84A9.12 9.12 0 0 1 8 22c-1.85-.27-3.76-.26-5.37-1.39A11.24 11.24 0 0 1 .22 19c-.58-.8.12-1.81.63-2.48 1.64 1.16 2.9 2.3 4.89 2.89a18.53 18.53 0 0 0 6.39.34 34.64 34.64 0 0 0 8.94-1.65c2.76-.91 5.4-1.94 8.07-3.1 1.52-.67 3-1.33 4.46-2 .43-.21.93-.28 1.31-.51.66-.37 1-.88 1.86-1l-.18-.36c1.47 0 2.5-1.06 3.72-1.86S42.72 7 44.07 7.38c.75 1.43-1.91 3.35-2.84 4.37-.63.68-4 3.7-3.7 4.54l-.13-.18-7.72 9.15.24.18h-.66L25.46 31l.18.12c-.89 0-1.89 2.07-2.28 2.71a20.64 20.64 0 0 0-1.29 2.52c-.24.56-.49 1.12-.74 1.67-.14.33-1.29 2.85-1.06 2.85a6.75 6.75 0 0 0 0 2.33 5 5 0 0 0 1.39 1.48 5.62 5.62 0 0 0 1.88 0 7 7 0 0 0 3.17-.83A22.92 22.92 0 0 0 30 42.2a6.82 6.82 0 0 0 1.67-1.45 2.71 2.71 0 0 1 .73-.75 6.43 6.43 0 0 0 1.09-.53c.25-.21.42-.59.69-.75s.5-.07.65-.16.38-.45.54-.62l1.56-1.82.24.18-.24-.36.18.06 1.22-1-.18-.24h.59C39.35 33 41 31.43 42.15 30c2-2.51 4.12-4.92 6.08-7.45.92-1.18 1.68-2.47 2.63-3.63s2-2.42 3.08-3.59c.7-.78 3.16-2.28 3-3.46.62 0 1.89-1.52 2.33-1.92C60.36 9 61.56 7.63 63 7.29zm95 34.27c-1.53.84-3.62 1.66-5.39 1.11-1.6-.49-1.46-1.78-1.46-3.14-.92.37-1.68 1-2.61 1.46a19 19 0 0 1-2.53 1.13c-1.58.43-1.93-.49-1.15-1.71s1.93-2.23 2.13-3.57l-2.37 1.25-.24-.67a7.47 7.47 0 0 1 2.88-1.54c2.42-.21-.37 3 0 3.85-.61 0-1.57 1.17-.46 1a10.55 10.55 0 0 0 2.91-1.49c1.27-.7 2.49-1.48 3.71-2.26.61.9.33 1.09-.19 1.95a4.49 4.49 0 0 0-.63 2.57c.83 0 2 .54 2.56-.33l.67.14a5.11 5.11 0 0 1 1.86-.86v-.81h.1A8.14 8.14 0 0 1 160 35.9a7.14 7.14 0 0 1 1.92-1.13c1.05-.39 1.39 0 2.37.26-.28 1.33-1.53 3-3 3.12l.2.29c-.56 0-2.79 1.08-2.37 1.86a.23.23 0 0 0-.12.29v-.09a2.8 2.8 0 0 0 2.46.16c.27-.14.41-.39.69-.52a23.3 23.3 0 0 0 2.72-1.21l.05 1.15a10 10 0 0 1-3.78 1.8c-1.43.25-2.46.67-3.53-.69zM142 41c-1.92.67-5.24 1.68-5.32-1.58a13.86 13.86 0 0 1-3 1.87 7 7 0 0 1-2.07.46c-.89-.39-.76-2.53-.43-3.17a14.75 14.75 0 0 1 .93-1.16c.32-.47.31-1.34 1.06-1.15l.2-.43c.89.56 2.43-1 3.34-1.2a14.61 14.61 0 0 1 2.23-.37 2.51 2.51 0 0 1 1.49.37.71.71 0 0 1 .13 1c-.35.73-.86.41-1.51.44l.82.51c-.08 1.32-2.33 2.54-1.26 3.94a9.82 9.82 0 0 1 1.86-.5c.7-.24 1.45-.46 2.13-.75l.29 1.48a6 6 0 0 1-.89.24zm-3.2-4.88a9 9 0 0 0-3.66 1.31c-.49.27-2.76 1.47-2.44 2.27.53 1.3 5.55-3.28 6.09-3.66v.08zm21.57 1.65c.61-.4 2.8-1.48 2.18-2.37-1 .71-2.69 1.4-2.79 2.82l.67-.45a.06.06 0 0 1-.09.03zm-63.93.63c1.81-.33 3.52-1.93 5.24-2.55a32.23 32.23 0 0 1 11-1.7l-1.33 2 .18.12h-.6c.2.61-1.35 2.13-1.68 2.51-.67.76-1.54 2-2.6 2.15l.18.36a7.29 7.29 0 0 0-2.22 1.38 16.05 16.05 0 0 1-3.7 1.92 11.64 11.64 0 0 1-3.43.88 7.86 7.86 0 0 1-3.16-.56 3.85 3.85 0 0 1-.76-.53c-.41-.46-.42-1-.81-1.47.27-.44.24-.84.51-1.26a7.87 7.87 0 0 1 1.08-1.08c.68-.67 1.23-1.69 2.27-1.79l-.19-.38zm39.89-31.81a15.09 15.09 0 0 0 2.77-1.07c1.35-.55 2.77-.32 4.09-.85l1.14.78c-.25 2.05-2.52 3.45-4.06 4.53-.9.63-1.84 1.2-2.78 1.77-.24.14-1.78.87-1.78 1.1-.68.09-1.13.59-1.74.85s-1.35.62-2 .92c-1.46.66-3.19.93-4.53 1.85l-.43-.58c1.1-1.23 2.21-2.46 3.3-3.7.65-.74 1.39-1.22 2.05-2 1.1-1.23 2.49-3.14 4.27-3.32l-.18-.37h-.1zm-24.27 12.28a14.91 14.91 0 0 1-7.5-2.53l-1 .6c.88 2.32 5.33 3 7.45 3.23a15.17 15.17 0 0 0 3.92-.2 31.81 31.81 0 0 0 7.87-1.67l.42.36c-2.08 3.3-4.16 6.64-6.54 9.73a15 15 0 0 0-1.6 2.51 4.1 4.1 0 0 1-1.44 1.91c-1 .59-2.56.52-3.72.63l-.24-.78-.49 1a22.11 22.11 0 0 0-8.34 1.8 25 25 0 0 0-4.69 2.61c-1.55 1-3.38 2.35-4 4.17-1.1 3.29 2.56 4.1 5 4.13a11.82 11.82 0 0 0 5.84-1.66 25.75 25.75 0 0 0 2.61-1.61 11.54 11.54 0 0 1 2.82-1.85l-.24-.3c1.1-.19 2.13-1.52 2.88-2.27s1.62-1.63 2.33-2.49c.38-.46.61-1.28 1.18-1.51a2.45 2.45 0 0 1 1.17 0 15.36 15.36 0 0 1 3.33.85 21.07 21.07 0 0 1 4.78 2.47c.39.27.82.53 1.19.83.74.62 1.14 2 2.19 2.1-.19.77.7 2.15.93 2.9a9.89 9.89 0 0 1 .46 3.15 8.67 8.67 0 0 1-.7 3.44c-.4.87-1.69 1.54-.93 2.59a9.62 9.62 0 0 0 3.17-5.51 8.58 8.58 0 0 0-1.77-7.18 21.07 21.07 0 0 0-6.21-5.05 16.32 16.32 0 0 0-3.37-1.27 10 10 0 0 0-1.6-.44 6.63 6.63 0 0 1-1.72-.19c.62-.82 1.2-1.68 1.77-2.54a7.33 7.33 0 0 0 1.52-2.94h.6c0-1.32 1.86-3.3 2.54-4.38s1.15-1.9 1.79-2.82c.51-.73 1-1.44 1.54-2.16a4.65 4.65 0 0 1 2.61-1.53 33.36 33.36 0 0 0 5.64-2.3c1.36-.79 2.8-1.4 4.17-2.18a9 9 0 0 1 2.78-1.34v-.36L142 10l-.3-.36.24.18 2.24-2.34c.28-.29.78-.66.91-1 .35-1-.37-1.69-.85-2.43h-3.08a15.43 15.43 0 0 0-6 2.21 27.71 27.71 0 0 0-5.13 4c-1.68 1.58-3 3.43-4.53 5.11a6.55 6.55 0 0 1-3.46 2.33c-1.07.23-2.15.43-3.22.65a40 40 0 0 1-6.76.52z" fill-rule="evenodd" data-name="Layer 1"/></g></symbol>';	
	echo '</svg>';
}
add_action( 'wp_head', 'vlp_svg_sprites' );