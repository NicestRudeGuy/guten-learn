/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

import apiFetch from "@wordpress/api-fetch";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @param {Object} [props]           Properties passed from the editor.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {

	if (!props.attributes.categories) {
		apiFetch({
			url: "/wp-json/wp/v2/categories",
		}).then((categories) => {
			props.setAttributes({
				categories: categories,
			});
		});
	}

	if (!props.attributes.categories) {
		return "Loading.....";
	}

	if (props.attributes.categories && props.attributes.categories.length == 0) {
		return "Please add some categories";
	}

	console.log(props.attributes);

	return (
		<div>
			<label>Categories : </label>
			<select
				onChange={(e) => {
					props.setAttributes({
						selectedCategory: e.target.value,
					});
				}}
				value={props.attributes.selectedCategory}
			>
				{props.attributes.categories.map((category) => {
					return (
						<option value={category.id} key={category.id}>
							{category.name}
						</option>
					);
				})}
			</select>
			<br/>
			<label> No of posts : </label>
			<input
				type="number"
				onChange={(e) => {
					props.setAttributes({
						postsPerPage: e.target.value,
					});
				}}
				value={props.attributes.postsPerPage}
			/>
		</div>
	);
}
