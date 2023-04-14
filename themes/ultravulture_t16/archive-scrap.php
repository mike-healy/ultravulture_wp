<?php
/**
 * Scraps, images & lightbox. No inner pages.
 */
get_template_part('header', 'touch-edge'); ?>

<div id="primary" class="content-area full-width">
	<main id="main" class="site-main" role="main">
		
		<div class="padded-container">
			<h1>Scraps</h1>
			<p>Quick &amp; rough</p>
		</div>
		
		<?php
		
		// Scraps
		//--------
		$q = new WP_Query([
			'post_type' => 'scrap',
			'posts_per_page' => 60
		]);
		
		if ( $q->have_posts() ) {
			
			echo '<section class="portfolio-grid more">';
			
			while ( $q->have_posts() ) {
				$q->the_post();

				$large = wp_get_attachment_image_src( get_post_thumbnail_id(null), 'large' );
				if( $large[0] ) {
					$large = esc_url($large[0]);
				} else {
					$large = '#';
				}
				
				printf(
					'<a href="%s" title="%s" rel="lightbox[scrap]">%s</a>', //Lightbox this
					$large,
					get_the_title(),
					uv_replace_img_sizes( get_the_post_thumbnail(null, 'medium') )
				);
			}
			
			echo '</section>'; // <!-- /.portfolio-grid -->
				
		} else {
			
			echo '<p>Aw shit, looks like I haven&rsquo;t made anything yet&hellip;</p>';
		}

		wp_reset_postdata();
		?>
		
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
