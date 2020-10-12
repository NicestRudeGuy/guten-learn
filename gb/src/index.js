/**
 * Registers a new block provided a unique name and an object defining its behavior.
 */
import { registerBlockType } from "@wordpress/blocks";

/**
 * Retrieves the translation of text.
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
import Save from "./save";

/**
 * Every block starts by registering a new block type definition.
 *
 */
registerBlockType("create-block/gb", {
	/**
	 * This is the display title for your block, which can be translated with `i18n` functions.
	 * The block inserter will show this name.
	 */
	title: __("Gb", "gb"),

	/**
	 * This is a short description for your block, can be translated with `i18n` functions.
	 * It will be shown in the Block Tab in the Settings Sidebar.
	 */
	description: __("Guten block (static)", "gb"),

	/**
	 * Blocks are grouped into categories to help users browse and discover them.
	 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
	 */
	category: "text",

	/**
	 * An icon property should be specified to make it easier to identify a block.
	 * These can be any of WordPress’ Dashicons, or a custom svg element.
	 */
	icon: "heart",

	/**
	 * Optional block extended support features.
	 */
	supports: {
		// Removes support for an HTML mode.
		html: false,
	},

	/**
	 * state of the block
	 */
	attributes: {
		title: {
			type: "string",
			source: "html",
			selector: "h2",
		},
		content: {
			type: "string",
			source: "html",
			selector: "p",
		},
		boxBgColor: {
			type: "string",
			default: "rgb(255,255,255)",
		},
		titleColor: {
			type: "string",
			default: "rgb(0,0,0,)",
		},
		contentColor: {
			type: "string",
			default: "rgb(0,0,0,)",
		},
		textAlignment: {
			type: "string",
			default: "center",
		},
	},

	/**
	 * Example
	 */
	example: {},

	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save: Save,
});
