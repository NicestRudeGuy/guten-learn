/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 */
import { registerBlockType } from "@wordpress/blocks";


/**
 * Retrieves the translation of text.
 *
 */
import { __ } from "@wordpress/i18n";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 */
import "./style.scss";

/**
 * Internal dependencies
 */
import Edit from "./edit";
import Save from './save';

/**
 * Every block starts by registering a new block type definition.
 *
 */
registerBlockType("create-block/rp", {
	/**
	 * This is the display title for your block, which can be translated with `i18n` functions.
	 * The block inserter will show this name.
	 */
	title: __("Rp", "rp"),

	/**
	 * This is a short description for your block, can be translated with `i18n` functions.
	 * It will be shown in the Block Tab in the Settings Sidebar.
	 */
	description: __(
		"Test block returns 5 latest posts",
		"rp"
	),

	/**
	 * Blocks are grouped into categories to help users browse and discover them.
	 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
	 */
	category: "text",
	/**
	 * An icon property should be specified to make it easier to identify a block.
	 * These can be any of WordPress’ Dashicons, or a custom svg element.
	 */
	icon: "smiley",

	/**
	 * Optional block extended support features.
	 */
	supports: {
		// Removes support for an HTML mode.
		html: false,
	},
	attributes: {
		selectedPostId: {
			type: 'number'
		}
	},

	/**
	 */
	edit: Edit,

	/**
	 */
	save: Save,
});
