<?php

/**
 * Plugin Name: FooGallery - Override FooBox Width & Heights Per Attachment
 * Description: A FooGallery plugin that adds size fields to all attachments to force that size when shown in FooBox
 * Version:     1.0.0
 * Author:      Brad Vincent
 * Author URI:  https://fooplugins.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Add override fields for FooBox
 *
 * @uses "foogallery_attachment_custom_fields" filter
 *
 * @param array $fields
 *
 * @return array
 */
function foogallery_custom_attachment_fields_foobox( $fields ) {
	$fields['foobox-width']  = array(
		'label'       => __( 'Override Foobox Width', 'foogallery' ),
		'input'       => 'text'
	);
	$fields['foobox-height'] = array(
		'label'       => __( 'Override Foobox Height', 'foogallery' ),
		'input'       => 'text'
	);

	return $fields;
}
add_filter( 'foogallery_attachment_custom_fields', 'foogallery_custom_attachment_fields_foobox' );

/**
 * Add data-width and data-height attributes to front-end anchor, which are used by FooBox to force a max width and max height
 *
 * @param                             $attr
 * @param                             $args
 * @param object|FooGalleryAttachment $attachment
 *
 * @return mixed
 * @uses "foogallery_attachment_html_link_attributes" filter
 *
 */
function foogallery_custom_foobox_size_attributes( $attr, $args, $attachment ) {
	if ( foogallery_gallery_template_setting( 'lightbox' ) === 'foobox' ) {
		//override width
		$override_width = get_post_meta( $attachment->ID, '_foobox-width', true );
		if ( ! empty( $override_width ) ) {
			$attr['data-width'] = intval( $override_width );
		}

		//override height
		$override_height = get_post_meta( $attachment->ID, '_foobox-height', true );
		if ( ! empty( $override_height ) ) {
			$attr['data-height'] = intval( $override_height );
		}
	}
	return $attr;
}
add_filter( 'foogallery_attachment_html_link_attributes', 'foogallery_custom_foobox_size_attributes', 50, 3 );
