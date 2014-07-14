<?php

/*
Plugin Name: Liste de joueur avec table
Description:
Version: 1.0
Author: Fabio Pinto, Karim Birem, Nicolas Cybard et Jean Louis Tseng
Author URI: http://fabiopinto.fr
*/

add_action('admin_menu','listPlayerModifyMenu');
register_activation_hook(__FILE__,'playerListActivate');
register_deactivation_hook( __FILE__, 'playerListDesactivate' );

function playerListActivate() {
    global $wpdb;
    $the_page_title = 'Liste des joueurs';
    $the_page_name = 'Liste des joueurs';
    delete_option("my_plugin_page_title");
    add_option("my_plugin_page_title", $the_page_title, '', 'yes');
    delete_option("my_plugin_page_name");
    add_option("my_plugin_page_name", $the_page_name, '', 'yes');
    delete_option("my_plugin_page_id");
    add_option("my_plugin_page_id", '0', '', 'yes');
    $the_page = get_page_by_title( $the_page_title );

    if ( ! $the_page ) {
        $_p = array();
        $_p['post_title'] = $the_page_title;
        $_p['post_content'] = "[listPlayer]";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1);
        $the_page_id = wp_insert_post( $_p );
    } else {
        // the plugin may have been previously active and the page may just be trashed...
        $the_page_id = $the_page->ID;
        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $the_page_id = wp_update_post( $the_page );
    }
    delete_option( 'my_plugin_page_id' );
    add_option( 'my_plugin_page_id', $the_page_id );

    $wpdb->query("CREATE TABLE IF NOT EXISTS `player` (
      `id` varchar(3) CHARACTER SET utf8 NOT NULL,
      `name` varchar(50) CHARACTER SET utf8 NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

}

function playerListDesactivate() {
    global $wpdb;
    $the_page_title = get_option( "my_plugin_page_title" );
    $the_page_name = get_option( "my_plugin_page_name" );
    $the_page_id = get_option( 'my_plugin_page_id' );
    if( $the_page_id ) {
        wp_delete_post( $the_page_id ); // this will trash, not delete
    }
    delete_option("my_plugin_page_title");
    delete_option("my_plugin_page_name");
    delete_option("my_plugin_page_id");
}

function listPlayerModifyMenu() {

	add_menu_page('Liste de joueurs',
	'Liste de joueurs',
	'manage_options',
	'adminPlayerList',
     adminPlayerList
	);

	add_submenu_page('playerList', //parent slug
	'Ajouter', //page title
	'Ajouter', //menu title
	'manage_options', //capability
	'createPlayer', //menu slug
	'createPlayer'); //function

	add_submenu_page(null,
	'Gérer',
	'Gérer',
	'manage_options',
	'updatePlayer',
	'updatePlayer');
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'player-list.php');
require_once(ROOTDIR . 'player-create.php');
require_once(ROOTDIR . 'player-update.php');
