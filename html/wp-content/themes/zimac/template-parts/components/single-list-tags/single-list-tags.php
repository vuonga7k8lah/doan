<ul class="mb-10 wil-single-list-tags">
    <?php
    $aTags = get_the_tags();
    if ($aTags && !is_wp_error($aTags)) : ?>
        <?php foreach ($aTags as $oTag) : ?>
            <li class="inline-block">
                <a class="inline-block px-3.5 py-2 text-gray-900 bg-gray-300 text-sm font-medium rounded-1.5xl mr-2 mb-1" href="<?php echo esc_url(get_tag_link($oTag->term_id)); ?>" title="<?php echo esc_attr($oTag->name); ?>">
                    <?php echo esc_html($oTag->name); ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>