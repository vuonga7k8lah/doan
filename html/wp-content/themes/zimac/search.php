<?php get_header(); ?>

<div class="wil-search-page bg-gray-100 dark:bg-gray-800">
    <?php if (defined('HSBLOG2_SC_PREFIX')) {
        $currentPageType = $_GET['pageType'] ?? '';
        switch ($currentPageType) {
            case 'categories':
                zimac_render_search_page_content_categories();
                break;
            case 'tags':
                zimac_render_search_page_content_tags();
                break;
            case 'authors':
                zimac_render_search_page_content_authors();
                break;
            default:
                zimac_render_search_page_content_articles();
                break;
        }
    } else {
        zimac_render_search_page_content_articles();
    }  ?>
</div>

<?php get_footer();
