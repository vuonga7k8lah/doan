<?php

namespace HSSC\Shared\ThemeOptions;

/**
 * Class ThemeOptionsController
 * @package HPSBlog\Controllers
 */
class ThemeOptionSkeleton
{
	/**
	 * @var string The key of theme options
	 */
	private static $key            = 'wiloke_themeoptions';
	public         $aArgs          = [];
	public         $aSections      = [];
	public         $aConfiguration = [];
	public static  $aOptions       = [];

	/**
	 * ThemeOptionsController constructor.
	 */
	public function __construct()
	{
		add_action('init', [$this, 'render']);
	}

	/**
	 * @param false $isFocus
	 * @return array|false|mixed|void
	 */
	public static function getOptions($isFocus = false)
	{
		if (self::$aOptions && !$isFocus) {
			return self::$aOptions;
		}

		self::$aOptions = get_option(self::$key);

		return self::$aOptions;
	}

	/**
	 * @param $field
	 * @param string $default
	 * @param false $isFocus
	 * @return mixed|string
	 */
	public static function getField($field, $default = '', $isFocus = false)
	{
		self::getOptions($isFocus);

		if (self::$aOptions[$field]) {
			return self::$aOptions[$field];
		}

		return $default;
	}

	/**
	 * Rendering Theme Options
	 */
	public function render()
	{
		try {
			if (class_exists('ReduxFramework')) {

				$this->aConfiguration = include plugin_dir_path(__FILE__) . 'config.php';
				$this->setArguments();
				$this->setSections();
				new \ReduxFramework($this->aSections, $this->aArgs);
			}
		} catch (\Exception $e) {
			echo esc_html($e->getMessage());
		}
	}

	public function setSections()
	{
		$this->aSections = $this->aConfiguration['sections'];
	}

	/**
	 * All the possible arguments for Redux.
	 * For full documentation on arguments, please refer to:
	 * https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
	 * */
	public function setArguments()
	{
		$this->aConfiguration['args']['opt_name'] = self::$key;
		$this->aArgs = $this->aConfiguration['args'];
	}
}
