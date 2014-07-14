<?php
	/*
	Plugin Name: Liste joueurs
	Description: Plugin permettant la gestion d'une liste de joueurs
	Version: 1.0
	Author: Groupe médicaments
	*/


	/**
	* Execution des fonctions sur les différents hooks
	**/
	add_action('init','joueurManager_init');
	add_action('add_meta_boxes','joueurManager_meta_box_add');
	add_action('save_post', 'joueurManager_meta_box_save');
	add_action('manage_posts_custom_column', 'joueurManager_manage_posts_custom_column', 10, 2);
	add_filter('manage_edit-joueurballer_columns', 'joueurManager_manage_posts_columns');
	add_shortcode('joueurManager','joueurManager_show');



	/**
	* Permet d'initialiser les fonctionnalités liés au carrousel
	**/
	function joueurManager_init (){

	   	add_option( 'name_joueur', 'Nom du joueur');
		add_option( 'pseudo_joueur', 'Pseudo du joueur');
		add_option( 'arme_joueur', 'Arme du joueur');
		add_option( 'equipe_joueur', 'Equipe du joueur');


		$labels = array(
			'name' => 'Liste Joueur',
			'singular_name' => 'joueur',
			'add_new' => 'Ajouter un nouveau joueur',
			'all_items' => 'Liste des joueurs',
			'edit_new_item' => 'Ajouter un joueur',
			'edit_item' => 'Editer un joueur',
			'new_item' => 'Nouveau joueur',
			'view_item' => 'Voir le joueur',
			'search_items' => 'Rechercher un joueur',
			'not_found' => 'Aucun joueur trouvé',
			'not_found_in_trash' => 'Aucun joueur trouvé dans la corbeille',
			'parent_item_colon' => 'joueur',
			'menu_name' => 'Liste Joueur',
		);

		register_post_type('joueur',array(
			'public'             => true,
			'publicly_queryable' => false,
			'labels'             => $labels,
			'menu_position'      => null,
			'supports'           => array('title')

		));
	}


	/**
	* Permet dajouter ue meta_box
	**/
	function joueurManager_meta_box_add()
	{
	    add_meta_box( 'my-meta-box-id',
	    			  'Remplir la fiche du joueur',
	    			  'joueurManager_meta_box_cb',
	    			  'joueur',
	    			  'normal',
	    			  'high'
	    			);
	}

	/**
	* Permet de mettre en place le rendu de la meta_box
	**/
	function joueurManager_meta_box_cb($post) {
	    global $post;
        $panelView = plugins_url()."/listejoueur/partials/panel-view.html.php";

		$values = get_post_custom( $post->ID );
		$name = isset($values['meta_box_name']) ? $values['meta_box_name'][0] : null;
		$pseudo = isset($values['meta_box_pseudo']) ? $values['meta_box_pseudo'][0] : null;  
		$type = isset($values['meta_box_type']) ? $values['meta_box_type'][0] : null;
		$number = isset($values['meta_box_number']) ? $values['meta_box_number'][0] : null;  
		$check = isset($values['my_meta_box_check']) ? $values['my_meta_box_check'][0]  : null;

	    //Permet de créer un champ génerer pour prévenir des attaques
        wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
		$panelView = file_get_contents($panelView);
		$typeSelection = displayTypeSelector($type);
        $numberSelection = displayNumberSelector((int)$number);
		$html = Fm_emulateTwigTemplating($panelView, array(
							   '%name%' => $name,
							   '%pseudo%' => $pseudo,
							   '%roleSelection%' => $typeSelection
							  ));
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('myplugin-script', plugins_url('js/script.js', __FILE__), array('wp-color-picker'), false, true );
        wp_enqueue_script('jquery');
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker', plugins_url('js/jquery-ui.min.js', __FILE__), array('jquery', 'jquery-ui-core') );
        wp_enqueue_style('jquery.ui.theme', plugins_url('css/jquery-ui.min.css', __FILE__));

		echo $html;
	}


	/**
	 * Permet de sauvegarder la meta_box
	 */
	function joueurManager_meta_box_save($post_id)
	{

		$slug = 'joueur';
		if (isset($_POST['post_type']) && $slug != $_POST['post_type']) {
	        return;
	    }
	
	    // Permet de gérer l'autosave
	    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	    //Si la donnée est posté est que le champ géneré convient
	    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce') ) return;

	    // Si le l'utilisateur courant a les droits d'edition
	    // if( !current_user_can( 'edit_post' ) ) return;

	    if( isset( $_POST['meta_box_name'] ) )
	    	update_post_meta( $post_id, 'meta_box_name', esc_attr( $_POST['meta_box_name']) );

	    if( isset( $_POST['meta_box_pseudo'] ) )
	        update_post_meta( $post_id, 'meta_box_pseudo', esc_attr( $_POST['meta_box_pseudo']) );

	    if( isset( $_POST['meta_box_role'] ) )
	        update_post_meta( $post_id, 'meta_box_role', esc_attr( $_POST['meta_box_role'] ) );  

	    if( isset( $_POST['meta_box_number'] ) )
	        update_post_meta( $post_id, 'meta_box_number', esc_attr( $_POST['meta_box_number'] ) );

		update_option( 'name_joueur',  esc_attr( $_POST['meta_box_name']));
	    update_option( 'pseudo_joueur', esc_attr( $_POST['meta_box_pseudo']));
	    update_option( 'arme_joueur', esc_attr( $_POST['meta_box_role']));
	    update_option( 'equipe_joueur',esc_attr( $_POST['meta_box_number'] ));
	}

	function joueurManager_show($limit = 10){

		$frontView = plugins_url()."/listejoueur/partials/front-view.php";
		$frontView = file_get_contents($frontView);

       	$joueur = new WP_query("post_type=joueur&posts_per_page=$limit");
       	$rows = displayjoueurAsRows($joueur);

       	$html = Fm_emulateTwigTemplating($frontView, array('%rows%' => $rows));
		echo $html;

		// faire la recherche ici ***********************************************
	}

	function joueurManager_manage_posts_columns($columns) {
	    global $wp_query;
	    echo 'joueurManager_manage_posts_columns';
	    unset(
	            $columns['author'], $columns['tags'], $columns['comments'],$columns['date']
	    );

	    $columns = array_merge($columns, array('name' => __('Nom'), 'pseudo' => __('Prénom'),  'role' => __('Poste'),'title' => 'joueur', 'number' => __('Numéro'), 'featured_image' => __('Photo')));
	    return $columns;
	}

	function joueurManager_manage_posts_custom_column($column, $post_id) {
		//echo 'joueurManager_manage_posts_custom_column';
	    switch ($column) {
	        case 'name':
	            $joueur_val = get_post_meta($post_id, 'meta_box_name', true);
	            break;
	        case 'pseudo':
	            $joueur_val = get_post_meta($post_id, 'meta_box_pseudo', true);
	            break;
            case 'role':
                $joueur_val = get_post_meta($post_id, 'meta_box_role', true);
                break;
           	case 'number':
           	    $joueur_val = get_post_meta($post_id, 'meta_box_number', true);
           	    break;
	    }
            //update_post_meta($post_id, 'meta_box_title', "joueur");

	   if(isset($joueur_val) && !empty($joueur_val))
	       echo $joueur_val;
	}

	function displayTypeSelector($effectiveRole){
		$roles = array('Attaquant','Gardien','Défenseur','Milieu', 'Milieur défensif', 'Ailier droit', 'Ailier Gauche', 'Latéral droit', 'Latéral Gauche');
		$selector = "<select name='meta_box_role' id='meta_box_role' class='large-text'>";

		foreach($roles as $role){
			$selector .= "<option value='$role'". Fm_selected($effectiveRole, $role) . ">". ucfirst($role) ."</option>";
		}
		$selector .= "</select>";

		return $selector;
	}
	
	function displayNumberSelector($number){
		$selector = "<select name='meta_box_number' id='meta_box_number' class='large-text'><option></option>";
            	for($i = 1; $i <= 5; $i++):
			$selector .= "<option value='$i'". Fm_selected($number, $i) . ">Equipe: $i</option>";
            	endfor;
            	$selector .= "</select>";
		return $selector;
	}

	function displayjoueurAsRow($post)
	{
		$row = "<tr>
					<td>" . get_post_meta($post->ID,'meta_box_name',true) . "</td>
					<td>" . $post->post_title . "</td>
					<td>" . get_post_meta($post->ID,'meta_box_role',true) . "</td>
					<td>" . get_post_meta($post->ID,'meta_box_number',true) . "</td>
				</tr>";
		return $row;
	}

	function displayjoueurAsRows($joueur)
	{
		$rows = '';
		while($joueur->have_posts()){
			$joueur->the_post();
			global $post;
			$rows .= displayjoueurAsRow($post);
		}
		return $rows;
	}

	function Fm_emulateTwigTemplating(&$fullString, $params)
	{
		foreach($params as $paramKey => $param){
			$fullString = str_replace("$paramKey", $param, $fullString);
		}
		return $fullString;
	}

	function Fm_selected($label, $match){
	    if($label === $match){
		return "selected='selected'";
	    }
	    else{
		return "";
	    }
	}
	
	
