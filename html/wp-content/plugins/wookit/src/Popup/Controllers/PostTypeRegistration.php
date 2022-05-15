<?php

namespace DoAn\Popup\Controllers;

use DoAn\Shared\AutoPrefix;

class PostTypeRegistration
{
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType()
    {
        register_post_type(AutoPrefix::namePrefix('popup'), include MYSHOOKITPSS_PATH_1.'src/Popup/Configs/PostType.php');
    }
}
