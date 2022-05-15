<?php

namespace HSSC\Reports\Controllers;

class ReportsController
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostTypeReport'], 0);
    }

    // Register Custom Post Type
    public function registerPostTypeReport()
    {
        $labels = array(
            'name'                  => _x('Reports', 'Post Type General Name', 'hs2'),
            'singular_name'         => _x('Report', 'Post Type Singular Name', 'hs2'),
            'menu_name'             => __('Reports', 'hs2'),
            'name_admin_bar'        => __('Report', 'hs2'),
            'archives'              => __('Item Archives', 'hs2'),
            'attributes'            => __('Item Attributes', 'hs2'),
            'parent_item_colon'     => __('Parent Item:', 'hs2'),
            'all_items'             => __('All Items', 'hs2'),
            'add_new_item'          => __('Add New Item', 'hs2'),
            'add_new'               => __('Add New', 'hs2'),
            'new_item'              => __('New Item', 'hs2'),
            'edit_item'             => __('Edit Item', 'hs2'),
            'update_item'           => __('Update Item', 'hs2'),
            'view_item'             => __('View Item', 'hs2'),
            'view_items'            => __('View Items', 'hs2'),
            'search_items'          => __('Search Item', 'hs2'),
            'not_found'             => __('Not found', 'hs2'),
            'not_found_in_trash'    => __('Not found in Trash', 'hs2'),
            'featured_image'        => __('Featured Image', 'hs2'),
            'set_featured_image'    => __('Set featured image', 'hs2'),
            'remove_featured_image' => __('Remove featured image', 'hs2'),
            'use_featured_image'    => __('Use as featured image', 'hs2'),
            'insert_into_item'      => __('Insert into item', 'hs2'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'hs2'),
            'items_list'            => __('Items list', 'hs2'),
            'items_list_navigation' => __('Items list navigation', 'hs2'),
            'filter_items_list'     => __('Filter items list', 'hs2'),
        );
        $args = array(
            'label'                 => __('Report', 'hs2'),
            'description'           => __('Include reason and id of reported comments', 'hs2'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'author'),
            'taxonomies'            => array('category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type('report', $args);
    }


    /**
     * 
     */
    public static function doActionReportComment(array $args): bool
    {
        if (!$args || empty($args)) {
            return false;
        }
        $wpResult = wp_insert_post($args);
        return !is_wp_error($wpResult);
    }
}
