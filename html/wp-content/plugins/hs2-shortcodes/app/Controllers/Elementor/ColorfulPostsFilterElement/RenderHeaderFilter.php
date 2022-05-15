<?php

namespace HSSC\Controllers\Elementor\ColorfulPostsFilterElement;

use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;

class RenderHeaderFilter
{
    public  $aSettings;
    public  $aPagState;
    public  $uid;

    function __construct(array $aSettings, string $uid, array $aPagState)
    {
        $this->aSettings = $aSettings;
        $this->uid = $uid;
        $this->aPagState = $aPagState;
    }


    /**
     * Render Area Pagination Next / Prev Paged
     *
     * @param string $className
     * @return string
     */
    public function renderNextPrev(string $className = "hidden md:block"): string
    {
        if ($this->aSettings['show_next_prev'] !== 'yes') {
            return '';
        }
        ob_start();
?>
        <div class="flex-shrink-0 <?php echo esc_attr($className); ?>">
            <div class="inline-flex items-center justify-between bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-full text-xl md:text-2xl py-2 px-4 w-24 h-9 md:h-11">
                <button data-block-id="<?php echo esc_attr($this->uid); ?>" data-filter-pagination-prev <?php disabled($this->aPagState['prev'], false); ?> class="-prev block disabled:text-gray-400 dark:disabled:text-gray-600">
                    <i class="las la-angle-left"></i>
                </button>
                <button data-block-id="<?php echo esc_attr($this->uid); ?>" data-filter-pagination-next class="-next block disabled:text-gray-400 dark:disabled:text-gray-600" data-glide-dir=">" <?php disabled($this->aPagState['next'], false); ?>>
                    <i class="las la-angle-right"></i>
                </button>
            </div>
        </div>
    <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * Render Area Dropdown filter by orderby
     *
     * @return string
     */
    public function renderDropdownFilterOrderBy(): string
    {
        $aOrderByOptions = $this->aSettings['order_by_options'];
        $orderby =  $this->aSettings['orderby'];
        if (!$aOrderByOptions || empty($aOrderByOptions)) {
            return '';
        }
        if (!in_array($orderby, $aOrderByOptions)) {
            $aOrderByOptions = array_merge([$orderby], $aOrderByOptions);
        }
        $aOrderByFullOptions   = App::get('ElementorCommonRegistration')::getOrderByOptions();
        ob_start();
    ?>
        <div class="wil-dropdown relative inline-block text-left">
            <button class="wil-dropdown__btn flex focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary rounded-full" type="button">
                <span class="inline-flex items-center justify-between w-full px-4 py-2.5 bg-white text-sm font-medium
                text-gray-700 hover:bg-gray-50 space-x-4 rounded-full min-w-[120px] md:min-w-[180px]">
                    <span class="text-base" data-block-id="<?php echo esc_attr($this->uid) ?>" data-filter-orderby-front>
                        <?php echo esc_html($aOrderByFullOptions[$orderby]); ?>
                    </span>
                    <i class="las la-angle-down"></i>
                </span>
            </button>
            <div class="wil-dropdown__panel absolute left-0 mt-2 shadow-lg bg-white text-gray-800 ring-1 ring-black ring-opacity-5 z-50 w-64 rounded-2.5xl overflow-hidden hidden">
                <div class="py-2" role="none">
                    <?php foreach ($aOrderByOptions as $value) : ?>
                        <a href="#" data-filter-orderby="<?php echo esc_attr($value); ?>" data-block-id="<?php echo esc_attr($this->uid) ?>" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100 hover:text-gray-900 isClose <?php echo esc_attr($value === $orderby ? 'wil-nav-item__a--type3--active' : ''); ?>">
                            <?php echo esc_html($aOrderByFullOptions[$value]); ?>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * Render area filter by categories
     * @return string
     */
    public function renderFilterCategories(): string
    {
        $aCategoies = $this->aSettings['categories'];
        if (!isset($aCategoies) || empty($aCategoies)) {
            return '';
        }
        ob_start();
    ?>
        <nav class="hidden md:block mx-auto">
            <ul class="space-x-1 md:space-x-2 flex items-center justify-start">
                <li class="wil-nav-item--type1">

                    <!-- FunctionHelper::encodeBase64($aCategoies) -> get array all cateID  -->
                    <a href="#All" data-filter-id="<?php echo esc_attr(FunctionHelper::encodeBase64($aCategoies)); ?>" data-block-id="<?php echo esc_attr($this->uid) ?>" class="block text-center text-sm md:text-base px-3 md:px-5 py-2 rounded-full font-medium wil-nav-item__a--type3--active">
                        <?php echo esc_html__('All', 'hs2-shortcodes'); ?>
                    </a>
                </li>
                <?php foreach ($aCategoies as $termId) : ?>
                    <li class="wil-nav-item--type1">
                        <a href="#<?php echo esc_attr($termId); ?>" data-block-id="<?php echo esc_attr($this->uid); ?>" class="block text-center text-xs md:text-base px-3 md:px-5 py-2 rounded-full font-medium" data-filter-id="<?php echo esc_attr($termId); ?>">
                            <?php echo esc_html(get_cat_name($termId)); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <div class="block md:hidden">
            <!-- DROPDOWN FILTER CATEGOTIES -->
            <div class="wil-dropdown relative inline-block text-left">
                <button class="wil-dropdown__btn flex focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary rounded-full" type="button">
                    <span class="inline-flex items-center justify-between w-full px-4 py-2.5 bg-white text-sm
                    font-medium text-gray-700 hover:bg-gray-50 space-x-4 rounded-full min-w-[120px] md:min-w-[180px]">
                        <span class="text-base" data-block-id="<?php echo esc_attr($this->uid) ?>" data-filter-category-front>
                            <?php echo esc_html__('All', 'hs2-shortcodes'); ?>
                        </span>
                        <i class="las la-angle-down"></i>
                    </span>
                </button>
                <div class="wil-dropdown__panel absolute right-0 mt-2 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 w-56 rounded-md hidden">
                    <div class="py-1" role="none">
                        <!-- FunctionHelper::encodeBase64($aCategoies) -> get array all cateID  -->
                        <a href="#All" data-filter-id="<?php echo esc_attr(FunctionHelper::encodeBase64($aCategoies)); ?>" data-block-id="<?php echo esc_attr($this->uid) ?>" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100 hover:text-gray-900 wil-nav-item__a--type3--active isClose">
	                        <?php echo esc_html__('All', 'hs2-shortcodes'); ?>
                        </a>
                        <?php foreach ($aCategoies as $termId) : ?>
                            <a href="#<?php echo esc_attr($termId); ?>" data-block-id="<?php echo esc_attr($this->uid); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 isClose" data-filter-id="<?php echo esc_attr($termId); ?>">
                                <?php echo esc_html(get_cat_name($termId)); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- DROPDOWN FILTER CATEGOTIES -->
        </div>
    <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function renderTitle()
    {
        ob_start();
    ?>
        <div class="wil-title-section font-bold text-xl lg:text-1.375rem flex items-center text-gray-900 dark:text-gray-100">
            <a href="<?php echo esc_url($this->aSettings['title_url']); ?>" class="truncate">
                <?php StringHelper::ksesHTML($this->aSettings['section_title']); ?>
            </a>
            <i class="las la-angle-right"></i>
        </div>
    <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function renderHeader()
    {
        ob_start();
    ?>
        <header class="mb-5 text-gray-900 dark:text-gray-100 flex items-center justify-between space-x-4">
            <div class="flex-grow space-x-0 sm:space-x-4 flex items-center justify-between">
                <div class="flex-shrink-0">
                    <!-- DROPDOWN FILTER -->
                    <?php echo $this->renderDropdownFilterOrderBy(); ?>
                    <!-- END DROPDOWN FILTER -->

                    <!-- RENDER TITLE -->
                    <?php if (!!$this->aSettings['section_title'] && empty($this->aSettings['order_by_options'])) {
                        echo $this->renderTitle();
                    } ?>
                    <!-- END RENDER TITLE -->

                </div>
                <div class="md:flex-grow flex wil-invisible-scrollbar">
                    <!-- RENDER CATEGORIES -->
                    <?php echo $this->renderFilterCategories(); ?>
                    <!-- END RENDER CATEGORIES -->
                </div>
            </div>
            <div class="hidden lg:block flex-shrink-0">
                <?php echo $this->renderNextPrev(); ?>
            </div>
        </header>
<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
