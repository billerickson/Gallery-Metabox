<?php
/*
Plugin Name: Gallery Metabox
Plugin URI: http://wordpress.org/extend/plugins/gallery-metabox/
Description: Displays all the post's attached images on the Edit screen
Author: Bill Erickson
Version: 1.4
Author URI: http://www.billerickson.net
*/

/**
 * Translations
 * @since 1.0
 *
 * @author Bill Erickson
 */
function be_gallery_metabox_translations() {
	load_plugin_textdomain( 'gallery-metabox', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'be_gallery_metabox_translations' );


/**
 * Add the Metabox
 * @since 1.0
 *
 * @author Bill Erickson
 */
function be_gallery_metabox_add() {
	// Filterable metabox settings. 
	$post_types = apply_filters( 'be_gallery_metabox_post_types', array( 'post', 'page') );
	$context = apply_filters( 'be_gallery_metabox_context', 'normal' );
	$priority = apply_filters( 'be_gallery_metabox_priority', 'high' );
	
	// Loop through all post types
	foreach( $post_types as $post_type ) {
		
		// Get post ID
		if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
		elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
		if( !isset( $post_id ) ) $post_id = false;
		
		// Granular filter so you can limit it to single page or page template
		if( apply_filters( 'be_gallery_metabox_limit', true, $post_id ) )
			add_meta_box( 'be_gallery_metabox', __( 'Gallery Images', 'gallery-metabox' ), 'be_gallery_metabox', $post_type, $context, $priority );

	}
}
add_action( 'add_meta_boxes', 'be_gallery_metabox_add' );

/**
 * Build the Metabox
 * @since 1.0
 *
 * @param object $post
 *
 * @author Bill Erickson
 */
function be_gallery_metabox( $post ) {
	
	$original_post = $post;
	echo be_gallery_metabox_html( $post->ID );
	$post = $original_post;
}

/** 
 * Gallery Metabox HTML 
 * @since 1.3
 *
 * @param int $post_id
 * @return string html output 
 *
 * @author Bill Erickson
 */
function be_gallery_metabox_html( $post_id ) {

	$args = array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'post_parent' => $post_id,
		'post_mime_type' => 'image',
		'posts_per_page' => '-1',
		'order' => 'ASC',
		'orderby' => 'menu_order',
	);
	$args = apply_filters( 'be_gallery_metabox_args', $args );
	$return = '';
	
	$intro = '<p><a href="media-upload.php?post_id=' . $post_id .'&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=715" id="add_image" class="thickbox" title="' . __( 'Add Image', 'gallery-metabox' ) . '">' . __( 'Upload Images', 'gallery-metabox' ) . '</a> | <a href="media-upload.php?post_id=' . $post_id .'&amp;type=image&amp;tab=gallery&amp;TB_iframe=1&amp;width=640&amp;height=715" id="manage_gallery" class="thickbox" title="' . __( 'Manage Gallery', 'gallery-metabox' ) . '">' . __( 'Manage Gallery', 'gallery-metabox' ) . '</a></p>';
	$return .= apply_filters( 'be_gallery_metabox_intro', $intro );

	
	$loop = get_posts( $args );
	if( empty( $loop ) )
		$return .= '<p>No images.</p>';
			
	foreach( $loop as $image ):
		$thumbnail = wp_get_attachment_image_src( $image->ID, apply_filters( 'be_gallery_metabox_image_size', 'thumbnail' ) );
		$return .= apply_filters( 'be_gallery_metabox_output', '<img src="' . $thumbnail[0] . '" alt="' . $image->post_title . '" title="' . $image->post_content . '" /> ', $thumbnail[0], $image );
	endforeach;

	return $return;
}

/**
 * Gallery Metabox - Do AJAX Update
 * @since 1.3
 *
 * This function will add metabox contents via Ajax call. Function is called when an
 * attachment is edited, so we can add/remove image from metabox without refreshing the page.
 *
 * @param object $form_fields
 * @param object $post
 *
 * @author Zlatko Salbut
 *
 */
function be_gallery_metabox_do_ajax_update( $form_fields, $post ) {
	?>
	<script type="text/javascript">
	    // <![CDATA[
	    jQuery.ajax({
		    url: "<?php echo admin_url( 'admin-ajax.php' );?>",
		    type: "POST",
		    data: "action=refresh_metabox&post_id=<?php echo $post->post_parent; ?>",
		    success: function(res) {
				jQuery('#be_gallery_metabox .inside', top.document).html(res);
		    },
		    error: function(request, status, error) {
				alert("There was an error! Please try again.");
		    }
	   });
	   // ]]>
    </script>
	<?php
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'be_gallery_metabox_do_ajax_update', 10, 2 );

/**
 * Gallery Metabox AJAX Update
 * @since 1.3
 *
 * Ajax hook for refreshing contents of Gallery Metabox
 *
 * @return void
 *
 * @author Zlatko Salbut
 */
function be_gallery_metabox_ajax_update() {
	if ( !empty( $_POST['post_id'] ) )
	    die( be_gallery_metabox_html( $_POST['post_id'] ) );
}

add_action( 'wp_ajax_refresh_metabox', 'be_gallery_metabox_ajax_update' );