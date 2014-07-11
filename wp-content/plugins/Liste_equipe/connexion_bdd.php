<?php
function connexion_bdd()
{//connection a ma BDD
	global $wpdb;
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$wpdb = new PDO('mysql:host=localhost;dbname=bd_worldcup_wp', 'root', 'root', $pdo_options);
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
}

?>