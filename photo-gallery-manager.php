<?php
/*
* Plugin Name: Photo Gallery Manager
* Plugin URI: #
* Description: A photo gallery with lightbox support
* Version: 0.0.2
* Author: John Lioneil P. Dionisio
*/

if( !function_exists( 'add_action' ) ) { echo "Hi there!  I'm just a plugin, not much I can do when called directly."; exit; }

if (!defined('PHOTOMAN_TEXT_DOMAIN')) define('PHOTOMAN_TEXT_DOMAIN', 'photoman-text-domain');

if (!defined('PHOTOMAN_VERSION')) define('PHOTOMAN_VERSION', '0.0.2');

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

    foreach ($metaboxes as $name => $metabox) {
        add_meta_box(
            $metabox['id'], // $id
            $metabox['title'], // $title
            function () use ($metabox) {
                global $post, $post_id;

                $global = require("config/global.php");
                require __DIR__ . "/views/partials/nonce.php";

                $old = get_post_meta($post->ID, $metabox['name'], true);

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

    if (!isset($_POST[$global['nonce']]) && !wp_verify_nonce($_POST[$global['nonce']], $global['nonce'])) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id) || !current_user_can( 'edit_page', $post_id )) {
        return $post_id;
    }

    if ($post->post_type == 'revision') {
        return $post_id;
    }

    foreach ($metaboxes as $key => $metabox) {
        $metas = isset($_POST[$metabox['name']]) ? $_POST[$metabox['name']] : false;

        if(get_post_meta($post_id, $metabox['name'], FALSE)) {
            // If the custom field already has a value
            update_post_meta($post_id, $metabox['name'], $metas);
        } else {
            // If the custom field doesn't have a value
            add_post_meta($post_id, $metabox['name'], $metas);
        }

        if(!$metas) delete_post_meta($post_id, $metabox['name']);
    }
}


/**
 * # Displaying & Shortcodes
 *
 */
add_filter('the_content', 'photoman_display_the_content');
function photoman_display_the_content($the_content) {
    global $post;
    $cpts = require("config/cpt.php");
    foreach ($cpts as $name => $cpt) {
        $query = get_posts("post_type=$name");
        if($query) {
            foreach ($query as $q) {
                $metaboxes = require("config/metaboxes.php");
                $options = get_post_meta($q->ID, $metaboxes['photomanoptionsmetabox']['name'], true);
                if (isset($options) && array_key_exists('display', $options) && array_key_exists('shortcode', $options) && get_the_ID() == $options['display']) {
                    $the_content .= do_shortcode($options['shortcode']);
                }
            }
        }
    }
    return $the_content;
}

$global = require("config/global.php");
foreach ($global['shortcodes'] as $shortcode) {
    add_shortcode($shortcode, function ($atts, $content = "") use ($shortcode) {
        $atts = shortcode_atts(array(
            'id' => false,
            'class' => 'photo-gallery',
            'container-class' => 'offset-sm-1 col-sm-10',
            'items' => 3
        ), $atts);
        ob_start();
        $q = get_post($atts['id']);
        if ($atts['id'] != false) {
            $metaboxes = require("config/metaboxes.php");
            $options = get_post_meta($q->ID, $metaboxes['photomanoptionsmetabox']['name'], true);
            $post = $q;
            setup_postdata($post);
            if (file_exists(get_template_directory()."/photo-gallery-manager/$shortcode.php")) {
                require get_template_directory() . "/photo-gallery-manager/$shortcode.php";
            } else {
                require __DIR__ . "/views/content/$shortcode.php";
            }
        } else {
            $cpts = require("config/cpt.php");
            foreach ($cpts as $name => $cpt) {
                $query = get_posts("post_type=$name");
                if($query) {
                    foreach ($query as $q) {
                        $metaboxes = require("config/metaboxes.php");
                        $options = get_post_meta($q->ID, $metaboxes['photomanoptionsmetabox']['name'], true);
                        if (isset($options) && array_key_exists('display', $options) && get_the_ID() == $options['display']) {
                            $post = $q;
                            setup_postdata($post);
                            if (file_exists(get_template_directory()."/photo-gallery-manager/$shortcode.php")) {
                                require get_template_directory() . "/photo-gallery-manager/$shortcode.php";
                            } else {
                                require __DIR__ . "/views/content/$shortcode.php";
                            }
                        }
                    }
                }
            }
        }
        wp_reset_postdata();
        return ob_get_clean();
    });
}



/**
 * Enqueue Admin Styles
 *
 */
add_action('admin_enqueue_scripts', 'photoman_enqueue_admin_styles');
function photoman_enqueue_admin_styles() {
    wp_enqueue_style('photoman', plugins_url('/assets/css/app.min.css', __FILE__), false, PHOTOMAN_VERSION);
}

add_action('admin_enqueue_scripts', 'photoman_enqueue_admin_scripts');
function photoman_enqueue_admin_scripts() {
    wp_enqueue_script('cloner', plugins_url('/vendor/jquery-cloner/dist/jquery.cloner.js', __FILE__), array('jquery'), '1.2.3', true);

    wp_enqueue_script('admin', plugins_url('/js/admin.js', __FILE__), array('jquery'), PHOTOMAN_VERSION, true);
}

/**
 * Enqueue Forntend Styles & Scripts
 *
 */
add_action('wp_enqueue_scripts', 'photoman_enqueue_styles');
add_action('wp_print_scripts', 'photoman_enqueue_footer_scripts');
function photoman_enqueue_styles() {
    wp_register_style('lightgallery', plugins_url('/vendor/lightgallery/dist/css/lightgallery.min.css', __FILE__), array(), PHOTOMAN_VERSION, 'all');
    wp_enqueue_style('lightgallery');
    wp_register_style('lightgallery-transitions', plugins_url('/vendor/lightgallery/dist/css/lg-transitions.min.css', __FILE__), array(), PHOTOMAN_VERSION, 'all');
    wp_enqueue_style('lightgallery-transitions');

    wp_register_style('owl-carousel', plugins_url('/vendor/owl-carousel/owl-carousel/owl.carousel.css', __FILE__), array(), PHOTOMAN_VERSION, 'all');
    wp_enqueue_style('owl-carousel');
    wp_register_style('owl-carousel-theme', plugins_url('/vendor/owl-carousel/owl-carousel/owl.theme.css', __FILE__), array(), PHOTOMAN_VERSION, 'all');
    wp_enqueue_style('owl-carousel-theme');
    wp_register_style('owl-carousel-transition', plugins_url('/vendor/owl-carousel/owl-carousel/owl.transitions.css', __FILE__), array(), PHOTOMAN_VERSION, 'all');
    wp_enqueue_style('owl-carousel-transition');

    wp_register_style('photoman-front', plugins_url('/css/photoman-front.css', __FILE__), array(), PHOTOMAN_VERSION, 'all');
    wp_enqueue_style('photoman-front');
}

function photoman_enqueue_footer_scripts() {
    wp_register_script('lightgallery', plugins_url('/vendor/lightgallery/lib/lightgallery-all.min.js', __FILE__), array('jquery'), '1.3.3', true);
    wp_enqueue_script('lightgallery');

    wp_register_script('owl-carousel', plugins_url('/vendor/owl-carousel/owl-carousel/owl.carousel.min.js', __FILE__), array('jquery'), '1.3.3', true);
    wp_enqueue_script('owl-carousel');

    wp_register_script('photoman-front', plugins_url('/js/photoman-front.js', __FILE__), array('jquery', 'lightgallery', 'owl-carousel'), '1.3.3', true);
    wp_enqueue_script('photoman-front');
}