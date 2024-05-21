<?php /* Template Name: paymentgateway */ ?>
<?php get_header();
global $wpdb;
$user = wp_get_current_user();
 
$roles = ( array ) $user->roles;

if(is_user_logged_in() && in_array('warehouse',$roles)) {?>

<div class="main-content admin-login">
	<div class="content-inner">
		<div id = "" class="left-sidebar" >
			<!-- <p>Filter</p> -->
			<div class="left-inner">
				<h4 class="">Dashboard</h4>
			<div class="commodity listing"><a href="<?php echo home_url();?>/owner_panel/" class="filter_titles active">My warehouse</a></div>
			<!-- <div class="commodity payment"><a href="<?php //echo home_url();?>/owner_panel/payment-gateway/" class="filter_titles">Subscription</a></div> -->
			<div class="commodity subscrip"><a href="<?php echo home_url();?>/owner_panel/subscription-management/" class="filter_titles">Current Subscription</a></div>
			<div class="commodity billing"><a href="<?php echo home_url();?>/owner_panel/billing-and-invoices/" class="filter_titles">Billing and invoicing</a></div>
			 <div class="my_profile"><a href="<?php echo home_url();?>/my-profile" class="filter_titles">My Profile</a></div>
			<!-- <div class="commodity"><a href="https://staggingweb.com/logicore/owner_panel/customer-posts/" class="filter_titles">Automated Reminders</a></div> -->
			</div>
		</div>
		<div class="middel-content" >
			<h2 class="blue-heading">Plans to Buy</h2>
			<div class="middle-inner">
				<p>Get your warehouse business listing on top of your city list, and full visiable and reachable from your potential customers</p>
				<p>Receiving project request emails from potential customers</p>

				 <div class="plain_main"> 
				 <div class="plain">
					<?php echo do_shortcode('[arm_setup id="3"]');?>
</div>
<div class="plain">
					<?php echo do_shortcode('[arm_setup id="2"]');?>
</div>
					
				</div>
			</div>

		</div>



<?php
}
else{?>
<script>
            window.location.href = "<?php echo home_url();?>/login";
        </script>
<?php } get_footer();?>


