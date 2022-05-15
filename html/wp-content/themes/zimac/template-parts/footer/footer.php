<?php

use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$bg = '';
if (defined('HSBLOG2_SC_PREFIX')) {
	$bg = ThemeOptionSkeleton::getField('footer_settings_bg_img') ?? [];
}

if (zimac_is_footer_active()) :
	?>
    <div class="wil-footer relative py-13 bg-cover"
         style="<?php echo esc_attr($bg ? 'background-image:url(' . $bg['url'] .
		     ')' : ''); ?>">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-90 dark:bg-opacity-95"></div>
        <div class="wil-container container">
            <div class="space-y-14 relative">

                <!-- WIDGET RECENT POSTS -->
				<?php zimac_render_footer_widget_recent_posts(); ?>

                <!-- 4 MAIN FOOTER WIDGETs -->
                <ul class="footer-four-widget-area text-base grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 xl:gap-8">
                    <li class="space-y-8">
						<?php zimac_render_footer_widget1(); ?>
                    </li>
                    <li class="space-y-8">
						<?php zimac_render_footer_widget2(); ?>
                    </li>
                    <li class="space-y-8">
						<?php zimac_render_footer_widget3(); ?>
                    </li>
                    <li class="space-y-8">
						<?php zimac_render_footer_widget4(); ?>
                    </li>
                </ul>

                <!-- COPYRIGHT -->
                <div class="text-center text-body text-gray-500">
					<?php if (defined('HSBLOG2_SC_PREFIX')) : ?>
						<?php
						$copyright = ThemeOptionSkeleton::getField('copyright_setting') ?? '';
						echo StringHelper::ksesHTML($copyright);
						?>
					<?php else : ?>
                        <span class="text-body text-gray-500 max-w-screen-sm text-center">
						<?php esc_html__('Copyright © 2021 Wiloke.com. Address: 1002312 State Street, 20th', 'zimac'); ?>
						<br> <?php esc_html__('Floor Boston A', 'zimac'); ?>
					</span>
					<?php endif; ?>

                </div>
            </div>
        </div>

        <!-- THE SAFELIST CLASS TAILWINDCSS  --  DONOT REMOVE THIS DIV! -->
        <!-- You can add more class tailwind in this div  -->
        <div class="!hidden bypostauthor
	gap-0 md:gap-0 lg:gap-0 xl:gap-0
	gap-1 md:gap-1 lg:gap-1 xl:gap-1
	gap-2 md:gap-2 lg:gap-2 xl:gap-2
	gap-3 md:gap-3 lg:gap-3 xl:gap-3
	gap-4 md:gap-4 lg:gap-4 xl:gap-4
	gap-5 md:gap-5 lg:gap-5 xl:gap-5
	gap-6 md:gap-6 lg:gap-6 xl:gap-6
	gap-7 md:gap-7 lg:gap-7 xl:gap-7
	gap-8 md:gap-8 lg:gap-8 xl:gap-8
	gap-9 md:gap-9 lg:gap-9 xl:gap-9
	gap-10 md:gap-10 lg:gap-10 xl:gap-10
	gap-11 md:gap-11 lg:gap-11 xl:gap-11
	----
	space-x-0 md:space-x-0 lg:space-x-0 xl:space-x-0
	space-x-1 md:space-x-1 lg:space-x-1 xl:space-x-1
	space-x-2 md:space-x-2 lg:space-x-2 xl:space-x-2
	space-x-3 md:space-x-3 lg:space-x-3 xl:space-x-3
	space-x-4 md:space-x-4 lg:space-x-4 xl:space-x-4
	space-x-5 md:space-x-5 lg:space-x-5 xl:space-x-5
	space-x-6 md:space-x-6 lg:space-x-6 xl:space-x-6
	space-x-7 md:space-x-7 lg:space-x-7 xl:space-x-7
	space-x-8 md:space-x-8 lg:space-x-8 xl:space-x-8
	space-x-9 md:space-x-9 lg:space-x-9 xl:space-x-9
	space-x-10 md:space-x-10 lg:space-x-10 xl:space-x-10
	space-x-11 md:space-x-11 lg:space-x-11 xl:space-x-11
	----
	space-y-0 md:space-y-0 lg:space-y-0 xl:space-y-0
	space-y-1 md:space-y-1 lg:space-y-1 xl:space-y-1
	space-y-2 md:space-y-2 lg:space-y-2 xl:space-y-2
	space-y-3 md:space-y-3 lg:space-y-3 xl:space-y-3
	space-y-4 md:space-y-4 lg:space-y-4 xl:space-y-4
	space-y-5 md:space-y-5 lg:space-y-5 xl:space-y-5
	space-y-6 md:space-y-6 lg:space-y-6 xl:space-y-6
	space-y-7 md:space-y-7 lg:space-y-7 xl:space-y-7
	space-y-8 md:space-y-8 lg:space-y-8 xl:space-y-8
	space-y-9 md:space-y-9 lg:space-y-9 xl:space-y-9
	space-y-10 md:space-y-10 lg:space-y-10 xl:space-y-10
	space-y-11 md:space-y-11 lg:space-y-11 xl:space-y-11
	----
	grid-cols-1 grid-cols-2 grid-cols-3 grid-cols-4 grid-cols-5 grid-cols-6 grid-cols-7 grid-cols-8 grid-cols-9 grid-cols-10 grid-cols-11 grid-cols-12
	sm:grid-cols-1 sm:grid-cols-2 sm:grid-cols-3 sm:grid-cols-4 sm:grid-cols-5 sm:grid-cols-6 sm:grid-cols-7 sm:grid-cols-8 sm:grid-cols-9 				sm:grid-cols-10 sm:grid-cols-11 sm:grid-cols-12
	md:grid-cols-1 md:grid-cols-2 md:grid-cols-3 md:grid-cols-4 md:grid-cols-5 md:grid-cols-6 md:grid-cols-7 md:grid-cols-8 md:grid-cols-9 md:grid-cols-10 md:grid-cols-11 md:grid-cols-12
	lg:grid-cols-1 lg:grid-cols-2 lg:grid-cols-3 lg:grid-cols-4 lg:grid-cols-5 lg:grid-cols-6 lg:grid-cols-7 lg:grid-cols-8 lg:grid-cols-9 lg:grid-cols-10 lg:grid-cols-11 lg:grid-cols-12
	xl:grid-cols-1 xl:grid-cols-2 xl:grid-cols-3 xl:grid-cols-4 xl:grid-cols-5 xl:grid-cols-6 xl:grid-cols-7 xl:grid-cols-8 xl:grid-cols-9 xl:grid-cols-10 xl:grid-cols-11 xl:grid-cols-12
	md:py-1 md:py-2 md:py-4 md:py-6 md:py-8 md:py-10 md:py-11 md:py-12 md:py-13 md:py-14 md:py-16
	py-1 py-2 py-3 py-4 py-5 py-6 py-7 py-8 py-9 py-10 py-11 py-12 py-13 py-14 py-16
	pb-1 pb-2 pb-3 pb-4 pb-5 pb-6 pb-7 pb-8 pb-9 pb-10 pb-11 pb-12 pb-13 pb-14 pb-16
	pt-1 pt-2 pt-3 pt-4 pt-5 pt-6 pt-7 pt-8 pt-9 pt-10 pt-11 pt-12 pt-13 pt-14 pt-16
	pl-1 pl-2 pl-3 pl-4 pl-5 pl-6 pl-7 pl-8 pl-9 pl-10 pl-11 pl-12 pl-13 pl-14 pl-16
	pr-1 pr-2 pr-3 pr-4 pr-5 pr-6 pr-7 pr-8 pr-9 pr-10 pr-11 pr-12 pr-13 pr-14 pr-16
	my-1 my-2 my-3 my-4 my-5 my-6 my-7 my-8 my-9 my-10 my-11 my-12 my-13 my-14 my-16
	mb-1 mb-2 mb-3 mb-4 mb-5 mb-6 mb-7 mb-8 mb-9 mb-10 mb-11 mb-12 mb-13 mb-14 mb-16
	mt-1 mt-2 mt-3 mt-4 mt-5 mt-6 mt-7 mt-8 mt-9 mt-10 mt-11 mt-12 mt-13 mt-14 mt-16
	ml-1 ml-2 ml-3 ml-4 ml-5 ml-6 ml-7 ml-8 ml-9 ml-10 ml-11 ml-12 ml-13 ml-14 ml-16
	mr-1 mr-2 mr-3 mr-4 mr-5 mr-6 mr-7 mr-8 mr-9 mr-10 mr-11 mr-12 mr-13 mr-14 mr-16
	"></div>
    </div>

<?php
endif;

zimac_render_footer_modal_nav_mobile();

if (!defined('HSBLOG2_SC_PREFIX')) {
	return;
}
zimac_render_footer_modal_sign_in_form();
zimac_render_footer_modal_sign_up_form();
zimac_render_footer_modal_forgot_password();
