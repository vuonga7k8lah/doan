<?php

use ZIMAC\Helpers\Helpers;
use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$userID = get_current_user_id();
$avatar = Helpers::getUserAvatarUrl($userID);
$userLink = get_author_posts_url($userID);
$name = get_current_user();

$accountPageLink = '';
$writePageLink = '';
$helpPageLink = '';
$enableSignIn = false;
if (defined('HSBLOG2_SC_PREFIX')) {
    $writePageLink = ThemeOptionSkeleton::getField('header_admin_user_wrire_artile_page_link');
    $accountPageLink = ThemeOptionSkeleton::getField('header_admin_user_account_page_link');
    $helpPageLink = ThemeOptionSkeleton::getField('header_admin_user_help_page_link');
    $enableSignIn =  ThemeOptionSkeleton::getField('sign_in_sign_up_login_frontend_enable_login') ?? false;
}
?>

<?php if ($userID) : ?>
    <?php if (!defined('HSBLOG2_SC_PREFIX')) : ?>
        <a href="<?php echo esc_url($userLink); ?>" class="flex-shrink-0 w-11 h-11 rounded-full border-2 border-gray-300 flex items-center justify-center ml-2 text-xl  focus:outline-none overflow-hidden p-1" type="button">
            <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 w-full h-full rounded-full <?php echo esc_attr(!$avatar ? 'wil-avatar-no-img' : ""); ?>">
                <?php if ($avatar) : ?>
                    <img alt="<?php echo esc_attr($name); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($avatar); ?>">
                <?php endif; ?>
                <span class="wil-avatar__name">
                    <?php echo esc_html(substr($name, 0, 1)); ?>
                </span>
            </div>
        </a>
    <?php else : ?>
        <div class="wil-dropdown relative inline-block text-left">
            <!-- BUTTON -->
            <button class="wil-dropdown__btn flex-shrink-0 w-11 h-11 rounded-full border-2 border-gray-300 flex items-center justify-center ml-2 text-xl  focus:outline-none overflow-hidden p-1" type="button">
                <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 w-full h-full rounded-full <?php echo esc_attr(!$avatar ? 'wil-avatar-no-img' : ""); ?>">
                    <?php if ($avatar) : ?>
                        <img alt="<?php echo esc_attr($name); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($avatar); ?>">
                    <?php endif; ?>
                    <span class="wil-avatar__name">
                        <?php echo esc_html(substr($name, 0, 1)); ?>
                    </span>
                </div>
            </button>
            <!-- PANEL -->
            <div class="wil-dropdown__panel absolute right-0 mt-2 shadow-lg bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 ring-1 ring-black ring-opacity-5 z-50 w-64 rounded-2.5xl overflow-hidden hidden">
                <div class="py-4 px-5 border-b border-gray-300 dark:border-gray-700">
                    <div class="flex space-x-3">
                        <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 w-12 h-12 rounded-full <?php echo esc_attr(!$avatar ? 'wil-avatar-no-img' : ""); ?>">
                            <?php if ($avatar) : ?>
                                <img alt="<?php echo esc_attr($name); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($avatar); ?>">
                            <?php endif; ?>
                            <span class="wil-avatar__name">
                                <?php echo esc_html(substr($name, 0, 1)); ?>
                            </span>
                        </div>
                        <div class="flex flex-col justify-center text-base truncate">
                            <h6 class="text-base truncate capitalize leading-tight mb-1px mt-0">
                                <?php echo esc_html(get_userdata($userID)->display_name);   ?>
                            </h6>
                            <span class="text-gray-600 dark:text-gray-500 truncate leading-tight">
                                <?php echo esc_html(get_userdata($userID)->user_nicename);   ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="py-3 border-b border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300" role="none">
                    <?php if (!!$accountPageLink) : ?>
                        <a href="<?php echo esc_url($accountPageLink); ?>" class="flex items-center space-x-2 px-5 py-2 text-base hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100" >
                            <i class="las la-address-card text-body leading-none"></i>
                            <span><?php echo esc_html__('Profile ', 'zimac'); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if (!!$writePageLink) : ?>
                        <a href="<?php echo esc_url($writePageLink); ?>" class="flex items-center space-x-2 px-5 py-2 text-base hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100" >
                            <i class="las text-body leading-none la-edit"></i>
                            <span><?php echo esc_html__('Write an artcle', 'zimac'); ?></span>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($userLink . '?pageType=saved'); ?>" class="flex items-center space-x-2 px-5 py-2 text-base hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100" >
                        <i class="las text-body leading-none la-bookmark"></i>
                        <span><?php echo esc_html__('Saved', 'zimac'); ?></span>
                    </a>
                </div>
                <div class="py-3" role="none">
                    <?php if (!!$helpPageLink) : ?>
                        <a href="<?php echo esc_url($helpPageLink); ?>" class="flex items-center space-x-2 px-5 py-2 text-base hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100" >
                            <i class="las text-body leading-none la-question-circle"></i>
                            <span><?php echo esc_html__('Help', 'zimac'); ?></span>
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="flex items-center space-x-2 px-5 py-2 text-base hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100" >
                        <i class="las text-body leading-none la-sign-out-alt"></i>
                        <span><?php echo esc_html__('Sign out', 'zimac'); ?></span>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if (!$userID) : ?>
    <?php if ($enableSignIn) : ?>
        <button class="flex-shrink-0 w-11 h-11 rounded-full border-2 border-gray-300 flex items-center justify-center ml-2 text-xl  focus:outline-none" type="button" data-open-modal="wil-modal-form-sign-in">
            <i class="las la-user"></i>
        </button>
    <?php else : ?>
        <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="flex-shrink-0 w-11 h-11 rounded-full border-2 border-gray-300 flex items-center justify-center ml-2 text-xl  focus:outline-none">
            <i class="las la-user"></i>
        </a>
    <?php endif; ?>
<?php endif; ?>
