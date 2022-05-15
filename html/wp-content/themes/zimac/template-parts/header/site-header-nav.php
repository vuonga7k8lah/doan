<div class="hidden lg:block relative bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="wil-container container">
        <div class="flex justify-between items-center py-14px space-x-4 lg:space-x-8">

            <!-- BTN OPEN NAV SIDEBAR OVER -->
            <?php if (has_nav_menu(ZIMAC_THEME_PREFIX . '_sidebar_menu')) : ?>
                <div class="flex justify-start flex-shrink-0 lg:w-0 lg:flex-1">
                    <button class="rounded-full w-11 h-11 inline-flex items-center justify-center text-gray-900 dark:text-gray-300 border-2 border-gray-200 text-2xl focus:outline-none" type="button" data-open-modal="wil-modal-navigation-mobile">
                        <span class="sr-only"><?php echo esc_html__('Open menu', 'zimac'); ?></span>
                        <i class="las la-bars"></i>
                    </button>
                </div>
            <?php endif; ?>

            <!-- MAIN NAV -->
            <nav class="site-header-nav-main flex flex-wrap text-sm lg:text-base font-medium capitalize max-w-[70%]">
                <?php
                wp_nav_menu(
                    array(
	                    'theme_location'  => ZIMAC_THEME_PREFIX . '_menu',
	                    'menu_class'      => 'menu-wrapper',
	                    'container_class' => 'primary-menu-container w-full',
	                    'items_wrap'      => '<ul id="primary-menu-list" class="flex flex-wrap w-full text-sm lg:text-base font-medium capitalize %2$s">%3$s</ul>',
	                    'fallback_cb'     => false,
                    )
                );
                ?>
            </nav>

            <!-- RIGHT -->
            <div class="lg:w-0 lg:flex-1 flex-shrink-0 md:flex items-center justify-end text-gray-900 dark:text-gray-100">
                <?php if (defined('HSBLOG2_SC_PREFIX')) : ?>
                    <div class="hidden xl:block">
                        <?php zimac_render_site_switch_night_mode(); ?>
                    </div>
                <?php endif; ?>
                <!-- USER -->
                <?php zimac_render_site_header_user(); ?>
            </div>
        </div>
    </div>
</div>
