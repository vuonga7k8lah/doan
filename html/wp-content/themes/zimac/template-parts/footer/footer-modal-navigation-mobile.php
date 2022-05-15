<?php

use ZIMAC\Menu\Controllers\WalkerSidebarMenu;
?>
<!-- THIS IS SHOW ALL MODAL OF THIS THEME -->
<div class="hidden fixed inset-0 overflow-auto z-max bg-gray-900 bg-opacity-40 wil-backdrop-filter-6px" id="wil-modal-navigation-mobile">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 z-0" data-wil-close-modal="wil-modal-navigation-mobile"></div>
        <div class="absolute z-10 inset-y-0 left-0 max-w-full flex">
            <div class="relative w-screen max-w-sm">
                <div class="h-full flex flex-col bg-gray-800 shadow-xl overflow-y-auto">
                    <div class="pt-7 pb-6 px-5 bg-white dark:bg-gray-800 border-b border-gray-300 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div>
                                <?php zimac_render_site_header_logo(['textAlign' => 'text-left text-base']); ?>
                            </div>
                            <div>
                                <button class="flex p-2 hover:bg-gray-200 dark:hover:bg-white dark:hover:bg-opacity-10 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-10" type="button" data-wil-close-modal="wil-modal-navigation-mobile">
                                    <span class="sr-only"><?php echo esc_html__('Dismiss', 'zimac'); ?></span>
                                    <svg class="h-6 w-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-between items-center space-x-4">
                            <?php zimac_render_site_header_socials(); ?>
                            <div class="my-1">
                                <?php zimac_render_site_switch_night_mode(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="py-5 px-2 space-y-6 text-gray-100">
                        <nav class="site-header-nav-sidebar flex flex-wrap text-sm lg:text-base font-medium capitalize">
                            <?php
                            wp_nav_menu(
                                array(
	                                'theme_location'  => ZIMAC_THEME_PREFIX . '_sidebar_menu',
	                                'menu_class'      => 'menu-wrapper',
	                                'container_class' => 'sidebar-menu-container',
	                                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
	                                'fallback_cb'     => false,
	                                'walker'          => new WalkerSidebarMenu(),
	                                'link_after'      => '<span class="nav-after-icon"><i class="las la-angle-down"></i></span>'
                                )
                            );
                            ?>
                            <?php
                            wp_nav_menu(
                                array(
	                                'theme_location'  => ZIMAC_THEME_PREFIX . '_menu',
	                                'menu_class'      => 'menu-wrapper',
	                                'container_class' => 'sidebar-menu-container block lg:hidden',
	                                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
	                                'fallback_cb'     => false,
	                                'walker'          => new WalkerSidebarMenu(),
	                                'link_after'      => '<span class="nav-after-icon"><i class="las la-angle-down"></i></span>'
                                )
                            );
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
