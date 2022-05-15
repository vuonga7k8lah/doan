<?php
get_header();

if (defined('HSBLOG2_SC_PREFIX')) {
    zimac_render_archive_page_has_hssc_plugin();
} else {
    zimac_render_archive_page_default();
}

get_footer();
