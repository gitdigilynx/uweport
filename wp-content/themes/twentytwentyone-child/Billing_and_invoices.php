<?php /* Template Name: Billing and Invoice */ ?>
<?php get_header();
global $wpdb;
$user = wp_get_current_user();
 
$roles = ( array ) $user->roles;

if(is_user_logged_in() && in_array('warehouse',$roles)) {
$user_id = get_current_user_id();

$args=array(
	'post_type' => 'warehouse',
	'post_status' => 'published',
	'posts_per_page' => 1,
	'author' => $user_id
);                       

$wp_query = new WP_Query($args);
while ( have_posts() ) : the_post();
$title = get_the_title();
endwhile; ?>

<div class="main-content admin-login">
	<div class="content-inner">
		<div id = "" class="left-sidebar" >
			<!-- <p>Filter</p> -->
			<div class="left-inner">
				<h4 class="">Dashboard</h4>
			<div class="commodity listing"><a href="<?php echo home_url();?>/owner_panel/" class="filter_titles">My warehouse</a></div>
			<!-- <div class="commodity payment"><a href="<?php// echo home_url();?>/owner_panel/payment-gateway/" class="filter_titles">Subscription</a></div> -->
			<div class="commodity subscrip"><a href="<?php echo home_url();?>/owner_panel/subscription-management/" class="filter_titles">Current Subscription</a></div>
			<div class="commodity billing"><a href="<?php echo home_url();?>/owner_panel/billing-and-invoices/" class="filter_titles active">Billing and invoicing</a></div>
			 <div class="my_profile"><a href="<?php echo home_url();?>/my-profile" class="filter_titles">My Profile</a></div>
			<!-- <div class="commodity"><a href="https://staggingweb.com/logicore/owner_panel/customer-posts/" class="filter_titles">Automated Reminders</a></div> -->
			</div>
		</div>
		<div class="middel-content" >
		<!-- <div class="subscription_top">
				<h5>Warehouse name: <span><?php //echo $title;?></span></h5>
				<?php //$location_country = get_post_meta(get_the_ID(),'location_country',true);?>
				
			
					<?php// $location = get_field('location');
					 //if($location['headquarter_location']){?>
						    <p>Address: <?php //echo $location['headquarter_location'].','.$location['country'].','.$location['state'].','.$location['zipcode'];?></p> 
						    <?php //}?>

						    
				
				
			</div> -->
			<div class="subscription_top">
				<h2 class="blue-heading">Billing and Invoices</h2>
				
			</div>	
			<div class="middle-inner billinvoice_page">
				<?php echo do_shortcode('[arm_member_transaction display_invoice_button="true" view_invoice_text="View Invoice" view_invoice_css="" view_invoice_hover_css="" title="Transactions" per_page="5" message_no_record="There is no any Transactions found"  label="transaction_id,invoice_id,plan,payment_gateway,payment_type,transaction_status,amount,payment_date,"  value="Transaction ID,Invoice ID,Plan,Payment Gateway,Payment Type,Transaction Status,Amount,Payment Date,"]');?>


			</div>

		</div>



<?php
}
else{?>
<script>
            window.location.href = "<?php echo home_url();?>/login";
        </script>
<?php } get_footer();?>




