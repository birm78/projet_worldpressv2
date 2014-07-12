<?php 
/*
 * Plugin Name: Liste joueur
 * Plugin URI: URI du plugin (si vous le mettez a disposition sur un site)
 * Description: Description du plugin et de son contenu
 * Version: Version du plugin (si vous le faites évoluer avec un système de version)
 * Author: Votre nom (car c'est votre plugin)
 * Author URI: l'URI de votre site
 * License: La ou les license(s) relative(s) à votre plugin
 */




function affi_camp()
{
	//function install();
	global $wpdb;
	$wpdb = new PDO('mysql:host=localhost;dbname=bd_worldcup_wp', 'root', 'root');
	$reponse = $wpdb->query('SELECT * FROM wp_options');	
	echo ('<table class="table">');
	echo ('<tr>');
	echo ('<th>Joueur</th>');
	echo ('<th>Equipe</th>');
	echo ('<tr>');
	while ($donne = $reponse->fetch())
		{
			echo ('<tr><td>'.$donne['option_name'].'</td><td>'.$donne['option_value'].'</td>');
		}
	echo ('</table>');
}

function usecurl ($q, $camp)
{
	// Connection à la base de donnée
	global $wpdb;
	$wpdb = new PDO('mysql:host=localhost;dbname=bd_worldcup_wp', 'root', 'root');
	//on regarde si la requete a deja etait rentrer une fois
	$id_req = "";
	$recup_id = $wpdb->query('SELECT `option_id` FROM `wp_options` WHERE option_name="'.$q.'"');
	while ($donnees = $recup_id->fetch())
	{
		$id_req = $donnees['id'];
	}
	//si elle nn'a pas etait rentrer on l'insert et on recupere son id
	if ($id_req == "")
	{
		$req1 = $wpdb->prepare('INSERT INTO wp_options (option_name, option_value) VALUES (:query_c, :libelle_c)');

		$req1->execute(array(
					'query_c' => $q,
					'libelle_c' => $camp
						));
		
	}
	//si on a pas choisit parmit les campagne deja existante on rentre la nouvel campagne et recupere son id
	/*if ($camp2 == "")
	{
		$req2 = $bdd->prepare('INSERT INTO campagne (date_campagne, libelle) VALUES (NOW(), :libelle_c)');
		$req2->execute(array(
					'libelle_c' => $camp
					//'query_c' => $t
					));
		
	}*/
					
							
				
	mysql_close($sql_bdd);
			
		
	
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
	while ($donne = $reponse->fetch())
		{
			echo ('<tr><td>'.$donne['option_name'].'</a></td><td>'.$donne['option_value'].'</td>');
			echo('<td><form method="post" action="options-general.php?page=my-unique-identifier?id='.$donne['option_id'].'" class="form-stacked"><input type="hidden" name="id_req_camp" value="'.$donne["id"].'" />
			<input class="btn btn-danger" type="submit" name="delete" value="supprimer"></form></td></tr>');
			
		}
	echo ('</table>');
}






 /** Step 2 (from text above).  */
 add_action( 'admin_menu', 'my_plugin_menu' );

 /** Step 1. */
 function my_plugin_menu() {
	 add_options_page( 'My Plugin Options', 'Gestion liste', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
 }

 /** Step 3. */
 function my_plugin_options() {
	 if ( !current_user_can( 'manage_options' ) ) {
		 wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	 }
	 global $wpdb;
	$wpdb = new PDO('mysql:host=localhost;dbname=bd_worldcup_wp', 'root', 'root');
				//<!-- On test si l'utilisateur a cliqué sur le bouton -->
				if (isset($_POST['ok'], $_POST['q'])) 
				{	
	 echo '<div class="wrap">';
	 echo '<p>Here is where the form would go if I actually had options.</p>';
	 echo  '<form method="post" action="">';
	echo'<fieldset>';
     echo '<label for="label">Query</label>';
	echo 	'<div class="clearfix"><div class="input"><input class="span8" type="text" name="q" value=""/></div></div>';
	echo 	'<label for="label">Nom de la nouvelle campagne</label>';
	echo 	'<div class="clearfix"><div class="input"><input class="span8" type="text" name="camp" value=""/></div></div>';						
	echo 	'<br/>';
	echo 	'<div class="clearfix"><div class="input"><input class="btn btn-primary" type="submit" name="ok" value="Lancer loutil"></div></div>';
	echo 	'</fieldset>';
	echo ('<h3>liste de joueur</h3>');
			affi_campfront();
	 echo '</form>';
	 echo '</div>';

	 usecurl(htmlspecialchars($_POST['q']),$_POST['camp']);
	}
	else
				{

					echo '<div class="wrap">';
	 echo '<p>Here is where the form would go if I actually had options.</p>';
	 echo  '<form method="post" action="">';
	echo'<fieldset>';
     echo '<label for="label">Query</label>';
	echo 	'<div class="clearfix"><div class="input"><input class="span8" type="text" name="q" value=""/></div></div>';
	echo 	'<label for="label">Nom de la nouvelle campagne</label>';
	echo 	'<div class="clearfix"><div class="input"><input class="span8" type="text" name="camp" value=""/></div></div>';						
	echo 	'<br/>';
	echo 	'<div class="clearfix"><div class="input"><input class="btn btn-primary" type="submit" name="ok" value="Lancer loutil"></div></div>';
	echo 	'</fieldset>';
	echo ('<h3>liste de joueur</h3>');
			affi_campfront();
	 echo '</form>';
	 echo '</div>';

				}
 }
 
 


