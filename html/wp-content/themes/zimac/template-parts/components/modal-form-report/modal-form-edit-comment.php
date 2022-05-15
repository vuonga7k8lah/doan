<?php
$modalId = 'wil-modal-form-edit-comment--' . $args['id'];
?>

<div class="hidden fixed inset-0 overflow-auto z-max bg-gray-900 bg-opacity-40 wil-backdrop-filter-15px" id="<?php echo esc_attr($modalId); ?>">
    <div>
        <div class="w-full sm:w-auto absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 p-1">
            <div class="bg-white rounded-2.5xl w-[450px] max-w-full mx-auto text-xs md:text-base text-gray-700">
                <header class="flex items-baseline justify-between px-5 pt-3 space-x-3 overflow-hidden">
                    <div>
                        <h4 class="truncate mb-1">
                            <?php echo esc_html__('Edit comment', 'zimac'); ?>
                        </h4>
                    </div>
                    <button class="flex p-2 rounded-full hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-10" type="button" data-wil-close-modal="<?php echo esc_attr($modalId); ?>">
                        <span class="sr-only">
                            <?php echo esc_html__('Dissmis', 'zimac'); ?>
                        </span>
                        <svg class="h-6 w-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" x-description="Heroicon name: x">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button>
                </header>
                <div class="p-5 space-y-5">
                    <!-- CUSTOM LOGIN FORM -->
                    <form class="space-y-5" name="report-comment-form" method="POST" action="<?php echo esc_url(get_permalink()); ?>">
                        <input hidden type="hidden" id="edit-comment-id" name="edit-comment-id" value="<?php echo esc_attr($args['id']); ?>" />
                        <div class="wil-input relative">
                            <textarea id="edit-comment-textarea" name="edit-comment-content" aria-required="true" required class="h-32 md:h-36 py-3 px-5 border-2 border-gray-300 dark:border-gray-600 w-full rounded-[30px] placeholder-gray-600 bg-transparent text-xs md:text-base focus:border-primary focus:ring-0 font-medium"><?php echo esc_html(get_comment_text($args['id'])); ?></textarea>
                        </div>
                        <div class="flex justify-end mt-8 space-x-3">
                            <button class="wil-button rounded-full h-14 w-full text-gray-900  bg-gray-200  text-xs lg:text-sm inline-flex items-center justify-center text-center py-2 px-4 md:px-5 font-bold focus:outline-none " data-wil-close-modal="<?php echo esc_attr($modalId); ?>">
                                <?php echo esc_html__('Cancel', 'zimac'); ?>
                            </button>
                            <button name="edit-comment-submit" type="submit" class="wil-button rounded-full h-14 w-full text-gray-900  bg-primary  text-xs lg:text-sm inline-flex items-center justify-center text-center py-2 px-4 md:px-5 font-bold focus:outline-none ">
                                <?php echo esc_html__('Edit', 'zimac'); ?>
                            </button>
                        </div>

                        <input type="hidden" name="redirect_to" value="<?php echo esc_url(get_permalink()); ?>">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
