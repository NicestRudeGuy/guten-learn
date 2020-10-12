/**
 * Retrieves the translation of text.
 */
import { __ } from "@wordpress/i18n";

/**
 * Retrives the ServerSideRender Component
 */
import ServerSideRender from "@wordpress/server-side-render";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} [props]           Properties passed from the editor.
 * @param {string} [props.className] Class name generated for the block.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
	console.log(props);
	return (
			<ServerSideRender
				block={props.name}
			/>
	);
}
