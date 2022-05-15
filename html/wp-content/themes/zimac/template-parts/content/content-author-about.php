<?php

use ZIMAC\Helpers\Helpers;
use HSSC\Illuminate\Helpers\StringHelper;

if (!defined('HSBLOG2_SC_PREFIX')) return;
$userID = get_queried_object()->ID;
$avatar = get_avatar_url($userID, ['size' => 200]);
$avatar = strpos($avatar, 'gravatar.com') ? '' : $avatar;
$name = get_the_author_meta('display_name', $userID);

$userSocials = [
    'facebook'  => Helpers::getASocialFontClass('facebook', get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_facebook_url', true)),
    'twitter'   => Helpers::getASocialFontClass('twitter', get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_twitter_url', true)),
    'linkedin'  => Helpers::getASocialFontClass('linkedin', get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_linkedin_url', true)),
    'youtube'   => Helpers::getASocialFontClass('youtube', get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_youtube_url', true)),
    'email'     => Helpers::getASocialFontClass('email', get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_email_url', true)),
    'whatsapp'  => Helpers::getASocialFontClass('whatsapp', get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_whatsapp_url', true)),
];
?>

<div class="flex flex-col md:flex-row">
    <div class="flex-shrink-0 hidden md:flex flex-col items-center">
        <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 rounded-2.5xl w-40 h-40 lg:w-46 lg:h-46 ring-2 ring-white <?php echo esc_attr($avatar ? "" : "wil-avatar-no-img"); ?>">
            <?php if ($avatar) : ?>
                <img class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($name); ?>" />
            <?php endif; ?>
            <span class="wil-avatar__name xl:text-3xl">
                <?php echo esc_html(substr($name, 0, 1)); ?>
            </span>
        </div>
        <span class="text-lg font-bold text-gray-900 dark:text-gray-200 mt-10px leading-tight">
            <?php echo esc_html($name); ?>
        </span>

        <?php if (get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_job_name', true)) : ?>
            <span class="text-gray-600 dark:text-gray-500 text-base font-medium">
                <?php echo esc_html(get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_job_name', true));  ?>
            </span>
        <?php endif; ?>

        <?php if (wp_get_current_user()->ID === $userID) : ?>
            <a href="<?php echo esc_url(home_url(add_query_arg('pageType', 'edit-profile', $wp->request))); ?>" class="wil-button rounded-full border border-gray-400 mt-5 w-full h-11 text-gray-900 dark:text-gray-200 bg-white dark:bg-gray-900 text-xs lg:text-sm xl:text-body inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none ">
                <span class="text-lg">
                    <i class="las la-pen"></i>
                </span>
                <span class="text-base font-bold text-gray-900 dark:text-gray-200 ml-1.5">
                    <?php echo esc_html__('Edit profile', 'zimac'); ?>
                </span>
            </a>
        <?php endif; ?>
    </div>
    <div class="p-4 lg:p-8 md:ml-8 bg-white rounded-2xl max-w-screen-md flex-grow">
        <?php if (get_the_author_meta('description', $userID)) : ?>
            <span class="block mb-7">
                <?php echo StringHelper::ksesHTML(get_the_author_meta('description', $userID)); ?>
            </span>
        <?php endif; ?>
        <?php
        $aHrefs = array_filter(array_values($userSocials), function (array $v, $k) {
            return !!$v['href'];
        }, ARRAY_FILTER_USE_BOTH);
        if (!empty($aHrefs)) :
        ?>
            <div>
                <h6 class="text-lg mb-10px">
                    <?php printf(esc_html__('Connect with %s', 'zimac'), $name); ?>
                </h6>
                <div class="flex items-center flex-wrap space-x-2 justify-start">
                    <?php
                    foreach ($userSocials as $social => $aSocial) {
                        if (!$aSocial['href']) continue;

                        echo '<a class="rounded-full flex items-center justify-center text-lg lg:w-11 w-8 lg:h-11 h-8 border-2 border-gray-300" href="' . esc_url($aSocial['href']) . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr($social) . '">';
                        echo '<i class="lab ' . esc_attr($aSocial['icon']) . '"></i>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
