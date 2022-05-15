<?php

use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$socials = [
    'facebook'  => '',
    'twitter'   => '',
    'google'    => '',
];
if (defined('HSBLOG2_SC_PREFIX') && defined('NSL_PLUGIN_BASENAME')) {
    $socials['facebook'] =  ThemeOptionSkeleton::getField('sign_in_sign_up_social_login_facebook');
    $socials['twitter'] =  ThemeOptionSkeleton::getField('sign_in_sign_up_social_login_twitter');
    $socials['google'] =  ThemeOptionSkeleton::getField('sign_in_sign_up_social_login_google');
}

if (!$socials['facebook'] && !$socials['twitter'] && !$socials['google']) {
    return '';
}
?>

<div class="space-y-5">
    <div class="text-center">
        <span> <?php echo esc_html__('Or sign in with social', 'zimac'); ?> </span>
    </div>
    <div>
        <div class="flex items-center flex-wrap space-x-2 justify-center">
            <!-- FACEBOOK -->
            <?php if (!!$socials['facebook']) : ?>
                <a href="<?php echo esc_url($socials['facebook']); ?>" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="flex items-center justify-center text-xl lg:text-h4 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full lg:w-20 w-12 lg:h-12 h-8 border-2 text-facebook border-facebook">
                    <i class="lab la-facebook-f"></i>
                </a>
            <?php endif; ?>

            <!-- TWITTER -->
            <?php if (!!$socials['twitter']) : ?>
                <a href="<?php echo esc_url($socials['twitter']); ?>" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="twitter" data-popupwidth="600" data-popupheight="600" class="flex items-center justify-center text-xl lg:text-h4 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full lg:w-20 w-12 lg:h-12 h-8 border-2 text-twitter border-twitter">
                    <i class="lab la-twitter"></i>
                </a>
            <?php endif; ?>

            <!-- GOOGLE -->
            <?php if (!!$socials['google']) : ?>
                <a href="<?php echo esc_url($socials['google']); ?>" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="flex items-center justify-center text-xl lg:text-h4 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full lg:w-20 w-12 lg:h-12 h-8 border-2 text-googlePlus border-googlePlus">
                    <i class="lab la-google-plus"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
