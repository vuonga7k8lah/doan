<div class="wil-header-01__top py-6 md:py-9 border-b border-gray-200 dark:border-gray-700">
    <div class="wil-container container">
        <div class="flex justify-between items-center md:space-x-4">
            <div class="hidden md:block md:w-0 md:flex-1">
                <?php zimac_render_site_header_input_search(); ?>
            </div>
            <!-- LOGO -->
            <div class="flex-shrink-0">
                <?php zimac_render_site_header_logo(); ?>
            </div>
            <!-- END LOGO -->

            <div class="wil-header-01__top-socials md:w-0 md:flex-1 hidden md:flex justify-end">
                <?php zimac_render_site_header_socials(); ?>
            </div>
            <div class="block lg:hidden">
                <button class="rounded-full w-11 h-11 inline-flex items-center justify-center text-gray-900 dark:text-gray-300 border-2 border-gray-200 text-2xl focus:outline-none" type="button" data-open-modal="wil-modal-navigation-mobile">
                    <span class="sr-only">
                        <?php echo esc_html__('Open menu', 'zimac'); ?>
                    </span>
                    <i class="las la-bars"></i>
                </button>
            </div>
        </div>
    </div>
</div>
