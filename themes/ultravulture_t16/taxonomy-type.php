<?php
/**
 * Customized Home page ... shows only Posts from Portfolio Post Type
 */
get_template_part('header', 'touch-edge'); ?>

<div id="primary" class="content-area full-width">
	<main id="main" class="site-main" role="main">
		
		<?=uv_portfolio_tag_nav();?>
		
		<header class="portfolio">
			<h1>Work &rarr; <span><?=esc_html( ucfirst(get_query_var('type')) );?></span></h1>
		</header>
		
		<?php
		/* Portfolio pieces for this type
		=================================== */
		uv_portfolio([
			'type' => get_query_var('type')
		]);
		?>
		
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
