<?php
/**
 * Dgb
 *
 * @category Widget
 * @package  Dgb
 * @author   Vipin Kumar Dinkar <vipin.dinkar@rtcamp.com>
 * @license  GPLv2+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link     https://github.com/NicestRudeGuy
 *
 * @wordpress-plugin
 * Plugin Name:       Dgb
 * Plugin URI:        https://github.com/NicestRudeGuy
 * Description:       Dynamic block which returns post the link from id .
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
 * Retrives the  post with id
 *
 * @param mixed $attr .
 * @throws  Error .
 * @return mixed
 */
function dynamic_render_callback( $attr ) {
	$str = '';
	if ( $attr['selectedPostId'] > 0 ) {
		$post = get_post( $attr['selectedPostId'] );
		if ( ! $post ) {
			return 'No post found for this id';
		}
		$str  = '<div class="wp-block-latest-post">';
		$str .= '<a href="' . get_the_permalink( $post ) . '">';
		$str .= '<h3>' . get_the_title( $post ) . '</h3>';
		$str .= '<p>' . get_the_excerpt( $post ) . '</p>';
		$str .= '</a>';
		$str .= '</div>';
	}
	return $str;
}

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @throws  Error .
 * @return void
 */
function create_block_dgb_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "create-block/dgb" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = include $script_asset_path;

	wp_register_script(
		'create-block-dgb-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);
	wp_set_script_translations( 'create-block-dgb-block-editor', 'dgb' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-dgb-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-dgb-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'create-block/dgb',
		array(
			'editor_script'   => 'create-block-dgb-block-editor',
			'editor_style'    => 'create-block-dgb-block-editor',
			'style'           => 'create-block-dgb-block',
			'render_callback' => 'dynamic_render_callback',
			'attributes'      => array(
				'selectedPostId' => array(
					'type'    => 'number',
					'default' => 0,
				),

			),
		)
	);
}
add_action( 'init', 'create_block_dgb_block_init' );
