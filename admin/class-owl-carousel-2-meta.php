<?php
class Owl_Carousel_2_Meta {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'add_metabox' )         );
		add_action( 'save_post',             array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		add_meta_box(
			'Carousel_Data',
			__( 'Carousel Data', 'owl-carousel-2' ),
			array( $this, 'render_carousel_data' ),
			'owl-carousel',
			'normal',
			'default'
		);
        
        add_meta_box(
            'owl-items-displayed',
            __('Items Displayed', 'owl-carousel-2'), 
            array($this, 'owl_carousel_items_content'), 
            'owl-carousel',
            'side', 
            'default');
        
    	add_meta_box('owl-shortcode-link', 
            __('Shortcode', 'owl-carousel-2'), 
            array($this, 'owl_carousel_shortcode_link'), 
            'owl-carousel', 
            'side', 
            'high');


	}

	public function render_carousel_data( $post ) {
        
        $args = array(
           'public'   => true,
        );

        $output = 'objects'; // names or objects, note names is the default
        $operator = 'and'; // 'and' or 'or'

        $post_types = get_post_types( $args, $output, $operator ); 
                
		// Retrieve an existing value from the database.
		$dd_owl_post_type = get_post_meta( $post->ID, 'dd_owl_post_type', true );
		$dd_owl_number_posts = get_post_meta( $post->ID, 'dd_owl_number_posts', true );
		$dd_owl_loop = get_post_meta( $post->ID, 'dd_owl_loop', true );
		$dd_owl_center = get_post_meta( $post->ID, 'dd_owl_center', true );
		$dd_owl_mousedrag = get_post_meta( $post->ID, 'dd_owl_mousedrag', true );
        $dd_owl_duration = get_post_meta( $post->ID, 'dd_owl_duration', true );
		$dd_owl_transition = get_post_meta( $post->ID, 'dd_owl_transition', true );
		$dd_owl_stop = get_post_meta( $post->ID, 'dd_owl_stop', true );
		$dd_owl_orderby = get_post_meta( $post->ID, 'dd_owl_orderby', true );
		$dd_owl_navs = get_post_meta( $post->ID, 'dd_owl_navs', true );
		$dd_owl_dots = get_post_meta( $post->ID, 'dd_owl_dots', true );
		$dd_owl_thumbs = get_post_meta( $post->ID, 'dd_owl_thumbs', true );
		$dd_owl_css_id = get_post_meta( $post->ID, 'dd_owl_css_id', true );
		$dd_owl_excerpt_length = get_post_meta( $post->ID, 'dd_owl_excerpt_length', true );
		$dd_owl_margin = get_post_meta( $post->ID, 'dd_owl_margin', true );
		$dd_owl_show_cta = get_post_meta( $post->ID, 'dd_owl_show_cta', true );
		$dd_owl_cta = get_post_meta( $post->ID, 'dd_owl_cta', true );
		$dd_owl_btn_class = get_post_meta( $post->ID, 'dd_owl_btn_class', true );
        $dd_owl_image_options = get_post_meta( $post->ID, 'dd_owl_image_options', true );
		$dd_owl_post_taxonomy_type = get_post_meta( $post->ID, 'dd_owl_post_taxonomy_type', true );
		$dd_owl_post_taxonomy_term = get_post_meta( $post->ID, 'dd_owl_post_taxonomy_term', true );
        $dd_owl_post_ids = get_post_meta( $post->ID, 'dd_owl_post_ids', true );
        $dd_owl_tax_options = get_post_meta( $post->ID, 'dd_owl_tax_options', true );
        $dd_owl_btn_display = get_post_meta( $post->ID, 'dd_owl_btn_display', true );
        $dd_owl_btn_margin = get_post_meta( $post->ID, 'dd_owl_btn_margin', true );
     
		// Set default values.
		if( empty( $dd_owl_post_type ) ) $dd_owl_post_type = '';
		if( empty( $dd_owl_number_posts ) ) $dd_owl_number_posts = '10';
        if( empty( $dd_owl_duration ) ) $dd_owl_duration = '2000';
		if( empty( $dd_owl_transition ) ) $dd_owl_transition = '400';
		if( empty( $dd_owl_orderby ) ) $dd_owl_orderby = '';
		if( empty( $dd_owl_css_id ) ) $dd_owl_css_id = 'carousel-'.$post->ID;
        if (empty( $dd_owl_excerpt_length ) ) $dd_owl_excerpt_length = '20';
        if (empty( $dd_owl_margin ) ) $dd_owl_margin = '10';
        if (empty( $dd_owl_cta ) ) $dd_owl_cta = 'Read More';
        if (empty( $dd_owl_btn_class ) ) $dd_owl_btn_class = 'btn btn-primary';
        if( empty( $dd_owl_image_options ) ) $dd_owl_image_options = 'dd_owl_null';
        if( empty( $dd_owl_post_ids ) ) $dd_owl_post_ids = '';
        if( empty( $dd_owl_tax_options ) ) $dd_owl_tax_options = 'null';
        if( empty( $dd_owl_btn_display ) ) $dd_owl_btn_display = 'inline';

        /**
         * Choose Post Type and Options
         *
         * @since    1.0.0
         */
        echo '<div id="postOptions"><span class="ajax-loader"></span>';
        echo '<h4>Post Type and Post Options</h4>';
        echo '<table class="form-table">';
		echo '	<tr>';
		echo '		<th><label for="dd_owl_post_type" class="dd_owl_post_type_label">' . __( 'Post Type', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';        
        echo '			<select id="dd_owl_post_type" name="dd_owl_post_type" class="dd_owl_post_type_field">';
                foreach ( $post_types  as $post_type ) {
                    if (!in_array($post_type->name, array('page', 'attachment')))    {
		echo '			<option value="'.$post_type->name.'" ';
        echo ($post_type->name === $dd_owl_post_type) ? "selected" : '';
        echo    '> ' . __( $post_type->label, 'owl-carousel-2' ) . '</option>';
                    }
                }
		echo '			</select>';
		echo '			<p class="description">' . __( 'Type of Post', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
        
        
        echo '	<tr id="tax-options">';
		echo '		<th><label for="dd_owl_tax_options" class="dd_owl_tax_options_label">' . __( 'Taxonomy Display Options', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="radio" name="dd_owl_tax_options" class="dd_owl_tax_options_field" value="null" ' . checked( $dd_owl_tax_options, 'null', false ) . '> ' . __( 'None - Show Latest Posts - set number of posts below', 'owl-carousel-2' ) . '</label><br>';
		echo '			<label><input type="radio" name="dd_owl_tax_options" class="dd_owl_tax_options_field" value="taxonomy" ' . checked( $dd_owl_tax_options, 'taxonomy', false ) . '> ' . __( 'By Taxonomy/Category - choose taxonomy below.', 'owl-carousel-2' ) . '</label><br>';
		echo '			<label><input type="radio" name="dd_owl_tax_options" class="dd_owl_tax_options_field" value="postID" ' . checked( $dd_owl_tax_options, 'postID', false ) . '> ' . __( 'By Post ID - Show Post / Product / Custom Post Type by Post ID.', 'owl-carousel-2' ) . '</label><br>';
        echo '			<label class="product-rows"><input type="radio" name="dd_owl_tax_options" class="dd_owl_tax_options_field" value="featured_product" ' . checked( $dd_owl_tax_options, 'featured_product', false ) . '> ' . __( 'Show Featured &#40;Starred&#41; Products', 'owl-carousel-2' ) . '</label><br>';
		echo '		</td>';
		echo '	</tr>';

        echo '	<tr id="choose-postids" class="hidden">';
		echo '		<th><label for="dd_owl_post_ids" class="dd_owl_post_ids_label">' . __( 'Post/Product ID&rsquo;s', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="dd_owl_post_ids" name="dd_owl_post_ids" class="dd_owl_post_ids_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_post_ids ) . '">';
		echo '			<p class="description">' . __( 'Enter the Post/Product ID&rsquo;s in a comma separated list.', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr id="category-row" class="hidden">';
		echo '		<th><label for="dd_owl_post_taxonomy_type" class="dd_owl_post_taxonomy_type_label">' . __( 'Taxonomy Type', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
        echo '      <div id="taxonomy"></div>';
		echo '			<p class="description">' . __( 'Taxonomy &#40;Category, Tag, etc&#41; of Post', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
        
		echo '	<tr id="term-row" class="hidden">';
		echo '		<th><label for="dd_owl_post_taxonomy_term" class="dd_owl_post_taxonomy_term_label">' . __( 'Taxonomy Term', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
        echo '      <div id="taxterm"></div>';
		echo '			<p class="description">' . __( 'Category, Tag, or other term of Post', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
        
        echo '	<tr>';
		echo '		<th><label for="dd_owl_number_posts" class="dd_owl_number_posts_label">' . __( 'Number of Posts', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="dd_owl_number_posts" name="dd_owl_number_posts" class="dd_owl_number_posts_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_number_posts ) . '">';
		echo '			<p class="description">' . __( 'Enter the number of posts to show.  -1 &#40;negative 1&#41; shows all posts.', 'owl-carousel-2' ) . '</p>';
        echo '		</td>';
		echo '	</tr>';
        echo '	<tr>';
		echo '		<th><label for="dd_owl_excerpt_length" class="dd_owl_excerpt_length_label">' . __( 'Post Excerpt Length', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="dd_owl_excerpt_length" name="dd_owl_excerpt_length" class="dd_owl_excerpt_length_field" value="' . esc_attr( $dd_owl_excerpt_length ) . '">';
		echo '			<p class="description">' . __( 'Number of words in the excerpt', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		echo '	<tr>';
		echo '		<th><label for="dd_owl_orderby" class="dd_owl_orderby_label">' . __( 'Order Output', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<select id="dd_owl_orderby" name="dd_owl_orderby" class="dd_owl_orderby_field">';
		echo '			<option value="date_asc" ' . selected( $dd_owl_orderby, 'date_asc', false ) . '> ' . __( ' Date Ascending', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="date_desc" ' . selected( $dd_owl_orderby, 'date_desc', false ) . '> ' . __( 'Date Descending', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="date_rand" ' . selected( $dd_owl_orderby, 'date_rnd', false ) . '> ' . __( 'Date Random', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="title_asc" ' . selected( $dd_owl_orderby, 'title_asc', false ) . '> ' . __( 'Title Ascending', 'owl-carousel-2' ) . '</option>';
        echo '			<option value="title_desc" ' . selected( $dd_owl_orderby, 'title_desc', false ) . '> ' . __( 'Title Descending', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="menu" ' . selected( $dd_owl_orderby, 'menu', false ) . '> ' . __( 'Menu Order', 'owl-carousel-2' ) . '</option>';
		echo '			</select>';
		echo '		</td>';
		echo '	</tr>';
        echo '  </table></div>';
        
        /**
         * Display Post Options - Set Appearance
         *
         * @since    1.0.0
         */
        
        echo '<h4>Display Post Options</h4>';
        echo '<table class="form-table">';
        echo '  <tr>';
		echo '		<th><label for="dd_owl_show_cta" class="dd_owl_show_cta_label">' . __( 'Show Link to Post', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_show_cta" name="dd_owl_show_cta" class="dd_owl_show_cta_field" value="checked" ' . checked( $dd_owl_show_cta, 'checked', false ) . '> ' . __( '', 'text_domain' ) . '</label>';
		echo '		</td>';
        echo '  </tr>';
        // Show button Options
        echo '  <tr class="show-button hidden">';
		echo '		<th><label for="dd_owl_cta" class="dd_owl_cta_label">' . __( 'Button Text', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="dd_owl_cta" name="dd_owl_cta" class="dd_owl_cta_field" placeholder="' . esc_attr__( 'Read More', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_cta ) . '">';
		echo '			<p class="description">' . __( 'Text inside the button', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '		<th><label for="dd_owl_btn_class" class="dd_owl_btn_class_label">' . __( 'Button CSS Class', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="dd_owl_btn_class" name="dd_owl_btn_class" class="dd_owl_btn_class_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_btn_class ) . '">';
		echo '			<p class="description">' . __( 'CSS Class for the button', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';        
        echo '  </tr>';
        echo '  <tr class="show-button hidden">';
		echo '		<th><label for="dd_owl_btn_display" class="dd_owl_btn_display_label">' . __( 'Button CSS Display', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<select id="dd_owl_btn_display" name="dd_owl_btn_display" class="dd_owl_btn_display_field">';
		echo '			<option value="inline" ' . selected( $dd_owl_btn_display, 'inline', false ) . '> ' . __( 'Inline', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="inline-block" ' . selected( $dd_owl_btn_display, 'inline-block', false ) . '> ' . __( 'Inline-Block', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="block" ' . selected( $dd_owl_btn_display, 'block', false ) . '> ' . __( 'Block', 'owl-carousel-2' ) . '</option>';
		echo '			</select>';
		echo '			<p class="description">' . __( 'CSS Display option for the link / Button ', 'owl-carousel-2' ) . '</p>';
        echo '		</td>';
		echo '		<th><label for="dd_owl_btn_margin" class="dd_owl_btn_margin_label">' . __( 'Button CSS margin', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="dd_owl_btn_margin" name="dd_owl_btn_margin" class="dd_owl_btn_margin_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_btn_margin ) . '">';
		echo '			<p class="description">' . __( 'Margins for Button', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';        
        echo '  </tr>';
        // End button display options
		echo '	<tr>';
		echo '		<th><label for="dd_owl_thumbs" class="dd_owl_thumbs_label">' . __( 'Show Post Thumbnails', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_thumbs" name="dd_owl_thumbs" class="dd_owl_thumbs_field" value="checked" ' . checked( $dd_owl_thumbs, 'checked', false ) . '> ' . __( '', 'owl-carousel-2' ) . '</label>';
		echo '		</td>';
		echo '	</tr>';        
        echo '	<tr class="hidden" id="image-options">';
		echo '		<th><label for="dd_owl_image_options" class="dd_owl_image_options_label">' . __( 'Image Display Options', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="radio" name="dd_owl_image_options" class="dd_owl_image_options_field" value="null" ' . checked( $dd_owl_image_options, 'null', false ) . '> ' . __( 'None - Just show image', 'owl-carousel-2' ) . '</label><br>';
		echo '			<label><input type="radio" name="dd_owl_image_options" class="dd_owl_image_options_field" value="lightbox" ' . checked( $dd_owl_image_options, 'lightbox', false ) . '> ' . __( 'Lightbox', 'owl-carousel-2' ) . '</label><br>';
		echo '			<label><input type="radio" name="dd_owl_image_options" class="dd_owl_image_options_field" value="link" ' . checked( $dd_owl_image_options, 'link', false ) . '> ' . __( 'Link to Post', 'owl-carousel-2' ) . '</label><br>';
		echo '		</td>';
		echo '	</tr>';
        echo '</table>';
        
        
        /**
         * Choose Owl Carousel Settings
         *
         * @since    1.0.0
         */
        
        echo '<h4>Carousel Options</h4>';
        echo '<table class="form-table">';
        echo '  <tr>';
		echo '		<th><label for="dd_owl_css_id" class="dd_owl_css_id_label">' . __( 'CSS ID', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="dd_owl_css_id" name="dd_owl_css_id" class="dd_owl_css_id_field" placeholder="' . esc_attr__( 'carousel-'.$post->ID , 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_css_id ) . '">';
		echo '			<p class="description">' . __( 'The CSS ID for the element no spaces please', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
        echo ' </tr>';
        echo ' <tr>';
        echo '		<th><label for="dd_owl_loop" class="dd_owl_loop_label">' . __( 'Loop', 'text_domain' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_loop" name="dd_owl_loop" class="dd_owl_loop_field" value="checked" ' . checked( $dd_owl_loop, 'checked', false ) . '> ' . __( '', 'text_domain' ) . '</label>';
		echo '		</td>';
        echo '		<th><label for="dd_owl_margin" class="dd_owl_margin_label">' . __( 'Margins around Carousel Items', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="dd_owl_margin" name="dd_owl_margin" class="dd_owl_margin_field" value="' . esc_attr( $dd_owl_margin ) . '">';
		echo '			<p class="description">' . __( 'Space between each carousel item in Pixels', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		echo '	<tr>';
		echo '		<th><label for="dd_owl_duration" class="dd_owl_duration_label">' . __( 'Slide Duration', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="dd_owl_duration" name="dd_owl_duration" class="dd_owl_duration_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_duration ) . '">';
		echo '			<p class="description">' . __( 'Duration in ms.', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		echo '	<tr>';
		echo '		<th><label for="dd_owl_transition" class="dd_owl_transition_label">' . __( 'Slide Transition', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="dd_owl_transition" name="dd_owl_transition" class="dd_owl_transition_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_transition ) . '">';
		echo '			<p class="description">' . __( 'Transition Time in ms', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_stop" class="dd_owl_stop_label">' . __( 'Stop on Hover', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_stop" name="dd_owl_stop" class="dd_owl_stop_field" value="checked" ' . checked( $dd_owl_stop, 'checked', false ) . '> ' . __( '', 'owl-carousel-2' ) . '</label>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_navs" class="dd_owl_navs_label">' . __( 'Show Nav Arrows', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_navs" name="dd_owl_navs" class="dd_owl_navs_field" value="checked" ' . checked( $dd_owl_navs, 'checked', false ) . '> ' . __( '', 'owl-carousel-2' ) . '</label>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_dots" class="dd_owl_dots_label">' . __( 'Show Dots', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_dots" name="dd_owl_dots" class="dd_owl_dots_field" value="checked" ' . checked( $dd_owl_dots, 'checked', false ) . '> ' . __( '', 'owl-carousel-2' ) . '</label>';
		echo '		</td>';
		echo '	</tr>';        
		echo '</table>';

	}
    
    public function owl_carousel_items_content($post){
        $items_width1 = intval(get_post_meta($post->ID, 'dd_owl_items_width1', true));
        $items_width2 = intval(get_post_meta($post->ID, 'dd_owl_items_width2', true));
        $items_width3 = intval(get_post_meta($post->ID, 'dd_owl_items_width3', true));
        $items_width4 = intval(get_post_meta($post->ID, 'dd_owl_items_width4', true));
        $items_width5 = intval(get_post_meta($post->ID, 'dd_owl_items_width5', true));
        $items_width6 = intval(get_post_meta($post->ID, 'dd_owl_items_width6', true));
        if ($items_width1 == 0) { $items_width1 = 1; }
        if ($items_width2 == 0) { $items_width2 = 1; }
        if ($items_width3 == 0) { $items_width3 = 2; }
        if ($items_width4 == 0) { $items_width4 = 3; }
        if ($items_width5 == 0) { $items_width5 = 4; }
        if ($items_width6 == 0) { $items_width6 = 6; }

        echo "<div id='items_displayed_metabox'>\n";
        echo "<h4>Browser/Device Width:</h4>\n";
        // items for browser width category 1
        echo "<div><em class='dd_owl_tooltip' href='' title='Up to 479 pixels'></em><span>Mobile Portrait</span><select name='dd_owl_items_width1'>";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $items_width1) {
                echo "<option value='".esc_attr($i)."' selected>".esc_html($i)."</option>";
            } else {
                echo "<option value='".esc_attr($i)."'>".esc_html($i)."</option>";
            }
        }
        echo "</select></div>\n";
        // items for browser width category 2
        echo "<div><em class='dd_owl_tooltip' href='' title='480 to 767 pixels'></em><span>Mobile Landscape</span><select name='dd_owl_items_width2'>";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $items_width2) {
                echo "<option value='".esc_attr($i)."' selected>".esc_html($i)."</option>";
            } else {
                echo "<option value='".esc_attr($i)."'>".esc_html($i)."</option>";
            }
        }
        echo "</select></div>\n";
        // items for browser width category 3
        echo "<div><em class='dd_owl_tooltip' href='' title='768 to 979 pixels'></em><span>Tablet Portrait</span><select name='dd_owl_items_width3'>";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $items_width3) {
                echo "<option value='".esc_attr($i)."' selected>".esc_html($i)."</option>";
            } else {
                echo "<option value='".esc_attr($i)."'>".esc_html($i)."</option>";
            }
        }
        echo "</select></div>\n";
        // items for browser width category 4
        echo "<div><em class='dd_owl_tooltip' href='' title='980 to 1199 pixels'></em><span>Desktop Small</span><select name='dd_owl_items_width4'>";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $items_width4) {
                echo "<option value='".esc_attr($i)."' selected>".esc_html($i)."</option>";
            } else {
                echo "<option value='".esc_attr($i)."'>".esc_html($i)."</option>";
            }
        }
        echo "</select></div>\n";
        // items for browser width category 5
        echo "<div><em class='dd_owl_tooltip' href='' title='1200 to 1499 pixels'></em><span>Desktop Large</span><select name='dd_owl_items_width5'>";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $items_width5) {
                echo "<option value='".esc_attr($i)."' selected>".esc_html($i)."</option>";
            } else {
                echo "<option value='".esc_attr($i)."'>".esc_html($i)."</option>";
            }
        }
        echo "</select></div>\n";
        // items for browser width category 6
        echo "<div><em class='dd_owl_tooltip' href='' title='Over 1500 pixels'></em><span>Desktop X-Large</span><select name='dd_owl_items_width6'>";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $items_width6) {
                echo "<option value='".esc_attr($i)."' selected>".esc_html($i)."</option>";
            } else {
                echo "<option value='".esc_attr($i)."'>".esc_html($i)."</option>";
            }
        }
        echo "</select></div>\n";


        echo "</div>\n";
    }

    public function owl_carousel_shortcode_link($post){
        $post_status = get_post_status($post->ID);
        $allow_shortcodes = (metadata_exists('post', $post->ID, 'dd_owl_shortcodes')) ? get_post_meta($post->ID, 'dd_owl_shortcodes', true) : '1';
        $shortcode = '[dd-owl-carousel id="'.$post->ID.'"]';
        echo "<div id='dd_owl_shortcode'>".esc_html($shortcode)."</div>\n";
        echo "<div id='dd_shortcode_copy' class='button button-primary'>Copy to Clipboard</div>\n";
    }
    
	public function save_metabox( $post_id, $post ) {

		// Sanitize user input.
		$dd_owl_new_post_type = isset( $_POST[ 'dd_owl_post_type' ] ) ? sanitize_text_field( $_POST[ 'dd_owl_post_type' ] ) : '';
        $dd_owl_new_number_posts = isset( $_POST[ 'dd_owl_number_posts' ] ) ? floatval( $_POST[ 'dd_owl_number_posts' ] ) : '';
		$dd_owl_new_loop = isset( $_POST[ 'dd_owl_loop' ] ) ? 'checked'  : '';
		$dd_owl_new_show_cta = isset( $_POST[ 'dd_owl_show_cta' ] ) ? 'checked'  : '';
		$dd_owl_new_center = isset( $_POST[ 'dd_owl_center' ] ) ? 'checked'  : '';
		$dd_owl_new_mousedrag = isset( $_POST[ 'dd_owl_mousedrag' ] ) ? 'checked'  : '';
        $dd_owl_new_duration = isset( $_POST[ 'dd_owl_duration' ] ) ? floatval( $_POST[ 'dd_owl_duration' ] ) : '';
		$dd_owl_new_transition = isset( $_POST[ 'dd_owl_transition' ] ) ? floatval( $_POST[ 'dd_owl_transition' ] ) : '';
		$dd_owl_new_stop = isset( $_POST[ 'dd_owl_stop' ] ) ? 'checked'  : '';
		$dd_owl_new_orderby = isset( $_POST[ 'dd_owl_orderby' ] ) ? $_POST[ 'dd_owl_orderby' ] : '';
		$dd_owl_new_navs = isset( $_POST[ 'dd_owl_navs' ] ) ? 'checked'  : '';
		$dd_owl_new_dots = isset( $_POST[ 'dd_owl_dots' ] ) ? 'checked'  : '';
        $dd_owl_new_thumbs = isset( $_POST[ 'dd_owl_thumbs' ] ) ? 'checked'  : '';
		$dd_owl_new_css_id = isset( $_POST[ 'dd_owl_css_id' ] ) ? sanitize_text_field( $_POST[ 'dd_owl_css_id' ] ) : '';
		$dd_owl_new_cta = isset( $_POST[ 'dd_owl_cta' ] ) ? sanitize_text_field( $_POST[ 'dd_owl_cta' ] ) : '';
		$dd_owl_new_btn_class = isset( $_POST[ 'dd_owl_btn_class' ] ) ? sanitize_text_field( $_POST[ 'dd_owl_btn_class' ] ) : '';
		$dd_owl_new_excerpt_length = isset( $_POST[ 'dd_owl_excerpt_length' ] ) ? floatval( $_POST[ 'dd_owl_excerpt_length' ] ) : '';
		$dd_owl_new_margin = isset( $_POST[ 'dd_owl_margin' ] ) ? floatval( $_POST[ 'dd_owl_margin' ] ) : '';
		$dd_owl_new_image_options = isset( $_POST[ 'dd_owl_image_options' ] ) ? $_POST[ 'dd_owl_image_options' ] : '';
		$dd_owl_new_tax_options = isset( $_POST[ 'dd_owl_tax_options' ] ) ? $_POST[ 'dd_owl_tax_options' ] : '';
		$dd_owl_new_post_taxonomy_type = isset( $_POST[ 'dd_owl_post_taxonomy_type' ] ) ? $_POST[ 'dd_owl_post_taxonomy_type' ] : '';
        $dd_owl_new_post_taxonomy_term = isset( $_POST[ 'dd_owl_post_taxonomy_term' ] ) ? $_POST[ 'dd_owl_post_taxonomy_term' ] : '';
        $dd_owl_new_post_ids = isset( $_POST[ 'dd_owl_post_ids' ] ) ? sanitize_text_field( $_POST[ 'dd_owl_post_ids' ] ) : '';
        $dd_owl_new_btn_display = isset( $_POST['dd_owl_btn_display'] ) ? $_POST['dd_owl_btn_display'] : '';
        $dd_owl_new_btn_margin = isset( $_POST['dd_owl_btn_margin'] ) ? sanitize_text_field( $_POST['dd_owl_btn_margin'] ) : '';


        $dd_owl_new_items_width1 = isset( $_POST['dd_owl_items_width1']) ? abs(intval($_POST['dd_owl_items_width1'])) : '';
        $dd_owl_new_items_width2 = isset( $_POST['dd_owl_items_width2']) ? abs(intval($_POST['dd_owl_items_width2'])) : '';
        $dd_owl_new_items_width3 = isset( $_POST['dd_owl_items_width3']) ? abs(intval($_POST['dd_owl_items_width3'])) : '';
        $dd_owl_new_items_width4 = isset( $_POST['dd_owl_items_width4']) ? abs(intval($_POST['dd_owl_items_width4'])) : '';
        $dd_owl_new_items_width5 = isset( $_POST['dd_owl_items_width5']) ? abs(intval($_POST['dd_owl_items_width5'])) : '';
        $dd_owl_new_items_width6 = isset( $_POST['dd_owl_items_width6']) ? abs(intval($_POST['dd_owl_items_width6'])) : '';
		
        // Update the meta field in the database.
		update_post_meta( $post_id, 'dd_owl_post_type', $dd_owl_new_post_type );
		update_post_meta( $post_id, 'dd_owl_number_posts', $dd_owl_new_number_posts );
		update_post_meta( $post_id, 'dd_owl_loop', $dd_owl_new_loop );
		update_post_meta( $post_id, 'dd_owl_show_cta', $dd_owl_new_show_cta );
		update_post_meta( $post_id, 'dd_owl_center', $dd_owl_new_center );
		update_post_meta( $post_id, 'dd_owl_mousedrag', $dd_owl_new_mousedrag );
        update_post_meta( $post_id, 'dd_owl_duration', $dd_owl_new_duration );
		update_post_meta( $post_id, 'dd_owl_transition', $dd_owl_new_transition );
		update_post_meta( $post_id, 'dd_owl_stop', $dd_owl_new_stop );
		update_post_meta( $post_id, 'dd_owl_orderby', $dd_owl_new_orderby );
		update_post_meta( $post_id, 'dd_owl_navs', $dd_owl_new_navs );
		update_post_meta( $post_id, 'dd_owl_dots', $dd_owl_new_dots );
		update_post_meta( $post_id, 'dd_owl_thumbs', $dd_owl_new_thumbs );
        update_post_meta( $post_id, 'dd_owl_css_id', $dd_owl_new_css_id );
        update_post_meta( $post_id, 'dd_owl_cta', $dd_owl_new_cta );
        update_post_meta( $post_id, 'dd_owl_btn_class', $dd_owl_new_btn_class );
        update_post_meta( $post_id, 'dd_owl_excerpt_length', $dd_owl_new_excerpt_length );
        update_post_meta( $post_id, 'dd_owl_margin', $dd_owl_new_margin );
  		update_post_meta( $post_id, 'dd_owl_image_options', $dd_owl_new_image_options );
        update_post_meta( $post_id, 'dd_owl_post_taxonomy_type', $dd_owl_new_post_taxonomy_type );
		update_post_meta( $post_id, 'dd_owl_post_taxonomy_term', $dd_owl_new_post_taxonomy_term );
		update_post_meta( $post_id, 'dd_owl_post_ids', $dd_owl_new_post_ids );
		update_post_meta( $post_id, 'dd_owl_tax_options', $dd_owl_new_tax_options );
		update_post_meta( $post_id, 'dd_owl_btn_display', $dd_owl_new_btn_display );
		update_post_meta( $post_id, 'dd_owl_btn_margin', $dd_owl_new_btn_margin );
        
        // Update Side Meta Fields
		update_post_meta( $post_id, 'dd_owl_items_width1', $dd_owl_new_items_width1 );
		update_post_meta( $post_id, 'dd_owl_items_width2', $dd_owl_new_items_width2 );
		update_post_meta( $post_id, 'dd_owl_items_width3', $dd_owl_new_items_width3 );
		update_post_meta( $post_id, 'dd_owl_items_width4', $dd_owl_new_items_width4 );
		update_post_meta( $post_id, 'dd_owl_items_width5', $dd_owl_new_items_width5 );
		update_post_meta( $post_id, 'dd_owl_items_width6', $dd_owl_new_items_width6 );

	}

}