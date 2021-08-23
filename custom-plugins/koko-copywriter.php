<?php
/**
 * Plugin Name: Koko Copywriter
 * Plugin URI: http://devopsowy.pl
 * Description: Add reference to your articles.
 * Version: 1.0
 * Author: Bartłomiej Komendarczuk
 * Author URI: http://devopsowy.pl
 */

 add_action( 'admin_menu', 'copywriter_admin_page' );

 function create_categories_table(){
     global $wpdb;
     $tableName = 'copywriter_categories';
     $wp_track_table = $wpdb->prefix . "$tableName";
     $charset_collate = $wpdb->get_charset_collate();

     $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
     `category_id` int(11) NOT NULL AUTO_INCREMENT,
     `name` varchar(256) NOT NULL,
     `image` LONGBLOB NOT NULL,
     PRIMARY KEY  (category_id)
     ) $charset_collate;";
     require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
     dbDelta($sql);
 }

 function create_articles_table(){
    global $wpdb;
    $tableName = 'copywriter_articles';
    $wp_track_table = $wpdb->prefix . "$tableName";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
    `article_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(256) NOT NULL,
    `source` varchar(2083) NOT NULL,
    `text` MEDIUMTEXT,
    `image` LONGBLOB NOT NULL,
    `category_id` int(11) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES wp_copywriter_categories(category_id),
    PRIMARY KEY  (article_id)
    ) $charset_collate;";
    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

 register_activation_hook( __FILE__, 'create_categories_table' );
 register_activation_hook( __FILE__, 'create_articles_table' );

function copywriter_admin_page()
 {
     add_menu_page( 'Copywriter', 'Copywriter', 'manage_options', 'copywriter-menu', 'copywriter_category_init', 'dashicons-media-text' );
     add_submenu_page( 'copywriter-menu', 'Teksty', 'Teksty', 'manage_options', 'Teksty', 'copywriter_articles_init' );
     add_submenu_page( 'copywriter-menu', 'Kategorie', 'Kategorie', 'manage_options', 'Kategorie', 'copywriter_category_init' );
     remove_submenu_page( 'copywriter-menu', 'copywriter-menu' );
 }

function copywriter_category_init()
 {
     echo "<h1>Kategorie</h1>";
 }

 function copywriter_articles_init()
 {
     echo "<h1>Teksty</h1>";
 }
 ?>