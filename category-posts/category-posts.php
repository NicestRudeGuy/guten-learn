<?php
/**
 * Plugin Name:     Category-posts-007
 * Description:     Dynamic Block which takes a category with no of posts
 * Version:         0.0.1
 * Author:          Vipin Kumar Dinkar
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     category-posts
 *
 * @package         category-posts
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @throws Error .
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function category_posts_category_posts_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "category-posts/category-posts" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require $script_asset_path;
	wp_register_script(
		'category-posts-category-posts-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);
	wp_set_script_translations( 'category-posts-category-posts-block-editor', 'category-posts' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'category-posts-category-posts-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'category-posts-category-posts-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'category-posts/category-posts',
		array(
			'editor_script'   => 'category-posts-category-posts-block-editor',
			'editor_style'    => 'category-posts-category-posts-block-editor',
			'style'           => 'category-posts-category-posts-block',
			'render_callback' => 'render_posts_cat',
		)
	);
}

/**
 * Renders the categories of posts
 *
 * @param array $attributes .
 * @return mixed
 */
function render_posts_cat( $attributes ) {
	$posts_data = get_posts(
		array(
			'category'    => $attributes['selectedCategory'],
			'numberposts' => $attributes['postsPerPage'],
		)
	);
	if ( empty( $posts_data ) ) {
		return '<h3>No posts under this category</h3>';
	}

	foreach ( $posts_data as $post_data ) {
		$str  = '<div class="card" >';
		$str .= '<img class="card_img" src="' . get_the_post_thumbnail_url( $post_data->ID ) . '">';
		$str .= '<a class="card_link" href="' . get_the_permalink( $post_data->ID ) . '">';
		$str .= '<h3 class="card_title">' . get_the_title( $post_data->ID ) . '</h3>';
		$str .= '</a>';
		$str .= '<p class="card_excerpt">' . get_the_excerpt( $post_data->ID ) . '</p>';
		$str .= '<p class="card_cat_list">' . get_the_category_list( $post_data->ID ) . '</p>';
		$str .= '</div>';
	}

	return $str;

}

add_action( 'init', 'category_posts_category_posts_block_init' );
