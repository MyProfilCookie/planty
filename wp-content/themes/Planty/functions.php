<?php 

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
}


/* MODIFICATION DU HEADER */

 // Récupération de la liste des items du menu actuel nom qui est donné au menu d'en-tête dans WP ocean: "site-header")
 add_filter( 'wp_nav_menu_items', 'menu_item_admin', 10, 2 );
 function menu_item_admin ( $items, $args ) {
		 // Contrôle si l'utilisateur est connecté avec la fonction is_user_logged_in()
			if (is_user_logged_in()) {
		// si l'utilisateur est connecté, on initialise un tableau qui stockera la liste des items 
			$items_array = array();
			 
		// Création d'une boucle pour récupérer la position actuelle de chaque item (balise '<li') avec '<li' comme point de repère dans la liste de items
		// l'offset de 10, permet d'être sûr de ne pas prendre en compte le '<li' où on démarre
			while ( false !== ( $item_pos = strpos ( $items, '<li', 10 ) ) ) {
			// recupère uniquement la partie qui va de <li> jusqu'au <li> suivant et on le stock dans le tableau
				$items_array[] = substr($items, 0, $item_pos);
			// Retrait de la partie de la liste des items avant de recommencer la boucle
				$items = substr($items, $item_pos);
			 }
			 //Ajoute au tableau le dernier élément de la liste
				$items_array[] = $items;
			 // Insertion du lien 'Admin' à la position indiquée ici c'est 1 pour qu'il soit en première place dans le tableau.
			 array_splice($items_array, 1, 0, '<li class="menu-item"><a class="menu-admin" href="'. get_site_url() .'/wp-admin/">Admin</a></li>'); 
			 //Retransforme le tableau en liste d'items
			 $items = implode('', $items_array);
		 }
		
		return $items;
	 
 }
?>
