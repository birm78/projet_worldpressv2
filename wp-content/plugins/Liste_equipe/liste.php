<?php 
/*
 * Plugin Name: Liste joueur
 * Plugin URI: URI du plugin (si vous le mettez a disposition sur un site)
 * Description: Description du plugin et de son contenu
 * Version: Version du plugin (si vous le faites évoluer avec un système de version)
 * Author: Votre nom (car c'est votre plugin)
 * Author URI: l'URI de votre site
 * License: La ou les license(s) relative(s) à votre plugin
 * License: La ou les license(s) relative(s) à votre plugin
 */
function affi_camp() {
    $wpdb = "";
    require_once("connexion_bdd.php");
    if($wpdb != "") {
        $listEquipe = getPlayers($wpdb);
        echo ('<table class="table table-striped">');
        echo ('<thead><tr>');
        echo ('<th>Joueur</th>');
        echo ('<th>Equipe</th>');
        echo ('<tr></thead>');
        $sizeListEquipe = sizeof($listEquipe);
        echo ('<tbody>');
        for ($i = 0; $i < $sizeListEquipe; $i++) {
            echo ('<tr><td>'.$listEquipe[$i]['playerName'].'</td><td>'.$listEquipe[$i]['playerTeam'].'</td>');
        }
        echo ('</tbody>');
        echo ('</table>');
    }
}

function getPlayers($wpdb) {
    $reponse = $wpdb->query("SELECT * FROM wp_options WHERE option_name = 'list_equipe'");
    $donne = $reponse->fetch(PDO::FETCH_ASSOC);
    return json_decode($donne['option_value'], true);
}

function insertNewPlayer ($player, $team) {
    $wpdb = "";
    require_once("connexion_bdd.php");
    if($wpdb != "") {
        $resultPlayer = getPlayers($wpdb);
        $newPlayer = array("playerName" => $player, "playerTeam" => $team);
        array_push($resultPlayer, $newPlayer);
        $req1 = $wpdb->prepare("UPDATE wp_options SET option_value = :resultPlayer WHERE option_name = 'list_equipe'");
        $req1->execute(array('resultPlayer' => json_encode($resultPlayer)));
    }
}

function affi_campfront()
{
	global $wpdb;
	$wpdb = new PDO('mysql:host=localhost;dbname=bd_worldcup_wp', 'root', 'root');
	$reponse = $wpdb->query('SELECT * FROM wp_options');	
	
	echo ('<table class="table">');
	echo ('<tr>');
	echo ('<th>Joueur</th>');
	echo ('<th>Equipe</th>');
	echo ('<th>Action</th>');

	echo ('<tr>');
	while ($donne = $reponse->fetch()) {
        echo ('<tr><td>'.$donne['option_name'].'</a></td><td>'.$donne['option_value'].'</td>');
        echo('<td><form method="post" action="options-general.php?page=my-unique-identifier?id='.$donne['option_id'].'" class="form-stacked"><input type="hidden" name="id_req_camp" value="'.$donne["id"].'" />
        <input class="btn btn-danger" type="submit" name="delete" value="supprimer"></form></td></tr>');
	}
	echo ('</table>');
}

add_action( 'admin_menu', 'my_plugin_menu' );

function my_plugin_menu() {
    add_options_page( 'My Plugin Options', 'Gestion liste', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
}

function my_plugin_options() {
    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ));
    }
    global $wpdb;
    $wpdb = new PDO('mysql:host=localhost;dbname=bd_worldcup_wp', 'root', 'root');
    if (isset($_POST['btnInsertPlayer'], $_POST['player'], $_POST['team'])) {
        insertNewPlayer(htmlspecialchars($_POST['player']),htmlspecialchars($_POST['team']));
	}
    echo '<div class="wrap">';
    echo '<p>Here is where the form would go if I actually had options.</p>';
    echo  '<form method="post" action="">';
    echo'<fieldset>';
    echo '<label for="label">Joueur</label>';
    echo 	'<div class="clearfix"><div class="input"><input class="span8" type="text" name="player" value=""/></div></div>';
    echo 	'<label for="label">Equipe</label>';
    echo 	'<div class="clearfix"><div class="input"><input class="span8" type="text" name="team" value=""/></div></div>';
    echo 	'<br/>';
    echo 	'<div class="clearfix"><div class="input"><input class="btn btn-primary" type="submit" name="btnInsertPlayer" value="Ajouter"></div></div>';
    echo 	'</fieldset>';
    echo '</form>';
    echo ('<h3>liste de joueur</h3>');
    affi_camp();
    echo '</div>';
}
 
 


