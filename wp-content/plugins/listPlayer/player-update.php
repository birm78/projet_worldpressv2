<?php
function updatePlayer () {
    global $wpdb;
    $id = $_GET["id"];
    $name=$_POST["name"];
    if(isset($_POST['update'])){
        $wpdb->update(
            'player',
            array('name' => $name),
            array( 'ID' => $id ),
            array('%s'),
            array('%s')
        );
    } else if(isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM school WHERE id = %s",$id));
    } else {
        $schools = $wpdb->get_results($wpdb->prepare("SELECT id,name from school where id=%s",$id));
        foreach ($schools as $s ){
            $name=$s->name;
        }
    }
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/assets/style-admin.css" rel="stylesheet" />
<div class="wrap">
    <h2>Joueur</h2>

    <?php if($_POST['delete']){?>
    <div class="updated"><p>Joueur Supprimé</p></div>
    <a href="<?php echo admin_url('admin.php?page=playerList')?>">&laquo; Retour à la liste</a>

    <?php } else if($_POST['update']) {?>
    <div class="updated"><p>Joueur modifié</p></div>
    <a href="<?php echo admin_url('admin.php?page=playerList')?>">&laquo; Retour à la liste</a>

    <?php } else {?>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table class='wp-list-table widefat fixed'>
    <tr><th>Name</th><td><input type="text" name="name" value="<?php echo $name;?>"/></td></tr>
    </table>
    <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
    <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('Etes vous sur ?')">
    </form>
<?php }?>

</div>
<?php
}