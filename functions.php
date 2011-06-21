<?php


//1. In This Part I take care of the menu of my website:
//******************************************************


// A. Add support for WP3 custom menus
add_theme_support( 'nav-menus' );


// B. Remove Thematic default menu
function remove_thematic_menu() {
	remove_action('thematic_header','thematic_blogdescription',5);
	remove_action('thematic_header','thematic_access',9);
}

add_action('init','remove_thematic_menu');


// C. Register the custom menu with the theme
function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
			'secondary-menu' => __( 'Secondary Menu' ),
		)
	);
}

add_action( 'init', 'register_my_menus' );


// D. Output the new menu to the thematic header
function childtheme_access(){
	
	wp_nav_menu( 
		array(
			'theme_location' => 'primary-menu',
			'menu_class' => 'sf-menu' 
			) 
	);
	
	if (is_category('works') or is_category('all') or is_category('web') or 
		is_category('font') or is_category('print') or is_category('video') or
		is_category('illus'))
		
		wp_nav_menu( array('theme_location' => 'secondary-menu', 'menu_class' => 'works-menu' ) );

}

add_action('thematic_header', 'childtheme_access', 4);


// E. Add Class to Last Menu Item
function addClassToLastMenuItem($theMenu)
{
	$classToSearchFor = 'class="menu-item';
	$lengthOfClassToSearchFor = strlen($classToSearchFor);
	$lastOccurranceOfClass = strripos( $theMenu, $classToSearchFor );
	$beforeTheClass = substr( $theMenu,
		0,
		($lastOccurranceOfClass + $lengthOfClassToSearchFor) );
	$afterTheClass = substr( $theMenu,
		($lastOccurranceOfClass + $lengthOfClassToSearchFor),
		strlen($theMenu) );
	return $beforeTheClass . ' last' . $afterTheClass;
}

add_filter('wp_nav_menu_items','addClassToLastMenuItem', 20, 1);



//2. After taking care of the menus, I want to remove all unnecessary stuff from the page:
//****************************************************************************************
// A. Removing sidebar
function remove_sidebar() {
	remove_action('thematic_sidebar','remove_sidebar()');
}

add_filter('thematic_sidebar', 'remove_sidebar');


// B. Removing Footer
function remove_footer() {
	remove_action('thematic_footer','remove_footer()');
}

add_filter('thematic_footer', 'remove_footer');

// C. Removing Site Info from footer
function remove_thematic_siteinfo() {
	remove_action('thematic_footer','thematic_siteinfo',30);
}

add_action('init','remove_thematic_siteinfo');

// D. Removing Post Header Author and Date info
function remove_postheader_postmeta() {
	remove_action('thematic_postheader_postmeta','remove_postheader_postmeta()');
}

add_filter('thematic_postheader_postmeta', 'remove_postheader_postmeta');

// E. Adding a DIV to the Post Title
function childtheme_posttitle($posttitle) {
	return '<div class="containing">' . $posttitle . '</div>';
}

add_filter('thematic_postheader_posttitle','childtheme_posttitle');


//F. Removing Post Footer
function remove_postfooter() {
	remove_action('thematic_postfooter','remove_postfooter()');
}

add_filter('thematic_postfooter', 'remove_postfooter');

//G. Removing Page Title
function remove_page_title( ){
	$content = '';
	return $content;
}

add_filter( 'thematic_page_title', 'remove_page_title' );


//3. After Removing all unnecessary stuff from the page, i'm adding the thumbnails!!!
//***********************************************************************************

//A. Add Support to thumbnails in WP:
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}

//B. Adding Thumbnails through the "Image Features" feature:
function childtheme_content($unfiltered) {

	if (is_category('works') or is_category('all') or is_category('web') or
	is_category('font') or is_category('print') or is_category('video') 
	or is_category('illus')){ //First i check which page is it
	    ?>
  		<div class="yennok">
  			<a class="nonen" href="<?php the_permalink();  ?>">
  			<?php
  	  		if ( has_post_thumbnail() ) {
  	  		$imgdata = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); //Getting The Featured Image Width & Height
			$height=200; //adding a specific Height for the thumbnail
  	  		$width=round(($imgdata[1]*$height)/$imgdata[2]); //Calculating (with ERECH MESHULSH) the proportional width of the thumbnail
		
    		set_post_thumbnail_size( $width, $height, true );//Setting the thumbnail with the specific width & height i wanted
	        the_post_thumbnail();
  		 	} else { 
				the_title(); //Adding the title of the post
  			}	
   			?></a>
   		</div>
   		<?php 
 	} else { 
  		echo $unfiltered; 
 	}
}

add_filter('thematic_post','childtheme_content');

//Zehoo, OLE!!!
?>