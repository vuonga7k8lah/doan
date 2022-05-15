<?php

namespace HSSC\Controllers\Shortcodes;

/**
 * Class MailPoetFormSc
 * @package HSSC\Controllers\Shortcodes
 */
class MailPoetFormSc
{
    public function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'mail_poet_form_sc', [$this, 'renderSc']);
    }

    /**
     * @param array $aAtts
     * @return string
     */
    public function renderSc($aAtts = [], $content = ""): string
    {
        ob_start();
?>
        <div class="wil-MailPoetFormSc">
            <?php echo do_shortcode($content); ?>
        </div>
<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
