<?php

use DoAn\Shared\AutoPrefix;

$labels = [
	'name'           => esc_html__( 'Tuyển sinh Tiến sĩ', 'do an' ),
	'singular_name'  => esc_html__( 'Tuyển sinh Tiến sĩ', 'do an' ),
	'menu_name'      => esc_html__( 'Tuyển sinh Tiến sĩ', 'do an' ),
	'name_admin_bar' => esc_html__( 'Tuyển sinh Tiến sĩ', 'do an' )
];

return [
	'description'        => esc_html__( 'The setting for your Slide in', 'do an' ),
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'query_var'          => true,
	'rewrite'            => [ 'slug' => AutoPrefix::namePrefix( 'TSDoctor' ) ],
	'post_type'          => AutoPrefix::namePrefix( 'TSDoctor' ),
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => true,
	'menu_position'      => null,
	'supports'           => [ 'title', 'editor', 'thumbnail', 'author' ]
];
