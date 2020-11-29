<?php
/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */


// Add the custom columns to the book post type:
add_filter( 'manage_post_posts_columns', 'set_custom_featured_columns' );
function set_custom_featured_columns($columns) {
    
    $columns['featured'] = __( 'Featured Post', 'twentytwenty' );
    $columns['hot'] = __( 'Hot Post', 'twentytwenty' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_post_posts_custom_column' , 'custom_post_column', 10, 2 );
function custom_post_column( $column, $post_id ) {
    switch ( $column ) {

        case 'featured' :
            $featured_post = get_post_meta( $post_id , 'featured_post', true );
            $checked = '';
            if ( !empty($featured_post) && $featured_post == 'yes' ){
                $checked = 'checked="checked"';
            }
            ?>
            <input type="checkbox" name="featured_post" class="featured_post" <?php echo  $checked;?> data-postid="<?php echo $post_id;?>">
            <?php
            break;

        case 'hot' :
            $hot_post = get_post_meta( $post_id , 'hot_post', true );
            $checked = '';
            if ( !empty($hot_post) && $hot_post == 'yes' ){
                $checked = 'checked="checked"';
            }
            ?>
            <input type="checkbox" name="hot_post" class="hot_post" <?php echo  $checked;?> data-postid="<?php echo $post_id;?>" >
            <?php
            break;

    }
}

/**
 * Add custom scripts for admin side
 */
function add_admin_scripts(){
    wp_enqueue_script( 'admin-script', get_stylesheet_directory_uri().'/assets/js/admin-script.js',array('jquery'),'1.0',true);
    

    //Create js object for localized
    $globalData = array(
        'siteurl'  => site_url(),
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    );
    
    wp_localize_script('admin-script', 'CALL', $globalData);
}  
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 99 );


/**
 * Add custom scripts for admin side
 */
function add_frontend_scripts(){
    wp_enqueue_script( 'front-script', get_stylesheet_directory_uri().'/assets/js/frnt-script.js',array('jquery'),'1.0',true);
    wp_enqueue_style( 'front-css', get_stylesheet_directory_uri().'/assets/css/frnt-style.css');

    //Create js object for localized
    $globalData = array(
        'siteurl'  	=> site_url(),
        'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
        'is_home' 	=> is_home()
    );
    
    wp_localize_script('front-script', 'CALLF', $globalData);
}
add_action( 'wp_enqueue_scripts', 'add_frontend_scripts', 99 ); 

//Change status for post fetured and hot 
add_action('wp_ajax_mark_post_featured_hot','change_post_status_combine');
add_action('wp_ajax_nopriv_mark_post_featured_hot','change_post_status_combine');
function change_post_status_combine(){
	
	$post_id 			= 	(int)$_POST['post_id'];
	$checked_status 	= 	$_POST['checked_status'];
	$mark_status		=	$_POST['mark_status'];
	$featured_status 	=	'';

	if(!empty($post_id) && $post_id > 0 && !empty($checked_status) && !empty($mark_status)){
		
		//featured status change
		if($checked_status == 'checked' && $mark_status == 'featured_post'){
			update_post_meta( $post_id , 'featured_post', 'yes' );
		}else if($checked_status == 'unchecked' && $mark_status == 'featured_post'){
			update_post_meta( $post_id , 'featured_post', '' );	
		}

		//hot status change
		if($checked_status == 'checked' && $mark_status == 'hot_post'){
			update_post_meta( $post_id , 'hot_post', 'yes' );	
		}else if($checked_status == 'unchecked' && $mark_status == 'hot_post'){
			update_post_meta( $post_id , 'hot_post', '' );	
		}

		echo json_encode(array('type' => 'success'));die;
	}
	echo json_encode(array('type' => 'error'));die;
}

//add slick slider cdn 
add_action('wp_head','add_slick_slider_cdn');
function add_slick_slider_cdn(){
	if(is_home()){
	?>
		<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

		<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<?php
	}
}

//view post count
add_action('wp','view_post_count');
function view_post_count() {
    
    global $post;
    $post_id = $post->ID;

    if(is_single()){

    	$count 		= 	(int) get_post_meta( $post_id, $key, true );
    	
    	if(empty($count))
    		$count = 0;
    	
	    $key 		= 	'view_count';
	    $post_id 	= 	get_the_ID();
	    $count 		= 	(int) get_post_meta( $post_id, $key, true );
	    $count++;
	    update_post_meta( $post_id, $key, $count );
	}
}