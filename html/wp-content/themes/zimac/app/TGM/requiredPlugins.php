<?php

require_once get_template_directory() . '/app/TGM/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'zmRequiredPlugins');

function zmRequiredPlugins()
{
	$plugins = array(
		// === Hsblog2 Shortcodes === //
		[
			'name'               => 'Hs2 Shortcodes',
			'slug'               => 'hs2-shortcodes',
			'source'             => get_template_directory() . '/plugins/hs2-shortcodes.zip',
			'required'           => true
		],
		// === wiloke-jwt === //
		[
			'name'               => 'Wiloke JWT',
			'slug'               => 'wiloke-jwt',
			'source'             => get_template_directory() . '/plugins/wiloke-jwt.zip',
			'required'           => true,
			'version'            => '1.0',
		],
		// === Nextend Social Login and Register === //
		[
			'name'               => 'Redux Framework',
			'slug'               => 'redux-framework',
			'required'           => true
		],
		// === CMB2 === //
		[
			'name'               => 'CMB2 Plugin',
			'slug'               => 'cmb2',
			'required'           => true
		],
		// === Nextend Social Login and Register === //
		[
			'name'               => 'Nextend Social Login and Register',
			'slug'               => 'nextend-facebook-connect',
			'required'           => true
		],
		// === SearchWP Live Ajax Search === //
		[
			'name'               => 'SearchWP Live Ajax Search',
			'slug'               => 'searchwp-live-ajax-search',
			'required'           => true
		],
		// === WP User Frontend === //
		[
			'name'               => 'WP User Frontend',
			'slug'               => 'wp-user-frontend',
			'required'           => false
		],
		// === One Click Demo Import === //
		[
			'name'               => 'One Click Demo Import',
			'slug'               => 'one-click-demo-import',
			'required'           => true
		],
		// === Elementor === //
		[
			'name'               => 'Elementor',
			'slug'               => 'elementor',
			'required'           => false
		],
		// === MailPoet === //
		[
			'name'               => 'MailPoet Newsletters',
			'slug'               => 'mailpoet',
			'required'           => false
		],
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = [
		'id'           => 'HsBlog2Sc',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	];
	tgmpa($plugins, $config);
}
