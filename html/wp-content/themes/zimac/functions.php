<?php

use ZIMAC\Comment\Controllers\CommentController;
use ZIMAC\EnqueueScript\Controllers\EnqueueScriptController;
use ZIMAC\Gutenberg\Controllers\EnqueueScript;
use ZIMAC\ImportDemos\ImportDemos;
use ZIMAC\Menu\Controllers\RegisterMenuController;
use ZIMAC\Widget\Controllers\RegisterWidgetController;
use HSSC\Users\Database\StatisticViewInDay;

define('ZIMAC_THEME_PREFIX', 'zimac_');
define('ZIMAC_THEME_SCRIPT_PREFIX', 'zimac-');
define('ZIMAC_THEME_VERSION', '1.0');
require_once get_template_directory() . '/vendor/autoload.php';
//
require_once get_template_directory() . '/hs-get-templates.php';
//
require_once get_template_directory() . '/app/TGM/requiredPlugins.php';

// === CLASS === //
new EnqueueScriptController();
new RegisterWidgetController();
new RegisterMenuController();
new CommentController();
new ImportDemos();
new EnqueueScript();
//

// function hsblogSetup
if (!function_exists('zimac_setup')) {
    /**
     * Basic Settup for hsblog theme
     *
     * @return void
     */
    function zimac_setup()
    {
        add_theme_support('post-thumbnails');
        //
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
                'navigation-widgets',
            )
        );
        add_theme_support("title-tag");
        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');

        // Add support for editor styles.
        add_theme_support('editor-styles');
        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add support for custom line height controls.
        add_theme_support('custom-line-height');

        // Add support for experimental link color control.
        add_theme_support('experimental-link-color');

        // Add support for experimental cover block spacing.
        add_theme_support('custom-spacing');
        //
        add_theme_support('automatic-feed-links');

        // Add support for custom units.
        // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
        add_theme_support('custom-units');
        if (!isset($content_width)) {
            $content_width = 1280;
        }

        load_theme_textdomain('zimac', get_template_directory() . '/languages');
    }
}
add_action('after_setup_theme', 'zimac_setup');

// Register Usermetabox
if (defined('HSBLOG2_SC_PREFIX')) {
    add_action('cmb2_admin_init', ['ZIMAC\Helpers\Helpers', 'registerUserMetabox']);
}

/**
 * REMOVE CSS OF SEARCH LIVE PLUGIN
 *
 * @return void
 */
function zimac_remove_search_wp_live_search_css()
{
    wp_dequeue_style('searchwp-live-search');
}
add_action('wp_enqueue_scripts', 'zimac_remove_search_wp_live_search_css', 20);

/**
 * CHANGE DEFAULT ARCHIVE TITLE
 *
 * @param [type] $title
 * @return void
 */
function zimac_theme_archive_title($title)
{
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
}
add_filter('get_the_archive_title', 'zimac_theme_archive_title');
//

/**
 * ADD/CHANGE QUERY PRE_GET_POST ON ARCHIVE PAGE FILTER
 *
 * @param [type] $query
 * @return void
 */
function zimac_exclude_query_for_archive_page($query)
{
    if (is_admin() || !$query->is_main_query() || !is_archive()) {
        return $query;
    }
    switch ($_GET['orderBy'] ?? '') {
        case 'title':
            $query->set('orderby', 'title');
            break;
        case 'comment_count':
            $query->set('orderby', 'comment_count');
            break;
        case 'date':
            $query->set('orderby', 'date');
        case 'view_count':
            add_filter('posts_clauses', 'zimac_clauses_get_most_view_to_wp_query', 10, 2);

            break;
        default:
            break;
    }
    $query->set('posts_per_page', 12);
    return $query;
}
if (defined('HSBLOG2_SC_PREFIX')) {
    add_action('pre_get_posts', 'zimac_exclude_query_for_archive_page');
}

/**
 * ADD QUERY INTO WPQUERY FILTER BY MOST VIEW ON ARCHIVE PAGE
 * @param [type] $clauses
 * @return void
 */
function zimac_clauses_get_most_view_to_wp_query($clauses)
{
    if (is_admin() ||  !is_archive() || $_GET['orderBy'] !== 'view_count') {
        return $clauses;
    }
    global $wpdb;
    $viewTable = StatisticViewInDay::getTblName();
    $clauses['join'] .= " LEFT JOIN 
        (SELECT {$viewTable}.post_id, SUM({$viewTable}.count) as views FROM {$viewTable} GROUP BY {$viewTable}.post_id) AS o 
            ON {$wpdb->posts}.ID = o.post_id";
    $clauses['orderby']  = " o.views DESC";
    $clauses['limit']  = "12";
    return $clauses;
}

/**
 *
 */
function zimac_search_wp_live_search_configs($configs)
{
    $configs['default'] = wp_parse_args(['input' => array(
        'delay'     => 400,
        'min_chars' => 0,
    )], $configs['default']);
    return $configs;
}
add_filter('searchwp_live_search_configs', 'zimac_search_wp_live_search_configs');

/**
 * @return mixed|void
 */
function zimac_get_search_query() {
    /**
     * Filters the contents of the search query variable.
     *
     * @since 2.3.0
     *
     * @param mixed $search Contents of the search query variable.
     */
    return apply_filters( 'zimac_get_search_query', get_query_var( 's' ) );
 }
