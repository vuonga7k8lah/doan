<?php

namespace HSSC\Controllers\Term;

/**
 * TermMetaDataController class
 */
class TermMetaDataController
{
    public function __construct()
    {
        add_action('cmb2_admin_init', [$this, 'registerTaxonomyMetabox']);
    }

    /**
     * Hook in and add a metabox to add fields to taxonomy terms
     */
    public function registerTaxonomyMetabox()
    {
        /**
         * Metabox to add fields to categories and tags
         */
        $cmb_term = new_cmb2_box(array(
	        'id'               => HSBLOG2_SC_PREFIX . 'term_edit',
	        'title'            => esc_html__('Term Metabox', 'hsblog2-shortcodes'), // Doesn't output for term boxes
	        'object_types'     => array('term'), // Tells CMB2 to use term_meta vs post_meta
	        'taxonomies'       => array('category', 'post_tag'), // Tells CMB2 which taxonomies should have these fields
	        'new_term_section' => true, // Will display in the "Add New Category" section
        ));

        $cmb_term->add_field(array(
	        'name' => esc_html__('Featured Image', 'hsblog2-shortcodes'),
	        'desc' => esc_html__("Term's featured image", 'hsblog2-shortcodes'),
	        'id'   => HSBLOG2_SC_PREFIX . 'term_featured_image',
	        'type' => 'file',
        ));
    }
}
