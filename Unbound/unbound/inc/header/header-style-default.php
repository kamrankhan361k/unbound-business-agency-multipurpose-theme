<?php
/**
 * Template for Default Header
 *
 * @package unbound
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-default">
	<!-- wraper_header_main -->
	<div class="wraper_header_main">
		<div class="container">
			<!-- header_main -->
			<div class="header_main">
				<!-- brand-logo -->
				<div class="brand-logo">
					<?php if ( has_custom_logo() ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php the_custom_logo(); ?></a>
					<?php endif; ?>
				</div>
				<!-- brand-logo -->
				<!-- responsive-nav -->
				<div class="responsive-nav" data-responsive-nav-direction="right" data-responsive-nav-displace="false">
					<i class="fa fa-bars"></i>
				</div>
				<!-- responsive-nav -->
			</div>
			<!-- header_main -->
		</div>
	</div>
	<!-- wraper_header_main -->
</header>
<!-- wraper_header -->


<!-- mobile-menu -->
<div class="mobile-menu hidden">
    <!-- mobile-menu-main -->
    <div class="mobile-menu-main">
        <!-- mobile-menu-close -->
        <div class="mobile-menu-close">
            <i class="fa fa-times"></i>
        </div>
        <!-- mobile-menu-close -->
        <!-- mobile-menu-nav -->
        <nav class="mobile-menu-nav">
        	<?php
        	wp_nav_menu(
        		array(
        			'theme_location' => 'top',
        			'fallback_cb'    => false,
        		)
        	);
        	?>
        </nav>
        <!-- mobile-menu-nav -->
    </div>
    <!-- mobile-menu-main -->
</div>
<!-- mobile-menu -->