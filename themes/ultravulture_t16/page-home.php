<?php
/**
 * Customized Home page ... shows only Posts from Portfolio Post Type
 */
get_template_part('header', 'touch-edge'); ?>

<div id="primary" class="content-area full-width">
	<main id="main" class="site-main" role="main">
		
		<?php
		echo uv_portfolio_tag_nav();
		?>
		
		<div class="padded-container">
		
			<?php
			//Standard page content
			//----------------------
			while ( have_posts() ) : the_post();
			?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
				<div class="entry-content">
					<?php
					the_content();
					?>
				</div><!-- .entry-content -->
	
			</article><!-- #post-## -->

			<?php 
			endwhile;
			?>
		
		</div> <!-- .padded-container -->
		
		<?php uv_portfolio(); ?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
