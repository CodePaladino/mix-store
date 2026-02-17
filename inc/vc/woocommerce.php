<?php

	$product_columns_deal = array(1, 2, 3, 4);
    vc_map( array(
        "name" => __("WPO Product Deals",TEXTDOMAIN),
        "base" => "wpo_product_deals",
        "class" => "",
        "category" => $this->l('WPO Elements'),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => $this->l('Title'),
                "param_name" => "title",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra class name", TEXTDOMAIN),
                "param_name" => "el_class",
                "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", TEXTDOMAIN)
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Columns count",TEXTDOMAIN),
                "param_name" => "columns_count",
                "value" => $product_columns_deal,
                "admin_label" => true,
                "description" => __("Select columns count.",TEXTDOMAIN)
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Layout",TEXTDOMAIN),
                "param_name" => "layout",
                "value" => array(__('Carousel', TEXTDOMAIN) => 'carousel', __('Grid', TEXTDOMAIN) =>'grid' ),
                "admin_label" => true,
                "description" => __("Select columns count.",TEXTDOMAIN)
            )
        )
    ));
    add_shortcode( 'wpo_product_deals', ('wpo_vc_shortcode_render') );

	/**
	 * wpo_productcategory
	 */
	global $wpdb;
	$sql = "SELECT a.name,a.slug,a.term_id FROM $wpdb->terms a JOIN  $wpdb->term_taxonomy b ON (a.term_id= b.term_id ) where b.count>0 and b.taxonomy = 'product_cat'";
	$results = $wpdb->get_results($sql);
	$value = array();
	foreach ($results as $vl) {
		$value[$vl->name] = $vl->slug;
	}

	$product_layout = array('Grid'=>'grid','List'=>'list','Carousel'=>'carousel', 'Special'=>'special');
	$product_type = array('Best Selling'=>'best_selling','Featured Products'=>'featured_product','Top Rate'=>'top_rate','Recent Products'=>'recent_product','On Sale'=>'on_sale','Recent Review' => 'recent_review' );
	$product_columns = array(6,4, 3, 2, 1);
	$show_tab = array(
	                array('recent', __('Latest Products', TEXTDOMAIN)),
	                array( 'featured_product', __('Featured Products', TEXTDOMAIN )),
	                array('best_selling', __('BestSeller Products', TEXTDOMAIN )),
	                array('top_rate', __('TopRated Products', TEXTDOMAIN )),
	                array('on_sale', __('Special Products', TEXTDOMAIN ))
	            );

	vc_map( array(
	    "name" => __("WPO Product Category",TEXTDOMAIN),
	    "base" => "wpo_productcategory",
	    "class" => "",
	    "category" =>__("Opal Widgets",TEXTDOMAIN),
	    "params" => array(
	    	array(
				"type" => "textfield",
				"class" => "",
				"heading" => __('Title', TEXTDOMAIN),
				"param_name" => "title",
				"value" =>''
			),
	    	array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __('Category', TEXTDOMAIN),
				"param_name" => "category",
				"value" =>$value,
				"admin_label" => true
			),
			array(
				"type" => "dropdown",
				"heading" => __("Style",TEXTDOMAIN),
				"param_name" => "style",
				"value" => $product_layout
			),
			array(
				"type"        => "attach_image",
				"description" => __("Upload an image for categories", TEXTDOMAIN),
				"param_name"  => "image_cat",
				"value"       => '',
				'heading'     => __('Image', TEXTDOMAIN )
			),
			array(
				"type" => "textfield",
				"heading" => __("Number of products to show",TEXTDOMAIN),
				"param_name" => "number",
				"value" => '4'
			),
			array(
				"type" => "dropdown",
				"heading" => __("Columns count",TEXTDOMAIN),
				"param_name" => "columns_count",
				"value" => $product_columns,
				"admin_label" => true,
				"description" => __("Select columns count.",TEXTDOMAIN)
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon",TEXTDOMAIN),
				"param_name" => "icon"
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name",TEXTDOMAIN),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",TEXTDOMAIN)
			)
	   	)
	));
	add_shortcode( 'wpo_productcategory', ('wpo_vc_shortcode_render') );



	/**
	* wpo_category_filter
	*/
	$cats = array();
	$query = "SELECT a.name,a.slug,a.term_id FROM $wpdb->terms a JOIN  $wpdb->term_taxonomy b ON (a.term_id= b.term_id ) where b.count>0 and b.taxonomy = 'product_cat' and b.parent = 0";
	$categories = $wpdb->get_results($query);
	foreach ($categories as $category) {
		$cats[$category->name] = $category->term_id;
	}

	vc_map( array(
			"name"     => __("WPO Product Categories Filter",TEXTDOMAIN),
			"base"     => "wpo_category_filter",
			"class"    => "",
			"category" => __('Opal Widgets', TEXTDOMAIN),
			"params"   => array(

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __('Category', TEXTDOMAIN),
				"param_name" => "term_id",
				"value" =>$cats,
				"admin_label" => true
			),

			array(
				"type"        => "attach_image",
				"description" => __("Upload an image for categories (190px x 190px)", TEXTDOMAIN),
				"param_name"  => "image_cat",
				"value"       => '',
				'heading'     => __('Image', TEXTDOMAIN )
			),

			array(
				"type"       => "textfield",
				"heading"    => __("Number of categories to show",TEXTDOMAIN),
				"param_name" => "number",
				"value"      => '5'
			),

			array(
				"type"        => "textfield",
				"heading"     => __("Extra class name",TEXTDOMAIN),
				"param_name"  => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",TEXTDOMAIN)
			)
	   	)
	));
	add_shortcode( 'wpo_category_filter', ('wpo_vc_shortcode_render')  );



	/**
	 * wpo_products
	 */
	vc_map( array(
	    "name" => __("WPO Products",TEXTDOMAIN),
	    "base" => "wpo_products",
	    "class" => "",
	    "category" => __('Opal Widgets', TEXTDOMAIN),
	    "params" => array(
	    	array(
				"type" => "textfield",
				"heading" => __("Title",TEXTDOMAIN),
				"param_name" => "title",
				"admin_label" => true,
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title font size', TEXTDOMAIN ),
				'param_name' => 'size',
				'value' => array(
					__( 'Large', TEXTDOMAIN ) => 'font-size-lg',
					__( 'Medium', TEXTDOMAIN ) => 'font-size-md',
					__( 'Small', TEXTDOMAIN ) => 'font-size-sm',
					__( 'Extra small', TEXTDOMAIN ) => 'font-size-xs'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title Alignment', TEXTDOMAIN ),
				'param_name' => 'title_align',
				'value' => array(
					__( 'Align left', TEXTDOMAIN ) => 'separator_align_left',
					__( 'Align center', TEXTDOMAIN ) => 'separator_align_center',
					__( 'Align right', TEXTDOMAIN ) => 'separator_align_right'
				)
			),
	    	array(
				"type" => "dropdown",
				"heading" => __("Type",TEXTDOMAIN),
				"param_name" => "type",
				"value" => $product_type,
				"admin_label" => true,
				"description" => __("Select columns count.",TEXTDOMAIN)
			),
			array(
				"type" => "dropdown",
				"heading" => __("Style",TEXTDOMAIN),
				"param_name" => "style",
				"value" => $product_layout
			),
			array(
				"type" => "dropdown",
				"heading" => __("Columns count",TEXTDOMAIN),
				"param_name" => "columns_count",
				"value" => $product_columns,
				"admin_label" => true,
				"description" => __("Select columns count.",TEXTDOMAIN)
			),
			array(
				"type" => "textfield",
				"heading" => __("Number of products to show",TEXTDOMAIN),
				"param_name" => "number",
				"value" => '4'
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name",TEXTDOMAIN),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",TEXTDOMAIN)
			)
	   	)
	));
	add_shortcode( 'wpo_products', ('wpo_vc_shortcode_render')  );

	/**
	 * wpo_all_products
	 */
	vc_map( array(
	    "name" => __("WPO Products Tabs",TEXTDOMAIN),
	    "base" => "wpo_all_products",
	    "class" => "",
	    "category" => __('Opal Widgets', TEXTDOMAIN),
	    "params" => array(
	    	array(
				"type" => "textfield",
				"heading" => __("Title",TEXTDOMAIN),
				"param_name" => "title",
				"admin_label" => true,
				"value" => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title font size', TEXTDOMAIN ),
				'param_name' => 'size',
				'value' => array(
					__( 'Large', TEXTDOMAIN ) => 'font-size-lg',
					__( 'Medium', TEXTDOMAIN ) => 'font-size-md',
					__( 'Small', TEXTDOMAIN ) => 'font-size-sm',
					__( 'Extra small', TEXTDOMAIN ) => 'font-size-xs'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title Alignment', TEXTDOMAIN ),
				'param_name' => 'title_align',
				'value' => array(
					__( 'Align left', TEXTDOMAIN ) => 'separator_align_left',
					__( 'Align center', TEXTDOMAIN ) => 'separator_align_center',
					__( 'Align right', TEXTDOMAIN ) => 'separator_align_right'
				)
			),
			array(
	            "type" => "sorted_list",
	            "heading" => __("Show Tab", "js_composer"),
	            "param_name" => "show_tab",
	            "description" => __("Control teasers look. Enable blocks and place them in desired order.", TEXTDOMAIN),
	            "value" => "recent,featured_product,best_selling",
	            "options" => $show_tab
	        ),
	        array(
				"type" => "dropdown",
				"heading" => __("Style",TEXTDOMAIN),
				"param_name" => "style",
				"value" => $product_layout
			),
			array(
				"type" => "textfield",
				"heading" => __("Number of products to show",TEXTDOMAIN),
				"param_name" => "number",
				"value" => '4'
			),
			array(
				"type" => "dropdown",
				"heading" => __("Columns count",TEXTDOMAIN),
				"param_name" => "columns_count",
				"value" => $product_columns,
				"admin_label" => true,
				"description" => __("Select columns count.",TEXTDOMAIN)
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name",TEXTDOMAIN),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",TEXTDOMAIN)
			)
	   	)
	));

	/**
	 * wpo_brands
	 */
	vc_map( array(
	    "name" => __("WPO Brands", TEXTDOMAIN ),
	    "base" => "wpo_brands",
	    "class" => "",
	    "category" => __('Opal Widgets', TEXTDOMAIN),
	    "params" => array(
	    	array(
				"type" => "textfield",
				"heading" => __("Title",TEXTDOMAIN),
				"param_name" => "title",
				"value" => '',
				"admin_label" => true
			),
			array(
				"type" => "textfield",
				"heading" => __("Number of brands to show",TEXTDOMAIN),
				"param_name" => "number",
				"value" => '6'
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon",TEXTDOMAIN),
				"param_name" => "icon"
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name",TEXTDOMAIN),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",TEXTDOMAIN)
			)
	   	)
	));
	add_shortcode( 'wpo_brands', ('wpo_vc_shortcode_render')  );

	vc_map( array(
		"name"     => __("WPO Product Categories List",TEXTDOMAIN),
		"base"     => "wpo_category_list",
		"class"    => "",
		"category" => __('Opal Widgets', TEXTDOMAIN),
		"params"   => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Title', TEXTDOMAIN),
			"param_name" => "title",
			"value"      => '',
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Show post counts', TEXTDOMAIN ),
			'param_name' => 'show_count',
			'description' => __( 'Enables show count total product of category.', TEXTDOMAIN ),
			'value' => array( __( 'Yes, please', TEXTDOMAIN ) => 'yes' )
		),
		array(
			"type"       => "checkbox",
			"heading"    => __("show children of the current category",TEXTDOMAIN),
			"param_name" => "show_children",
			'description' => __( 'Enables show children of the current category.', TEXTDOMAIN ),
			'value' => array( __( 'Yes, please', TEXTDOMAIN ) => 'yes' )
		),
		array(
			"type"       => "checkbox",
			"heading"    => __("Show dropdown children of the current category ",TEXTDOMAIN),
			"param_name" => "show_dropdown",
			'description' => __( 'Enables show dropdown children of the current category.', TEXTDOMAIN ),
			'value' => array( __( 'Yes, please', TEXTDOMAIN ) => 'yes' )
		),

		array(
			"type"        => "textfield",
			"heading"     => __("Extra class name",TEXTDOMAIN),
			"param_name"  => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.",TEXTDOMAIN)
		)
   	)
));
add_shortcode( 'wpo_category_list', ('wpo_vc_shortcode_render')  );
?>