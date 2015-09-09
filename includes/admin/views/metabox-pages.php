<?php
/**
 * @package   Behavior Flow/Metabox
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $post;

$post_types = BF()->post_types;
$pt_slugs   = array();

foreach ( $post_types as $pt_slug => $pt_name ) {
	array_push( $pt_slugs, $pt_slug );
}

$args    = array( 'post_type' => $pt_slugs, 'posts_per_page' => 500, 'post_status' => 'publish' );
$pages   = new WP_Query( $args );
$value   = isset( $post ) && is_object( $post ) && is_a( $post, 'WP_Post' ) ? (int) get_post_meta( $post->ID, '_bf_page_prerender', true ) : '';
$ordered = array();

foreach ( $pages->posts as $page ) {

	if ( ! array_key_exists( $page->post_type, $ordered ) ) {
		$ordered[ $page->post_type ] = array();
	}

	$ordered[ $page->post_type ][ $page->ID ] = $page->post_title;

}
?>

<p><?php _e( 'Choose the page that visitors usually visit after this one. We will then prerender the page you selected.', 'behavior-flow' ); ?></p>
<label class="screen-reader-text" for="bf_next_page"><?php _e( 'Next Page', 'behavior-flow' ); ?></label>
<select name="bf_next_page" id="bf_next_page">
	<option value=""><?php _e( 'No prerender', 'behavior-flow' ); ?></option>
	<?php
	foreach ( $ordered as $group_id => $group ) {

			printf( '<optgroup label="%s">', $post_types[ $group_id ] );

			foreach ( $group as $post_id => $post_title ) {
				$selected = $value === $post_id ? 'selected="selected"' : '';
				printf( '<option value="%s" %s>%s</option>', $post_id, $selected, $post_title );
			}

			echo '</optgroup>';
		}
	?>
</select>
<?php wp_nonce_field( 'bf_mb_save', 'bf_mb_nonce' ); ?>