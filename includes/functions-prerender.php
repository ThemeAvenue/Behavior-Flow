<?php
/**
 * @package   Behavior Flow/Prerender
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get link of the page to prerender for a given page
 *
 * @since 0.1.0
 * @param int $post_id ID of the page to prerender from
 *
 * @return string|bool
 */
function bf_get_prerender_page_link( $post_id ) {

	$next = get_post_meta( $post_id, '_bf_page_prerender', true );

	if ( empty( $next ) ) {
		return false;
	}

	// Post to prerender is actually a post
	if ( is_numeric( $next ) ) {
		$next_link = get_permalink( (int) $next );
	}

	// Post to prerender is maybe an archive
	else {

		// Not an archive :(
		if ( false === strpos( $next, 'archive' ) ) {
			return false;
		}

		$post_type_id = str_replace( 'archive_', '', $next );
		$next_link    = get_post_type_archive_link( $post_type_id );

	}

	if ( false === $next_link ) {
		return false;
	}

	return esc_url( $next_link );

}

add_action( 'wp_head', 'bf_prerender_meta_tag' );
/**
 * Output the prerender meta tag
 *
 * @since 0.1.0
 * @return void
 */
function bf_prerender_meta_tag() {

	global $post;

	if ( ! isset( $post ) || ! is_object( $post ) || ! is_a( $post, 'WP_Post' ) ) {
		return;
	}

	$link = bf_get_prerender_page_link( $post->ID );

	if ( false === $link ) {
		return;
	}

	$meta = sprintf( '<link rel="prerender" href="%s" />', $link );

	echo $meta;

}