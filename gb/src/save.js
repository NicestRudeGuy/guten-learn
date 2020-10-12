/**
 * Retrieves the translation of text.
 */
import { __ } from "@wordpress/i18n";

/**
 * Retrieves the predefined components from block-editor
 */
import { RichText, InnerBlocks } from "@wordpress/block-editor";

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param {Object} [props]
 *
 * @return {WPElement} Element to render.
 */
export default function save({ attributes }) {
	const {
		title,
		content,
		boxBgColor,
		titleColor,
		contentColor,
		textAlignment,
	} = attributes;
	return (
		<>
			<div
				className="wp-block-create-block-gb"
				style={{ backgroundColor: boxBgColor }}
			>
				<RichText.Content
					tagName="h2"
					value={title}
					style={{ color: titleColor, textAlign: textAlignment }}
				/>
				<RichText.Content
					tagName="p"
					value={content}
					style={{ color: contentColor, textAlign: textAlignment }}
				/>
				<InnerBlocks.Content />
			</div>
		</>
	);
}
