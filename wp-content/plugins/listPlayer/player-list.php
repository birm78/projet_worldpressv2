<?php
add_shortcode("listPlayer", "frontPlayerList");
function adminPlayerList () {
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
<div class="wrap">
<h2>Liste des joueurs</h2>
<a href="<?php echo admin_url('admin.php?page=createPlayer'); ?>">Add New</a>
<?php
playerList(true);
?>
</div>
<?php
}

function frontPlayerList () {
    ?>
    <div class="wrap">
        <h2>Liste des joueurs</h2>
        <?php
        playerList(false);
        ?>
    </div>
<?php
}

function playerList ($maj) {
    global $wpdb;
    $rows = $wpdb->get_results("SELECT id,name from player");
    echo "<table class='wp-list-table widefat fixed'>";
    echo "<tr><th>ID</th><th>Name</th><th>&nbsp;</th></tr>";
    foreach ($rows as $row ){
        echo "<tr>";
        echo "<td>$row->id</td>";
        echo "<td>$row->name</td>";
        if($maj) {
            echo "<td><a href='".admin_url('admin.php?page=updatePlayer&id='.$row->id)."'>Mettre à jour</a></td>";
        }
        echo "</tr>";}
    echo "</table>";

}