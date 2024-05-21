<?php


// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')) :
	function chld_thm_cfg_locale_css($uri)
	{
		if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
			$uri = get_template_directory_uri() . '/rtl.css';
		return $uri;
	}
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');
add_action('wp_head', 'theme_custom_script_load');
function theme_custom_script_load()
{
	wp_enqueue_style('owl_css_1', get_stylesheet_directory_uri() . '/assets/css/owl-css.css');
	//wp_enqueue_style('owl_css_2','https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css');
	wp_enqueue_script('owl_js', get_stylesheet_directory_uri() . '/assets/js/owl-js.js?' . mt_rand(0, 100000), array('jquery'), '1.0');
	// wp_enqueue_script('custom_js',get_stylesheet_directory_uri() . '/assets/js/custom.js'); 
	//  wp_enqueue_script('custom_datatables','https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js');


}
add_action('wp_footer', 'theme_custom_script');
function theme_custom_script()
{

	wp_enqueue_script('custom_js', get_stylesheet_directory_uri() . '/assets/js/custom.js');
	wp_enqueue_script('custom_datatables', 'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js');
}

if (!function_exists('child_theme_configurator_css')) :
	function child_theme_configurator_css()
	{
		wp_enqueue_style('chld_thm_cfg_child', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('twenty-twenty-one-style', 'twenty-twenty-one-style', 'twenty-twenty-one-print-style'));
	}
endif;
add_action('wp_enqueue_scripts', 'child_theme_configurator_css', 10);

// END ENQUEUE PARENT ACTION
// user registration login form
function pippin_registration_form()
{

	// only show the registration form to non-logged-in members
	if (!is_user_logged_in()) {

		global $pippin_load_css;

		// set this to true so the CSS is loaded
		$pippin_load_css = true;

		// check to make sure user registration is enabled
		$registration_enabled = get_option('users_can_register');

		// only show the registration form if allowed
		if ($registration_enabled) {
			$output = pippin_registration_form_fields();
		} else {
			$output = __('User registration is not enabled');
		}
		return $output;
	} else { ?>
		<script>
			window.location.href = "<?php echo home_url(); ?>/user-profile";
		</script>
	<?php }
}
add_shortcode('register_form', 'pippin_registration_form');

// user login form
function pippin_login_form()
{

	if (!is_user_logged_in()) {

		global $pippin_load_css;

		// set this to true so the CSS is loaded
		$pippin_load_css = true;

		$output = pippin_login_form_fields();
	} else {
		// could show some logged in user info here
		// $output = 'user info here';
	}
	return $output;
}
add_shortcode('login_form', 'pippin_login_form');

// registration form fields
function pippin_registration_form_fields()
{

	ob_start();
	global $wp_roles; ?>
	<script>
	</script>


	<form id="pippin_registration_form" class="pippin_form" action="" method="POST">
		<h3 class="pippin_header"><?php _e('Register'); ?></h3>

		<div class="input-container">
			<input name="pippin_user_login" placeholder="Username" id="pippin_user_login" class="required" type="text" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_company" placeholder="Company" id="pippin_user_company" type="text" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_email" placeholder="Email" id="pippin_user_email" class="required" type="email" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_phone" placeholder="Phone Number" id="pippin_user_phone" type="text" maxlength="15" minlength="10" onkeypress="return isNumber(event)" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_address" placeholder="Address" id="pippin_user_address" class="required" type="text" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_state" placeholder="State" id="pippin_user_state" type="text" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_city" placeholder="City" id="pippin_user_city" type="text" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_zip" placeholder="Zip Code" id="pippin_user_zip" type="text" onkeypress="return isNumber(event)" minlength="5" maxlength="5" required />
		</div>
		<div class="input-container">
			<input name="pippin_user_pass" placeholder="Password" id="password" class="required" type="password" required />
		</div>

		<div class="input-container">
			<input name="pippin_user_pass_confirm" placeholder="Confirm Password" id="password_again" class="required" type="password" required />

		</div>
		<div id="pwdmessage" style="display:none">
			<h4>Password must contain the following:</h4>
			<p id="letter" class="pwdinvalid">A <b>lowercase</b> letter</p>
			<p id="capital" class="pwdinvalid">A <b>capital (uppercase)</b> letter</p>
			<p id="number" class="pwdinvalid">A <b>number</b></p>
			<p id="length" class="pwdinvalid">Minimum <b>8 characters</b></p>
		</div>
		<div class="radio-list">
			<label>Select Your Company Category:</label>
			<?php

			if (!isset($wp_roles))
				$wp_roles = new WP_Roles();
			$roles = $wp_roles->roles;


			unset($roles['administrator']);
			unset($roles['editor']);
			unset($roles['author']);
			unset($roles['subscriber']);
			unset($roles['contributor']);
			unset($roles['armember']);
			unset($roles['super_admin']);
			unset($roles['blocked']);

			foreach ($roles as $key => $role) { ?>
				<div class="radio-btn"><input type="radio" id="<?php echo $key; ?>" name="user_role" value="<?php echo $key; ?>" required /><label for="<?php echo $key; ?>"><?php echo $role['name']; ?></label></div>
			<?php }
			?>
		</div>
		<?php
		pippin_show_error_messages(); ?>
		<button class="custom-btn" style="width:100%">
			<input type="hidden" name="pippin_register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>" />
			<img src="/wp-content/uploads/2023/05/login.png" alt="icon">
			<input type="submit" value="<?php _e('Register'); ?>" />
		</button>

	</form>
<?php
	return ob_get_clean();
}

// login form fields
function pippin_login_form_fields()
{

	ob_start();
	$errors = pippin_show_error_messages();
?>


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<form id="pippin_login_form" class="pippin_form" action="" method="post">
		<h3 class="pippin_header"><?php _e('Login'); ?></h3>

		<div class="input-container">
			<input name="pippin_user_login" placeholder="Username/Email" id="pippin_user_login" class="required <?php echo ($errors[0] ? 'input-error' : ''); ?>" type="text" />
		</div>
		<div class="input-container">
			<input name="pippin_user_pass" placeholder="Password" id="pippin_user_pass" class="required <?php echo ($errors[0] ? 'input-error' : ''); ?>" type="password" /><input type='checkbox' id='check' />
			</body>

		</div>
		<?php
		// show any error messages after form submission


		pippin_show_error_messages(); ?>
		<div class="forgetmenot keepme">
			<input name="rememberme" type="checkbox" id="rememberme" value="forever"> <label for="rememberme">Keep Me Logged In</label>

		</div>
		<button class="custom-btn" style="width:100%">
			<input type="hidden" name="pippin_login_nonce" value="<?php echo wp_create_nonce('pippin-login-nonce'); ?>" />
			<img src="/wp-content/uploads/2023/05/login.png" alt="icon">
			<input id="pippin_login_submit " type="submit" value="Login" />
		</button>
		<div id="nav">
			<a href="<?php echo home_url(); ?>/logicoreadmin?action=lostpassword">Forgot Password?</a>
			<a href="<?php echo home_url(); ?>/register">New User?/ Register</a>
		</div>
	</form>
	<!-- <p>© All rights reserved by logicore.com @2023</p> -->
	<?php
	return ob_get_clean();
}

// logs a member in after submitting a form
// function pippin_login_member() {
//    error_reporting(0);

//    if(isset($_POST['pippin_user_login']) && wp_verify_nonce($_POST['pippin_login_nonce'], 'pippin-login-nonce')  ) {

//         // this returns the user ID and other info from the user name

//         $user = get_user_by( 'email', $_POST['pippin_user_login'] );
//         echo "<pre>";
//         print_R($user);


//     $activated = get_user_meta($user->ID,'wp-approve-user',true);
//     if(!$user->ID) {
//             // if the user name doesn't exist
//         pippin_errors()->add('empty_username', __('Empty Username'));
//     }
//     else{


//         if($user && $activated != 1){
//             pippin_errors()->add('Not_activated', __('Your account has to be confirmed by an administrator before you can log in.'));
//         }

//         if(!isset($_POST['pippin_user_pass']) || $_POST['pippin_user_pass'] == '') {
//             // if no password was entered
//             pippin_errors()->add('empty_password', __('Empty Password'));
//         }

//         // check the user's login with their password
//         if(!wp_check_password($_POST['pippin_user_pass'], $user->user_pass, $user->ID)) {
//             // if the password is incorrect for the specified user
//             pippin_errors()->add('empty_password', __('Incorrect password'));
//         }

//         // retrieve all error messages
//         $errors = pippin_errors()->get_error_messages();

//         // only log the user in if there are no errors
//         if(empty($errors)) {

//             wp_setcookie($_POST['pippin_user_login'], $_POST['pippin_user_pass'], true);
//             wp_set_current_user($user->email, $_POST['pippin_user_login']);    
//             do_action('wp_login', $_POST['pippin_user_login']);

//             $user_roles = $user->roles;
//             echo "<pre>";
//             print_R($user);
//             echo "<pre>";
//             print_R($user_roles);
//             die;

//     if( in_array('warehouse', $user_roles)){
//         $url = home_url('/owner_panel');
//         wp_redirect($url);

//     }
//    elseif( in_array('administrator', $user_roles)){
//     $url = admin_url('/admin.php?page=admin_dashboard');
//     wp_redirect($url);

//     }
// else{
//     wp_redirect(home_url());
// }

//              exit;
//         }
//     }
// }
// }
// add_action('init', 'pippin_login_member');

function pippin_login_member()
{

	if (isset($_POST['pippin_user_login']) && wp_verify_nonce($_POST['pippin_login_nonce'], 'pippin-login-nonce')) {

		// this returns the user ID and other info from the user name
		//$user = get_userdatabylogin($_POST['pippin_user_login']);
		// $user = get_user_by( 'login', $_POST['pippin_user_login'] );
		$user_email = get_user_by('email', $_POST['pippin_user_login']);
		if (!$user_email) {
			$user = get_user_by('login', $_POST['pippin_user_login']);
		} else {
			$user = get_user_by('email', $_POST['pippin_user_login']);
		}

		$activated = get_user_meta($user->data->ID, 'wp-approve-user', true);

		if (!$user) {
			// if the user name doesn't exist
			pippin_errors()->add('empty_username', __('Invalid username'));
		}
		if ($user && $activated != 1) {
			pippin_errors()->add('Not_activated', __('Your account has to be confirmed by an administrator before you can log in.'));
		}

		if (!isset($_POST['pippin_user_pass']) || $_POST['pippin_user_pass'] == '') {
			// if no password was entered
			pippin_errors()->add('empty_password', __('Please enter a password'));
		}

		// check the user's login with their password
		if (!wp_check_password($_POST['pippin_user_pass'], $user->data->user_pass, $user->data->ID)) {
			// if the password is incorrect for the specified user
			pippin_errors()->add('empty_password', __('Incorrect password'));
		}

		// retrieve all error messages
		$errors = pippin_errors()->get_error_messages();

		// only log the user in if there are no errors
		if (empty($errors)) {


			// wp_setcookie($user->data->user_login, $_POST['pippin_user_pass'], true);
			// wp_set_current_user($user->data->ID, $user->data->user_login);	
			//  wp_set_auth_cookie($user->data->ID);
			// do_action('wp_login', $user->data->user_login);
			wp_set_current_user($user->data->ID, $user->data->user_login);
			wp_set_auth_cookie($user->data->ID);
			do_action('wp_login', $user->data->user_login);
			$user_roles = $user->roles;


			if (in_array('warehouse', $user_roles)) {
				$url = home_url('/owner_panel');
				wp_redirect($url);
			} elseif (in_array('administrator', $user_roles)) {
				$url = admin_url('/admin.php?page=admin_dashboard');
				wp_redirect($url);
			} elseif (in_array('super_admin', $user_roles)) {
				$url = admin_url('/admin.php?page=admin_dashboard');
				wp_redirect($url);
			} else {
				wp_redirect(home_url());
			}

			exit;
		}
	}
}
add_action('init', 'pippin_login_member');

// register a new user
function pippin_add_new_member()
{



	if (isset($_POST["pippin_user_login"]) && wp_verify_nonce($_POST['pippin_register_nonce'], 'pippin-register-nonce')) {

		$user_login     = $_POST["pippin_user_login"];
		$user_email     = $_POST["pippin_user_email"];
		// $user_first     = $_POST["pippin_user_first"];
		// $user_last      = $_POST["pippin_user_last"];
		$user_pass      = $_POST["pippin_user_pass"];
		$pass_confirm   = $_POST["pippin_user_pass_confirm"];

		// this is required for username checks
		require_once(ABSPATH . WPINC . '/registration.php');

		if (username_exists($user_login)) {
			// Username already registered
			pippin_errors()->add('username_unavailable', __('Username already taken'));
		}
		if (!validate_username($user_login)) {
			// invalid username
			pippin_errors()->add('username_invalid', __('Invalid username'));
		}
		if ($user_login == '') {
			// empty username
			pippin_errors()->add('username_empty', __('Please enter a username'));
		}
		if (!is_email($user_email)) {
			//invalid email
			pippin_errors()->add('email_invalid', __('Invalid email'));
		}
		if (email_exists($user_email)) {
			//Email address already registered
			pippin_errors()->add('email_used', __('Email already registered'));
		}
		if ($user_pass == '') {
			// passwords do not match
			pippin_errors()->add('password_empty', __('Please enter a password'));
		}
		if ($user_pass != $pass_confirm) {
			// passwords do not match
			pippin_errors()->add('password_mismatch', __('Passwords do not match'));
		}

		$errors = pippin_errors()->get_error_messages();

		// only create the user in if there are no errors
		if (empty($errors)) {


			$new_user_id = wp_insert_user(
				array(
					'user_login'        => $user_login,
					'user_pass'         => $user_pass,
					'user_email'        => $user_email,
					// 'first_name'        => $user_login,
					// 'last_name'         => $user_login,
					'user_registered'   => date('Y-m-d H:i:s'),
					'role'              => $_POST['user_role']
				)
			);
			if ($new_user_id) {
				$user_info = get_userdata($new_user_id);
				$code = md5(time());
				// make it into a code to send it to user via email
				$string = array('id' => $new_user_id, 'code' => $code);
				// create the activation code and activation status
				update_user_meta($new_user_id, 'account_activated', 0);
				update_user_meta($new_user_id, 'activation_code', $code);
				// create the url
				$url = get_site_url() . '?act=' . base64_encode(serialize($string));
				// basically we will edit here to make this nicer
				$home_url = home_url();
				$html = 'You are successfully registered in the <a href=' . $home_url . '> Logicoreapp </a>.';
				$html .= 'Please click the following link to verify <br/><br/> <a href="' . $url . '">' . $url . '</a> <br/> <br/>';
				$html .= 'Logicore <br/>';
				$html .= '<a href=' . $home_url . '> Logicoreapp </a>';

				// send an email out to user
				wp_mail($user_info->user_email, __('User Verification', 'text-domain'), $html, 'Content-type: text/html');
				// send an email to the admin alerting them of the registration
				//wp_new_user_notification($new_user_id);


				update_user_meta($new_user_id, 'company', $_POST['pippin_user_company']);
				update_user_meta($new_user_id, 'address', $_POST['pippin_user_address']);
				update_user_meta($new_user_id, 'city', $_POST['pippin_user_city']);
				update_user_meta($new_user_id, 'state', $_POST['pippin_user_state']);
				update_user_meta($new_user_id, 'zipcode', $_POST['pippin_user_zip']);
				update_user_meta($new_user_id, 'phone_number', $_POST['pippin_user_phone']);
				if (is_admin()) {

					update_user_meta($new_user_id, 'wp-approve-user', '1');
					//wp_redirect(home_url());exit;
					wp_redirect(admin_url('admin.php?page=warehouse_owner'));
					exit;
				} else {
					update_user_meta($new_user_id, 'wp-approve-user', '');
					wp_redirect(home_url());
					exit;
				}



				// log the new user in
				// wp_setcookie($user_login, $user_pass, true);
				// wp_set_current_user($new_user_id, $user_login); 
				//do_action('wp_login', $user_login);

				// send the newly created user to the home page after logging them in
				// exit;
			}
		}
	}
}
add_action('init', 'pippin_add_new_member');
add_action('init', 'verify_user_code');
function verify_user_code()
{
	if (isset($_GET['act'])) { ?>
		<style>
			.verified-notice {
				position: fixed;
				width: 100%;
				height: 100%;
				background: #000000;
				z-index: 999;
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.verified-notice .verifild_text {
				background: #fff;
				width: 360px;
				padding: 15px;
				border-radius: 12px;
				text-align: center;
			}

			.verified-notice .verifild_text strong {
				display: block;
				font-size: 26px;
				text-align: center;
				color: green;
			}

			.verified-notice .verifild_text p {
				margin-bottom: 5px;
			}
		</style>
		<?php
		$data = unserialize(base64_decode($_GET['act']));
		$code = get_user_meta($data['id'], 'activation_code', true);
		$user_info = get_userdata($data['id']);
		// verify whether the code given is the same as ours
		if ($code == $data['code'] && !is_user_logged_in()) {
			$approval_email_send_status = get_user_meta($data['id'], 'approval_send', true);
			// update the user meta
			update_user_meta($data['id'], 'is_activated', 1);
			$domain = get_option('blogname'); ?>
			<div class="verified-notice">
				<div class="verifild_text">

					<p><strong>Success:</strong> Your account has been activated!</p>
					<p>Please wait for the admin approval. Once admin approve Your account you will be able to login your account</p>
					<!-- <a href="<?php //echo home_url();
									?>"><?php //echo $domain;
										?></a> -->
					<p>For further information you can contact at <a href="mailto:support@logicoreapp.com">support@logicoreapp.com</a></p>
				</div>
			</div>
			<?php
			if ($approval_email_send_status != 1) {

				$username = $user_info->display_name;
				$useremail = $user_info->user_email;

				$headers = 'From: ' . $username . ' <' . $useremail . '>' . "\r\n";

				$to = 'mail@logicoreapp.com';
				$subject = 'Approval Pending';
				$html = "The approval is pending for the verified user";
				wp_mail($to, $subject, $html, $headers);
				update_user_meta($data['id'], 'approval_send', 1);
			}
		}
		if ($code == $data['code'] && is_user_logged_in()) { ?>
			<div class="verified-notice">
				<div class="verifild_text">
					<p>Your account is activated!</p>
					<p>You are already logged in your account</p>
				</div>
			</div>

		<?php
			die;
		}
		if ($code !== $data['code']) { ?>
			<div class="verified-notice">
				<div class="verifild_text">
					<p>This is not the correct Url</p>
					<p>For further information you can contact at <a href="mailto:support@logicoreapp.com">support@logicoreapp.com</a></p>

				</div>
			</div>

	<?php die;
		}
	} ?>

<?php
}

// used for tracking error messages
function pippin_errors()
{
	static $wp_error; // Will hold global variable safely
	return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function pippin_show_error_messages()
{
	if ($codes = pippin_errors()->get_error_codes()) {
		echo '<div class="pippin_errors">';
		// Loop error codes and display errors
		foreach ($codes as $code) {
			$message = pippin_errors()->get_error_message($code);
			echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		}
		echo '</div>';
	}
	return $codes;
}

function wpdocs_theme_slug_widgets_init()
{

	register_sidebar(array(
		'name'          => __('Copyrigts Footer', 'storefront'),
		'id'            => 'copyrights-footer',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));

	register_sidebar(array(
		'name'          => __('Footer left', 'storefront'),
		'id'            => 'footer-top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));
}
add_action('widgets_init', 'wpdocs_theme_slug_widgets_init');


add_action('wp_ajax_product_filter', 'product_filter_callback');
add_action('wp_ajax_nopriv_product_filter', 'product_filter_callback');

add_action('wp_ajax_wharehouse_product_filter', 'wharehouse_product_filter_callback');
add_action('wp_ajax_nopriv_wharehouse_product_filter', 'wharehouse_product_filter_callback');

add_action('wp_ajax_toCity_filter', 'toCity_filter_callback');
add_action('wp_ajax_nopriv_toCity_filter', 'toCity_filter_callback');

add_action('wp_ajax_toCityWharehouse_filter', 'toCityWharehouse_filter_callback');
add_action('wp_ajax_nopriv_toCityWharehouse_filter', 'toCityWharehouse_filter_callback');

add_action('wp_ajax_range_filter', 'range_filter_callback');
add_action('wp_ajax_nopriv_range_filter', 'range_filter_callback');



add_action('wp_ajax_blog_data', 'blog_data_callback');
add_action('wp_ajax_nopriv_blog_data', 'blog_data_callback');
function blog_data_callback()
{
	global $wpdb; ?>
	<h2 class="blue-heading">Industrial Updates and News</h2>
	<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => 10,
		'paged' => $paged
	);

	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) : $query->the_post();
			echo '<div class="blog-item"><span><img src="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '"></span>';
			// echo '<br>';
			echo '<h4>' . get_the_title() . '</h4>';
			$limit = 35;
			$text = wp_strip_all_tags(get_the_content());
			if (str_word_count($text, 0) > $limit) {
				$arr = str_word_count($text, 2);
				$pos = array_keys($arr);
				$text = substr($text, 0, $pos[$limit]) . '...';
				$text = force_balance_tags($text); // may be you dont need this…
			}
			if ($text) {
				echo ' <div itemprop="description" class="shop_desc"><p>' . $text . '</p></div>';
			} else {
				echo ' <div itemprop="description" class="shop_desc"></div>';
			}
			// echo "<br>";
			echo '<a class="custom-btn" href="' . get_the_permalink() . '">Read More</a></div>';
		endwhile;
		wp_reset_postdata();
	}
	?>
	</div>
	<?php
	die();
}

function range_filter_callback()
{
	global $wpdb;
	$input =  $_POST['input'] . ' ' . $_POST['state'];
	$address = ($_POST['top_cities_name'] ? $_POST['top_cities_name'] : $input);
	$prepAddr = str_replace(' ', '+', $address);
	$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $prepAddr . '&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
	$output = json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$lat1 = deg2rad($latitude);
	$lng1 = deg2rad($longitude);
	$distance = str_replace(' miles', '', $_POST['mile']);
	$paid_ids = get_users(array('role' => 'armember', 'fields' => 'ID'));
	$warehouse_ids = get_users(array('role' => 'warehouse', 'fields' => 'ID'));
	$total_ids = implode(',', array_merge($paid_ids, $warehouse_ids));
	$args = [
		'post_type'      => 'warehouse',
		'post_status'    =>  'publish',
		'posts_per_page' => -1,
		'author'     => [$total_ids], // Specify the author IDs you want
		'orderby'        => 'author',
	];
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		$warehouses = array();
		while ($query->have_posts()) : $query->the_post();
			$lat2 = get_field('latitude');
			$lon2 = get_field('longitude');
			$theta = (float)$longitude - (float)$lon2;
			$dist = sin(deg2rad((float)$latitude)) * sin(deg2rad((float)$lat2)) +  cos(deg2rad((float)$latitude)) * cos(deg2rad((float)$lat2)) * cos(deg2rad((float)$theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = (float)$dist * 60 *  (float)1.1515;
			if ((float)$miles <= (float)$distance) {
				$user_id = get_post_field('post_author', get_the_ID());
				$user = get_userdata($user_id);
				$user_roles = $user->roles;
				$warehouse_data = array(
					'id' => get_the_ID(),
					'distance' => $miles,
					'user_roles' => $user_roles,
					'user_id' => $user_id,
				);
				$warehouses[] = $warehouse_data;
			}
		endwhile;
		usort($warehouses, function ($a, $b) {
			// Priority 1: Check for 'armember' role
			if (in_array('armember', $a['user_roles'], true) && !in_array('armember', $b['user_roles'], true)) {
				return -1;
			} elseif (!in_array('armember', $a['user_roles'], true) && in_array('armember', $b['user_roles'], true)) {
				return 1;
			}
			// Priority 2: Compare distance if user roles are the same
			if ($a['distance'] == $b['distance']) {
				return 0;
			}
			return ($a['distance'] < $b['distance']) ? -1 : 1;
		});
		foreach ($warehouses as $warehouse) {
			$post_id = $warehouse['id']; ?>
			<div class="blog-item">
				<span><a class="" target="_blank" href="<?php echo get_permalink($post_id); ?>">
						<img src="<?php echo get_the_post_thumbnail_url($post_id, 'thumbnail'); ?>"></a>
				</span>
				<?php $user_id = get_post_field('post_author', $post_id);
				$user = get_userdata($warehouse['user_id']);
				$user_roles = $user->roles;
				?><div class="warehouse_titles">
					<h2 class="blue-heading"> <a class="" target="_blank" href="<?php echo get_permalink($post_id); ?>"><?php echo  get_the_title($post_id); ?></a></h2>
					<?php if (in_array('armember', $user_roles, true)) { ?>
						<span class="paid_member"> <?php echo 'Member Pro'; ?></span>
					<?php } ?>
				</div>
				<?php $location = get_field('warehouse-address', $post_id); ?>
				<p><strong><img src="/wp-content/uploads/2023/05/location.png" alt="icon">Address: </strong><?php if ($location) {
																												echo $location;
																											}
																											$city = get_field('city', $post_id);
																											if ($city) {
																												echo ', ' . $city;
																											}
																											$state = get_field('state', $post_id);
																											if ($state) {
																												echo ', ' . $state;
																											}
																											$zipcode = get_field('zipcode', $post_id);
																											if ($zipcode) {
																												echo ', ' . $zipcode;
																											}
																											?></p>
				<?php $speciality_services = get_field('specialty_services', $post_id); ?>
				<p><img src="/wp-content/uploads/2023/05/services.png" alt="icon" style="filter: invert(1);"><strong>Speciality Services: </strong><?php echo $speciality_services; ?></p>
			</div>
		<?php  }
	} else { ?>
		<div class="empty">No Warehouse found with your search criteria.</div>
		<?php }
	wp_reset_postdata();
	die;
}

function toCityWharehouse_filter_callback()
{
	global $wpdb;
	$city_name = $_POST['top_cities_name'];

	$result1 = $wpdb->get_results($wpdb->prepare("
	SELECT *
	FROM {$wpdb->prefix}gf_entry
	INNER JOIN {$wpdb->prefix}gf_entry_meta ON {$wpdb->prefix}gf_entry.id = {$wpdb->prefix}gf_entry_meta.entry_id
	WHERE {$wpdb->prefix}gf_entry_meta.meta_key = 1
	AND {$wpdb->prefix}gf_entry_meta.meta_value LIKE %s
	AND {$wpdb->prefix}gf_entry.form_id = '2'
	ORDER BY {$wpdb->prefix}gf_entry.id DESC
	LIMIT 10", '%' . $wpdb->esc_like($city_name) . '%'));

	$result2 = array();
	foreach ($result1 as $entry_form) {
		$result2[] = GFAPI::get_entry($entry_form->entry_id);
	}

	if (!empty($result2)) {
		foreach ($result2 as $key => $entry_data) {
			$no = $key;
			$user_name = get_userdata($entry_data['created_by']);
			$created_date = strtotime($entry_data['date_created']);
		?>

			<div class="blog-item home_items">
				<h4><?= ucfirst(strtolower($user_name->data->user_login)) ?> is looking for a Wharehouse in <?= $entry_data['1'] ?></h4>
				<p class="icon-date"><img src="/wp-content/uploads/2023/05/calander_icon.png"><?php echo date("F j, Y", $created_date); ?></p>
				<?php
				$limit = 25;
				$text = $entry_data['12'];
				if (str_word_count($text, 0) > $limit) {
					$arr = str_word_count($text, 2);
					$pos = array_keys($arr);
					$text = substr($text, 0, $pos[$limit]) . "...";
					$text = force_balance_tags($text);
				}
				?>
				<div itemprop="description" class="shop_desc">
					<p><?= $text ?></p>
				</div>
				<a class="custom-btn" href="../wharehouse?id=<?=$entry_data['id']?>">See Details</a>
			</div>

		<?php
		}
	} else { ?>
		<div class="empty">No Warehouse Request found with your search criteria.</div>
		<?php }
	exit;
}

function toCity_filter_callback()
{
	global $wpdb;
	$address = $_POST['top_cities_name']; // Google HQ
	$prepAddr = str_replace(' ', '+', $address);
	$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $prepAddr . '&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
	$output = json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$lat1 = deg2rad($latitude);
	$lng1 = deg2rad($longitude);
	$distance = str_replace(' miles', '', $_POST['miles']);
	unset($_POST['action']);
	unset($_POST['miles']);
	unset($_POST['top_cities']);
	unset($_POST['top_cities_name']);
	foreach ($_POST as $key => $taxanomy) {
		$tax =  $key;
		$terms = implode(", ", $taxanomy);
		$tax_qry[] = [
			'taxonomy' => $tax,
			'field'    => 'id',
			'terms'    => $terms,
		];
	}

	$paid_ids = get_users(array('role' => 'armember', 'fields' => 'ID'));
	$author_paid = implode(',', $paid_ids);
	$warehouse_ids = get_users(array('role' => 'warehouse', 'fields' => 'ID'));
	$admin_ids = get_users(array('role' => 'administrator', 'fields' => 'ID'));
	$total_ids = implode(',', array_merge($paid_ids, $warehouse_ids,));
	$args = [
		'post_type'      => 'warehouse',
		'post_status'    =>  'publish',
		'posts_per_page' => -1,
		'author'    => [$total_ids],
		'orderby'       =>  'author',
		'order'         =>  'DESC',
		'meta_query' => array(
			array(
				'key' => 'city',
				'value' => $_POST['top_cities_name'],
				'compare' => 'LIKE'
			)
		)
	];
	if ($tax_qry) :
		$args['tax_query'] = $tax_qry;
	endif;
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) : $query->the_post(); ?>
			<?php $lat2 = get_field('latitude');
			$lon2 = get_field('longitude');
			$theta = (float)$longitude - (float)$lon2;
			$dist = sin(deg2rad((float)$latitude)) * sin(deg2rad((float)$lat2)) +  cos(deg2rad((float)$latitude)) * cos(deg2rad((float)$lat2)) * cos(deg2rad((float)$theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = (float)$dist * 60 *  (float)1.1515;
			if ((float)$miles <= $distance) {
			?>
				<div class="blog-item">
					<span><a class="" target="_blank" href="<?php echo get_the_permalink(); ?>">
							<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>"></a>
					</span>
					<?php $user_id = get_post_field('post_author', get_the_ID());
					$user = get_userdata($user_id);
					$user_roles = $user->roles;
					?><div class="warehouse_titles">
						<h2 class="blue-heading"> <a class="" target="_blank" href="<?php echo get_the_permalink(); ?>"><?php echo  get_the_title(); ?></a></h2>
						<?php if (in_array('armember', $user_roles, true)) { ?>
							<span class="paid_member"> <?php echo 'Member Pro'; ?></span>
						<?php   } ?>
					</div>
					<?php $location = get_field('warehouse-address'); ?>
					<p><strong><img src="/wp-content/uploads/2023/05/location.png" alt="icon">Address: </strong><?php if ($location) {
																													echo $location;
																												}
																												$city = get_field('city');
																												if ($city) {
																													echo ', ' . $city;
																												}
																												$state = get_field('state');
																												if ($state) {
																													echo ', ' . $state;
																												}
																												$zipcode = get_field('zipcode');
																												if ($zipcode) {
																													echo ', ' . $zipcode;
																												}
																												?></p>
					<?php $speciality_services = get_field('specialty_services'); ?>
					<p><img src="/wp-content/uploads/2023/05/services.png" alt="icon" style="filter: invert(1);"><strong>Speciality Services: </strong><?php echo $speciality_services; ?></p>
				</div>
		<?php
			}
		endwhile;
	} else { ?>
		<div class="empty">No Warehouse found with your search criteria.</div>
		<?php }
	wp_reset_postdata();
	die;
}

function wharehouse_product_filter_callback()
{
	global $wpdb;

	$conditions = array();

	if (isset($_POST['city']) && !empty($_POST['city'])) {
		$city = $_POST['city'];
		$conditions[] = "{$wpdb->prefix}gf_entry_meta.meta_key = 1 AND {$wpdb->prefix}gf_entry_meta.meta_value LIKE %s";
	}

	if (isset($_POST['state']) && !empty($_POST['state'])) {
		$state = $_POST['state'];
		$conditions[] = "{$wpdb->prefix}gf_entry_meta.meta_key = 3 AND {$wpdb->prefix}gf_entry_meta.meta_value LIKE %s";
	}

	$query = "
    SELECT *
    FROM {$wpdb->prefix}gf_entry
    INNER JOIN {$wpdb->prefix}gf_entry_meta ON {$wpdb->prefix}gf_entry.id = {$wpdb->prefix}gf_entry_meta.entry_id
    WHERE 1=1";

	if (!empty($conditions)) {
		$query .= " AND (" . implode(" OR ", $conditions) . ")";
	}

	$query .= "
    AND {$wpdb->prefix}gf_entry.form_id = '2'
    ORDER BY {$wpdb->prefix}gf_entry.id 
	DESC";

	$results = $wpdb->get_results($wpdb->prepare($query, '%' . $wpdb->esc_like($city) . '%', '%' . $wpdb->esc_like($state) . '%'));

	$result2 = array();
	foreach ($results as $entry_form) {
		$result2[] = GFAPI::get_entry($entry_form->entry_id);
	}


	if (!empty($result2)) {
		foreach ($result2 as $key => $entry_data) {
			$no = $key;
			$user_name = get_userdata($entry_data['created_by']);
			$created_date = strtotime($entry_data['date_created']);
		?>

			<div class="blog-item home_items">
				<h4><?= ucfirst(strtolower($user_name->data->user_login)) ?> is looking for a Wharehouse in <?= $entry_data['1'] ?></h4>
				<p class="icon-date"><img src="/wp-content/uploads/2023/05/calander_icon.png"><?php echo date("F j, Y", $created_date); ?></p>
				<?php
				$limit = 25;
				$text = $entry_data['12'];
				if (str_word_count($text, 0) > $limit) {
					$arr = str_word_count($text, 2);
					$pos = array_keys($arr);
					$text = substr($text, 0, $pos[$limit]) . "...";
					$text = force_balance_tags($text);
				}
				?>
				<div itemprop="description" class="shop_desc">
					<p><?= $text ?></p>
				</div>
				<a class="custom-btn" href="../wharehouse?id=<?=$entry_data['id']?>">See Details</a>
			</div>
		<?php
		}
	} else { ?>
		<div class="empty">No Warehouse Request found with your search criteria.</div>
	<?php }
	exit;
}
function product_filter_callback()
{
	global $wpdb;
	$table_name_postmeta = $wpdb->prefix . "postmeta";
	$table_name_taxanomies = $wpdb->prefix . "term_relationships";
	$distance = str_replace(' miles', '', $_POST['miles']);
	if (isset($_POST['input']) && !empty($_POST['input'])) {
		$input = $_POST['input'];
	}
	if (isset($_POST['state']) && !empty($_POST['state'])) {
		$state = $_POST['state'];
	}
	$city_posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE `meta_key` = 'city' AND `meta_value` = '" . $input . "' ", ARRAY_A);
	$state_posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE `meta_key` = 'state' AND `meta_value` = '" . $_POST['state'] . "' ", ARRAY_A);
	$address = $input . ' ' . $state; // Google HQ
	$prepAddr = str_replace(' ', '+', $address);
	$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $prepAddr . '&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
	$output = json_decode($geocode);
	$latitude = (float)($output->results[0]->geometry->location->lat);
	$longitude = (float)($output->results[0]->geometry->location->lng);
	$lat1 = deg2rad($latitude);
	$lng1 = deg2rad($longitude);
	?>
	<script>
		jQuery(".range-wrap").css("display", "block");
	</script>
	<?php
	if ($input) {
		$q1 = get_posts(array(
			'fields' => 'ids',
			'post_type' => 'warehouse',
			's' => $input
		));
		$q2 = get_posts(array(
			'fields' => 'ids',
			'post_type' => 'warehouse',
			'meta_query' => array(
				array(
					'key' => 'city',
					'value' => $input,
					'compare' => 'LIKE'
				)
			)
		));
		$unique = array_unique(array_merge($q1, $q2));
	}
	if ($_POST['state'] && !empty($_POST['state'])) {
		$meta_qry[] = [
			'key' => 'state',
			'value' => $_POST['state'],
			'compare' => '=',
		];
	}
	unset($_POST['action']);
	unset($_POST['miles']);
	unset($_POST['input']);
	unset($_POST['state']);
	foreach ($_POST as $key => $taxanomy) {
		$tax =  $key;
		$terms = implode(", ", $taxanomy);
		$tax_qry[] = [
			'taxonomy' => $tax,
			'field'    => 'id',
			'terms'    => $terms,
		];
	}
	$blocked_ids = get_users(array('role' => 'blocked', 'fields' => 'ID'));
	$paid_ids = get_users(array('role' => 'armember', 'fields' => 'ID'));
	$warehouse_ids = get_users(array('role' => 'warehouse', 'fields' => 'ID'));
	$admin_ids = get_users(array('role' => 'administrator', 'fields' => 'ID'));
	$blocked_owners = implode(',', $blocked_ids);
	$total_ids = implode(',', array_merge($paid_ids, $warehouse_ids));
	$args = [
		'post_type'      => 'warehouse',
		'post_status'    =>  'publish',
		'posts_per_page' => -1,
		'author'     => [$total_ids],
		'orderby'        => 'author',
	];
	if ($tax_qry) :
		$args['tax_query'] = $tax_qry;
	endif;
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		$warehouses = array();
		while ($query->have_posts()) : $query->the_post();
			$lat2 = get_field('latitude');
			$lon2 = get_field('longitude');
			$theta = (float)$longitude - (float)$lon2;
			$dist = sin(deg2rad((float)$latitude)) * sin(deg2rad((float)$lat2)) +  cos(deg2rad((float)$latitude)) * cos(deg2rad((float)$lat2)) * cos(deg2rad((float)$theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = (float)$dist * 60 *  (float)1.1515;
			if ((float)$miles <= $distance) {
				$user_id = get_post_field('post_author', get_the_ID());
				$user = get_userdata($user_id);
				$user_roles = $user->roles;
				$warehouse_data = array(
					'id' => get_the_ID(),
					'distance' => $miles,
					'user_roles' => $user_roles,
					'user_id' => $user_id,
				);
				$warehouses[] = $warehouse_data;
			}
		endwhile;
		// Custom sorting function to prioritize warehouses with 'armember' role
		usort($warehouses, function ($a, $b) {
			// Priority 1: Check for 'armember' role
			if (in_array('armember', $a['user_roles'], true) && !in_array('armember', $b['user_roles'], true)) {
				return -1;
			} elseif (!in_array('armember', $a['user_roles'], true) && in_array('armember', $b['user_roles'], true)) {
				return 1;
			}
			if ($a['distance'] == $b['distance']) {
				return 0;
			}
			return ($a['distance'] < $b['distance']) ? -1 : 1;
		});
		foreach ($warehouses as $warehouse) {
			$post_id = $warehouse['id'];
			//  echo $warehouse['distance'];
	?>
			<div class="blog-item">
				<span><a class="" target="_blank" href="<?php echo get_permalink($post_id); ?>">
						<img src="<?php echo get_the_post_thumbnail_url($post_id, 'thumbnail'); ?>"></a>
				</span>
				<?php $user_id = get_post_field('post_author', $post_id);
				$user = get_userdata($warehouse['user_id']);

				// Get all the user roles as an array.
				$user_roles = $user->roles;

				// Check if the role you're interested in, is present in the array.

				?><div class="warehouse_titles">
					<h2 class="blue-heading"> <a class="" target="_blank" href="<?php echo get_permalink($post_id); ?>"><?php echo  get_the_title($post_id); ?></a></h2>
					<?php if (in_array('armember', $user_roles, true)) { ?>

						<span class="paid_member"> <?php echo 'Member Pro'; ?></span>
					<?php   } ?>
				</div>


				<?php $location = get_field('warehouse-address', $post_id); ?>
				<p><strong><img src="/wp-content/uploads/2023/05/location.png" alt="icon">Address: </strong><?php if ($location) {
																												echo $location;
																											}
																											$city = get_field('city', $post_id);
																											if ($city) {

																												echo ', ' . $city;
																											}
																											$state = get_field('state', $post_id);
																											if ($state) {
																												echo ', ' . $state;
																											}
																											$zipcode = get_field('zipcode', $post_id);
																											if ($zipcode) {
																												echo ', ' . $zipcode;
																											}
																											?></p>
				<?php $speciality_services = get_field('specialty_services', $post_id); ?>
				<p><img src="/wp-content/uploads/2023/05/services.png" alt="icon" style="filter: invert(1);"><strong>Speciality Services: </strong><?php echo $speciality_services; ?></p>
			</div>
		<?php   }
	} else { ?>
		<div class="empty">No Warehouse found with your search criteria.</div>
	<?php }
	wp_reset_postdata();
	die;
}

function property_gallery_add_metabox()
{
	add_meta_box(
		'post_custom_gallery',
		'Gallery',
		'property_gallery_metabox_callback',
		'warehouse', // Change post type name
		'normal',
		'core'
	);
}
add_action('admin_init', 'property_gallery_add_metabox');

function property_gallery_metabox_callback()
{
	wp_nonce_field(basename(__FILE__), 'sample_nonce');
	global $post;
	$gallery_data = get_post_meta($post->ID, 'gallery_data', true);
	?>
	<div id="gallery_wrapper">
		<div id="img_box_container">
			<?php
			if (isset($gallery_data['image_url'])) {
				for ($i = 0; $i < count($gallery_data['image_url']); $i++) {
			?>
					<div class="gallery_single_row dolu">
						<div class="gallery_area image_container ">
							<img class="gallery_img_img" src="<?php esc_html_e($gallery_data['image_url'][$i]); ?>" height="55" width="55" onclick="open_media_uploader_image_this(this)" />
							<input type="hidden" class="meta_image_url" name="gallery[image_url][]" value="<?php esc_html_e($gallery_data['image_url'][$i]); ?>" />
						</div>
						<div class="gallery_area">
							<span class="button remove" onclick="remove_img(this)" title="Remove" /><i class="fas fa-trash-alt"></i></span>
						</div>
						<div class="clear" />
					</div>
		</div>
<?php
				}
			}
?>
	</div>
	<div style="display:none" id="master_box">
		<div class="gallery_single_row">
			<div class="gallery_area image_container" onclick="open_media_uploader_image(this)">
				<input class="meta_image_url" value="" type="hidden" name="gallery[image_url][]" />
			</div>
			<div class="gallery_area">
				<span class="button remove" onclick="remove_img(this)" title="Remove" /><i class="fas fa-trash-alt"></i></span>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="add_gallery_single_row">
		<input class="button add" type="button" value="+" onclick="open_media_uploader_image_plus();" title="Add image" />
	</div>
	</div>
<?php
}

function property_gallery_styles_scripts()
{
	global $post;
	if ('warehouse' != $post->post_type)
		return;
?>
	<style type="text/css">
		.gallery_area {
			float: right;
		}

		.image_container {
			float: left !important;
			width: 100px;
			background: url('https://i.hizliresim.com/dOJ6qL.png');
			height: 100px;
			background-repeat: no-repeat;
			background-size: cover;
			border-radius: 3px;
			cursor: pointer;
		}

		.image_container img {
			height: 100px;
			width: 100px;
			border-radius: 3px;
		}

		.clear {
			clear: both;
		}

		#gallery_wrapper {
			width: 100%;
			height: auto;
			position: relative;
			display: inline-block;
		}

		#gallery_wrapper input[type=text] {
			width: 300px;
		}

		#gallery_wrapper .gallery_single_row {
			float: left;
			display: inline-block;
			width: 100px;
			position: relative;
			margin-right: 8px;
			margin-bottom: 20px;
		}

		.dolu {
			display: inline-block !important;
		}

		#gallery_wrapper label {
			padding: 0 6px;
		}

		.button.remove {
			background: none;
			color: #f1f1f1;
			position: absolute;
			border: none;
			top: 4px;
			right: 7px;
			font-size: 1.2em;
			padding: 0px;
			box-shadow: none;
		}

		.button.remove:hover {
			background: none;
			color: #fff;
		}

		.button.add {
			background: #c3c2c2;
			color: #ffffff;
			border: none;
			box-shadow: none;
			width: 100px;
			height: 100px;
			line-height: 100px;
			font-size: 4em;
		}

		.button.add:hover,
		.button.add:focus {
			background: #e2e2e2;
			box-shadow: none;
			color: #0f88c1;
			border: none;
		}
	</style>
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
	<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script type="text/javascript">
		function remove_img(value) {
			var parent = jQuery(value).parent().parent();
			parent.remove();
		}
		var media_uploader = null;

		function open_media_uploader_image(obj) {
			media_uploader = wp.media({
				frame: "post",
				state: "insert",
				multiple: false
			});
			media_uploader.on("insert", function() {
				var json = media_uploader.state().get("selection").first().toJSON();
				var image_url = json.url;
				var html = '<img class="gallery_img_img" src="' + image_url + '" height="55" width="55" onclick="open_media_uploader_image_this(this)"/>';
				console.log(image_url);
				jQuery(obj).append(html);
				jQuery(obj).find('.meta_image_url').val(image_url);
			});
			media_uploader.open();
		}

		function open_media_uploader_image_this(obj) {
			media_uploader = wp.media({
				frame: "post",
				state: "insert",
				multiple: false
			});
			media_uploader.on("insert", function() {
				var json = media_uploader.state().get("selection").first().toJSON();
				var image_url = json.url;
				console.log(image_url);
				jQuery(obj).attr('src', image_url);
				jQuery(obj).siblings('.meta_image_url').val(image_url);
			});
			media_uploader.open();
		}

		function open_media_uploader_image_plus() {
			media_uploader = wp.media({
				frame: "post",
				state: "insert",
				multiple: true
			});
			media_uploader.on("insert", function() {

				var length = media_uploader.state().get("selection").length;
				var images = media_uploader.state().get("selection").models

				for (var i = 0; i < length; i++) {
					var image_url = images[i].changed.url;
					var box = jQuery('#master_box').html();
					jQuery(box).appendTo('#img_box_container');
					var element = jQuery('#img_box_container .gallery_single_row:last-child').find('.image_container');
					var html = '<img class="gallery_img_img" src="' + image_url + '" height="55" width="55" onclick="open_media_uploader_image_this(this)"/>';
					element.append(html);
					element.find('.meta_image_url').val(image_url);
					//console.log(image_url);     
				}
			});
			media_uploader.open();
		}
		jQuery(function() {
			jQuery("#img_box_container").sortable();
		});
	</script>
<?php
}
add_action('admin_head-post.php', 'property_gallery_styles_scripts');
add_action('admin_head-post-new.php', 'property_gallery_styles_scripts');

function property_gallery_save($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce = (isset($_POST['sample_nonce']) && wp_verify_nonce($_POST['sample_nonce'], basename(__FILE__))) ? 'true' : 'false';

	if ($is_autosave || $is_revision || !$is_valid_nonce) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	// Correct post type
	if ('warehouse' != $_POST['post_type']) // here you can set the post type name
		return;

	if ($_POST['gallery']) {

		// Build array for saving post meta
		$gallery_data = array();
		for ($i = 0; $i < count($_POST['gallery']['image_url']); $i++) {
			if ('' != $_POST['gallery']['image_url'][$i]) {
				$gallery_data['image_url'][]  = $_POST['gallery']['image_url'][$i];
			}
		}

		if ($gallery_data)
			update_post_meta($post_id, 'gallery_data', $gallery_data);
		else
			delete_post_meta($post_id, 'gallery_data');
	}
	// Nothing received, all fields are empty, delete option
	else {
		delete_post_meta($post_id, 'gallery_data');
	}
	// update_post_meta($post_id,'title',get_the_title($post_id));
}
add_action('save_post', 'property_gallery_save');
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

add_filter('gform_notification_2', 'change_autoresponder_email', 10, 3);
function change_autoresponder_email($notification, $form, $entry)
{
	global $current_user, $wpdb;
	//      ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	//      echo "Notification";

	//    echo "Form";
	// echo "<pre>";
	// print_r($form); 
	//    echo "Entry";
	// echo "<pre>";
	// print_r($entry); 

	$table_name = $wpdb->prefix . "postmeta";
	$value = $entry['1'];

	$prepAddr = str_replace(' ', '+', $value);
	echo $prepAddr;
	$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $prepAddr . '&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
	$output = json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	$search_lat = $latitude . ' ' . $longitude;
	// echo $search_lat;
	$post_ids = $wpdb->get_results('SELECT post_id FROM ' . $table_name . ' where meta_key = "city" && meta_value = "' . $value . '"', ARRAY_A);

	// $user_id        = $current_user->ID;
	// $user_name = $current_user->user_nicename;

	//    $user_company_name  =   get_user_meta($user_id,'company',true);


	// $users = get_users(array(
	//     'meta_key'     => 'city',
	//     'meta_value'     => $entry['1'],
	// ));
	// echo "<pre>";
	// print_R($post_ids);


	foreach ($post_ids as $post_id) {

		$address = get_post_meta($post_id['post_id'], 'warehouse-address', true);
		$city = get_post_meta($post_id['post_id'], 'city', true);
		$state = get_post_meta($post_id['post_id'], 'state', true);
		$zipcode = get_post_meta($post_id['post_id'], 'zipcode', true);
		$full_address = $address . ',' . $city . ',' . $state . ',' . $zipcode; // Google HQ

		$prepAddr = str_replace(' ', '+', $full_address);
		$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $prepAddr . '&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
		$output = json_decode($geocode);
		$lat2 = $output->results[0]->geometry->location->lat;
		$lon2 = $output->results[0]->geometry->location->lng;

		//$lon2 = get_field('longitude');
		//echo "<br>";
		//echo $lat2.' '.$lon2;
		$theta = $longitude - $lon2;
		$dist = sin(deg2rad($latitude)) * sin(deg2rad($lat2)) +  cos(deg2rad($latitude)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		// echo $miles;







		// $theta = (float)$longitude - (float)$lon2;           
		//               $dist = sin(deg2rad((float)$latitude)) * sin(deg2rad((float)$lat2)) +  cos(deg2rad((float)$latitude)) * cos(deg2rad((float)$lat2)) * cos(deg2rad((float)$theta));
		//               $dist = acos($dist);
		//               $dist = rad2deg($dist);

		//               $miles = $dist * 60 * 1.1515;
		//  if((float)$miles <= 30)
		echo "miles away";
		// echo $miles;
		// echo "test";
		// echo get_post_meta($post_id['post_id'],'ware_house_email',true);
		// echo "<br>";

		if ($miles <= 30) {
			// echo $miles;
			// echo get_post_meta($post_id['post_id'],'email',true);
			$email_address[] = get_post_meta($post_id['post_id'], 'ware_house_email', true);
		}
	}
	// echo "<pre>";
	// print_R($email_address);
	$result = array_filter($email_address);
	// echo "<pre>";  
	$emails = array_unique($result);



	array_push($emails, $notification['toEmail']);
	//$notification['subject'] ="Warehouse project request from (".$user_name.", ".$user_company_name.")";
	$notification['subject'] = "Quote inquiry---" . $entry['15'];
	if (isset($emails) && !empty($emails)) {
		$notification['bcc'] = GFCommon::implode_non_blank(',', $emails);
	}
	// echo "<pre>";
	// print_R($notification);
	return $notification;
}


function K45_disable_new_user_notifications()
{
	//Remove original use created emails
	remove_action('register_new_user', 'wp_send_new_user_notifications');
	remove_action('edit_user_created_user', 'wp_send_new_user_notifications', 10, 2);
}

add_action('init', 'K45_disable_new_user_notifications');

function custom_admin_js()
{
	echo '<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>';
	echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>';
}
add_action('wp_head', 'custom_admin_js');

function custom_admin_css()
{
	echo '<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	';
}
add_action('wp_head', 'custom_admin_css');

function my_acf_init()
{
	acf_update_setting('google_api_key', 'AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
}
add_action('acf/init', 'my_acf_init');

add_filter('get_custom_logo', 'wecodeart_com');
function wecodeart_com()
{
	$custom_logo_id = get_theme_mod('custom_logo');
	$html = sprintf(
		'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
		home_url(),
		wp_get_attachment_image($custom_logo_id, 'full', false, array(
			'class'    => 'custom-logo',
		))
	);
	return $html;
}


function simple_fep($content = null)
{
	global $post;

	// We're outputing a lot of html and the easiest way 
	// to do it is with output buffering from php.
	ob_start();

?>
	<style>
		#fep-new-post label {
			display: inline-block;
			width: 15%;
		}

		#fep-new-post input {
			width: 60%;
		}

		#fep-new-post input[type="submit"] {
			margin-left: 15%;
			width: 30%;
			padding: 7px;
		}

		#fep-new-post textarea {
			display: inline-block;
			width: 80%;
			vertical-align: top;
		}
	</style>
	<div id="simple-fep-postbox" class="<?php if (is_user_logged_in()) echo 'closed';
										else echo 'loggedout' ?>">
		<?php do_action('simple-fep-notice'); ?>
		<div class="simple-fep-inputarea">
			<?php if (is_user_logged_in()) { ?>
				<form id="fep-new-post" name="new_post" method="post" action="<?php the_permalink(); ?>">
					<p><label>Title *</label><input type="text" id="fep-post-title" name="post-title" /></p>
					<p><label>Content *</label><textarea class="fep-content" name="posttext" id="fep-post-text" tabindex="1" rows="4" cols="60"></textarea></p>
					<p><label>Tags</label><input id="fep-tags" name="tags" type="text" tabindex="2" autocomplete="off" value="<?php esc_attr_e('Add tags', 'simple-fep'); ?>" onfocus="this.value=(this.value=='<?php echo esc_js(__('Add tags', 'simple-fep')); ?>') ? '' : this.value;" onblur="this.value=(this.value=='') ? '<?php echo esc_js(__('Add tags', 'simple-fep')); ?>' : this.value;" /></p>
					<input id="submit" type="submit" tabindex="3" value="<?php esc_attr_e('Post', 'simple-fep'); ?>" />
					<input type="hidden" name="action" value="post" />
					<input type="hidden" name="empty-description" id="empty-description" value="1" />
					<?php wp_nonce_field('new-post'); ?>
				</form>
			<?php } else { ?>
				<h4>Please Log-in To Post</h4>
			<?php } ?>
		</div>

	</div> <!-- #simple-fep-postbox -->
<?php
	// Output the content.
	$output = ob_get_contents();
	ob_end_clean();

	// Return only if we're inside a page. This won't list anything on a post or archive page. 
	if (is_page()) return  $output;
}

// Add the shortcode to WordPress. 
add_shortcode('simple_fep', 'simple_fep');


function simple_fep_errors()
{
?>
	<style>
		.simple-fep-error {
			border: 1px solid #CC0000;
			border-radius: 5px;
			background-color: #FFEBE8;
			margin: 0 0 16px 0px;
			padding: 12px;
		}
	</style>
	<?php
	global $error_array;
	foreach ($error_array as $error) {
		echo '<p class="simple-fep-error">' . $error . '</p>';
	}
}

function simple_fep_notices()
{
	?>
	<style>
		.simple-fep-notice {
			border: 1px solid #E6DB55;
			border-radius: 5px;
			background-color: #FFFBCC;
			margin: 0 0 16px 0px;
			padding: 12px;
		}
	</style>
	<?php

	global $notice_array;
	foreach ($notice_array as $notice) {
		echo '<p class="simple-fep-notice">' . $notice . '</p>';
	}
}

function simple_fep_add_post()
{
	if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'post') {
		if (!is_user_logged_in())
			return;
		global $current_user;

		$user_id        = $current_user->ID;
		$post_title     = $_POST['post-title'];
		$post_content   = $_POST['posttext'];
		$tags           = $_POST['tags'];

		global $error_array;
		$error_array = array();

		if (empty($post_title)) $error_array[] = 'Please add a title.';
		if (empty($post_content)) $error_array[] = 'Please add some content.';

		if (count($error_array) == 0) {

			$post_id = wp_insert_post(array(
				'post_author'   => $user_id,
				'post_title'    => $post_title,
				'post_type'     => 'warehouse',
				'post_content'  => $post_content,
				'tags_input'    => $tags,
				'post_status'   => 'publish'
			));
			$address = $_POST['Address'];
			$city = $_POST['City'];
			$state = $_POST['State'];
			$zipcode = $_POST['Zipcode'];
			$email_address = $_POST['email_address'];
			$phone_number = $_POST['phone_number'];
			$area = $_POST['area'];
			$parking_space = $_POST['parking_space'];
			$clear_height = $_POST['clear_height'];
			$dock_doors = $_POST['dock_doors'];
			$rail = $_POST['rail'];
			$website = $_POST['website'];
			update_post_meta($post_id, 'location_headquarter_location', $address);
			update_post_meta($post_id, 'location_country', $city);
			update_post_meta($post_id, 'location_state', $state);
			update_post_meta($post_id, 'location_zipcode', $zipcode);
			update_post_meta($post_id, 'location_ware_house_email', $email_address);
			update_post_meta($post_id, 'location_phone_number', $phone_number);
			update_post_meta($post_id, 'location_area', $area);
			update_post_meta($post_id, 'parking_space', $parking_space);
			update_post_meta($post_id, 'clear_height', $clear_height);
			update_post_meta($post_id, 'dock_doors', $dock_doors);
			update_post_meta($post_id, 'rail', $rail);
			update_post_meta($post_id, 'website', $website);

			global $notice_array;
			$notice_array = array();
			$notice_array[] = "Thank you for posting. Your post is now live. ";
			add_action('simple-fep-notice', 'simple_fep_notices');
		} else {
			add_action('simple-fep-notice', 'simple_fep_errors');
		}
	}
}

add_action('init', 'simple_fep_add_post');

function total_count_bro()
{
	$out             = '';
	$user_count_data = count_users();
	$avail_roles = $user_count_data['avail_roles'];
	foreach ($avail_roles as $role_key => $role_count) {
		$out = $contributor = $avail_roles['warehouse']; /* User role author  */
		'<br/>';
	}
	return $out;
}
add_shortcode('users_count_bro', 'total_count_bro');
function total_count_bro2()
{
	$args = [

		'role__not_in' => ['administrator', 'subscriber', 'contributor', 'author', 'editor', 'super_admin'],
		'orderby' => 'nicename',
		'order' => 'ASC',
		'fields' => 'all',
	];
	$users = get_users($args);

	return count($users);
}
add_shortcode('users_count_bro2', 'total_count_bro2');

function warehouse_users_data()
{
	$out             = '';
	$user_count_data = count_users();
	$avail_roles = $user_count_data['avail_roles'];
	foreach ($avail_roles as $role_key => $role_count) {
		$contributor = $avail_roles['warehouse']; /* User role author  */
		'<br/>';
	}
	//return $out;
}
add_shortcode('warehouse_users_data', 'warehouse_users_data');

add_action("wp_ajax_add_warehouses", "add_warehouses_callback");
add_action("wp_ajax_nopriv_add_warehouses", "add_warehouses_callback");

function add_warehouses_callback()
{

	require_once(ABSPATH . 'wp-admin/includes/image.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/media.php');

	global $wpdb, $current_user;
	//   echo "<pre>";
	//     print_R($_POST);
	//     die;

	if (!isset($_POST['warehouse_title']) || empty($_POST['warehouse_title'])) {
		return;
	}
	$error = array();
	$warehouse_title = $_POST['warehouse_title'];
	$warehouse_description = ($_POST['warehouse_desc'] ? $_POST['warehouse_desc'] : '');

	// $query = $wpdb->prepare(
	//        'SELECT ID FROM ' . $wpdb->posts . '
	//        WHERE post_title = %s
	//        AND post_type = \'warehouse\'',
	//        $warehouse_title
	//    );
	//    $wpdb->query( $query );

	//    if ( $wpdb->num_rows ) {
	//        $error['board']['status'] = 'Error';
	//    $error['board']['msg'] = $_POST['warehouse_title'].' warehouse is already exist';

	//    } else {
	$user_id  = $current_user->ID;
	$new_post = array(
		'post_title' => $warehouse_title,
		'post_content' => $warehouse_description,
		'post_status' => 'draft',
		'post_date' => date('Y-m-d H:i:s'),
		'post_author' => $user_id,
		'post_type' => 'warehouse',
		//'post_category' => array(0)
	);



	$post_id = wp_insert_post($new_post);
	$address = $_POST['Address'];
	$city = $_POST['City'];
	$state = $_POST['State'];
	$zipcode = $_POST['Zipcode'];
	$email_address = $_POST['email_address'];
	$phone_number = $_POST['phone_number'];
	$area = $_POST['area'];
	$parking_space = $_POST['parking_space'];
	$clear_height = $_POST['clear_height'];
	$dock_doors = $_POST['dock_doors'];
	$rail = ($_POST['rail'] ? $_POST['rail'] : "NO");
	$website = $_POST['website'];
	$specialty_services = $_POST['spciality_services'];
	$capacity = $_POST['warehouse_capacity'];

	if (isset($_FILES['upload_file']) && !empty($_FILES['upload_file']['name'])) {


		$upload = wp_upload_bits($_FILES["upload_file"]["name"], null, file_get_contents($_FILES["upload_file"]["tmp_name"]));

		if (!$upload['error']) {
			$post_id = $post_id; //set post id to which you need to add featured image
			$filename = $upload['file'];
			$wp_filetype = wp_check_filetype($filename, null);
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => sanitize_file_name($filename),
				'post_content' => '',
				'post_status' => 'inherit'
			);

			$attachment_id = wp_insert_attachment($attachment, $filename, $post_id);



			if (!is_wp_error($attachment_id)) {
				require_once(ABSPATH . 'wp-admin/includes/image.php');

				$attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
				wp_update_attachment_metadata($attachment_id, $attachment_data);
				set_post_thumbnail($post_id, $attachment_id);
			}
		}
	}
	if (isset($_FILES['image']) && !empty($_FILES['image'])) {
		$files = $_FILES["image"];
		foreach ($files['name'] as $key => $value) {
			if ($files['name'][$key]) {
				$file = array(
					'name' => $files['name'][$key],
					'type' => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error' => $files['error'][$key],
					'size' => $files['size'][$key]
				);
				$_FILES = array("upload_file" => $file);
				$attachment_id = media_handle_upload("upload_file", 0);
				$image_ids[] =  $attachment_id;
			}
		}
		if (isset($image_ids) && !empty($image_ids)) {
			foreach ($image_ids as $image_id) {
				$gallery_data['image_url'][] = wp_get_attachment_image_url($image_id, 'full');
			}


			update_post_meta($post_id, 'gallery_data', $gallery_data);
		}
	}

	$full_address = $address . ',' . $city . ',' . $state . ',' . $zipcode; // Google HQ
	// echo $full_address;
	$prepAddr = str_replace(' ', '+', $full_address);
	$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $prepAddr . '&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
	$output = json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;

	update_post_meta($post_id, '_city', 'field_6476ee1cc3336');
	update_post_meta($post_id, '_meta_title', 'field_6495664da7f9a');
	update_post_meta($post_id, '_location', 'field_645a1b13d4ad4');
	update_post_meta($post_id, '_warehouse-address', 'field_649282e5b8dcf');
	update_post_meta($post_id, '_address', 'field_645a1a3334091');
	update_post_meta($post_id, '_state', 'field_646c9eb180784');
	update_post_meta($post_id, '_zipcode', 'field_646c9eb880785');
	update_post_meta($post_id, ' _ware_house_email', 'field_6465bf2a63fef');
	update_post_meta($post_id, '_phone_number', 'field_6465bf3c63ff0');
	update_post_meta($post_id, '_area', 'field_6465bf7863ff1');
	update_post_meta($post_id, '_miles', 'field_645c8c50d2bd9');
	update_post_meta($post_id, '_parking_space', 'field_646c9e9f80783');
	update_post_meta($post_id, '_clear_height', 'field_646c9f0a9bf3d');
	update_post_meta($post_id, '_dock_doors', 'field_646c9f239bf3e');
	update_post_meta($post_id, '_rail', 'field_646c9f3a9bf3f');
	update_post_meta($post_id, '_website', 'field_646c9f489bf40');
	update_post_meta($post_id, '_specialty_services', 'field_648bf41f284cf');
	update_post_meta($post_id, '_warehouse_capacity', 'field_648fee64270e6');
	update_post_meta($post_id, '_longitude', 'field_6492ad994660b');
	update_post_meta($post_id, '_latitude', 'field_6492ada44660c');
	update_post_meta($post_id, 'miles', '200');
	update_post_meta($post_id, 'address', '');
	update_post_meta($post_id, 'location', '');
	update_post_meta($post_id, 'warehouse-address', $address);
	update_post_meta($post_id, 'city', $city);
	update_post_meta($post_id, 'meta_title', $warehouse_title);
	update_post_meta($post_id, 'state', $state);
	update_post_meta($post_id, 'zipcode', $zipcode);
	update_post_meta($post_id, 'ware_house_email', $email_address);
	update_post_meta($post_id, 'phone_number', $phone_number);
	update_post_meta($post_id, 'area', $area);
	update_post_meta($post_id, 'parking_space', $parking_space);
	update_post_meta($post_id, 'clear_height', $clear_height);
	update_post_meta($post_id, 'dock_doors', $dock_doors);
	update_post_meta($post_id, 'rail', $rail);
	update_post_meta($post_id, 'website', $website);
	update_post_meta($post_id, 'longitude', $longitude);
	update_post_meta($post_id, 'latitude', $latitude);
	update_post_meta($post_id, 'specialty_services', $specialty_services);
	update_post_meta($post_id, 'warehouse_capacity', $capacity);
	wp_set_post_terms($post_id, $_POST['services'], 'services');
	wp_set_post_terms($post_id, $_POST['warehouse_commodity'], 'commodity');
	wp_set_post_terms($post_id, $_POST['warehouse_certification'], 'certification');
	wp_set_post_terms($post_id, $_POST['warehouse_additional_services'], 'additional_service');
	//  wp_set_post_terms($post_id, $_POST['warehouse_area'], 'area');


	if ($post_id) {
		$error['board']['status'] = 'Success';
		$error['board']['msg'] = 'warehouse is created.';
	} else {
		$error['board']['status'] = 'Error';
		$error['board']['msg'] = 'Unable to create board.';
	}
	//}
	echo json_encode($error);
	die;
}


// // function redirect_login_page() {

// //     $login_page  = home_url( '/login/' );  
// //     $page_viewed = basename($_SERVER['REQUEST_URI']);  

// //     if( $page_viewed == "wp-login.php") {  
// //         wp_redirect(admin_url());  
// //         exit;  
// //     }  
// // }  
// // add_action('init','redirect_login_page');

// function login_failed() {

//     $login_page  = home_url( '/login/' );      
//     wp_redirect( $login_page . '?login=failed' );  
//     exit;  
// }  
// add_action( 'wp_login_failed', 'login_failed' );  

// // function verify_username_password( $user, $username, $password ) {  
// //     echo 

// //     $login_page  = home_url( '/login/' );  
// //     if( $username == "" || $password == "" ) {  
// //         wp_redirect( $login_page . "?login=empty" );  
// //         exit;  
// //     }  
// // }  
// // add_filter( 'authenticate', 'verify_username_password', 1, 3);  

// function check_login($user) {

//     if ($user->roles[0] == "") {
//         if (substr($user->user_email, -12) == "@company.com") {
//             $user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Please login using Google.' ) );
//         }
//     }

//     return $user;
// }

// add_filter('wp_authenticate_user', 'check_login', 9, 1);

// function logout_page() {

//     $login_page  = home_url( '/login/' );  
//     wp_redirect( $login_page . "?login=false" );  
//     exit;  
// }  
// add_action('wp_logout','logout_page');

add_action('wp_logout', 'auto_redirect_after_logout');

function auto_redirect_after_logout()
{
	wp_safe_redirect(home_url('/login/'));
	exit;
}

function wpb_widgets_init()
{

	register_sidebar(array(
		'name' => __('Adds Sidebar', 'wpb'),
		'id' => 'add_sidebar',
		'description' => __('The main sidebar appears on the right on each page except the front page template', 'wpb'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}

add_action('widgets_init', 'wpb_widgets_init');

add_filter('gform_counter_script_2', 'set_counter_script', 10, 5);
function set_counter_script($script, $form_id, $input_id, $max_length, $field)
{
	$script = "jQuery('#{$input_id}').textareaCount(" .
		"    {" .
		"    'maxCharacterSize': {$max_length}," .
		"    'originalStyle': 'ginput_counter'," .
		"    'displayFormat' : '#left / {$max_length}'" .
		"    });";
	return $script;
}

function custom_admin_datatables()
{
	echo '<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>';
}
add_action('wp_head', 'custom_admin_datatables');

function custom_admin_datatables_css()
{
	echo '<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">';
}
add_action('wp_head', 'custom_admin_datatables_css');

function show_adds()
{
	ob_start();
	$args = [
		'post_type'      => 'adds',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	];
	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) : $query->the_post();
			$add_data = get_field('adds');
	?>
			<div class="rightside_links">
				<ul>
					<li><a class="" href="<?php echo $add_data['company_link']; ?>"><img src="<?php echo home_url(); ?>/wp-content/uploads/2023/06/Vector.png"> <?php echo $add_data['company_name']; ?></a></li>
					<li><img src="<?php echo home_url(); ?>/wp-content/uploads/2023/06/Vector-1.png">
						<?php
						// foreach($add_data['services'] as $service){
						// echo $service->name;
						//  echo ", ";

						// }
						echo $add_data['services'];
						?>
					</li>
				</ul>
			</div>


	<?php endwhile;
	}


	return ob_get_clean();
}

add_shortcode('show_adds', 'show_adds');

add_action("wp_ajax_edit_user", "edit_user_callback");
add_action("wp_ajax_nopriv_edit_user", "edit_user_callback");

function edit_user_callback()
{

	global $wpdb;
	$error = array();
	if (isset($_POST['owner_name']))
		wp_update_user(
			['ID' => $_POST['user_id'], 'display_name' => $_POST['owner_name']]
		);
	if (isset($_POST['owner_email']))
		wp_update_user(
			['ID' => $_POST['user_id'], 'user_email' => $_POST['owner_email']]
		);
	if (isset($_POST['owner_company_name']))
		update_user_meta($_POST['user_id'], 'company', $_POST['owner_company_name']);
	if (isset($_POST['owner_phone']))
		update_user_meta($_POST['user_id'], 'phone_number', $_POST['owner_phone']);
	if (isset($_POST['owner_address']))
		update_user_meta($_POST['user_id'], 'address', $_POST['owner_address']);
	if (isset($_POST['owner_city']))
		update_user_meta($_POST['user_id'], 'city', $_POST['owner_city']);
	if (isset($_POST['owner_state']))
		update_user_meta($_POST['user_id'], 'state', $_POST['owner_state']);

	if (isset($_POST['owner_zipcodes']))
		update_user_meta($_POST['user_id'], 'zipcode', $_POST['owner_zipcodes']);



	// if($post_id){
	$error['owner']['status'] = 'notice-success';
	$error['owner']['msg'] = 'User Profile updated Successfully.';

	// }else{
	//     $error['owner']['status'] = 'notice-error';
	//     $error['owner']['msg'] = 'Unable to edit owner.';
	// }

	echo json_encode($error);
	die;
}

add_action('admin_head', 'remove_cycle_detail');
function remove_cycle_detail()
{
	?>
	<script type="text/javascript">
		jQuery('.arm_setup_paymentcyclebox_wrapper').hide();
	</script>
<?php }


function custom_admin_datatable1()
{
	//echo '<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>';

	echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>';
}
add_action('wp_head', 'custom_admin_datatable1');

function custom_admin_datatable_css1()
{
	echo '<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">';

	echo '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
	// echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>';

}
add_action('wp_head', 'custom_admin_datatable_css1');

add_action("wp_ajax_wharehouse_contact_request", "wharehouse_contact_request_callback");
add_action("wp_ajax_nopriv_wharehouse_contact_request", "wharehouse_contact_request_callback");

function wharehouse_contact_request_callback()
{
	if (isset($_POST["userId"])) {
        $user_id = $_POST["userId"];
    }
    if (isset($_POST["userEmail"])) {
        $to_email = $_POST["userEmail"];
    }
    $user_data = get_userdata($user_id);

    $subject = 'Response to your warehouse request';
    $message = "Hey there,\n\n";
    $message .= "{$user_data->display_name} is interested in providing you warehouse services as per your request at Logicore.\n";
    $message .= "You can contact them at their email: {$user_data->user_email}";

    // Send email
    $sent = wp_mail($to_email, $subject, $message);

    if ($sent) {
        $response = array(
            'status' => 'success',
            'message' => 'Email successfully sent to the user!'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Failed to send email'
        );
    }

    // Return JSON response
    wp_send_json($response);
}

function ja_global_enqueues()
{

	wp_enqueue_style(
		'jquery-auto-complete',
		'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css',
		array(),
		'1.0.7'
	);

	wp_enqueue_script(
		'jquery-auto-complete',
		'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js',
		array('jquery'),
		'1.0.7',
		true
	);

	wp_enqueue_script(
		'global',
		get_template_directory_uri() . '/js/global.min.js',
		array('jquery'),
		'1.0.0',
		true
	);

	wp_localize_script(
		'global',
		'global',
		array(
			'ajax' => admin_url('admin-ajax.php'),
		)
	);
}
add_action('wp_enqueue_scripts', 'ja_global_enqueues');

/**
 * Live autocomplete search feature.
 *
 * @since 1.0.0
 */
function ja_ajax_search()
{




	$results = new WP_Query(array(
		'post_type'     => array('warehouse'),
		'post_status'   => 'publish',
		'nopaging'      => true,
		'posts_per_page' => 100,
		's'             => stripslashes($_POST['search']),
		's_meta_keys' => array('city', 'meta_title'),
	));
	$items = array();

	if (!empty($results->posts)) {
		foreach ($results->posts as $result) {
			$items[] = $result->post_title;
		}
	}

	wp_send_json_success($items);
}
add_action('wp_ajax_search_site',        'ja_ajax_search');
add_action('wp_ajax_nopriv_search_site', 'ja_ajax_search');

add_action('pre_get_posts', 'my_search_query'); // add the special search fonction on each get_posts query (this includes WP_Query())
function my_search_query($query)
{
	if ($query->is_search() and $query->query_vars and $query->query_vars['s'] and $query->query_vars['s_meta_keys']) { // if we are searching using the 's' argument and added a 's_meta_keys' argument
		global $wpdb;
		$search = $query->query_vars['s']; // get the search string
		$ids = array(); // initiate array of martching post ids per searched keyword
		foreach (explode(' ', $search) as $term) { // explode keywords and look for matching results for each
			$term = trim($term); // remove unnecessary spaces
			if (!empty($term)) { // check the the keyword is not empty
				$query_posts = $wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE post_status='publish' AND ((post_title LIKE '%%%s%%') OR (post_content LIKE '%%%s%%'))", $term, $term); // search in title and content like the normal function does
				$ids_posts = [];
				$results = $wpdb->get_results($query_posts);
				if ($wpdb->last_error)
					die($wpdb->last_error);
				foreach ($results as $result)
					$ids_posts[] = $result->ID; // gather matching post ids
				$query_meta = [];
				foreach ($query->query_vars['s_meta_keys'] as $meta_key) // now construct a search query the search in each desired meta key
					$query_meta[] = $wpdb->prepare("meta_key='%s' AND meta_value LIKE '%%%s%%'", $meta_key, $term);
				$query_metas = $wpdb->prepare("SELECT * FROM {$wpdb->postmeta} WHERE ((" . implode(') OR (', $query_meta) . "))");
				$ids_metas = [];
				$results = $wpdb->get_results($query_metas);
				if ($wpdb->last_error)
					die($wpdb->last_error);
				foreach ($results as $result)
					$ids_metas[] = $result->post_id; // gather matching post ids
				$merged = array_merge($ids_posts, $ids_metas); // merge the title, content and meta ids resulting from both queries
				$unique = array_unique($merged); // remove duplicates
				if (!$unique)
					$unique = array(0); // if no result, add a "0" id otherwise all posts wil lbe returned
				$ids[] = $unique; // add array of matching ids into the main array
			}
		}
		if (count($ids) > 1)
			$intersected = call_user_func_array('array_intersect', $ids); // if several keywords keep only ids that are found in all keywords' matching arrays
		else
			$intersected = $ids[0]; // otherwise keep the single matching ids array
		$unique = array_unique($intersected); // remove duplicates
		if (!$unique)
			$unique = array(0); // if no result, add a "0" id otherwise all posts wil lbe returned
		unset($query->query_vars['s']); // unset normal search query
		$query->set('post__in', $unique); // add a filter by post id instead
	}
}

/******* Disable plugin and theme update notification **********/

add_filter('site_transient_update_plugins', 'remove_update_notification_1234');
function remove_update_notification_1234($value)
{
	unset($value->response[plugin_basename(__FILE__)]);
	return $value;
}

function jm_update_notice()
{
	remove_action('load-update-core.php', 'wp_update_plugins');
}
add_filter('pre_site_transient_update_plugins', '__return_null');


function disable_theme_update_notification($value)
{
	remove_action('load-update-core.php', 'wp_update_themes');
}
add_filter('site_transient_update_themes', 'disable_theme_update_notification');

function remove_news_from_events_widget()
{ ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$("[id*='_news']").remove();
		});
	</script>

<?php }
add_action('admin_head', 'remove_news_from_events_widget');


function remove_core_updates()
{
	global $wp_version;
	return (object) array('last_checked' => time(), 'version_checked' => $wp_version,);
}
add_filter('pre_site_transient_update_core', 'remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
add_filter('pre_site_transient_update_themes', 'remove_core_updates');

/******* Disable plugin and theme update notification **********/
function wpb_login_logo()
{ ?>
	<style type="text/css">
		#login h1 a,
		.login h1 a {
			background-image: url('https://logicoreapp.com/wp-content/uploads/2023/05/logo.png') !important;
			height: 100px;
			width: 300px;
			background-size: 300px 100px;
			background-repeat: no-repeat;
			padding-bottom: 10px;
		}

		#login #nav {
			display: none !important;
		}

		div#login {
			background: #fff;
			padding: 15px 30px;
			border-radius: 12px;
			box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
		}

		body.login.js.login-action- {
			display: flex;
			align-items: center;
			justify-content: center;
			background: url(/wp-content/uploads/2023/05/login-bg.png);
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			background-attachment: fixed;
		}

		div#login h1 a {
			background-size: 120px;
			margin-bottom: 0;
			width: auto;
			height: 80px;
		}

		div#login .privacy-policy-page-link {
			margin: 0;
			font-size: 14px;
		}

		div#login input#user_login {
			border: 1px solid #ddd;
		}

		div#login p.message {
			background: #f5f5f5;
		}
	</style>
<?php }
add_action('login_enqueue_scripts', 'wpb_login_logo');

add_action('init', 'prevent_wp_login');

function prevent_wp_login()
{
	// WP tracks the current page - global the variable to access it
	global $pagenow;
	// Check if a $_GET['action'] is set, and if so, load it into $action variable
	$action = (isset($_GET['action'])) ? $_GET['action'] : '';
	// Check if we're on the login page, and ensure the action is not 'logout'
	if ($pagenow == 'wp-login.php' && (!$action || ($action && !in_array($action, array('logout', 'lostpassword', 'rp', 'resetpass'))))) {
		// Load the home page url
		$url = home_url() . '/login';
		wp_safe_redirect($url);
		// Redirect to the home page
		// wp_redirect($page);
		// Stop execution to prevent the page loading for any reason
		exit();
	}
}
