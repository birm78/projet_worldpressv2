<?php
try {
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $wpdb = new PDO('mysql:host=localhost;dbname=bd_worldcup_wp', 'root', 'root', $pdo_options);
    $wpdb->exec("SET CHARACTER SET utf8");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}