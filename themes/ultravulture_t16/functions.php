<?php
add_action('after_theme_setup', function() {
	remove_theme_support('custom-header');
});


/**
* Responsive Image SIZES attribute helper
* replace default attribute which knows nothing of Media Queries and expected widths
* @param string $markup
* @param string $newSizes flag big|small or Media Query rules to put in markup
* @return string
*/
function uv_replace_img_sizes($markup, $newSizes = 'small') {
	
	//Named FLAGS for $newSizes
	//--------------------------
	if($newSizes === 'big') {
		$newSizes = '(max-width: 800px) 50vw, 34vw';
	}
	else if($newSizes === 'small') {
		$newSizes = '(max-width: 800px) 50vw, (max-width: 2400px) 20vw, 17vw';
	}
	
	
	return preg_replace('/sizes="([a-zA-Z0-9, :\-\(\)]+)"/', "sizes=\"$newSizes\"", $markup);
	
}

//set true for live
//where is my GIT
//CSS build would be broken fo sure
function uv_logo_path($cdn = true) {
	
	if($cdn) {
		return 'https://d3lelize76uef8.cloudfront.net';
	}
	return get_stylesheet_directory_uri();
}

/**
* Show Portfolio Grid for home page or Tag/Category
*/
function uv_portfolio($args = null) {
	
	if($args === null) {
		$args = [
			'post_type' => 'portfolio',
			'posts_per_page' => 12
		];
	}
	
	if(!isset($args['post_type']))      $args['post_type'] = 'portfolio';
	if(!isset($args['posts_per_page'])) $args['posts_per_page'] = 12;

	//Pagination
	$args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
	
	$q = new WP_Query($args);

	if ( $q->have_posts() ) {

		echo '<section class="portfolio-grid">';

		while ( $q->have_posts() ) {
			$q->the_post();

			printf(
				'<a href="%s" title="%s">%s</a>',
				get_post_permalink(),
				get_the_title(),
				uv_replace_img_sizes( get_the_post_thumbnail(null, 'hiresthumb'), 'big' )
			);

		}

		echo '</section>'; // <!-- /.portfolio-grid -->

		//Manual because next_posts_link() depends on main Loop
		echo uv_page_links($args['paged'], $q->max_num_pages);

	} else {

		echo '<p>Aw shit, looks like I haven&rsquo;t made anything yet&hellip;</p>';
	}
	
	wp_reset_postdata();
}

function uv_page_links($current, $pages) {

	$out = "<nav class='uv-pages'>";

	if($current > 1) {
		$to = $current-1;
		$out .= sprintf("<a href='%s'>&larr; Previous</a> ", site_url('page/' . $to));
	}

	if($current < $pages) {
		$to = $current+1;
		$out .= sprintf("<a href='%s'>Next &rarr;</a>", site_url('page/' . $to));
	}

	return $out . "</nav>\n\n";
}


/**
* Get <nav> to preferred Portfolio tags
* NB: Scraps use 'type' taxonomy too; avoid sharing tags to avoid having scraps show up in portfolio
*/
function uv_portfolio_tag_nav() {

	return sprintf(
		"<nav class='portfolio-tags'>
		<a href='%s'>Illustration</a>
		<a href='%s'>Typographic</a>
		<a href='%s'>Abstract</a>
		</nav>",
		esc_url( get_term_link(6, 'type') ),
		esc_url( get_term_link(7, 'type') ),
		esc_url( get_term_link(4, 'type') )
	);
	
}


/**
* Stylesheet from Cloudfront with non-query string version bump
* (manually copy & rename style.css after compile)
*/
$cdn = true;

if($cdn) {
	
	add_filter('stylesheet_uri', function() {
		return  'https://d3lelize76uef8.cloudfront.net/style_263.min.css';
	}, 10, 2);

	//New Genericons, CDN
	//Browser would use ?v=, but Cloudfront ignores it on current config
	add_action('init', function() {
		wp_enqueue_style( 'genericons', 'https://d3lelize76uef8.cloudfront.net/genericons/genericons_7b44.css', null, null);
	});
}

//LOCAL FILES
else {
	add_action('init', function() {
		wp_enqueue_style( 'genericons', get_stylesheet_directory_uri().'/genericons/genericons.css', null, '7b44');
	});
}

//Custom JS
add_action('init', function() {
	wp_register_script('ultravulture', get_stylesheet_directory_uri().'/js/ultrav.js', '[jquery]', null, true);
	
	//Not queued, because the code in there is junk
	//wp_enqueue_script('ultravulture');
});




/**
* Google Analytics
*/
add_filter('wp_head', function() {
	
	if( current_user_can('edit_posts') ) {
		echo "<!-- Analytics Off: Logged in -->\n\n";
		return;
	}
	
echo <<<EOD
<!-- Google Tag Manager -->

<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5CMG9C"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5CMG9C');</script>

<!-- /Google Tag Manager -->

EOD;
	
});

/**
* Analytics Event tracking
*/
add_filter('wp_footer', function() {
	
echo <<<EOD
<script>

	//Analytics Events
	(function() {
		if( typeof jQuery === 'undefined' ) {
			return;
		}
		
		if( typeof ga === 'undefined' ) {
			return;
		}
		
		//Buy Links
		jQuery('a.buy').on('click', function(ev) {
			var title = ev.currentTarget.title;
			ga('send', 'event', 'Portfolio', 'Buy Click', title);
		});
		
		//Social Media clicks
		jQuery('ul.social-links-menu').on('click', 'a', function(ev) {
			var network = null;
			var lookFor = ['Twitter', 'Facebook', 'Instagram', 'Dribbble'];
			
			for(i=0; i<lookFor.length; i++) {
				if( this.href.search(lookFor[i].toLowerCase() ) != -1) {
					network = lookFor[i];
					break;
				}
			}
			
			if(network !== null) {
				ga('send', 'event', 'Social', 'click', network);
			}
		});
	})();
</script>

EOD;
}, 35);


/* --- WooCommerce Customisations ---
------------------------------------ */

# loop_shop_columns failed. Use customiser


add_theme_support( 'woocommerce', [
	'thumbnail_image_width' => 540,
	'single_image_width' => 322,
]);
