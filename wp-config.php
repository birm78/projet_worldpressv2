<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/Applications/MAMP/htdocs/projet_worldpress/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'bd_worldcup_wp');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Q3-B1Zo&Q!I=D%S4)%&5Aqm~>acf[LlHIg-jmF8E&y>kMFX+4$M4o)v?sT%Arf>]');
define('SECURE_AUTH_KEY',  'CV}+n?.9A)~9i9Ud|) 1@[t-mBf`Od-4g0SVr`-jJ~uwW|pFG)b`I=0)6<_u]L&s');
define('LOGGED_IN_KEY',    ' 5ge&UXT|!|<-HMh[6){q;ltTY/,,B?GIhuFjy,iVe#|?HqzXA-~.rp,=sAowWQq');
define('NONCE_KEY',        '+9$%O*,;K:8cHBPA&~Y^D$oS-mxniWfo2)`wG36(#T7dx$9fW9b1QVsY#&jPpKib');
define('AUTH_SALT',        '<-RbJDj Lj6.?k]kSXVK+boqJp^5Q3V6e-:LE@@rRB(g%8Z,.f=1Lz3]#+ADOI-q');
define('SECURE_AUTH_SALT', 'E:f]oa9,BOytGB|$u/k,oGS8S1k*(tm9vbzJu2d`Hpjm:_/#/j)UrihO@E9vr9y1');
define('LOGGED_IN_SALT',   'YJ/f:l-/wo|qL|kHu/5E99lMSk=gOs5J-:k>{)IY2qaiIPSGod:8i?<5;:Kzu~i|');
define('NONCE_SALT',       'Z0U:+c=c~]SHBYj@:I2e]KcqzB]u1g_:&]30q;|ZJ,U5Kh;(v@-`sFZ8zbT}$<)~');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');