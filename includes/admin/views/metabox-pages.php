<?php
/**
 * @package   Behavior Flow/Metabox
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 */

global $post;

$args  = array( 'post_type' => BF()->post_types, 'posts_per_page' => 500, 'post_status' => 'publish' );
$pages = new WP_Query( $args );
$value = isset( $post ) && is_object( $post ) && is_a( $post, 'WP_Post' ) ? (int) get_post_meta( $post->ID, '_bf_page_prerender', true ) : '';
?>

<p><?php _e( 'Choose the page that visitors usually visit after this one. We will then prerender the page you selected.', 'behavior-flow' ); ?></p>
<label class="screen-reader-text" for="bf_next_page"><?php _e( 'Next Page', 'behavior-flow' ); ?></label>
<select name="bf_next_page" id="bf_next_page">
	<option value=""><?php _e( 'No prerender', 'behavior-flow' ); ?></option>
	<?php
	foreach ( $pages->posts as $post ) {
		$selected = $value === $post->ID ? 'selected="selected"' : '';
		printf( '<option value="%s" %s>%s</option>', $post->ID, $selected, $post->post_title );
	}
	?>
</select>
<?php wp_nonce_field( 'bf_mb_save', 'bf_mb_nonce' ); ?>