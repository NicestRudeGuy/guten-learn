/**
 * Retrieves the translation of text.
 */
import { __ } from "@wordpress/i18n";

/**
 * Retrieves the predefined components from block-editor
 */
import {
	RichText,
	InnerBlocks,
	InspectorControls,
	ColorPalette,
	AlignmentToolbar,
	BlockControls,
} from "@wordpress/block-editor";

/**
 * Retrieves the predefined component from components
 */
import { PanelBody, Toolbar, ToolbarButton } from "@wordpress/components";

/**
 * Allowed innerblocks for this block
 */
const ALLOWED_BLOCKS = ["core/button"];

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} [props]           Properties passed from the editor.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes, className }) {
	const {
		title,
		content,
		boxBgColor,
		titleColor,
		contentColor,
		textAlignment,
	} = attributes;

	return [
		<InspectorControls>
			<PanelBody title="Color Settings" initialOpen={false}>
				<p>
					<strong>Background Color:</strong>
				</p>
				<ColorPalette
					value={boxBgColor}
					onChange={(value) => {
						setAttributes({ boxBgColor: value });
					}}
				/>
				<p>
					<strong>Title Color:</strong>
				</p>
				<ColorPalette
					value={titleColor}
					onChange={(value) => {
						setAttributes({ titleColor: value });
					}}
				/>
				<p>
					<strong>Background Color:</strong>
				</p>
				<ColorPalette
					value={contentColor}
					onChange={(value) => {
						setAttributes({ contentColor: value });
					}}
				/>
			</PanelBody>
		</InspectorControls>,
		<BlockControls>
			<AlignmentToolbar
				value={textAlignment}
				onChange={(value) => setAttributes({ textAlignment: value })}
			/>
			<Toolbar label="Options">
				<ToolbarButton
					label="My very own custom button"
					icon="dashboard"
					className="my-custom-button"
					onClick={() => console.log("pressed button")}
				/>
			</Toolbar>
		</BlockControls>,
		<div className={className} style={{ backgroundColor: boxBgColor }}>
			<RichText
				key="editable"
				tagName="h2"
				placeholder="Enter Title"
				value={title}
				onChange={(value) => {
					setAttributes({ title: value });
				}}
				style={{ color: titleColor, textAlign: textAlignment }}
			/>
			<RichText
				key="editable"
				tagName="p"
				placeholder="Enter Content"
				value={content}
				onChange={(value) => {
					setAttributes({ content: value });
				}}
				style={{ color: contentColor, textAlign: textAlignment }}
			/>
			<InnerBlocks
				allowedBlocks={ALLOWED_BLOCKS}
				style={{ textAlign: textAlignment }}
			/>
		</div>,
	];
}
