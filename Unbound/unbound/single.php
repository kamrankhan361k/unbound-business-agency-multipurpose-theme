<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package unbound
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<!-- wraper_blog_main -->
		<section class="wraper_blog_main">
			<div class="container">
				<!-- row -->
				<div class="row">
					<?php if ( 'nosidebar' === unbound_global_var( 'blog-layout', '', false ) ) { ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php } else { ?>
						<?php if ( 'leftsidebar' === unbound_global_var( 'blog-layout', '', false ) ) { ?>
							<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 pull-right">
						<?php } elseif ( 'rightsidebar' === unbound_global_var( 'blog-layout', '', false ) ) { ?>
							<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 pull-left">
						<?php } else { ?>
							<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
						<?php } ?>
					<?php } ?>
						<!-- blog_single -->
						<div class="blog_single">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content-single', get_post_format() );
								endwhile; // End of the loop.
							?>
							<?php if ( true == unbound_global_var( 'display_tags', '', false ) ) : ?>
							<?php
							$tags = get_the_tags( $post->ID );
							if ( ! empty( $tags ) ) {
							?>
								<!-- post-tags -->
								<div class="post-tags">
									<?php
									/* translators: used between list items, there is a space after the comma */
									$tags_list = get_the_tag_list( '', ' ' );
									if ( $tags_list ) {
										printf(
											wp_kses_post( '<strong class="tags-title">Tags:</strong> ' ) .
											/* translators: used between list items, there is a space after the comma */
											esc_html( '%1$s' ) .
											wp_kses_post( '' ),
											wp_kses_post( $tags_list )
										); // WPCS: XSS OK.
									}
									?>
								</div>
								<!-- post-tags -->
							<?php } ?>
							<?php endif; ?>
							<?php if ( true == unbound_global_var( 'display_navigation', '', false ) ) : ?>
							<!-- post-navigation -->
							<div class="navigation post-navigation">
							    <div class="nav-links">
							        <?php
									$prev_post = get_previous_post();
									if ( ! empty( $prev_post ) ) {
										$prev_title = strip_tags( str_replace( '"', '', $prev_post->post_title ) );
										?>
    							        <div class="nav-previous">
    							            <a rel="prev" href="<?php echo get_permalink($prev_post->ID); ?>" title="<?php echo esc_attr( $prev_title ); ?>"><?php echo esc_html__( 'Previous Post', 'unbound' ); ?> <strong><?php echo esc_attr( $prev_title ); ?></strong></a>
    							        </div>
							        <?php } ?>
							        <?php
                                    $next_post = get_next_post();
                                    if ( ! empty( $next_post ) ) {
										$next_title = strip_tags( str_replace( '"', '', $next_post->post_title ) );
										?>
    							        <div class="nav-next">
    							            <a rel="next" href="<?php echo get_permalink($next_post->ID); ?>" title="<?php echo esc_attr( $next_title ); ?>"><?php echo esc_html__( 'Next Post', 'unbound' ); ?> <strong><?php echo esc_attr( $next_title ); ?></strong></a>
    							        </div>
							        <?php } ?>
						        </div>
                            </div>
							<!-- post-navigation -->
							<?php endif; ?>
							<?php if ( true == unbound_global_var( 'display_author_information', '', false ) ) : ?>
								<?php if ( get_the_author_meta( 'description' ) ) : ?>
									<!-- author-bio -->
									<div class="author-bio">
										<div class="holder">
											<div class="pic">
												<?php echo get_avatar( get_the_author_meta( 'email' ), '150' ); ?>
											</div><!-- .pic -->
											<div class="data">
												<p class="designation">
													<?php echo esc_html__( 'Author', 'unbound' ); ?>
												</p>
												<p class="title"><?php the_author_link(); ?></p>
												<?php the_author_meta( 'description' ); ?>
											</div><!-- .data -->
										</div>
									</div>
									<!-- author-bio -->
								<?php endif; ?>
							<?php endif; ?>
							<?php if ( true == unbound_global_var( 'display_related_article', '', false ) ) : ?>
							<!-- related-post-box -->
							<div class="related-post-box">
								<h5 class="title"><?php echo esc_html__( 'Related Articles', 'unbound' ); ?></h5>
								<div class="row">
									<?php
									$related = get_posts(
										array(
											'category__in' => wp_get_post_categories( $post->ID ),
											'numberposts'  => 2,
											'post__not_in' => array( $post->ID ),
										)
									);
									if ( $related ) {
										foreach ( $related as $post ) {
											setup_postdata( $post );
									?>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<!-- related-post-box-item -->
										<div class="related-post-box-item matchHeight">
											<div class="holder">
												<div class="title">
													<p class="date"><?php echo esc_attr( get_the_date() ); ?></p>
													<h6 class="title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h6>
												</div><!-- .title -->
												<div class="data">
													<p><?php echo esc_html( get_the_excerpt() ); ?></p>
												</div><!-- .data -->
												<div class="entry-meta">
													<?php echo esc_html__( 'By', 'unbound' ); ?> <?php echo esc_html( get_the_author() ); ?>
												</div><!-- .entry-meta -->
											</div>
										</div>
										<!-- related-post-box-item -->
									</div>
									<?php
										}
									}
									wp_reset_postdata();
									?>
								</div>
							</div>
							<!-- related-post-box -->
							<?php endif; ?>
							<!-- comments-area -->
							<?php if ( unbound_global_var( 'blog-layout', '', false ) ) : ?>
							<?php if ( unbound_global_var( 'blog_comment_display', '', false ) ) : ?>
								<?php if ( comments_open() || get_comments_number() ) : ?>
									<?php comments_template(); ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php else : ?>
							<?php if ( comments_open() || get_comments_number() ) : ?>
									<?php comments_template(); ?>
								<?php endif; ?>
							<?php endif; ?>
							<!-- comments-area -->
						</div>
						<!-- blog_single -->
					</div>
					<?php if ( 'nosidebar' === unbound_global_var( 'blog-layout', '', false ) ) { ?>
					<?php } else { ?>
						<?php if ( 'leftsidebar' === unbound_global_var( 'blog-layout', '', false ) ) { ?>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pull-left">
						<?php } elseif ( 'rightsidebar' === unbound_global_var( 'blog-layout', '', false ) ) { ?>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pull-right">
						<?php } else { ?>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<?php } ?>
							<?php get_sidebar(); ?>
						</div>
					<?php } ?>
				</div>
				<!-- row -->
			</div>
		</section>
		<!-- wraper_blog_main -->
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
