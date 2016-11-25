<?php

/**
 * Metabox Configurations
 *
 * add metaboxes here
 */
return array(
	'gallerymetabox' => array(
		'id' => 'gallery',
		'title' => 'Gallery',
		'view' => 'views/metaboxes/gallery.php',
		'name' => 'gallerymetabox',
		'context' => 'normal'
	),

	'photomanoptionsmetabox' => array(
		'id' => 'photomanoptions',
		'title' => 'Options',
		'view' => 'views/metaboxes/options.php',
		'name' => 'photomanoptionsmetabox',
		'context' => 'advanced',
	),
);