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
	$reponse = $wpdb->query('SELECT * FROM wp_options');	
	echo ('<table class="table">');
	echo ('<tr>');
	echo ('<th>Campagne</th>');
	echo ('<th>Pays</th>');
	echo ('<th>Date</th>');
	echo ('<tr>');
	while ($donne = $reponse->fetch())
		{
			echo ('<tr><td>'.$donne['option_name'].'</td><td>'.$donne['option_value'].'</td><td>'.$donne['autoload'].'</td>');
		}
	echo ('</table>');
}

function usecurl ($q, $camp, $YMJ)
{
	// Connection à la base de donnée
	//include (TEMPLATEPATH . "/connexion_bdd.php");

	//on regarde si la requete a deja etait rentrer une fois
	$id_req = "";
	$recup_id = $bdd->query('SELECT `id` FROM `campagne` WHERE pays="'.$q.'"');
	while ($donnees = $recup_id->fetch())
	{
		$id_req = $donnees['id'];
	}
	//si elle nn'a pas etait rentrer on l'insert et on recupere son id
	if ($id_req == "")
	{
		$req1 = $bdd->prepare('INSERT INTO campagne (pays, libelle, date_campagne) VALUES (:query_c, :libelle_c, NOW())');

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
	include (TEMPLATEPATH . "/connexion_bdd.php");
	$reponse = $bdd->query('SELECT * FROM campagne');	
	echo ('<table class="table">');
	echo ('<tr>');
	echo ('<th>Campagne</th>');
	echo ('<th>Pays</th>');
	echo ('<th>Date</th>');
	echo ('<th>Action</th>');

	echo ('<tr>');
	while ($donne = $reponse->fetch())
		{
			echo ('<tr><td>'.$donne['libelle'].'</a></td><td>'.$donne['pays'].'</td><td>'.$donne['date_campagne'].'</td>');
			echo('<td><form method="post" action="index.php?id='.$donne['id'].'" class="form-stacked"><input type="hidden" name="id_req_camp" value="'.$donne["id"].'" />
			<input class="btn btn-danger" type="submit" name="delete" value="supprimer"></form></td></tr>');
			
		}
	echo ('</table>');
}

function add_admin_menu(){
echo "coucou";
}


add_action('admin_menu', 'add_admin_menu');





