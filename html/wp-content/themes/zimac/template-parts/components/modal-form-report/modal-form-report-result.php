<?php
$modalId = 'wil-modal-form-report-comment-result';
?>
<a href="#" class="hidden" data-open-modal="<?php echo esc_attr($modalId); ?>"></a>

<div class="fixed inset-0 overflow-auto z-max bg-gray-900 bg-opacity-40 wil-backdrop-filter-15px" id="<?php echo esc_attr($modalId); ?>">
    <div>
        <div class="w-full sm:w-auto absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 p-1">
            <div class="bg-white rounded-2.5xl sm:max-w-md mx-auto text-xs md:text-base text-gray-700">
                <header class="flex items-baseline justify-between p-5 space-x-3 overflow-hidden">
                    <div>
                        <h4 class="truncate mb-1">
                            <?php echo esc_html__('Thank you for your report.', 'zimac'); ?>
                        </h4>
                        <span>
                            <?php echo esc_html__('We will remove content that goes against our community standards policy.', 'zimac'); ?>
                        </span>
                    </div>
                    <button class="flex p-2 rounded-full hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-10" type="button" data-wil-close-modal="<?php echo esc_attr($modalId); ?>">
                        <span class="sr-only">
                            <?php echo esc_html__('Dismiss', 'zimac'); ?>
                        </span>
                        <svg class="h-6 w-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" x-description="Heroicon name: x">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button>
                </header>

            </div>
        </div>
    </div>
</div>
