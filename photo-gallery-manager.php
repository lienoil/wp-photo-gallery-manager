<?php
/*
* Plugin Name: Photo Gallery Manager
* Plugin URI: #
* Description: A photo gallery with lightbox support
* Version: 2.0
* Author: John Lioneil P. Dionisio
*/

if( !function_exists( 'add_action' ) ) { echo "Hi there!  I'm just a plugin, not much I can do when called directly."; exit; }

if (!defined('PHOTOMAN_TEXT_DOMAIN')) {
    define('PHOTOMAN_TEXT_DOMAIN', 'photoman-text-domain');
}

/**
 * Wordpress Hooks
 *
 */
add_action('init', 'photoman_cpt_init');
add_action('add_meta_boxes', 'photoman_cpt_metaboxes');
add_action('save_post', 'photoman_cpt_save_metaboxes', 1, 2);

/**
 * Register all Custom Post Types found
 * in /config/cpt.php
 *
 * @see  /config/cpt.php
 * @return void
 */
function photoman_cpt_init() {
    $cpts = require("config/cpt.php");

    if (is_null($cpts)) return false;

    foreach ($cpts as $key => $cpt) {
        $labels = array(
            'name'              => ucwords($cpt['name']),
            'singular_name'     => ucwords($cpt['name']),
            'all_items'         => "All " . ucwords($cpt['names']),
            'add_new'           => "Add New " . ucwords($cpt['name']),
            'add_new_item'      => "Add New " . ucwords($cpt['name']),
            'edit_item'         => "Edit " . ucwords($cpt['name']),
            'new_item'          => "New " . ucwords($cpt['name']),
            'view_item'         => "View " . ucwords($cpt['name']),
            'search_items'      => "Search " . ucwords($cpt['names']),
            'not_found'         => "No " . ucwords($cpt['name']) . " found",
            'not_found_in_trash'=> "No " . ucwords($cpt['name']) . " found in trash",
            'parent_item_colon' => "Parent " . ucwords($cpt['name']) . ":",
            'menu_name'         => _x(ucwords($cpt['names']), 'wordpress')
        );

        $args = array(
            'labels'            => $labels,
            'query_var'         => $cpt['name'],
            'rewrite'           => $cpt['rewrite'],
            'menu_icon'         => $cpt['icon'],
            'public'            => false,
            'hierarchical'      => true,
            'supports'          => $cpt['supports'],
            'show_ui'           => true,
            'show_in_menu'      => true,
            'menu_position'     => $cpt['menu_position'],
            'show_in_nav_menus' => false,
            'publicly_queryable'=> false,
            'exclude_from_search' => true,
            'has_archive'       => true,
            'can_export'        => true,
            'capability_type'   => 'post',
            'capabilities' => array(
                'read' => true,
                'create_posts' => true, // Toggles support for the "Add New" function
            ),
            'map_meta_cap' => true, // Set to false, if users are not allowed to edit/delete existing posts
        );

        register_post_type($cpt['name'], $args);
    }

}

/**
 * Register all metaboxes found
 * in /config/metaboxes.php
 *
 * @see  /config/metaboxes.php
 * @return void
 */
function photoman_cpt_metaboxes() {
    $cpts = require("config/cpt.php");
    $metaboxes = require("config/metaboxes.php");

    if (is_null($metaboxes)) return false;

    foreach ($metaboxes as $key => $metabox) {
        add_meta_box(
            $metabox['id'], // $id
            $metabox['title'], // $title
            function () use ($metabox) {
                global $post;

                $global = require("config/global.php");
                require("views/partials/nonce.php");

                $old = get_post_meta($post->ID, $metabox['htmlname'], true);

                require($metabox['view']);
            }, // $callback
            $cpts['gallery']['slug'], // $page
            $metabox['context'], // $context
            'default' // $callback args
        );
    }
}

/**
 * Save metaboxes
 *
 * @param  int $post_id The posts' ID
 * @param  Object $post    The post object
 * @return void
 */
function photoman_cpt_save_metaboxes($post_id, $post)
{
    $global = require("config/global.php");
    $metaboxes = require("config/metaboxes.php");

    if (isset($_POST[$global['nonce']]) && !wp_verify_nonce($_POST[$global['nonce']], plugin_basename(__FILE__))) {
        return $post_id;
    }

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id) || !current_user_can( 'edit_page', $post_id )) {
        return $post_id;
    }

    if ($post->post_type == 'revision') {
        return $post_id;
    }

    foreach ($metaboxes as $key => $metabox) {
        $metas = isset($_POST[$metabox['htmlname']]) ? $_POST[$metabox['htmlname']] : false;

        if(get_post_meta($post_id, $metabox['htmlname'], FALSE)) {
            // If the custom field already has a value
            update_post_meta($post_id, $metabox['htmlname'], $metas);
        } else {
            // If the custom field doesn't have a value
            add_post_meta($post_id, $metabox['htmlname'], $metas);
        }

        if(!$metas) delete_post_meta($post_id, $metabox['htmlname']);
    }
}


/**
 * # Shortcodes
 *
 */
add_shortcode('schedule', 'add_photoman_gallery_shortcode');