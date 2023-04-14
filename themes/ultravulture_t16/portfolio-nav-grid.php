<?php

/**
* Navigate to other Portfolio pieces by thumbnail
* img grid srcest does include the larger 960px size
* Hopefully the customized 'sizes' attribute gives a good enough hint to browsers that that size is not necessary
*/

$q = new WP_Query([
	'post_type'      => 'portfolio',
	'posts_per_page' => 25
]);

if( $q->have_posts() ) {
?>
	<section class="portfolio-grid more">
		
		<?php
		while( $q->have_posts() ) {
			$q->the_post();
			
			printf(
				'<a href="%s">%s</a>',
				get_the_permalink(),
				uv_replace_img_sizes( get_the_post_thumbnail(null, 'medium'), 'small')
			);
		}
		?>
	</section>

<?php

}

wp_reset_postdata();
?>