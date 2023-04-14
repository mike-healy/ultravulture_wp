<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

		?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<div class="portfolio-image">
				<?php
				printf(
					'<a href="%s" rel="lightbox[piece]">%s</a>',
					wp_get_attachment_image_src( get_post_thumbnail_id(null), 'large' )[0],
					get_the_post_thumbnail(null, 'large')
				)
				?>
			</div> <!-- /.portfolio-image -->
			
			<div class="portfolio-other">
				<?php
				the_content();
				
				$shop = get_post_meta( get_the_ID(), 'shop_url', true );
				if($shop) {
					printf(
						'<p><a href="%s" title="%s" class="buy" target="shop">Buy Print</a><p>',
						esc_url($shop),
						esc_attr(get_the_title())
					);
				}
				
				//Like this page on Facebook
				echo do_shortcode( '[mh_facebook_like_this]' );
				
				?>
			</div> <!-- /.portfolio-other -->
			
			<!-- <div class="entry-content">
			</div> .entry-content -->
			
		</article><!-- #post-## -->

		<?php
			// End of the loop.
		endwhile;
		
		//GET SWEET GRAPHICAL NAV TO OTHER PIECES
		//so we don't have to click back like a chump!
		get_template_part('portfolio-nav', 'grid');
		
		?>

	</main><!-- .site-main -->



</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
