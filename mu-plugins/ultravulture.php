<?php

/**
* Ultra Vulture Custom Post Types and Taxonomies
*
* @version 2015-11-08
*/


class UltraVultureStructure {
    
    public function registerPostTypes() {
        
        //Portfolio Work -- better finished pieces
        register_post_type(
            'portfolio',
            [
                'labels' => ['name'=>'Portfolio', 'singular_name'=>'Work', 'add_new' => 'Add New Work'],
                'public' => true,
				'has_archive' => true,
                'menu_position' => 5,
                'hierarchical' => false,
                'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes'],
                'permalink_epmask' => 'work'
            ]
        );
        
        //Scraps -- misc imagery and process
        register_post_type(
            'scrap',
            [
                'labels' => ['name'=>'Scraps', 'singular_name'=>'Scrap', 'add_new' => 'Add Scrap'],
                'public' => true,
				'has_archive' => true,
                'menu_position' => 6,
                'hierarchical' => false,
                'supports' => ['title', 'thumbnail'],
				'rewrite' => ['slug' => 'scraps']
            ]
        );
    }

	//Non-hierarchical like shop, abstract, lettering, 3d, etc.
    public function registerTaxonomies() {
        register_taxonomy('type', ['portfolio', 'scrap']);
    }
}


add_filter('init', function() {

    $structure = new UltraVultureStructure();
    $structure -> registerPostTypes();
    $structure -> registerTaxonomies();
	
	
	/* Media Sizes
	----------------
	Original	(resize to <2000px before upload)
	Large:		<=1200px longest, no crop. Used for actual-ratio preview
	hiresthumb	960x600
	medium
	thumb		(configured in WP Admin)
    */
	update_option( 'medium_crop', 1 );
	
	add_image_size('hiresthumb', 960, 600, true);
	
});