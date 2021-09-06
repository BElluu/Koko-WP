<?php
/**
 * Plugin Name: Koko Copywriter
 * Plugin URI: http://devopsowy.pl
 * Description: Add reference to your articles.
 * Version: 1.0
 * Author: Bartłomiej Komendarczuk
 * Author URI: http://devopsowy.pl
 */

if (! function_exists('add_action')){
    echo 'Hi! I\'m a plugin. Do not call me directly.';
    exit;
}

require_once __DIR__ . '\categories-list.php';
require_once __DIR__ . '\add-category.php';
require_once __DIR__ . '\edit-category.php';
require_once __DIR__ . '\articles-list.php';
require_once __DIR__ . '\add-article.php';
require_once __DIR__ . '\edit-article.php';

 add_action( 'admin_menu', 'copywriter_admin_page' );

 function create_categories_table(){
     global $wpdb;
     $tableName = 'copywriter_categories';
     $wp_track_table = $wpdb->prefix . "$tableName";
     $charset_collate = $wpdb->get_charset_collate();

     $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table (
     `category_id` int(11) NOT NULL AUTO_INCREMENT,
     `category_name` varchar(256) NOT NULL,
     `category_image` LONGBLOB NOT NULL,
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
    `article_name` varchar(256) NOT NULL,
    `article_source` varchar(2083) NOT NULL,
    `article_image` LONGBLOB NOT NULL,
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
     add_submenu_page( 'copywriter-menu', 'Artykuly', 'Artykuly', 'manage_options', 'Artykuly', 'copywriter_articles_init' );
     add_submenu_page( 'copywriter-menu', 'Kategorie', 'Kategorie', 'manage_options', 'Kategorie', 'copywriter_category_init' );
     add_submenu_page( 'Kategorie', 'Dodaj Kategorie', 'Dodaj Kategorie', 'manage_options', 'dodaj-kategorie', 'copywriter_add_category_init' );
     add_submenu_page( 'Kategorie', 'Edytuj Kategorie', 'Edytuj Kategorie', 'manage_options', 'edytuj-kategorie', 'copywriter_edit_category_init' );
     add_submenu_page( 'Artykuly', 'Dodaj Artykul', 'Dodaj Artykul', 'manage_options', 'dodaj-artykul', 'copywriter_add_article_init' );
     add_submenu_page( 'Artykuly', 'Edytuj Artykul', 'Edytuj Artykul', 'manage_options', 'edytuj-artykul', 'copywriter_edit_article_init' );
     remove_submenu_page( 'copywriter-menu', 'copywriter-menu' );
 }

 function copywriter_add_article_init()
 {
     $Article_Form = new Add_Article_Form();
     $Article_Form -> addArticle();
 }
 function copywriter_edit_article_init()
 {
     $Article_Form = new Edit_Article_Form();
     $Article_Form -> editArticle();
 }

 function copywriter_add_category_init()
 {
    $Category_Form = new Add_Category_Form();
    $Category_Form->addCategory();
 }

 function copywriter_edit_category_init()
 {
     $Category_Form = new Edit_Category_Form();
     $Category_Form -> editCategory();
 }

function copywriter_category_init()
 {
    $Categories_List = new Categories_List();
    $Categories_List->prepare_items();
    ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h1 style="display:inline-block;">Kategorie</h1> 
            <?php echo ' <a href="' . esc_url( admin_url( 'admin.php?page=dodaj-kategorie' ) ) . '" class="page-title-action">' . esc_html( 'Dodaj' ) . '</a>';?>
            <?php $Categories_List->display(); ?>

            <?php submit_button( __( 'Dodaj kategorie', '' ), 'primary', 'Zatwierdź' ); ?>
        </div>
    <?php
}

 function copywriter_articles_init()
 {
    $Articles_List = new Articles_List();
    $Articles_List->prepare_items();
    ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h1 style="display:inline-block;">Artykuły</h1> 
            <?php echo ' <a href="' . esc_url( admin_url( 'admin.php?page=dodaj-artykul' ) ) . '" class="page-title-action">' . esc_html( 'Dodaj' ) . '</a>';?>
            <?php $Articles_List->display(); ?>

            <?php submit_button( __( 'Dodaj Artykuł', '' ), 'primary', 'Zatwierdź' ); ?>
        </div>
    <?php
 }
 ?>