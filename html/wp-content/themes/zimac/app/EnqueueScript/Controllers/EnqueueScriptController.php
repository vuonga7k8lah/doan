<?php

namespace ZIMAC\EnqueueScript\Controllers;

use DirectoryIterator;

/**
 * Class EnqueueScriptController
 * @package ZM\EnqueueScript\Controllers
 */
class EnqueueScriptController
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', [$this, 'registerStyles'], 998);
		add_action('wp_enqueue_scripts', [$this, 'registerScripts']);
		//
		add_action('enqueue_block_editor_assets', [$this, 'registerStylesAdmin']);
		add_action('admin_enqueue_scripts', [$this, 'registerScriptsAdmin']);
		//
		$script = 'script';
		$tag = '_loader_tag';
		add_filter(
			$script . $tag,
			[$this, 'addModuleTypeForScripts'],
			10,
			3
		);
	}

	/**
	 *
	 */
	function addModuleTypeForScripts($tag, $handle, $src)
	{
		if ('vitejs' === $handle) {
			return $tag = '<script id="' . esc_attr($handle) . '" type="module" src="' . esc_url($src) . '"></script>';
		}
		return $tag;
	}

	/**
	 *  register styles
	 */
	public function registerStylesAdmin($hook)
	{
		// if ('post.php' !== $hook) {
		//     return;
		// }
		$dirCSS = [];
		if (is_dir(get_stylesheet_directory() . '/assets/dist/assets/')) {
			$dirCSS = new DirectoryIterator(get_stylesheet_directory() . '/assets/dist/assets');
		}
		foreach ($dirCSS as $file) {
			if (pathinfo($file, PATHINFO_EXTENSION) === 'css' &&
				preg_match('/^editor./', pathinfo($file, PATHINFO_FILENAME))) {
				$fullName = basename($file);
				$name = ZIMAC_THEME_SCRIPT_PREFIX . substr(basename($fullName), 0, strpos(basename($fullName), '.'));
				wp_enqueue_style($name, get_template_directory_uri() . '/assets/dist/assets/' . $fullName, [],
					ZIMAC_THEME_VERSION, 'all');
			}
		}
		wp_enqueue_style(
			ZIMAC_THEME_SCRIPT_PREFIX . 'assets-style',
			get_template_directory_uri() . '/assets/dist/css/styles.css',
			[],
			ZIMAC_THEME_VERSION,
			'all'
		);
	}

	public function registerStyles()
	{
		$dirCSS = [];
		// WILL ENABLE WHEN DEPLOY BUILD
		if (is_dir(get_stylesheet_directory() . '/assets/dist/assets/')) {
			$dirCSS = new DirectoryIterator(get_stylesheet_directory() . '/assets/dist/assets');
		}

		foreach ($dirCSS as $file) {
			if (pathinfo($file, PATHINFO_EXTENSION) === 'css' &&
				preg_match('/^main./', pathinfo($file, PATHINFO_FILENAME))) {
				$fullName = basename($file);
				$name = ZIMAC_THEME_SCRIPT_PREFIX . substr(basename($fullName), 0, strpos(basename($fullName), '.'));
				wp_enqueue_style($name, get_template_directory_uri() . '/assets/dist/assets/' . $fullName, [],
					ZIMAC_THEME_VERSION, 'all');
			}
		}
		wp_enqueue_style(
			'line-awesome',
			get_template_directory_uri() . '/assets/dist/fonts/line-awesome-1.3.0/css/line-awesome.min.css',
			[],
			'1.3.0',
			'all'
		);

		wp_enqueue_style(
			ZIMAC_THEME_SCRIPT_PREFIX . 'assets-style',
			get_template_directory_uri() . '/assets/dist/css/styles.css',
			[],
			ZIMAC_THEME_VERSION
		);
		wp_enqueue_style(ZIMAC_THEME_SCRIPT_PREFIX . 'main-style', get_template_directory_uri() . '/style.css', [],
			ZIMAC_THEME_VERSION, 'all');
	}

	/**
	 * @param $hook
	 */
	public function registerScriptsAdmin($hook)
	{
		if ('post.php' !== $hook) {
			return;
		}

		if (is_dir(get_stylesheet_directory() . '/assets/dist/assets/')) {
			$dirJS = new DirectoryIterator(get_stylesheet_directory() . '/assets/dist/assets');
		}

		foreach ($dirJS as $file) {
			if (pathinfo($file, PATHINFO_EXTENSION) === 'js' &&
				preg_match('/^editor./', pathinfo($file, PATHINFO_FILENAME))) {
				$fullName = basename($file);
				$name = ZIMAC_THEME_SCRIPT_PREFIX . substr(basename($fullName), 0, strpos(basename($fullName), '.'));
				wp_enqueue_script($name, get_template_directory_uri() . '/assets/dist/assets/' . $fullName, [],
					ZIMAC_THEME_VERSION, true);
			}
		}
	}

	/**
	 *  register scripts
	 */
	public function registerScripts()
	{
		$dirJS = [];
		// WILL ENABLE WHEN DEPLOY BUILD PRODUCT
		if (is_dir(get_stylesheet_directory() . '/assets/dist/assets/')) {
			$dirJS = new DirectoryIterator(get_stylesheet_directory() . '/assets/dist/assets');
		}

		foreach ($dirJS as $file) {
			if (pathinfo($file, PATHINFO_EXTENSION) === 'js' &&
				preg_match('/^main./', pathinfo($file, PATHINFO_FILENAME))) {
				$fullName = basename($file);
				wp_enqueue_script('vitejs',
					get_template_directory_uri() . '/assets/dist/assets/' . $fullName, [], ZIMAC_THEME_VERSION, true);
			}
		}

		if (is_singular()) {
			wp_enqueue_script('comment-reply');
		}

		wp_enqueue_script(
			'axios',
			get_template_directory_uri() . '/assets/dist/js/axios.min.js',
			[],
			'0.21.1',
			false
		);
	}
}
