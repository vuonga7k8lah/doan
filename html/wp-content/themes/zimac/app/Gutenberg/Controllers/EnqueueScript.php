<?php

namespace ZIMAC\Gutenberg\Controllers;

/**
 * Class EnqueueScripts
 * @package HPSBlog\Controllers
 */
class EnqueueScript
{
	/**
	 * EnqueueScripts constructor.
	 */
	public function __construct()
	{
		add_action('enqueue_block_editor_assets', [$this, 'enqueueGutenbergEditors'], 999);
	}

	public function enqueueGutenbergEditors() {
		wp_enqueue_style('zm-editor', get_template_directory_uri() . '/app/Gutenberg/Assets/editor.css', [],
			ZIMAC_THEME_VERSION);
	}
}
