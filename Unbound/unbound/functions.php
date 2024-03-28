<?php
/**
 * RadiantThemes functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RadiantThemes
 */

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Fire the wp_body_open action.
	 *
	 * @return mixed
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Load Jetpack compatibility file.
 */

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_parent_theme_file_path( '/inc/jetpack.php' );
}



// Plugin activator.
require_once get_template_directory() . '/inc/tgmpa/tgmpa.php';



// Admin pages.
if ( is_admin() ) {
	include_once get_template_directory() . '/inc/radiantthemes-dashboard/rt-admin.php';
}



if ( ! function_exists( 'unbound_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function unbound_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Finacorp, use a find and replace
		 * to change 'unbound' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'unbound', get_template_directory() . '/languages' );

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

		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/

		 */

		add_theme_support( 'post-thumbnails' );

		/*
		 * Enable support for woocommerce lightbox gallery.

		*/

		add_theme_support( 'wc-product-gallery-zoom' );

		add_theme_support( 'wc-product-gallery-lightbox' );

		add_theme_support( 'wc-product-gallery-slider' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(

				'top'             => esc_html__( 'Primary', 'unbound' ),

				'footer'          => esc_html__( 'Footer', 'unbound' ),

				'full-width-menu' => esc_html__( 'Full Width Menu', 'unbound' ),

			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments

		 * to output valid HTML5.

		 */

		add_theme_support(
			'html5',
			array(

				'search-form',

				'comment-form',

				'comment-list',

				'gallery',

				'caption',

			)
		);

		// Set up the WordPress core custom background feature.
		$unbound_args = array(

			'default-color' => 'ffffff',

			'default-image' => '',

		);

		add_theme_support( 'custom-background', $unbound_args );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Registers an editor stylesheet for the theme.
		$font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Roboto:400,500,700' );

		add_editor_style( $font_url );

		add_editor_style( 'css/radiantthemes-editor-styles.css' );

		/**

		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */

		add_theme_support(
			'custom-logo',
			array(

				'height'      => 250,

				'width'       => 250,

				'flex-width'  => true,

				'flex-height' => true,

			)
		);

				// Gutenberg Start.
		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'editor-styles' );

		/**
		 * Register custom fonts.
		 * Based on the function from Twenty Seventeen.
		 */
		function gutenberg_editor_fonts_url() {
			$fonts_url = '';

			/*
			* Translators: If there are characters in your language that are not
			* supported by Roboto, translate this to 'off'. Do not translate
			* into your own language.
			*/
			$roboto = esc_html_x( 'on', 'Roboto font: on or off', 'unbound' );

			/*
			* Translators: If there are characters in your language that are not
			* supported by Poppins, translate this to 'off'. Do not translate
			* into your own language.
			*/
			$poppins = esc_html_x( 'on', 'Poppins font: on or off', 'unbound' );
			if ( 'off' !== $roboto && 'off' !== $poppins ) {
				$font_families = array();
				if ( 'off' !== $roboto ) {
					$font_families[] = 'Roboto:400,500,700';
				}

				if ( 'off' !== $poppins ) {
					$font_families[] = 'Poppins:400,500,600,700';
				}

				$query_args = array(
					'family' => rawurlencode( implode( '|', $font_families ) ),
					'subset' => rawurlencode( 'latin,latin-ext' ),
				);

				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			}
			return esc_url_raw( $fonts_url );
		}

		add_editor_style( gutenberg_editor_fonts_url() );

		add_filter( 'body_class', 'radiantthemes_body_classes' );

		function radiantthemes_body_classes( $classes ) {

			$classes[] = 'radiantthemes';
			$classes[] = 'radiantthemes-' . get_template();

			return $classes;
		}

		// Gutenberg End.

		add_action( 'enqueue_block_editor_assets', 'radiantthemes_gutenberg_block_editor_style' );
		add_action( 'enqueue_block_assets', 'radiantthemes_gutenberg_block_style' );

		function radiantthemes_gutenberg_block_style() {

			wp_register_style(
				'radiantthemes_gutenberg_block',
				get_parent_theme_file_uri( '/css/radiantthemes-gutenberg-blocks.css' ),
				array(),
				time(),
				'all'
			);
			wp_enqueue_style( 'radiantthemes_gutenberg_block' );
		}

		function radiantthemes_gutenberg_block_editor_style() {
			wp_register_style(
				'radiantthemes_gutenberg_editor',
				get_parent_theme_file_uri( '/css/radiantthemes-gutenberg-editor.css' ),
				array(),
				time(),
				'all'
			);
			wp_enqueue_style( 'radiantthemes_gutenberg_editor' );
		}

		// Require Redux Framework.
		require_once get_parent_theme_file_path( '/inc/redux-framework/admin-init.php' );
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		Redux::init('unbound_theme_option');
		}
		/**
		 * Redux custom css
		 */
		function unbound_custom_redux_css() {

			/**
			 * [unbound_custom_redux_css description]
			 */
			function unbound_override_css_fonts_url() {

				$google_font_url = '';

				/*
				Translators          : If there are characters in your language that are not supported

				by chosen font(s), translate this to 'off'. Do not translate into your own language.

				*/

				if ( 'off' !== _x( 'on', 'Google font: on or off', 'unbound' ) ) {

					$google_font_url = add_query_arg( 'family', rawurlencode( 'Poppins: 300,400,500,600,700' ), '//fonts.googleapis.com/css' );

				}

				return $google_font_url;

			}

			wp_enqueue_style(
				'radiantthemes-google-fonts',
				unbound_override_css_fonts_url(),
				array(),
				'1.0.0'
			);

			wp_register_style(
				'simple-dtpicker',
				get_parent_theme_file_uri( '/inc/redux-framework/css/jquery.simple-dtpicker.min.css' ),
				array(),
				time(),
				'all'
			);

			wp_enqueue_style( 'simple-dtpicker' );

			wp_register_style(
				'radiantthemes-redux-custom',
				get_parent_theme_file_uri( '/inc/redux-framework/css/radiantthemes-redux-custom.css' ),
				array(),
				time(),
				'all'
			);

			wp_enqueue_style( 'radiantthemes-redux-custom' );

			wp_enqueue_script(
				'simple-dtpicker',
				get_parent_theme_file_uri( '/inc/redux-framework/js/jquery.simple-dtpicker.min.js' ),
				array( 'jquery' ),
				time(),
				true
			);

			wp_enqueue_script(
				'radiantthemes-redux-custom',
				get_parent_theme_file_uri( '/inc/redux-framework/js/radiantthemes-redux-custom.js' ),
				array( 'jquery' ),
				time(),
				true
			);

		}

		// This example assumes your opt_name is set to unbound_theme_option, replace with your opt_name value.
		add_action( 'redux/page/unbound_theme_option/enqueue', 'unbound_custom_redux_css', 2 );

	}

endif;

add_action( 'after_setup_theme', 'unbound_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function unbound_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'unbound_content_width', 640 );

}

add_action( 'after_setup_theme', 'unbound_content_width', 0 );



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function unbound_widgets_init() {

	register_sidebar(
		array(

			'name'          => esc_html__( 'Sidebar', 'unbound' ),

			'id'            => 'sidebar-1',

			'description'   => esc_html__( 'Add widgets here.', 'unbound' ),

			'before_widget' => '<section id="%1$s" class="widget %2$s">',

			'after_widget'  => '</section>',

			'before_title'  => '<h2 class="widget-title">',

			'after_title'   => '</h2>',

		)
	);

	if ( class_exists( 'woocommerce' ) ) {

		register_sidebar(
			array(

				'name'          => esc_html__( 'Product | Sidebar', 'unbound' ),

				'id'            => 'unbound-product-sidebar',

				'description'   => esc_html__( 'Add widgets here.', 'unbound' ),

				'before_widget' => '<section id="%1$s" class="widget %2$s">',

				'after_widget'  => '</section>',

				'before_title'  => '<h5 class="widget-title">',

				'after_title'   => '</h5>',

			)
		);

	}

	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {

		// unbound Footer Areas.
		for ( $j = 1; $j <= 4; $j++ ) {

			register_sidebar(
				array(

					'name'          => esc_html__( 'Footer | #', 'unbound' ) . $j . '',

					'id'            => 'unbound-footer-area-' . $j,

					'description'   => esc_html__( 'Add widgets here.', 'unbound' ),

					'before_widget' => '<section id="%1$s" class="widget %2$s">',

					'after_widget'  => '</section>',

					'before_title'  => '<h5 class="widget-title">',

					'after_title'   => '</h5>',

				)
			);

		}
	}

	register_sidebar(
		array(

			'name'          => esc_html__( 'Hamburger | Sidebar', 'unbound' ),

			'id'            => 'unbound-hamburger-sidebar',

			'description'   => esc_html__( 'Add widgets for "Hamburger" menu from here. To turn it on/off please navigate to "Theme Options > Header" and select "Hamburger" for respetive header styles.', 'unbound' ),

			'before_widget' => '<div id="%1$s" class="widget %2$s matchHeight">',

			'after_widget'  => '</div>',

			'before_title'  => '<p class="widget-title">',

			'after_title'   => '</p>',

		)
	);

}

add_action( 'widgets_init', 'unbound_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function unbound_scripts() {

	// ENQUEUE STYLESHEETS.
	wp_deregister_style( 'font-awesome' );

	wp_deregister_style( 'font-awesome-css' );

	wp_enqueue_style(
		'bootstrap',
		get_parent_theme_file_uri( '/css/bootstrap.min.css' ),
		array(),
		time()
	);

	wp_enqueue_style(
		'font-awesome',
		get_parent_theme_file_uri( '/css/font-awesome.min.css' ),
		array(),
		time()
	);

	wp_enqueue_style(
		'elusive-icons',
		get_parent_theme_file_uri( '/css/elusive-icons.min.css' ),
		array(),
		time()
	);

	wp_enqueue_style(
		'animate',
		get_parent_theme_file_uri( '/css/animate.min.css' ),
		array(),
		time()
	);

	wp_enqueue_style( 'js-composer-front' );

	wp_enqueue_style(
		'radiantthemes-custom',
		get_parent_theme_file_uri( '/css/radiantthemes-custom.css' ),
		array(),
		time()
	);

	wp_enqueue_style(
		'radiantthemes-responsive',
		get_parent_theme_file_uri( '/css/radiantthemes-responsive.css' ),
		array(),
		time()
	);

	// CALL RESET CSS IF REDUX NOT ACTIVE.
	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {

		wp_enqueue_style(
			'radiantthemes-reset',
			get_parent_theme_file_uri( '/css/radiantthemes-reset.css' ),
			array(),
			time()
		);

		/**
		 * Load Montserrat Google Font when redux framework is not installed.
		 */
		function unbound_default_google_fonts_url() {

			$google_font_url = '';

			/*
			Translators          : If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			*/
			if ( 'off' !== _x( 'on', 'Google font: on or off', 'unbound' ) ) {

				$google_font_url = add_query_arg( 'family', rawurlencode( 'Roboto:400,500,700|Poppins:400,500,600,700' ), '//fonts.googleapis.com/css' );

			}

			return $google_font_url;

		}

		wp_enqueue_style(
			'radiantthemes-google-fonts',
			unbound_default_google_fonts_url(),
			array(),
			'1.0.0'
		);

	}

	// ENQUEUE PRELOADER STYLE.
	if ( ! empty( unbound_global_var( 'preloader_switch', '', false ) ) ) {

		wp_enqueue_style(
			'preloader',
			get_parent_theme_file_uri( '/css/spinkit.min.css' ),
			array(),
			time()
		);

	}

	// ENQUEUE HEADER STYLE.
	if ( is_404() && ! empty( unbound_global_var( 'error_custom_header_style', '', false ) ) ) {

		wp_enqueue_style(
			'radiantthemes-' . unbound_global_var( 'error_custom_header_style', '', false ),
			get_parent_theme_file_uri( '/css/radiantthemes-' . unbound_global_var( 'error_custom_header_style', '', false ) . '.css' ),
			array(),
			null
		);

	} elseif ( ! empty( unbound_global_var( 'header-style', '', false ) ) ) {

		$id = get_the_ID();

		if ( ( 'default' != get_post_meta( $id, 'selectheader', true ) ) && ( ! empty( get_post_meta( $id, 'selectheader', true ) ) ) ) {

			wp_enqueue_style(
				'radiantthemes-header-style-' . get_post_meta( $id, 'selectheader', true ),
				get_parent_theme_file_uri( '/css/radiantthemes-header-style-' . get_post_meta( $id, 'selectheader', true ) . '.css' ),
				array(),
				null
			);

		} else {

			wp_enqueue_style(
				'radiantthemes-' . unbound_global_var( 'header-style', '', false ),
				get_parent_theme_file_uri( '/css/radiantthemes-' . unbound_global_var( 'header-style', '', false ) . '.css' ),
				array(),
				null
			);

		}
	} else {

		wp_enqueue_style(
			'radiantthemes-header-style-default',
			get_parent_theme_file_uri( '/css/radiantthemes-header-style-default.css' ),
			array(),
			null
		);

	}

	// ENQUEUE FOOTER STYLE.
	if ( ! empty( unbound_global_var( 'footer-style', '', false ) ) ) {

		wp_enqueue_style(
			'radiantthemes-' . unbound_global_var( 'footer-style', '', false ),
			get_parent_theme_file_uri( '/css/radiantthemes-' . unbound_global_var( 'footer-style', '', false ) . '.css' ),
			array(),
			null
		);

	} else {

		wp_enqueue_style(
			'radiantthemes-footer-style-one',
			get_parent_theme_file_uri( '/css/radiantthemes-footer-style-one.css' ),
			array(),
			null
		);

	}

	// ENQUEUE STYLE.CSS.
	wp_enqueue_style( 'radiantthemes-style', get_stylesheet_uri() );

	// ENQUEUE RAIDNATTHEMES USER CUSTOM - GERERATED FROM REDUX CUSTOM CSS.
	wp_enqueue_style(
		'radiantthemes-user-custom',
		get_parent_theme_file_uri( '/css/radiantthemes-user-custom.css' ),
		array(),
		time()
	);

	// ENQUEUE RADIANTTHEMES DYNAMIC - GERERATED FROM REDUX FRAMEWORK.
	wp_enqueue_style(
		'radiantthemes-dynamic',
		get_parent_theme_file_uri( '/css/radiantthemes-dynamic.css' ),
		array(),
		time()
	);

	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( class_exists( 'ReduxFrameworkPlugin' ) && class_exists( 'Radiantthemes_Addons' ) ) {

		$buttonradius = '';

		$buttonradius = esc_html( unbound_global_var( 'border-radius', 'margin-top', true ) );

		$buttonradius .= ' ' . esc_html( unbound_global_var( 'border-radius', 'margin-top', true ) );

		$buttonradius .= ' ' . esc_html( unbound_global_var( 'border-radius', 'margin-top', true ) );

		$buttonradius .= ' ' . esc_html( unbound_global_var( 'border-radius', 'margin-top', true ) );

		$buttonborderradius = '.gdpr-notice .btn, .team.element-six .team-item > .holder .data .btn, .radiantthemes-button > .radiantthemes-button-main, .rt-fancy-text-box > .holder > .more .btn, .rt-call-to-action-wraper .rt-call-to-action-item .btn:hover, .radiant-contact-form .form-row input[type=submit], .wraper_error_main.style-one .error_main .btn, .wraper_error_main.style-two .error_main .btn, .wraper_error_main.style-three .error_main_item .btn, .wraper_error_main.style-four .error_main .btn {  border-radius:' . $buttonradius . ' ; }';

		wp_enqueue_style(
			'radiantthemes-button-element-one',
			plugins_url( 'radiantthemes-addons/button/css/radiantthemes-button-element-one.css' ),
			plugin_dir_url( __FILE__ ) . 'css/radiantthemes-button-element-one.css',
			array(),
			null
		);

		wp_add_inline_style( 'radiantthemes-button-element-one', $buttonborderradius );

	}

	/**

	 * ENQUEUE SCRIPTS
	 */

	// ENQUEUE BOOTSTRAP JQUERY.
	wp_enqueue_script(
		'bootstrap',
		get_parent_theme_file_uri( '/js/bootstrap.min.js' ),
		array( 'jquery' ),
		false,
		true
	);

	// ENQUEUE SIDR JQUERY.
	wp_enqueue_script(
		'sidr',
		get_parent_theme_file_uri( '/js/jquery.sidr.min.js' ),
		array( 'jquery' ),
		false,
		true
	);

	// ENQUEUE MATCHHEIGHT JQUERY.
	wp_enqueue_script(
		'matchHeight',
		get_parent_theme_file_uri( '/js/jquery.matchHeight-min.js' ),
		array( 'jquery' ),
		false,
		true
	);

	// ENQUEUE WOW JQUERY.
	wp_enqueue_script(
		'wow',
		get_parent_theme_file_uri( '/js/wow.min.js' ),
		array( 'jquery' ),
		false,
		true
	);

	// ENQUEUE NICESCROLL JQUERY.
	wp_enqueue_script(
		'nicescroll',
		get_parent_theme_file_uri( '/js/jquery.nicescroll.min.js' ),
		array( 'jquery' ),
		false,
		true
	);

	// ENQUEUE STICKY JQUERY.
	wp_enqueue_script(
		'sticky',
		get_parent_theme_file_uri( '/js/jquery.sticky.min.js' ),
		array( 'jquery' ),
		false,
		true
	);

	// ENQUEUE RETINA JQUERY.
	wp_enqueue_script(
		'retina',
		get_parent_theme_file_uri( '/js/retina.min.js' ),
		false,
		true
	);

	// ENQUEUE ISOTOPE JQUERY.
	if ( 'two' === unbound_global_var( 'blog-style', '', false ) || 'five' === unbound_global_var( 'blog-style', '', false ) ) {

		wp_enqueue_script(
			'isotope',
			get_parent_theme_file_uri( '/js/isotope.pkgd.min.js' ),
			array( 'jquery' ),
			false,
			true
		);

		wp_enqueue_script(
			'radiantthemes-blog-style',
			get_parent_theme_file_uri( '/js/radiantthemes-blog-style.js' ),
			array( 'jquery', 'isotope' ),
			false,
			true
		);

	}

	// ENQUEUE RADIANTTHEMES CUSTOM JQUERY.
	wp_enqueue_script(
		'radiantthemes-custom',
		get_parent_theme_file_uri( '/js/radiantthemes-custom.js' ),
		array( 'jquery' ),
		false,
		true
	);

	// Load comment-reply.js into footer.
	if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) === 1 ) ) {

		// Load comment-reply.js (into footer).
		wp_enqueue_script( 'comment-reply', 'wp-includes/js/comment-reply', array(), false, true );

	}

	// Load Countdown JS and Coming Soon JS.
	if ( ! is_user_logged_in() && ! empty( unbound_global_var( 'coming_soon_switch', '', false ) ) ) {

		wp_enqueue_script(
			'countdown',
			get_parent_theme_file_uri( '/js/jquery.countdown.min.js' ),
			array( 'jquery' ),
			true
		);

		wp_enqueue_script(
			'radiantthemes-comingsoon',
			get_parent_theme_file_uri( '/js/radiantthemes-comingsoon.js' ),
			array( 'jquery' ),
			true
		);

	}

}

add_action( 'wp_enqueue_scripts', 'unbound_scripts' );

/**
 * ADMIN CUSTOM CSS
 *
 * @return void
 */
function radiantthemes_admin_custom_css() {
	$radiantthemes_admin_custom_css = unbound_global_var( 'radiantthemes_custom_css_editor', '', false );
	if ( ! empty( $radiantthemes_admin_custom_css ) ) {
		wp_add_inline_style( 'radiantthemes-style', $radiantthemes_admin_custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'radiantthemes_admin_custom_css' );



/**

 * RadiantThemes Dynamic CSS.
 */

global $wp_filesystem;

$radiantthemes_theme_options = get_option( 'unbound_theme_option' );

ob_start();

require_once get_parent_theme_file_path( '/inc/dynamic-style/radiantthemes-dynamic-style.php' );

$css = ob_get_clean();

$filename = get_parent_theme_file_path( '/css/radiantthemes-dynamic.css' );



if ( empty( $wp_filesystem ) ) {

	require_once ABSPATH . '/wp-admin/includes/file.php';

	WP_Filesystem();

}



if ( $wp_filesystem ) {

	$wp_filesystem->put_contents(
		$filename,
		$css,
		FS_CHMOD_FILE // predefined mode settings for WP files.
	);

}



/**

 * Woocommerce Support
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );



/**

 * [unbound_wrapper_start description]
 */

function unbound_wrapper_start() {

	echo wp_kses_post( '<section id="main">' );

}

add_action( 'woocommerce_before_main_content', 'unbound_wrapper_start', 10 );



/**

 * [unbound_wrapper_end description]
 */

function unbound_wrapper_end() {

	echo wp_kses_post( '</section>' );

}

add_action( 'woocommerce_after_main_content', 'unbound_wrapper_end', 10 );



/**

 * [woocommerce_support description]
 */

function unbound_woocommerce_support() {

	add_theme_support( 'woocommerce' );

}

add_action( 'after_setup_theme', 'unbound_woocommerce_support' );



// Remove the product rating display on product loops.
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );



// Ajax cart basket.
add_filter( 'woocommerce_add_to_cart_fragments', 'unbound_iconic_cart_count_fragments', 10, 1 );



// Woocommerce product per page
add_filter( 'loop_shop_per_page', 'unbound_shop_per_page', 20 );



function unbound_shop_per_page( $cols ) {

	// $cols contains the current number of products per page based on the value stored on Options -> Reading
	// Return the number of products you wanna show per page.
	$cols = esc_html( unbound_global_var( 'shop-products-per-page', '', false ) );

	return $cols;

}

/**

 * [unbound_iconic_cart_count_fragments description]
 *
 * @param  [type] $fragments description.

 * @return [type]            [description]
 */

function unbound_iconic_cart_count_fragments( $fragments ) {

	$fragments['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';

	return $fragments;

}



/**

 * Set Site Icon
 */

function unbound_site_icon() {

	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {

		if ( unbound_global_var( 'favicon', 'url', true ) ) :

			?>

			<link rel="icon" href="<?php echo esc_url( unbound_global_var( 'favicon', 'url', true ) ); ?>" sizes="32x32" />

			<link rel="icon" href="<?php echo esc_url( unbound_global_var( 'apple-icon', 'url', true ) ); ?>" sizes="192x192">

			<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( unbound_global_var( 'apple-icon', 'url', true ) ); ?>" />

			<meta name="msapplication-TileImage" content="<?php echo esc_url( unbound_global_var( 'apple-icon', 'url', true ) ); ?>" />

		<?php else : ?>

			<link rel="icon" href="<?php echo esc_url( get_parent_theme_file_uri( '/images/favicon.ico' ) ); ?>" sizes="32x32" />

			<link rel="icon" href="<?php echo esc_url( get_parent_theme_file_uri( '/images/favicon.ico' ) ); ?>" sizes="192x192">

			<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( get_parent_theme_file_uri( '/images/favicon.ico' ) ); ?>" />

			<meta name="msapplication-TileImage" content="<?php echo esc_url( get_parent_theme_file_uri( '/images/favicon.ico' ) ); ?>" />

		<?php endif; ?>

		<?php

	}

}

add_filter( 'wp_head', 'unbound_site_icon' );



add_filter(
	'wp_prepare_attachment_for_js',
	function( $response, $attachment, $meta ) {

		if (

			'image/x-icon' === $response['mime'] &&

			isset( $response['url'] ) &&

			! isset( $response['sizes']['full'] )

		) {

			$response['sizes'] = array(

				'full' => array(

					'url' => $response['url'],

				),

			);

		}

		return $response;

	},
	10,
	3
);



if ( ! function_exists( 'unbound_pagination' ) ) {



	/**

	 * Displays pagination on archive pages
	 */

	function unbound_pagination() {

		global $wp_query;

		$big = 999999999; // need an unlikely integer.

		$paginate_links = paginate_links(
			array(

				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

				'format'    => '?paged=%#%',

				'current'   => max( 1, get_query_var( 'paged' ) ),

				'total'     => $wp_query->max_num_pages,

				'next_text' => esc_html__( 'Next Page &raquo;', 'unbound' ),

				'prev_text' => esc_html__( '&laquo; Previous Page', 'unbound' ),

				'end_size'  => 5,

				'mid_size'  => 5,

				'add_args'  => false,

			)
		);

		// Display the pagination if more than one page is found.
		if ( $paginate_links ) :

			?>



			<div class="pagination clearfix">

				<?php echo wp_kses_post( $paginate_links ); ?>

			</div>



			<?php

		endif;

	}
}



if ( ! function_exists( 'unbound_pagination' ) ) {



	/**

	 * Displays pagination on archive pages
	 */

	function unbound_pagination() {

		global $wp_query;

		$big = 999999999; // need an unlikely integer.

		$paginate_links = paginate_links(
			array(

				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

				'format'    => '?paged=%#%',

				'current'   => max( 1, get_query_var( 'paged' ) ),

				'total'     => $wp_query->max_num_pages,

				'next_text' => esc_html__( 'Next Page &raquo;', 'unbound' ),

				'prev_text' => esc_html__( '&laquo; Previous Page', 'unbound' ),

				'end_size'  => 5,

				'mid_size'  => 5,

				'add_args'  => false,

			)
		);

		// Display the pagination if more than one page is found.
		if ( $paginate_links ) :

			?>



			<div class="pagination clearfix">

				<?php echo wp_kses_post( $paginate_links ); ?>

			</div>



			<?php

		endif;

	}
}





/**

 * Display the breadcrumbs.
 */

function unbound_breadcrumbs() {

	$show_on_home = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show

	if ( ! unbound_global_var( 'breadcrumb_arrow_style', '', false ) ) {

		$delimiter = '<span class="gap"><i class="el el-chevron-right"></i></span>';

	} else {

		$delimiter = '<span class="gap"><i class="' . unbound_global_var( 'breadcrumb_arrow_style', '', false ) . '"></i></span>';

	}

	$home = esc_html__( 'Home', 'unbound' ); // text for the 'Home' link.

	$show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show

	$before = '<span class="current">'; // tag before the current crumb.

	$after = '</span>'; // tag after the current crumb.

	global $post;

	$home_link = get_home_url( 'url' );

	if ( is_home() && is_front_page() ) {

		if ( 1 === $show_on_home ) {

			echo '<div id="crumbs"><a href="' . esc_url( $home_link ) . '">' . esc_html__( 'Home', 'unbound' ) . '</a></div>';

		}
	} elseif ( class_exists( 'woocommerce' ) && ( is_shop() || is_singular( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {

		function my_woocommerce_breadcrumbs() {

			if ( ! unbound_global_var( 'breadcrumb_arrow_style', '', false ) ) {

				$delimiter = '<span class="gap"><i class="el el-chevron-right"></i></span>';

			} else {

				$delimiter = '<span class="gap"><i class="' . unbound_global_var( 'breadcrumb_arrow_style', '', false ) . '"></i></span>';

			}

			return array(

				'delimiter'   => $delimiter,

				'wrap_before' => '<div id="crumbs" itemprop="breadcrumb">',

				'wrap_after'  => '</div>',

				'before'      => '',

				'after'       => '',

				'home'        => _x( 'Home', 'breadcrumb', 'unbound' ),

			);

		}

		add_filter( 'woocommerce_breadcrumb_defaults', 'my_woocommerce_breadcrumbs' );

		woocommerce_breadcrumb();

	} else {

		echo '<div id="crumbs"><a href="' . esc_url( $home_link ) . '">' . esc_html__( 'Home', 'unbound' ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';

		if ( is_home() ) {

			echo wp_kses_post( $before ) . get_the_title( get_option( 'page_for_posts', true ) ) . wp_kses_post( $after );

		} elseif ( is_category() ) {

			$this_cat = get_category( get_query_var( 'cat' ), false );

			if ( 0 != $this_cat->parent ) {

				echo get_category_parents( $this_cat->parent, true, ' ' . wp_kses_post( $delimiter ) . ' ' );

			}

			echo wp_kses_post( $before ) . esc_html__( 'Archive by category "', 'unbound' ) . single_cat_title( '', false ) . '"' . wp_kses_post( $after );

		} elseif ( is_search() ) {

			echo wp_kses_post( $before ) . esc_html__( 'Search results for "', 'unbound' ) . get_search_query() . '"' . wp_kses_post( $after );

		} elseif ( is_day() ) {

			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';

			echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';

			echo wp_kses_post( $before ) . get_the_time( 'd' ) . wp_kses_post( $after );

		} elseif ( is_month() ) {

			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';

			echo wp_kses_post( $before ) . get_the_time( 'F' ) . wp_kses_post( $after );

		} elseif ( is_year() ) {

			echo wp_kses_post( $before ) . get_the_time( 'Y' ) . wp_kses_post( $after );

		} elseif ( class_exists( 'Tribe__Events__Main' ) && ( is_singular( 'tribe_events' ) || ( tribe_is_past() || tribe_is_upcoming() && ! is_tax() ) || ( tribe_is_month() && ! is_tax() ) || ( tribe_is_day() && ! is_tax() ) ) ) {

			echo wp_kses_post( $before ) . esc_html( unbound_global_var( 'event_banner_title', '', false ) ) . wp_kses_post( $after );

		} elseif ( is_single() && ! is_attachment() ) {

			if ( 'post' != get_post_type() ) {

				$post_type = get_post_type_object( get_post_type() );

				$slug = $post_type->rewrite;

				$cpost_label = $slug['slug'];

				$cpost_label = implode( '-', array_map( 'ucfirst', explode( '-', $cpost_label ) ) );

				$cpost_label = str_replace( '-', ' ', $cpost_label );

				if ( 'team' == get_post_type() || 'portfolio' == get_post_type() || 'case-studies' == get_post_type() ) {

					echo '<a href="' . esc_url( $home_link ) . '/' . esc_attr( $slug['slug'] ) . '/">' . esc_html( $cpost_label ) . '</a>';

				} else {

					echo '<a href="' . esc_url( $home_link ) . '/' . esc_attr( $slug['slug'] ) . '/">' . esc_html( $post_type->labels->singular_name ) . '</a>';

				}

				if ( 1 == $show_current ) {

					echo ' ' . wp_kses_post( $delimiter ) . ' ' . wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );

				}
			} else {

				$cat = get_the_category();

				$cat = $cat[0];

				$cats = get_category_parents( $cat, true, ' ' . wp_kses_post( $delimiter ) . ' ' );

				if ( 0 == $show_current ) {

					$cats = preg_replace( "#^(.+)\s$delimiter\s$#", '$1', $cats );

				}

				echo wp_kses_post( $cats );

				if ( 1 == $show_current ) {

					echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );

				}
			}
		} elseif ( ! is_single() && ! is_page() && 'post' != get_post_type() && ! is_404() ) {

			$post_type = get_post_type_object( get_post_type() );

			echo wp_kses_post( $before ) . esc_html( $post_type->labels->singular_name ) . wp_kses_post( $after );

		} elseif ( is_attachment() ) {

			$parent = get_post( $post->post_parent );

			$cat = get_the_category( $parent->ID );

			$cat = $cat[0];

			echo wp_kses_post( get_category_parents( $cat, true, ' ' . $delimiter . ' ' ) );

			echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( $parent->post_title ) . '</a>';

			if ( 1 == $show_current ) {

				echo ' ' . wp_kses_post( $delimiter ) . ' ' . wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );

			}
		} elseif ( is_page() && ! $post->post_parent ) {

			if ( 1 == $show_current ) {

				echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );

			}
		} elseif ( is_page() && $post->post_parent ) {

			$parent_id = $post->post_parent;

			$breadcrumbs = array();

			while ( $parent_id ) {

				$page = get_page( $parent_id );

				$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';

				$parent_id = $page->post_parent;

			}

			$breadcrumbs = array_reverse( $breadcrumbs );

			$count_breadcrumbs = count( $breadcrumbs );

			for ( $i = 0; $i < $count_breadcrumbs; $i++ ) {

				echo wp_kses_post( $breadcrumbs[ $i ] );

				if ( ( count( $breadcrumbs ) - 1 ) != $i ) {

					echo ' ' . wp_kses_post( $delimiter ) . ' ';

				}
			}

			if ( 1 == $show_current ) {

				echo ' ' . wp_kses_post( $delimiter ) . ' ' . wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );

			}
		} elseif ( is_tag() ) {

			echo wp_kses_post( $before ) . esc_html__( 'Posts tagged "', 'unbound' ) . single_tag_title( '', false ) . '"' . wp_kses_post( $after );

		} elseif ( is_author() ) {

			global $author;

			$userdata = get_userdata( $author );

			echo wp_kses_post( $before ) . esc_html__( 'Articles posted by ', 'unbound' ) . esc_html( $userdata->display_name ) . wp_kses_post( $after );

		} elseif ( is_404() ) {

			echo wp_kses_post( $before ) . esc_html__( 'Error 404', 'unbound' ) . wp_kses_post( $after );

		}

		if ( get_query_var( 'paged' ) ) {

			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {

				echo ' (';

			}

			echo esc_html_e( 'Page', 'unbound' ) . ' ' . get_query_var( 'paged' );

			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {

				echo ')';

			}
		}

		echo '</div>';

	}

}



/**

 * [unbound_template_caching description]
 *
 * @param  WP_Screen $current_screen description.
 */

function unbound_template_caching( WP_Screen $current_screen ) {

	// Only flush the file cache with each request to post list table, edit post screen, or theme editor.
	if ( ! in_array( $current_screen->base, array( 'post', 'edit', 'theme-editor' ), true ) ) {

		return;

	}

	$theme = wp_get_theme();

	if ( ! $theme ) {

		return;

	}

	$cache_hash = md5( $theme->get_theme_root() . '/' . $theme->get_stylesheet() );

	$label = sanitize_key( 'files_' . $cache_hash . '-' . $theme->get( 'Version' ) );

	$transient_key = substr( $label, 0, 29 ) . md5( $label );

	delete_transient( $transient_key );

}

add_action( 'current_screen', 'unbound_template_caching' );



/**

 * Undocumented function
 *
 * @param [type] $url check link.
 */

function rt_check_url( $url ) {

	$headers = @get_headers( $url );

	$headers = ( is_array( $headers ) ) ? implode( "\n ", $headers ) : $headers;

	return (bool) preg_match( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );

}
$demo_dir='';
if ( class_exists( 'Radiantthemes_Addons' ) ) {
    $radiantthemes_dir = ABSPATH . 'wp-content/plugins/radiantthemes-addons/';
    $demo_dir = $radiantthemes_dir . 'demo-data/';

    if ( ! file_exists( $demo_dir ) ) {

    	// Create demo-data folder.
    	if ( wp_mkdir_p( $demo_dir ) ) {
    		wp_mkdir_p( $demo_dir );
    	}



    	// Upload files in target folder.
    	$value = 'https://unbound.radiantthemes.com/demo-data/unbound/demo.zip';

    	$get_file = wp_remote_get(
    		$value,
    		array(

    			'timeout'     => 120,

    			'httpversion' => '1.1',

    		)
    	);

    	$upload = wp_upload_bits( basename( $value ), '', wp_remote_retrieve_body( $get_file ) );

    	if ( ! empty( $upload['error'] ) ) {

    		return false;

    	}

    	// unzip demo files.
    	$zip = new ZipArchive();

    	$success_unzip = '';

    	if ( $zip->open( $upload['file'] ) === true ) {

    		$zip->extractTo( $demo_dir . '/' );

    		$zip->deleteAfterUnzip = true;

    		$zip->close();

    		$success_unzip = 'success';

    	} else {

    		$success_unzip = 'failed';

    	}
    }
}

if ( ! function_exists( 'unbound_import_files' ) ) :



	/**

		* [unbound_import_files description]
		*/

	function unbound_import_files() {

		return array(

			array(

				'import_file_name'             => esc_html__( 'All Demos', 'unbound' ),

				'import_file_key'              => 'all-demos',

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/all/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/all/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/all/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/all/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/all-demos.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency One', 'unbound' ),

				'import_file_key'              => 'business-agency-1',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-1/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-1/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-1/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-1/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-1.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-1/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency Two', 'unbound' ),

				'import_file_key'              => 'business-agency-2',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-2/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-2/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-2/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-2/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-2.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-2/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency Three', 'unbound' ),

				'import_file_key'              => 'business-agency-3',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-3/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-3/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-3/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-3/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-3.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-3/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency Four', 'unbound' ),

				'import_file_key'              => 'business-agency-4',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-4/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-4/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-4/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-4/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-4.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-4/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency Five', 'unbound' ),

				'import_file_key'              => 'business-agency-5',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-5/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-5/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-5/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-5/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-5.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-5/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency Six', 'unbound' ),

				'import_file_key'              => 'business-agency-6',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-6/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-6/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-6/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-6/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-6.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-6/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency Seven', 'unbound' ),

				'import_file_key'              => 'business-agency-7',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-7/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-7/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-7/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-7/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-7.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-7/',

			),

			array(

				'import_file_name'             => esc_html__( 'Business Agency Eight', 'unbound' ),

				'import_file_key'              => 'business-agency-8',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-8/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-8/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-8/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/business-agency-8/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/business-agency-8.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/business-agency-8/',

			),

			array(

				'import_file_name'             => esc_html__( 'Marketing Agency', 'unbound' ),

				'import_file_key'              => 'marketing-agency',

				'categories'                   => array( 'Agency' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/marketing-agency/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/marketing-agency/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/marketing-agency/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/marketing-agency/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/marketing-agency.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/marketing-agency/',

			),

			array(

				'import_file_name'             => esc_html__( 'Mobile App', 'unbound' ),

				'import_file_key'              => 'mobile-app',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/mobile-app/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/mobile-app/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/mobile-app/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/mobile-app/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/mobile-app.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/mobile-app/',

			),

			array(

				'import_file_name'             => esc_html__( 'Web Design', 'unbound' ),

				'import_file_key'              => 'web-design',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/web-design/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/web-design/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/web-design/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/web-design/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/web-design.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/web-design/',

			),

			array(

				'import_file_name'             => esc_html__( 'Software Firm', 'unbound' ),

				'import_file_key'              => 'software-firm',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/software-firm/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/software-firm/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/software-firm/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/software-firm/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/software-firm.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/software-firm/',

			),

			array(

				'import_file_name'             => esc_html__( 'Crypto Currency', 'unbound' ),

				'import_file_key'              => 'crypto-currency',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/crypto-currency/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/crypto-currency/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/crypto-currency/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/crypto-currency/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/crypto-currency.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/crypto-currency/',

			),

			array(

				'import_file_name'             => esc_html__( 'Product Showcase', 'unbound' ),

				'import_file_key'              => 'product-showcase',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/product-showcase/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/product-showcase/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/product-showcase/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/product-showcase/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/product-showcase.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/product-showcase/',

			),

			array(

				'import_file_name'             => esc_html__( 'Creative Agency', 'unbound' ),

				'import_file_key'              => 'creative-agency',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/creative-agency.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/creative-agency/',

			),

			array(

				'import_file_name'             => esc_html__( 'Creative Agency Two', 'unbound' ),

				'import_file_key'              => 'creative-agency-2',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-2/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-2/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-2/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-2/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/creative-agency-2.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/creative-agency-2/',

			),

			array(

				'import_file_name'             => esc_html__( 'Creative Agency Three', 'unbound' ),

				'import_file_key'              => 'creative-agency-3',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-3/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-3/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-3/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-3/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/creative-agency-3.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/creative-agency-3/',

			),

			array(

				'import_file_name'             => esc_html__( 'Creative Agency Four', 'unbound' ),

				'import_file_key'              => 'creative-agency-4',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-4/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-4/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-4/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/creative-agency-4/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/creative-agency-4.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/creative-agency-4/',

			),

			array(

				'import_file_name'             => esc_html__( 'Freelancer', 'unbound' ),

				'import_file_key'              => 'freelancer',

				'categories'                   => array( 'Portfolio' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/freelancer/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/freelancer/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/freelancer/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/freelancer/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/freelancer.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/freelancer/',

			),

			array(

				'import_file_name'             => esc_html__( 'Startup Agency', 'unbound' ),

				'import_file_key'              => 'startup-agency',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/startup-agency/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/startup-agency/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/startup-agency/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/startup-agency/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/startup-agency.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/startup-agency/',

			),

			array(

				'import_file_name'             => esc_html__( 'Recruitment Agency', 'unbound' ),

				'import_file_key'              => 'recruitment-agency',

				'categories'                   => array( 'Creative' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/recruitment-agency/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/recruitment-agency/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/recruitment-agency/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/recruitment-agency/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/recruitment-agency.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/recruitment-agency/',

			),

			array(

				'import_file_name'             => esc_html__( 'Photography Agency', 'unbound' ),

				'import_file_key'              => 'photography-agency',

				'categories'                   => array( 'Portfolio' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/photography-agency/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/photography-agency/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/photography-agency/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/photography-agency/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/photography-agency.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/photography-agency/',

			),

			array(

				'import_file_name'             => esc_html__( 'Portfolio Website One', 'unbound' ),

				'import_file_key'              => 'portfolio-website-1',

				'categories'                   => array( 'Portfolio' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-1/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-1/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-1/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-1/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/portfolio-website-1.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/portfolio-website-1/',

			),

			array(

				'import_file_name'             => esc_html__( 'Portfolio Website Two', 'unbound' ),

				'import_file_key'              => 'portfolio-website-2',

				'categories'                   => array( 'Portfolio' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-2/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-2/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-2/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-2/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/portfolio-website-2.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/portfolio-website-2/',

			),

			array(

				'import_file_name'             => esc_html__( 'Portfolio Website Three', 'unbound' ),

				'import_file_key'              => 'portfolio-website-3',

				'categories'                   => array( 'Portfolio' ),

				'local_import_file'            => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-3/content.xml',

				'local_import_widget_file'     => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-3/widgets.wie',

				'local_import_customizer_file' => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-3/customizer.dat',

				'local_import_redux'           => array(

					array(

						'file_path'   => ABSPATH . 'wp-content/plugins/radiantthemes-addons/demo-data/portfolio-website-3/redux.json',

						'option_name' => 'unbound_theme_option',

					),

				),

				'import_preview_image_url'     => '//unbound.radiantthemes.com/demo-data/unbound/import-image/portfolio-website-3.jpg',

				'import_notice'                => esc_html__( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.', 'unbound' ),

				'preview_url'                  => '//unbound.radiantthemes.com/portfolio-website-3/',

			),

		);

	}

	add_filter( 'pt-ocdi/import_files', 'unbound_import_files' );

endif;

if ( ! function_exists( 'unbound_after_import' ) ) :

	/**

		* [unbound_after_import description]
		*
		* @param  [type] $selected_import description.
		*/

	function unbound_after_import( $selected_import ) {

		// Set Menu.
		$main_menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );

		$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

		$full_width_menu = get_term_by( 'name', 'Minimal Header Menu', 'nav_menu' );

		set_theme_mod(
			'nav_menu_locations',
			array(

				'top'             => $main_menu->term_id,

				'footer'          => $footer_menu->term_id,

				'full-width-menu' => $full_width_menu->term_id,

			)
		);

		// Set Front page.
		if ( 'all-demos' === $selected_import['import_file_key'] ) {

			$home_page = get_page_by_title( 'Business Agency 1' );

		} else {

			$home_page = get_page_by_title( 'Home' );

		}

		if ( isset( $home_page->ID ) ) :

			update_option( 'page_on_front', $home_page->ID );

			update_option( 'show_on_front', 'page' );

		endif;

		// Set Blog page.
		$blog_page = get_page_by_title( 'Blog' );

		if ( isset( $blog_page->ID ) ) {

			update_option( 'page_for_posts', $blog_page->ID );

		}

		if ( class_exists( 'RevSlider' ) ) {

					$slider_array = array(

						get_parent_theme_file_path( '/inc/import/web-design/slider.zip' ),

					);

					$slider = new RevSlider();

					foreach ( $slider_array as $filepath ) {

						$slider->importSliderFromPost( true, true, $filepath );

					}

					$slider_array = array(

						get_parent_theme_file_path( '/inc/import/creative-agency/slider.zip' ),

					);

					$slider = new RevSlider();

					foreach ( $slider_array as $filepath ) {

						$slider->importSliderFromPost( true, true, $filepath );

					}
		}

		$old_url        = 'https://unbound.radiantthemes.com';
		$old_url_encode = rawurlencode( 'https://unbound.radiantthemes.com' );

		$new_url        = site_url();
		$new_url_encode = rawurlencode( site_url() );

		$new_link = str_replace( array( 'http://', 'https://', 'www.' ), array( '', '', '' ), site_url() );

		global $wpdb;

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->options SET option_value = replace(option_value, %s, %s) WHERE option_name = 'home' OR option_name = 'siteurl'", $old_url, $new_url ) );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", $old_url, $new_url ) );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", $old_url_encode, $new_url_encode ) );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", $old_url, $new_url ) );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", $old_url_encode, $new_url_encode ) );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = replace(meta_value, %s, %s)", $old_url, $new_url ) );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = replace(meta_value, %s, %s)", $old_url_encode, $new_url_encode ) );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->options SET option_value = REPLACE(option_value, %s, %s) WHERE option_value LIKE %s", 'unbound.radiantthemes.com', $new_link, '%unbound.radiantthemes.com%' ) );

	}

	add_action( 'pt-ocdi/after_import', 'unbound_after_import' );

endif;

add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * Change slug of custom post types
 *
 * @param  [type] $args      description.

 * @param  [type] $post_type description.

 * @return [string]
 */

function unbound_register_post_type_args( $args, $post_type ) {

	if ( 'portfolio' === $post_type ) {

		$args['rewrite']['slug'] = unbound_global_var( 'change_slug_portfolio', '', false );

	}

	if ( 'team' === $post_type ) {

		$args['rewrite']['slug'] = unbound_global_var( 'change_slug_team', '', false );

	}

	if ( 'case-studies' === $post_type ) {

		$args['rewrite']['slug'] = unbound_global_var( 'change_slug_casestudies', '', false );

	}

	return $args;

}

add_filter( 'register_post_type_args', 'unbound_register_post_type_args', 10, 2 );



/**

 * Add new mimes for custom font upload
 */

if ( ! function_exists( 'unbound_upload_mimes' ) ) {

	/**

	 * [unbound_upload_mimes description]
	 *
	 * @param array $existing_mimes description.
	 */

	function unbound_upload_mimes( $existing_mimes = array() ) {

		$existing_mimes['woff'] = 'font/woff';

		$existing_mimes['ttf'] = 'application/x-font-ttf';

		$existing_mimes['svg'] = 'font/svg';

		$existing_mimes['eot'] = 'font/eot';

		return $existing_mimes;

	}
}

add_filter( 'upload_mimes', 'unbound_upload_mimes' );



/**

 * UNWANTED NOTICE REMOVE
 *
 * @return void
 */

function radiantthemes_unwanted_notice_remove() {

	echo '<style type="text/css">.rs-update-notice-wrap,.vc_license-activation-notice{display:none;}</style>';

}

add_action( 'admin_head', 'radiantthemes_unwanted_notice_remove' );



add_action( 'admin_enqueue_scripts', 'enqueue_scripts' );

function enqueue_scripts() {

	$validate_old_theme = get_option( 'radiant_purchase' ) && ! get_option( 'radiant_purchase_validation' ) ? true : false;

	wp_enqueue_style(
		'radiantthemes-admin-styles',
		get_template_directory_uri() . '/inc/radiantthemes-dashboard/css/admin-pages.css'
	);

	wp_enqueue_script(
		'radiantthemes-admin-script',
		get_parent_theme_file_uri( '/inc/radiantthemes-dashboard/js/admin-pages.js' ),
		array( 'jquery' ),
		false,
		true
	);

	wp_localize_script(
		'radiantthemes-admin-script',
		'ajaxObject',
		array(

			'ajaxUrl'            => admin_url( 'admin-ajax.php' ),

			'colornonce'         => wp_create_nonce( 'colorCategoriesNonce' ),

			'validate_old_theme' => $validate_old_theme,

		)
	);

}



add_action( 'admin_menu', 'radiantthemes_dashboard_submenu_page' );

function radiantthemes_dashboard_submenu_page() {

	add_submenu_page(
		'themes.php',
		'RadiantThemes Dashboard',
		'RadiantThemes Dashboard',
		'manage_options',
		'radiantthemes-dashboard',
		'radiantthemes_screen_welcome'
	);

}


/**
 * Welcome Page.
 *
 * @return void
 */
function radiantthemes_screen_welcome() {

	echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';

	require_once get_parent_theme_file_path( '/inc/radiantthemes-dashboard/welcome.php' );

}



add_action( 'admin_menu', 'radiantthemes_plugins_submenu_page' );

/**
 * Install Plugin Submenu.
 *
 * @return void
 */
function radiantthemes_plugins_submenu_page() {

	add_submenu_page(
		'themes.php',
		'Radiantthemes Install Plugins',
		'Radiantthemes Install Plugins',
		'manage_options',
		'radiantthemes-admin-plugins',
		'radiantthemes_screen_plugin'
	);

}


/**
 * Install Plugin page.
 *
 * @return void
 */
function radiantthemes_screen_plugin() {

	echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
	require_once get_parent_theme_file_path( '/inc/radiantthemes-dashboard/install-plugins.php' );

}

/**
 * Video Documentation Submenu.
 *
 * @return void
 */
function radiantthemes_video_submenu_page() {

	add_submenu_page(
		'themes.php',
		'RadiantThemes Videos',
		'RadiantThemes Videos',
		'manage_options',
		'radiantthemes-videos',
		'radiantthemes_screen_videos'
	);

}
add_action( 'admin_menu', 'radiantthemes_video_submenu_page' );

/**
 * Video Documentation Page.
 *
 * @return void
 */
function radiantthemes_screen_videos() {

	echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
	require_once get_parent_theme_file_path( '/inc/radiantthemes-dashboard/video-tutorial.php' );

}

/**
 * Redirect to welcome page.
 */
function after_switch_theme() {

	if ( current_user_can( 'manage_options' ) ) {
		wp_redirect( admin_url( 'themes.php?page=radiantthemes-dashboard' ) );
	}

}
add_action( 'after_switch_theme', 'after_switch_theme' );
