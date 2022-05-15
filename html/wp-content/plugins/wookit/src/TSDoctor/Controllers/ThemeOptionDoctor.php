<?php

namespace DoAn\TSDoctor\Controllers;

use Redux;

class ThemeOptionDoctor
{
    public function __construct()
    {
        add_filter(
            HSBLOG2_SC_PREFIX . '/configuration/themeoptions',
            [$this, 'addThemeOptionSettings']
        );
    }

    public function addThemeOptionSettings($optionName)
    {
        $aListOptionConfig = array_values(include plugin_dir_path(__FILE__) . '../Configs/ThemeOption.php');
        $aData=array_merge($optionName,$aListOptionConfig);
        return $aData;
    }
}
