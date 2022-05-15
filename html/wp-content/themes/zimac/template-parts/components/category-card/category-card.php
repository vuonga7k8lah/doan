<?php
$oTerm = $args['oTerm'];

$termLink = get_term_link($oTerm);
if (is_wp_error($termLink)) {
    return '';
}
$termImg =  get_term_meta($oTerm->term_id, 'hs_term_featured_image', true);
$termImg =  !!$termImg ? $termImg : get_template_directory_uri() . '/assets/dist/images/placeholder.jpg';
?>
<a href="<?php echo esc_url($termLink); ?>" class="wil-cat-box-1 block w-full relative rounded-2xl overflow-hidden pt-62.5% md:pt-56.25% lg:pt-53.8% h-0">
    <?php if (!!$termImg) : ?>
        <img class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($termImg); ?>" alt="<?php echo esc_attr($oTerm->name); ?>">
    <?php endif; ?>
    <div class="absolute inset-0 bg-gray-900 bg-opacity-25 flex items-center justify-center p-2">
        <span class="truncate px-3 md:px-5 py-3 text-xs lg:text-base leading-5 font-bold text-white text-center bg-white bg-opacity-10 wil-backdrop-filter-6px rounded-1.5xl">
            <?php echo esc_html($oTerm->name); ?>
        </span>
    </div>
</a>