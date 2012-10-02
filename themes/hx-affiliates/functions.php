<?php
/**
 * Harvest Exchange functions and definitions
 *
 * @package Harvest Exchange
 * @since Harvest Exchange 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Harvest Exchange 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'hx_affiliates_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Harvest Exchange 1.0
 */
function hx_affiliates_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Harvest Exchange, use a find and replace
	 * to change 'hx_affiliates' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'hx_affiliates', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hx_affiliates' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // hx_affiliates_setup
add_action( 'after_setup_theme', 'hx_affiliates_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Harvest Exchange 1.0
 */
function hx_affiliates_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'hx_affiliates' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'hx_affiliates_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function hx_affiliates_scripts() {
	wp_enqueue_style( 'style', get_template_directory_uri() . '/bootstrap/css/bootstrap.css' );
	wp_enqueue_style( 'style-responsive', get_template_directory_uri() . '/bootstrap/css/bootstrap-responsive.css' );
	wp_enqueue_style( 'jons-css', get_template_directory_uri() . '/layouts/box.css' );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'hx_affiliates_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );



/**************************
 * ADDED BY JONATHON MCDONALD
 * Oct 1, 2012
 **/


/**
 * Function to help quickly register a user,
 * and add them to the affiliates category.  
 */
function add_new_user()
{
	// If the user has attempted to register
	if(isset($_POST['register_now'])):

		// Begin by sanitizing the data
		$user = sanitize_user( $_POST['user'] );
		$pass = $_POST['password'];
		$email = sanitize_email( $_POST['enter_email'] );
		$first_name = sanitize_text_field( $_POST['first'] );
		$last_name = sanitize_text_field( $_POST['last'] );

		// Next we need to perform a check to see if the user is already
		// registered
		if( username_exists( $user ) ):
			$jon_error = "A user already has that username!";
		endif;

		if( email_exists( $email ) ):
			$jon_error = "A user already has that email!";
		endif;

		if( $email == '' || $pass == '' || $user == '' || $first_name == '' || $last_name == '' ):
			$jon_error = "No email";
		endif;

		if( isset($jon_error) ):
			return;
		endif;

		// Prepare the data to add to the database of users
		$userData = array(
			'user_login' => $user,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'user_pass' => $pass,
			'user_email' => $email,
			'role' => 'subscriber'
		);

		// Prepare the affiliate data to add as an affiliate
		$affiliateData = array(
			'user_login' => $user,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $email,
		);

		// Add the user to WP
		$user_id = wp_insert_user($userData);
		
		// Register the user as an affiliate
		$affil = new Affiliates_Registration;
		$affil->store_affiliate($user_id, $affiliateData);

		// Log the user in, redirect to the affiliate area
		$creds = array();
		$creds['user_login'] = $user;
		$creds['user_password'] = $pass;
		$creds['remember'] = true;
		$user = wp_signon( $creds );
		wp_redirect( home_url() . '/affiliate-area');
		exit;

	endif;
}
add_action('init', 'add_new_user');

/**
 * Shows a registration form, saving data
 * if possible.  
 */
function show_user_form($data)
{	
	// First make sure this is not a logged in user!  
	if(!is_user_logged_in()):
		$email = "";
		$user = "";
		$first = "";
		$last = "";

		// Check if the user came from the home page
		if(isset($_POST['email'])):
			$email = $_POST['email'];
			do_action('save_email');
		endif;

		// Check if the user has attempted to fill out the form
		if(isset($_POST['register_now'])):
			// Get all the data they filled out so they don't have to re-enter the data
			$user = sanitize_user( $_POST['user'] );
			$email = sanitize_email( $_POST['enter_email'] );
			$first = $_POST['first'];
			$last = $_POST['last'];
			$jon_error = "";

			if( username_exists( $user ) ):
				$jon_error .= "A user already has that username! <br />";
			endif;

			if( email_exists( $email ) ):
				$jon_error .= "A user already has that email! <br />";
			endif;

			echo $jon_error;
		endif;


		// Below is boiler HTML for a form, un-commented.  
	?>
	<form class="form-horizontal" method="post">

      	<input name="enter_email" type="hidden" id="inputEmail" placeholder="Email" <?php if(isset($email)): echo'value="' . $email . '"'; endif; ?>>

  		<div class="control-group">
    		<label class="control-label" for="inputUser">User</label>
    		<div class="controls">
      			<input type="text" id="inputUser" placeholder="Username" name="user">
    		</div>
  		</div>
  		<div class="control-group">
    		<label class="control-label" for="inputFirst">First name</label>
    		<div class="controls">
      			<input type="text" id="inputFirst" placeholder="First name" name="first" <?php if(isset($first)): echo'value="' . $first . '"'; endif; ?>>
    		</div>
  		</div>
  		<div class="control-group">
    		<label class="control-label" for="inputLast">Last name</label>
    		<div class="controls">
      			<input type="text" id="inputLast" placeholder="Last name" name="last" <?php if(isset($last)): echo'value="' . $last . '"'; endif; ?>>
    		</div>
  		</div>
  		<div class="control-group">
    		<label class="control-label" for="inputPass">Password</label>
    		<div class="controls">
      			<input type="password" id="inputPass" placeholder="Password" name="password">
    		</div>
  		</div>
  		<div class="control-group">
    		<div class="controls">
      			<button type="submit" class="btn" name="register_now">Register</button>
    		</div>
  		</div>
	</form>
	<?php
	// Uh oh, they're logged in.  Maybe something went wrong?
	else:
		echo 'Welcome to the site';
	endif;
}
add_shortcode('user_reg','show_user_form');

/**
 * Installs the table, run manually
 * to collect emails.  
 */
function jm_table_install ()
{
	// Get global wpdb
	global $wpdb;

	// Prepare a table name, and change to true
	$table_name = $wpdb->prefix . 'jm_emails';
	$double_check = false;

	// SQL statement to create table
	$sql = "CREATE TABLE $table_name (
  	id mediumint(9) NOT NULL AUTO_INCREMENT,
  	time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  	email text NOT NULL,
  	UNIQUE KEY id (id)
    );";

	// Initialize the table
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	if( $double_check == true)
    	dbDelta($sql);

}
add_action('init', 'jm_table_install');

/**
 * Saves email to the table
 */
function jm_save_email($email)
{
	// Initialize globals 
	if($email == '')
		return;

	
}








