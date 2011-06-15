<?php


/*
function childtheme_welcome_blurb() {
 
if (is_home() & !is_paged()) { ?>
 
<div id="welcome-blurb">
<p>history123! <?php bloginfo('name'); ?>.</p>
</div>
<!-- our welcome blurb ends here -->
<?php }
 
} // end of our new function childtheme_welcome_blurb
 
// Now we add our new function to our Thematic Action Hook
add_action('thematic_belowheader','childtheme_welcome_blurb');
*/

// Unhook default Thematic functions
// Unhook default Thematic functions


//
/*
function childtheme_posttitle($posttitle) {
    return '<div class="containing" style="background-color:white;font-family:dejavuserif">' . $posttitle . '</div>';
}
add_filter('thematic_postheader_posttitle','childtheme_posttitle');
*/

/*
// Take Away Default Thematic Header
function new_header() {
remove_action('thematic_header','thematic_blogtitle',3);
remove_action('thematic_header','thematic_blogdescription',5);
remove_action('thematic_header','thematic_access',9);
}
add_action('init', 'new_header');
// Insert Custom Header
function custom_header() { ?>

<div id="page-menu" class="menu">
<ul id="page-nav" class="sf-menu">
<br>
<?php wp_list_pages('title_li=');?>

</div>
<?php }
add_action('thematic_header','custom_header', 'wp_page_menu', 'childtheme_menu');

?>*/


//These are My Special Menus
// Add support for WP3 custom menus
add_theme_support( 'nav-menus' );


// Remove Thematic default menu
function remove_thematic_menu() {
remove_action('thematic_header','thematic_blogdescription',5);

remove_action('thematic_header','thematic_access',9);
}
add_action('init','remove_thematic_menu');

// Register the custom menu with the theme
function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
			'secondary-menu' => __( 'Secondary Menu' ),
		)
	);
}

add_action( 'init', 'register_my_menus' );



// Output the new menu to the thematic header
function childtheme_access(){
	
wp_nav_menu( array('theme_location' => 'primary-menu', 'menu_class' => 'sf-menu' ) );
if (is_category('works') or is_category('all') or is_category('web') or is_category('font') or is_category('print') or is_category('video') or is_category('illus')) wp_nav_menu( array('theme_location' => 'secondary-menu', 'menu_class' => 'works-menu' ) );

}
add_action('thematic_header', 'childtheme_access', 4);


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


/*
// Remove default Thematic actions
function remove_thematic_actions() {
remove_action('thematic_header','thematic_blogtitle',3);
}
add_action('init','remove_thematic_actions');

function additional_header_content() {
  // your stuff goes inside here
  ?>
  <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/img/logo.png" alt="yanna's logo"/>
  <?php
}
add_action('thematic_header', 'additional_header_content', 3);
//add_action('thematic_abovepost', 'additional_header_content');
*/

/*
function remove_post() {
	if (is_home()){
		remove_action('thematic_post','remove_post()');
}
add_filter('thematic_post', 'remove_post');

	add_filter('thematic_post','remove_post'); 
	
}*/


//removing sidebar
function remove_sidebar() {
remove_action('thematic_sidebar','remove_sidebar()');
}
add_filter('thematic_sidebar', 'remove_sidebar');


//removing footer - not working!!!
function remove_footer() {
remove_action('thematic_footer','remove_footer()');
}
add_filter('thematic_footer', 'remove_footer');


function remove_thematic_actions() {
	remove_action('thematic_footer','thematic_siteinfo',30);
}
add_action('init','remove_thematic_actions');


//removing postheader
/*
function remove_postheader() {
	remove_action('thematic_postheader','remove_postheader()');
}
add_filter('thematic_postheader', 'remove_postheader');
*/

function remove_postheader_postmeta() {
	remove_action('thematic_postheader_postmeta','remove_postheader_postmeta()');
}
add_filter('thematic_postheader_postmeta', 'remove_postheader_postmeta');

function childtheme_posttitle($posttitle) {
	return '<div class="containing">' . $posttitle . '</div>';
}
add_filter('thematic_postheader_posttitle','childtheme_posttitle');

//removing postfooter
function remove_postfooter() {
	remove_action('thematic_postfooter','remove_postfooter()');
}
add_filter('thematic_postfooter', 'remove_postfooter');

function remove_page_title( ){
	$content = '';
	return $content;
}
add_filter( 'thematic_page_title', 'remove_page_title' );

/*
// Remove default Thematic actions
function remove_thematic_actions() {
    
remove_action('thematic_postheader','remove_
postheader()');
    
remove_action('thematic_postfooter','remove_
postfooter()');
    //whatever other functions you might want to remove...
}
//init = when the page initializes:
add_action('init','remove_thematic_actions');

*/


//adding thumbnails to posts
function childtheme_hp_thumbs(){

}

//Supporting thumbnails in WP:
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}


function childtheme_content($unfiltered) {
/*	 
?><script>
  function alertSize() {
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
 // window.alert( 'Width = ' + myWidth );
 // window.alert( 'Height = ' + myHeight );
}
alertSize();
</script> <?php
*/
//pass the original unfiltered content
global $pook;
if (is_category('works') or is_category('all') or is_category('web') or is_category('font') or is_category('print') or is_category('video') or is_category('illus')){ // if this is the home page
    ?>
    <div class="yennok"><a class="nonen" href="<?php the_permalink();  ?>"><?php //call the link to the post
      if ( has_post_thumbnail() ) {
      $imgdata = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); 
	 // $height=$_GET[myHeight]/3;
		
	 $height=200;
      $width=round(($imgdata[1]*$height)/$imgdata[2]);
	/*
      $pook+=$width+50;
echo $pook;
   */
     // if the post has a Post Thumbnail
      set_post_thumbnail_size( $width, $height, true );
	  
        the_post_thumbnail(); //use it in 100px maximum
      } else { 
        the_title(); //use the title of the post
      }
	
    ?></a></div><?php //close the link
  } else { //if it's not the homepage
    echo $unfiltered; //forget about it, use the original content
  }
}
add_filter('thematic_post','childtheme_content'); //filter the_content with our function



?>