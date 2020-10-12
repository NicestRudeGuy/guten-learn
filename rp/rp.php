<?php
/**
 * Rp
 *
 * @category Text
 * @package  Rp
 * @author   Vipin Kumar Dinkar <vipin.dinkar@rtcamp.com>
 * @license  GPLv2+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link     https://github.com/NicestRudeGuy
 *
 * @wordpress-plugin
 * Plugin Name:       Rp
 * Plugin URI:        https://github.com/NicestRudeGuy
 * Description:       Dynamic block that returns 5 recent post links .
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Vipin Kumar Dinkar
 * Author URI:        https://eyeem.com/u/nicestrudeguy
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Retrives the top 5 recent posts
 *
 * @throws  Error .
 * @return mixed
 */
function dynamic_render_callback_rp() {
	$recent_posts = wp_get_recent_posts(
		array(
			'numberposts' => 5,
			'post_status' => 'publish',
		)
	);
	if ( count( $recent_posts ) === 0 ) {
		return 'No posts';
	}
	$post_data = '<div class="wp-block-latest-post"><h2>Top 5 recent posts </h2>';
	foreach ( $recent_posts as $posts ) {
		$post_id    = $posts['ID'];
		$post_data .= '<div class="post-title">
		<p><a href="' . get_permalink( $post_id ) . '">' . get_the_title( $post_id ) . '</a></p>
		</div>';
	}
	$post_data .= '</div>';
	return $post_data;
}

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @throws  Error .
 * @return void
 */
function create_block_rp_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "create-block/rp" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = include $script_asset_path;

	wp_register_script(
		'create-block-rp-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version'],
		false
	);
	wp_set_script_translations( 'create-block-rp-block-editor', 'rp' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-rp-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-rp-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'create-block/rp',
		array(
			'editor_script'   => 'create-block-rp-block-editor',
			'editor_style'    => 'create-block-rp-block-editor',
			'style'           => 'create-block-rp-block',
			'render_callback' => 'dynamic_render_callback_rp',
		)
	);
}
add_action( 'init', 'create_block_rp_block_init' );
