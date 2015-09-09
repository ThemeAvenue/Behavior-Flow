<?php
/**
 * @package   Behavior Flow
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'add_meta_boxes', 'bf_register_page_prerender_metabox' );
/**
 * Register the page selection dropdown metabox
 *
 * @since 0.1.0
 * @return void
 */
function bf_register_page_prerender_metabox() {

	$screens = BF()->post_types;

	foreach ( $screens as $slug => $name ) {

		add_meta_box(
			'bf_page_prerender_metabox',
			__( 'Page to Prerender', 'behavior-flow' ),
			'bf_page_prerender_metabox_content',
			$slug,
			'side',
			'default'
		);

	}

}

/**
 * Metabox content
 *
 * @since 0.1.0
 * @return void
 */
function bf_page_prerender_metabox_content() {
	require_once( BH_PATH . 'includes/admin/views/metabox-pages.php' );
}

add_action( 'save_post', 'bf_save_page_prerender_metabox_data' );
/**
 * When the post is saved, saves our custom data.
 *
 * @since 0.1.0
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return void
 */
function bf_save_page_prerender_metabox_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['bf_mb_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['bf_mb_nonce'], 'bf_mb_save' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && ! array_key_exists( $_POST['post_type'], BF()->post_types ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['bf_next_page'] ) ) {
		delete_post_meta( $post_id, '_bf_page_prerender' );
		return;
	}

	// Sanitize user input.
	$prerender = sanitize_text_field( $_POST['bf_next_page'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_bf_page_prerender', $prerender );

}