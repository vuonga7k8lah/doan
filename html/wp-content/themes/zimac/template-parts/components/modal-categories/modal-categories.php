<?php
$aTermResults = $args['termResults'];
$modalId = 'wil-modal-list-categories';
?>

<div class="hidden fixed inset-0 overflow-auto z-max bg-gray-800" id="<?php echo esc_attr($modalId); ?>">
    <div>
        <div class="w-full h-full absolute inset-0 p-10 md:p-16 xl:px-[85px] xl:py-[120px]">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-5 xl:gap-8">
                <?php foreach ($aTermResults as  $oTerm) {
                    zimac_render_category_card(['oTerm' => $oTerm]);
                } ?>
            </div>
            <button class="flex p-2 rounded-full absolute top-1 right-1 md:top-2 md:right-2  transition focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white bg-opacity-10" type="button" data-wil-close-modal="<?php echo esc_attr($modalId); ?>">
                <span class="sr-only">
                    <?php echo esc_html__('Dissmis', 'zimac'); ?>
                </span>
                <svg class="h-6 w-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
