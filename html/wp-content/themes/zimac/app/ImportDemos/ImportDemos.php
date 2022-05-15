<?php

namespace ZIMAC\ImportDemos;

/**
 * Class ImportDemos
 * @package ZIMAC\ImportDemos
 */
class ImportDemos
{

    public  function __construct()
    {
        if (class_exists('OCDI_Plugin')) {
            add_filter('ocdi/import_files', [$this, 'ocdi_import_files']);
            add_action('ocdi/after_import', [$this, 'ocdi_after_import_setup']);
        }
    }

    function ocdi_after_import_setup()
    {
        // Assign menus to their locations.
        $main_menu = get_term_by('name', 'Zimac Menu', 'nav_menu');
        $sidebar_menu = get_term_by('name', 'Zimac Sidebar Menu', 'nav_menu');
        set_theme_mod(
            'nav_menu_locations',
            [
	            ZIMAC_THEME_PREFIX . '_menu'         => $main_menu->term_id,
	            ZIMAC_THEME_PREFIX . '_sidebar_menu' => $sidebar_menu->term_id,
            ]
        );

        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title('Home Page');
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page_id->ID);
    }


    public function ocdi_import_files()
    {
        return [
            [
                'import_file_name'           => 'Demo Import 1',
                'categories'                 => ['Category 1'],
                'import_file_url'            => get_template_directory_uri() . '/demos/demo1/contents.xml',
                'import_widget_file_url'     => get_template_directory_uri() . '/demos/demo1/widgets.wie',
                'import_redux'               => [
                    [
                        'file_url'    => get_template_directory_uri() . '/demos/demo1/reduxs.json',
                        'option_name' => 'wiloke_themeoptions',
                    ],
                ],
                'import_preview_image_url'   => get_template_directory_uri() . '/demos/demo1/preview.png',
                'preview_url'                => 'https://zimac.wiloke.com/',
            ],
        ];
    }
}
