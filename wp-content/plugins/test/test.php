<?php 
/*
 * Plugin Name: test
 * Plugin URI: URI du plugin (si vous le mettez a disposition sur un site)
 * Description: Description du plugin et de son contenu
 * Version: Version du plugin (si vous le faites évoluer avec un système de version)
 * Author: Votre nom (car c'est votre plugin)
 * Author URI: l'URI de votre site
 * License: La ou les license(s) relative(s) à votre plugin
 */

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        add_post_meta($postID, $count_key, '1');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        return "1";
    }
    return $count;
}

function set_get_PostViews($postID) {
    setPostViews($postID);
    $counter_views = getPostViews($postID);
    if ( $counter_views < 2) {
        echo $counter_views.' vue';}
    else {
        echo $counter_views.' vues';
    };
    if(!empty($_POST['ID_count'])){
        $postID = ($_POST['ID_count']);
    }
    setPostViews($postID);
    $counter_views = getPostViews($postID);
    $return .= '<div id="set_views_count" data-id="'. $postID .'">';
    if ( $counter_views < 2) {
        $return .= $counter_views .' vue';
    } else {
        $return .= $counter_views .' vues';
    };
    $return .= '</div>';
    echo $return;
 
    if(!empty($_POST['ID_count'])){
        die();
    }
}


add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Vue');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}