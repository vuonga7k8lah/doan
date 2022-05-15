<?php
$postId = $args->ID;
$featuredImage = get_the_post_thumbnail_url($postId, 'medium');
$avatar = get_avatar_url($args->post_author);
$class = empty($avatar) ?
    'wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 rounded-xl w-10 h-10 wil-avatar-no-img' :
    'wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 rounded-xl w-10 h-10';
$authorName = get_the_author_meta('display_name', $args->post_author);
?>
<div class="wil-post-card-6 relative rounded-2xl overflow-hidden">
    <?php if (!empty($featuredImage)) : ?>
        <div class="relative h-0 pt-56.25% bg-gray-400">
            <img alt="<?php echo esc_attr($args->post_title); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($featuredImage); ?>">
        </div>
    <?php endif; ?>
    <div class="bg-white dark:bg-gray-900 p-5 pt-4 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center">
            <div class="flex items-center truncate">
                <div class="<?php echo esc_attr($class); ?>">
                    <?php if (empty($avatar)) { ?>
                        <span class="wil-avatar__name"><?php echo esc_html(substr($authorName, 0, 1)); ?></span>
                    <?php } else { ?>
                        <img alt="<?php echo esc_attr($authorName); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($avatar); ?>">
                        <span class="wil-avatar__name"><?php echo esc_html(substr($authorName, 0, 1)); ?></span>
                    <?php } ?>
                </div>
                <span class="truncate ml-10px text-base font-medium"><?php echo esc_html($authorName); ?></span>
            </div>
            <div class="flex-shrink-0 ml-2">
                <div class="wil-post-info flex items-center truncate space-x-3.5 xl:text-sm text-xs font-medium leading-tight text-gray-800 dark:text-gray-300">
                    <div class="truncate"><i class="las la-comment text-base opacity-80 leading-tight"></i>
                        <span><?php echo esc_html($args->comment_count); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <h6 class="wil-line-clamp-2 mt-4 mb-5"><?php echo get_the_title($postId); ?></h6>
        <div class="flex justify-between items-center">
            <span class="text-xs text-gray-700 dark:text-gray-300 font-medium truncate mr-4">
                <?php echo esc_attr(date(get_option('date_format'), strtotime($args->post_date))); ?>
            </span>
        </div>
    </div>
    <a class="absolute inset-0 z-0" href="<?php echo esc_url(get_permalink($postId)); ?>">
        <span class="sr-only"><?php echo get_the_title($postId); ?></span>
    </a>
</div>