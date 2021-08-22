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