<?php
/**
 * Gb
 *
 * @category Widget
 * @package  Gb
 * @author   Vipin Kumar Dinkar <vipin.dinkar@rtcamp.com>
 * @license  GPLv2+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link     https://github.com/NicestRudeGuy
 *
 * @wordpress-plugin
 * Plugin Name:       Gb
 * Plugin URI:        https://github.com/NicestRudeGuy
 * Description:       Gutenblock ( static ) with coding standards .
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
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @throws Error .
 * @return void
 */
function create_block_gb_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build`'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = include $script_asset_path;
	wp_register_script(
		'create-block-gb-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);
	wp_set_script_translations( 'create-block-gb-block-editor', 'gb' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-gb-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-gb-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'create-block/gb',
		array(
			'editor_script' => 'create-block-gb-block-editor',
			'editor_style'  => 'create-block-gb-block-editor',
			'style'         => 'create-block-gb-block',
		)
	);
}
add_action( 'init', 'create_block_gb_block_init' );