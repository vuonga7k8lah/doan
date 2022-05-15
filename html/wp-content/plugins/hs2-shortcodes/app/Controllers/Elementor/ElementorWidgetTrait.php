<?php


namespace HSSC\Controllers\Elementor;


trait ElementorWidgetTrait
{
    /**
     * @param string $target
     * @param string $default
     * @return mixed|string
     */
    protected function getConfiguration(string $target, $default = '')
	{
		$aPath = explode('\\', __CLASS__);
		$folder = end($aPath);
		if (!$this->aConfig) {
			$this->aConfig = include plugin_dir_path(__FILE__) . $folder . '/config.php';
		}
		return array_key_exists($target, $this->aConfig) ? $this->aConfig[$target] : $default;
	}
}
