<?php
if (!defined('HSBLOG2_SC_PREFIX')) return;
$userID = get_queried_object()->ID;

if (!is_user_logged_in() || !current_user_can('edit_user', $userID) || wp_get_current_user()->ID !== $userID) {
    echo '<div class="bg-white dark:bg-gray-900 py-8 px-5 rounded-2.5xl max-w-[700px] mx-auto">';
    echo esc_html__('Sorry, You do not have permission to access this feature.', 'zimac');
    echo '</div>';
    return;
}

$userSocials = [
    'facebook'    => [
        'href'  => get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_facebook_url', true),
        'icon'  => 'lab la-facebook-f',
        'key'   =>  HSBLOG2_SC_PREFIX . 'user_facebook_url',
    ],
    'twitter'    => [
        'href'  => get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_twitter_url', true),
        'icon'  => 'lab la-twitter',
        'key'   =>  HSBLOG2_SC_PREFIX . 'user_twitter_url',
    ],
    'linkedin'    => [
        'href'  => get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_linkedin_url', true),
        'icon'  => 'lab la-linkedin-in',
        'key'   =>  HSBLOG2_SC_PREFIX . 'user_linkedin_url',
    ],
    'youtube'    => [
        'href'  => get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_youtube_url', true),
        'icon'  => 'lab la-youtube-square',
        'key'   =>  HSBLOG2_SC_PREFIX . 'user_youtube_url',
    ],
    'email'    => [
        'href'  => get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_email_url', true),
        'icon'  => 'las la-at',
        'key'   =>  HSBLOG2_SC_PREFIX . 'user_email_url',
    ],
    'whatsapp'    => [
        'href'  => get_user_meta($userID, HSBLOG2_SC_PREFIX . 'user_whatsapp_url', true),
        'icon'  => 'lab la-whatsapp',
        'key'   =>  HSBLOG2_SC_PREFIX . 'user_whatsapp_url',
    ],
];


?>

<div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 py-8 px-5 rounded-2.5xl max-w-[700px] mx-auto">
    <h2 class="text-h4 font-bold mb-7">
        <?php echo esc_html__('Change profile', 'zimac'); ?>
    </h2>
    <form method="POST" action="<?php echo esc_url(home_url(add_query_arg('pageType', 'about', $wp->request))); ?>" class="space-y-5">
        <div class="grid grid-cols-2 gap-3 sm:gap-5">
            <div class="wil-input relative">
                <div class="absolute left-1 top-1/2 transform -translate-y-1/2">
                    <div class="text-1.375rem text-gray-700 dark:text-gray-400 px-4 leading-none">
                        <i class="las la-user"></i>
                    </div>
                </div>
                <input type="text" name="first_name" aria-label="<?php echo esc_attr__('First Name', 'zimac'); ?>" placeholder="<?php echo esc_attr__('First Name', 'zimac'); ?>" class=" px-5 h-14 w-full border-2 border-gray-300 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base pl-14 focus:border-primary focus:ring-0 font-medium" value="<?php echo esc_attr(get_user_meta($userID, 'first_name', true)); ?>" />
            </div>
            <div class="wil-input relative">
                <div class="absolute left-1 top-1/2 transform -translate-y-1/2">
                    <div class="text-1.375rem text-gray-700 dark:text-gray-400 px-4 leading-none">
                        <i class="las la-user-tag"></i>
                    </div>
                </div>
                <input type="text" name="last_name" aria-label="<?php echo esc_attr__('Last Name', 'zimac'); ?>" placeholder="<?php echo esc_attr__('Last Name', 'zimac'); ?>" class=" px-5 h-14 w-full border-2 border-gray-300 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base pl-14 focus:border-primary focus:ring-0 font-medium" value="<?php echo esc_attr(get_user_meta($userID, 'last_name', true)); ?>" />
            </div>
        </div>

        <div class="wil-input relative">
            <div class="absolute left-1 top-1/2 transform -translate-y-1/2">
                <div class="text-1.375rem text-gray-700 dark:text-gray-400 px-4 leading-none">
                    <i class="las la-user-edit"></i>
                </div>
            </div>
            <input required type="text" name="display_name" aria-label="<?php echo esc_attr__('Display Name', 'zimac'); ?>" placeholder="<?php echo esc_attr__('Display Name', 'zimac'); ?>" class=" px-5 h-14 w-full border-2 border-gray-300 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base pl-14 focus:border-primary focus:ring-0 font-medium" value="<?php echo esc_attr(get_userdata($userID)->display_name); ?>" />
        </div>

        <div class="wil-Textarea relative">
            <div class="absolute left-1 top-4">
                <div class="text-1.375rem text-gray-700 dark:text-gray-400 px-4 leading-none">
                    <i class="las la-pen"></i>
                </div>
            </div>
            <textarea name="description" aria-label="<?php echo esc_attr__('About me', 'zimac'); ?>" placeholder="<?php echo esc_attr__('About me', 'zimac'); ?>" class="px-5 w-full rounded-4xl border-2 border-gray-300 py-4 sm:py-3 relative placeholder-gray-600 bg-transparent text-xs md:text-base pl-14 focus:border-primary focus:ring-0 font-medium" rows="6"><?php echo esc_attr(get_user_meta($userID, 'description', true)); ?></textarea>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <?php
            foreach ($userSocials as $social => $aSocial) {
                echo '<div class="wil-input relative"><div class="absolute left-1 top-1/2 transform -translate-y-1/2"><div class="text-[26px] text-gray-900 dark:text-gray-200 px-4 leading-none">';
                echo '<i class="lab ' . esc_attr($aSocial['icon']) . '"></i>';
                echo '</div></div><input name="' . esc_attr($aSocial['key']) . '" type="url" aria-label="' . esc_attr($social) . '" placeholder="' . esc_attr($social) . '" class=" px-5 h-14 w-full border-2 border-gray-300 rounded-full placeholder-gray-600 bg-transparent text-xs md:text-base pl-14 focus:border-primary focus:ring-0 font-medium" value="' . esc_attr($aSocial['href']) . '" />
                </div>';
            }
            ?>
        </div>

        <button name="submitUpdateUser" type="submit" class="wil-button rounded-full h-14 w-full text-gray-900 bg-primary text-xs lg:text-sm xl:text-body inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none ">
            <?php echo esc_html__('Submit', 'zimac'); ?>
        </button>
    </form>
</div>
