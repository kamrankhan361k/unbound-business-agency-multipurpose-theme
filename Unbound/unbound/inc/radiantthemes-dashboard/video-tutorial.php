<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$radiantthemes_my_theme = wp_get_theme();
if( $radiantthemes_my_theme->parent_theme ) {
	$radiantthemes_my_theme = wp_get_theme( basename( get_template_directory() ) );
}
?>

<div class="wrap about-wrap rt-admin-wrap">

	<h1><?php echo esc_html__( 'Welcome to ', 'unbound' ) . $radiantthemes_my_theme->Name; ?></h1>
	<div class="about-text"><?php echo esc_html( $radiantthemes_my_theme->Name ) . esc_html__( ' is now installed and ready to use!', 'unbound' ); ?></div>
	<div class="wp-badge"><?php printf( esc_html__( 'Version %s', 'unbound' ), esc_html( $radiantthemes_my_theme->Version ) ); ?></div>

	<h2 class="nav-tab-wrapper wp-clearfix">
		<a class="nav-tab" href="<?php echo esc_url( self_admin_url( 'themes.php?page=radiantthemes-dashboard' ) ); ?>"><?php esc_html_e( 'Dashboard', 'unbound' ); ?></a>
		<a class="nav-tab" href="<?php echo esc_url( self_admin_url( 'themes.php?page=radiantthemes-admin-plugins' ) ); ?>"><?php esc_html_e( 'Install Plugins', 'unbound' ); ?></a>
		<?php if ( class_exists( 'OCDI_Plugin' ) ) { ?>
			<a class="nav-tab" href="<?php echo esc_url( self_admin_url( 'themes.php?page=pt-one-click-demo-import' ) ); ?>"><?php esc_html_e( 'Demo Importer', 'unbound' ); ?></a>
		<?php } ?>
		<?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
			<a class="nav-tab" href="<?php echo esc_url( self_admin_url( 'admin.php?page=_options' ) ); ?>"><?php esc_html_e( 'Theme Options', 'unbound' ); ?></a>
		<?php } ?>
		<a class="nav-tab nav-tab-active" href="<?php echo esc_url( self_admin_url( 'themes.php?page=radiantthemes-videos' ) ); ?>"><?php esc_html_e( 'Video Tutorials', 'unbound' ); ?></a>
	</h2>

	<div id="radiantthemes-dashboard" class="wrap about-wrap">
		<div class="welcome-content w-clearfix extra">
			<div class="w-row">
					<div class="w-col-sm-6">
						<div class="w-box text-center">
							<div class="w-box-head">
								<?php esc_html_e('Theme Documentation','unbound'); ?>
							</div>
							<div class="w-box-content">
								<div class="w-button">
									<a href="http://themes.radiantthemes.com/unbound/docs/" target="_blank"><?php esc_html_e('DOCUMENTATION','unbound'); ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="w-col-sm-6">
						<div class="w-box text-center">
							<div class="w-box-head">
								<?php esc_html_e('Theme Support','unbound'); ?>
							</div>
							<div class="w-box-content">
								<div class="w-button">
									<a href="https://support.radiantthemes.com/open.php" target="_blank"><?php esc_html_e('OPEN SUPPORT TICKET','unbound'); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<div class="w-row">
				<div class="w-col-sm-6">
					<div class="w-box doc">
						<iframe width="100%" height="315" src="https://www.youtube.com/embed/kRyhlqVCI9E" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
				</div>
				<div class="w-col-sm-6">
					<div class="w-box doc">
						<iframe width="100%" height="315" src="https://www.youtube.com/embed/munvFZKIV0w" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>

</div> <!-- end wrap -->