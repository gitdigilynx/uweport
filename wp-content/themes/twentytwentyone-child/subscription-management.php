<?php /* Template Name: subscriptionmanagement */ ?>
<?php get_header();
global $wpdb;

// echo "<pre>";
// print_R($user_all_plans);

	    $user = wp_get_current_user();
 
    $roles = ( array ) $user->roles;

if(is_user_logged_in() && in_array('warehouse',$roles)) {
	$user_id = get_current_user_id();

	$args=array(
		'post_type' => 'warehouse',
		'post_status' => 'published',
		'posts_per_page' => -1,
		'author' => $user_id
	);                       
	
	$wp_query = new WP_Query($args);
	while ( have_posts() ) : the_post();
	$title = get_the_title();
endwhile; 
global $wp, $wpdb, $current_user, $current_site, $arm_errors, $ARMember, $arm_members_class, $arm_global_settings, $arm_email_settings, $arm_members_activity, $arm_subscription_plans , $arm_membership_setup;

$date_time_format =  $arm_global_settings->arm_get_wp_date_time_format();
$user = wp_get_current_user();
$userplan = wp_get_current_user()->arm_user_plan_ids;
$setup_id = $userplan[0];
 $setup_data = $arm_membership_setup->arm_get_membership_setup($setup_id);
 // echo "<pre>";
 // print_R($setup_data);

                $all_user_plans = $arm_subscription_plans->arm_member_memberships($user_id, 0, 1, 1);
                $membership_count = $all_user_plans['total'];
                $user_all_plans = $all_user_plans['memberships'];

   
?>

<div class="main-content admin-login">
	<div class="content-inner">
		<div id = "" class="left-sidebar" >
			<!-- <p>Filter</p> -->
			<div class="left-inner">
				<h4 class="">Dashboard</h4>
			<div class="commodity listing"><a href="<?php echo home_url();?>/owner_panel/" class="filter_titles">My warehouse</a></div>
			<!-- <div class="commodity payment"><a href="<?php // echo home_url();?>/owner_panel/payment-gateway/" class="filter_titles">Subscription</a></div> -->
			<div class="commodity subscrip"><a href="<?php echo home_url();?>/owner_panel/subscription-management/" class="filter_titles active">Current Subscription</a></div>
			<div class="commodity billing"><a href="<?php echo home_url();?>/owner_panel/billing-and-invoices/" class="filter_titles">Billing and invoicing</a></div>
			 <div class="my_profile"><a href="<?php echo home_url();?>/my-profile" class="filter_titles">My Profile</a></div>
			<!-- <div class="commodity"><a href="https://staggingweb.com/logicore/owner_panel/customer-posts/" class="filter_titles">Automated Reminders</a></div> -->
			</div>
		</div>
		<div class="middel-content" >
			<!-- <div class="subscription_top">
				<h5>Warehouse name: <span><?php //echo $title;?></span></h5>
				<?php //$location_country = get_post_meta(get_the_ID(),'location_country',true);?>
				<h5>location: <span><?php //echo $location_country;?></span></h5>
			</div> -->
			<h2 class="blue-heading">Subscription Management</h2>
			<div class="middle-inner subscript_managpage">
<?php $now = current_time('mysql');
$arm_last_payment_status = $wpdb->get_row("SELECT * FROM `ckUW6Emnn_arm_payment_log` WHERE `arm_user_id`=".$user_id." ORDER BY`arm_log_id` DESC LIMIT 0,1");
if($arm_last_payment_status->arm_plan_id){

$arm_last_payment_plan_detail = $wpdb->get_row("SELECT * FROM `ckUW6Emnn_arm_subscription_plans` WHERE `arm_subscription_plan_id`=".$arm_last_payment_status->arm_plan_id);
}

// echo "<pre>";
//    print_R($arm_last_payment_plan_detail);
//    echo "<pre>";
//    print_R(unserialize($arm_last_payment_plan_detail->arm_subscription_plan_options));
  
   $payment_options = unserialize($arm_last_payment_plan_detail->arm_subscription_plan_options);
   // echo "<pre>";
   // print_R($arm_last_payment_status);

   // 	print_r(unserialize($arm_last_payment_status->arm_extra_vars));
    $userEmail = wp_get_current_user()->user_email;
   	$args =  array(
                    'post_type' => 'warehouse',                    
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key'     => 'ware_house_email',
                            'value'   => $userEmail,
                           // 'compare' => '=',
                        ),
                    ),

            ) ;
$wp_query = new WP_Query($args);



                
   	?>
				<table class="arm_user_current_membership_list_table arm_front_grid dataTable no-footer" cellpadding="0" cellspacing="0" border="0" id="DataTables_Table_1" aria-describedby="DataTables_Table_0_info">
					<thead>
						<tr class="arm_current_membership_list_header" id="arm_current_membership_list_header">
							<th class="arm_cm_sr_no sorting" id="arm_cm_sr_no" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="No.: activate to sort column ascending" style="width: 45px;">Warehouse ID.
							</th>
							<th class="arm_cm_plan_name sorting sorting_asc" id="arm_cm_plan_name" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Membership Plan: activate to sort column descending" style="width: 131.297px;">Membership Plan
							</th>
							<th class="arm_cm_plan_profile sorting" id="arm_cm_plan_profile" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Plan Type: activate to sort column ascending" style="width: 186.188px;">Plan Type
							</th>
							<th class="arm_cm_plan_start_date sorting" id="arm_cm_plan_start_date" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Starts On: activate to sort column ascending" style="width: 103.984px;">Starts On
							</th>
							<th class="arm_cm_plan_end_date sorting" id="arm_cm_plan_end_date" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Expires On: activate to sort column ascending" style="width: 115px;">Expires On
							</th>
							<th class="arm_cm_plan_renew_date sorting" id="arm_cm_plan_renew_date" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Cycle Date: activate to sort column ascending" style="width: 145.672px;">Cycle Date
							</th>
							<th class="arm_cm_plan_action_btn sorting" id="arm_cm_plan_action_btn" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 195px;">Action
							</th>
						</tr>
						</thead>
							<tbody>
							<?php	while ( have_posts() ) : the_post();
								$warehouse_id = get_the_ID();
                
                	 if (!empty($user_all_plans)) {
                    
                   
                    foreach ($user_all_plans as $user_plan) {
                    	?>
								<tr class="arm_current_membership_list_item arm_current_membership_tr_<?php echo $user_plan['plan_id'];?> odd" id="arm_current_membership_tr_<?php echo $user_plan['plan_id'];?>">

							<td data-label="No." class="arm_current_membership_list_item_plan_sr" id="arm_current_membership_list_item_plan_sr_<?php echo $user_plan['plan_id'];?>"><?php  echo $warehouse_id;?></td>

							<td data-label="Membership Plan" class="arm_current_membership_list_item_plan_name sorting_1" id="arm_current_membership_list_item_plan_name_<?php echo $user_plan['plan_id'];?>"><?php echo $user_plan['name'];?> </td>

							<td data-label="Plan Type" class="arm_current_membership_list_item_plan_profile" id="arm_current_membership_list_item_plan_profile_<?php echo $user_plan['plan_id'];?>"><?php echo $user_plan['recurring_profile_html'];?></td>

							<td data-label="Starts On" class="arm_current_membership_list_item_plan_start" id="arm_current_membership_list_item_plan_start_<?php echo $user_plan['plan_id'];?>"><?php echo $user_plan['start_date'];?></td>

							<td data-label="Expires On" class="arm_current_membership_list_item_plan_end" id="arm_current_membership_list_item_plan_end_<?php echo $user_plan['plan_id'];?>"><?php echo $user_plan['remaining_occurence'];?></td>

							<td data-label="Cycle Date" class="arm_current_membership_list_item_renew_date" id="arm_current_membership_list_item_renew_date_<?php echo $user_plan['plan_id'];?>"><?php echo $user_plan['renew_date'];?></td>
							<td id="arm_cm_plan_action_btn" data-label="Action" class="arm_current_membership_list_item_action_btn_3">
						 <?php if (isset($user_plan['is_plan_cancelled']) && $user_plan['is_plan_cancelled'] == 'yes') {?>
                                                   <div class="arm_cm_cancel_btn_div" id="arm_cm_cancel_btn_div_<?php echo $user_plan['plan_id'];?>"><button type="button" id="arm_cancel_subscription_link_<?php echo $user_plan['plan_id'];?>" class= "arm_cancel_subscription_button aftercancle_btn" data-plan_id = "<?php echo $user_plan['plan_id'];?>" style="cursor: default;" disabled="disabled">Cancelled</button></div>
                                               <?php  } else {?>
                                                 <div class="arm_cm_cancel_btn_div" id="arm_cm_cancel_btn_div_<?php echo $user_plan['plan_id'];?>"><button type="button" id="arm_cancel_subscription_link_<?php echo $user_plan['plan_id'];?>" class= "arm_cancel_subscription_button arm_cancel_membership_link" data-plan_id = "<?php echo $user_plan['plan_id'];?>">Cancel</button><img src="<?php echo home_url();?>/wp-content/plugins/armember/images/arm_loader.gif" id="arm_field_loader_img_<?php echo $user_plan['plan_id'];?>" style="display: none;"/></div>
						</td>

                                               <?php }?>
					</tr>
					<?php } }
				endwhile;
								?></tbody></table>
						

	<?php
	// echo do_shortcode('[arm_membership title="" setup_id="3" display_renew_button="false" renew_text="Renew" make_payment_text="Make Payment" renew_css="" renew_hover_css="" display_cancel_button="true" cancel_text="Cancel" cancel_css="" cancel_hover_css="" cancel_message="Your subscription has been cancelled." display_update_card_button="false" update_card_text="Update Card" update_card_css="" update_card_hover_css="" trial_active="trial active" per_page="5" message_no_record="There is no membership found."  membership_label="current_membership_no,current_membership_is,current_membership_recurring_profile,current_membership_started_on,current_membership_expired_on,current_membership_next_billing_date,action_button,"  membership_value="No.,Membership Plan,Plan Type,Starts On,Expires On,Cycle Date,Action,"]');

?>
			</div>

		</div>



<?php

}
else{?>
<script>
            window.location.href = "<?php echo home_url();?>/login";
        </script>
<?php } get_footer();?>


