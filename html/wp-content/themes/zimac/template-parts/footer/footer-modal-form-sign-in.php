<?php

use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$enableSignIn =  ThemeOptionSkeleton::getField('sign_in_sign_up_login_frontend_enable_login') ?? false;
$enableSignUp = true;
if (get_option('users_can_register')) {
    $enableSignUp =  ThemeOptionSkeleton::getField('sign_in_sign_up_login_frontend_enable_register')  ?? false;
}
if (is_user_logged_in() || !$enableSignIn) {
    return '';
}
?>
<div class="hidden fixed inset-0 overflow-auto z-max bg-gray-900 bg-opacity-40 wil-backdrop-filter-15px" id="wil-modal-form-sign-in">
    <div>
        <div class="w-full md:w-96 absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 p-1">
            <div class="bg-white rounded-2.5xl divide-y divide-gray-300 md:max-w-sm text-xs md:text-base text-gray-700">
                <div class="flex items-center justify-between px-5 py-3 space-x-3 overflow-hidden">
                    <h4 class="truncate">
                        <?php echo esc_html__('Sign in', 'zimac'); ?>
                    </h4>
                    <button class="flex p-2 rounded-full hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-10" type="button" data-wil-close-modal="wil-modal-form-sign-in">
                        <span class="sr-only">
                            <?php echo esc_html__('Dissmis', 'zimac'); ?>
                        </span>
                        <svg class="h-6 w-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-5 space-y-5">
                    <!-- CUSTOM LOGIN FORM -->
                    <form class="space-y-5" name="loginform" method="POST" action="<?php echo esc_url(wp_login_url(get_permalink())); ?>">
                        <div class="wil-input relative">
                            <div class="absolute left-1 top-1/2 transform -translate-y-1/2">
                                <div class="text-1.375rem text-gray-700 px-4 leading-none"><i class="las la-user"></i></div>
                            </div>
                            <input required name="log" class="px-5 h-14 w-full border-2 border-gray-300 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base pl-14 focus:border-primary focus:ring-0 font-medium" type="text" aria-label="<?php echo esc_html__('Username or email', 'zimac'); ?>" placeholder="<?php echo esc_html__('Username or email', 'zimac'); ?>">
                        </div>
                        <div class="wil-input relative">
                            <div class="absolute left-1 top-1/2 transform -translate-y-1/2">
                                <div class="text-1.375rem text-gray-700 px-4 leading-none"><i class="las la-lock"></i></div>
                            </div>
                            <input required name="pwd" class="px-5 h-14 w-full border-2 border-gray-300 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base pl-14 focus:border-primary focus:ring-0 font-medium" type="password" aria-label="<?php echo esc_html__('Password', 'zimac'); ?>" placeholder="<?php echo esc_html__('Password', 'zimac'); ?>">
                        </div>
                        <div class="flex items-center justify-between space-x-2">
                            <label class="flex items-center space-x-2 md:space-x-3 text-xs md:text-base">
                                <input name="rememberme" class="form-tick appearance-none h-5 md:h-6 w-5 md:w-6
                                border-2 border-gray-400 rounded-md checked:bg-quateary checked:border-quateary focus:outline-none focus:ring-quateary text-quateary" type="checkbox" value="1">
                                <span class="text-gray-700"><?php echo esc_html__('Remember', 'zimac'); ?></span>
                            </label>
                            <button class="hover:text-gray-900 hover:underline focus:outline-none" type="button" data-wil-close-modal="wil-modal-form-sign-in" data-open-modal="wil-modal-form-forgot-password">
                                <?php echo esc_html__('Forgot password?', 'zimac'); ?>
                            </button>
                        </div>
                        <button type="submit" name="wp-submit" class="wil-button rounded-full h-14 w-full text-gray-900 bg-primary text-xs lg:text-sm xl:text-body inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none ">
                            <?php echo esc_html__('Sign in', 'zimac'); ?>
                        </button>
                        <input type="hidden" name="redirect_to" value="<?php echo esc_url(get_permalink()); ?>">
                    </form>
                    <!-- CUSTOM LOGIN FORM END -->
                    <?php zimac_render_socials_login(); ?>
                    <?php if ($enableSignUp) : ?>
                        <div class="text-center text-gray-800">
                            <span><?php echo esc_html__("I'm a new user.", 'zimac'); ?> </span>
                            <button class="underline text-quateary focus:outline-none" type="button" data-wil-close-modal="wil-modal-form-sign-in" data-open-modal="wil-modal-form-sign-up">
                                <?php echo esc_html__("Sign up", 'zimac'); ?>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
