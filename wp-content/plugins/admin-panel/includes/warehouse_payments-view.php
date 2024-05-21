<div class="dashboar_container">
	 <div class="d-flex">
      <h2 class="blue-heading">Manage Payments</h2>
      
   </div>
  <div class="bg-white p-0 rounded listing_table mt-4">  
	<?php //echo do_shortcode('[arm_member_transaction]');?>
   
   
<?php
   

   global $wp, $wpdb, $ARMember, $arm_slugs, $arm_global_settings, $arm_members_class, $arm_subscription_plans, $arm_payment_gateways, $arm_transaction;

   $date_format = $arm_global_settings->arm_get_wp_date_format();

   $pay_log = $wpdb->get_results("SELECT * FROM `".$ARMember->tbl_arm_payment_log."` WHERE `arm_is_post_payment`='0' AND `arm_paid_post_id`='0' AND arm_is_gift_payment = 0 ORDER BY `arm_created_date` DESC LIMIT 0,6", ARRAY_A);

   $bt_logs = $arm_transaction->arm_get_bank_transfer_logs(0, 0, 0, 6);

   $payment_log = array_merge($pay_log, $bt_logs);


   $transactions = array();

   if (!empty($payment_log)) {

	   $i = 0;

	   foreach ($payment_log as $log) {

		   $date = strtotime($log['arm_created_date']);

		   if (isset($newLog[$date]) && !empty($newLog[$date])) {

			   $date += $i;

			   $transactions[$date] = $log;

		   } else {

			   $transactions[$date] = $log;

		   }

		   $i++;

	   }

	   krsort($transactions);

	   

   }

   if (!empty($transactions))

   {

	   $global_currency = $arm_payment_gateways->arm_get_global_currency();

	   $all_currencies = $arm_payment_gateways->arm_get_all_currencies();

	   $global_currency_sym = $all_currencies[strtoupper($global_currency)];

	   ?>

	   <div class="ARMUserTransactions_content armAdminDashboardWidgetContent">
	   <div class="w-100 overflow-xscroll d-block rounded">	
		   <table cellpadding="0" cellspacing="0" border="0" id="payment_table" class="display">

			   <thead>

				   <tr>
				   <th align="left">S no</th>
				   <th align="left"><?php _e('Business Name', 'ARMember');?></th>

					   <th align="left"><?php _e('User', 'ARMember');?></th>

					   <th align="left"><?php _e('Membership', 'ARMember');?></th>
					    <th align="left"><?php _e('Start Date', 'ARMember');?></th>
					     <th align="left"><?php _e('End Date', 'ARMember');?></th>

					   <th align="center"><?php _e('Amount', 'ARMember');?></th>

					   <th align="center"><?php _e('Status', 'ARMember');?></th>
					   <th align="center"><?php _e('Payment Type', 'ARMember');?></th>



				   </tr>

			   </thead>

			   <tbody>

			   <?php
			   $i=1;
			    $j = 0;foreach($transactions as $t): $t = (object) $t;
			   ?>

				   <?php 

				   if ($j > 5) {

					   continue;

				   }

				   $j++;

				   ?>

				   <tr>
					<td><?php echo $i++;?>

					<td> <?php echo get_user_meta($t->arm_user_id,'company',true);?></td>

					   <td>
						<!-- <a href="<?php //echo admin_url('admin.php?page='.$arm_slugs->manage_members.'&action=view_member&id='.$t->arm_user_id);?>"> -->
						<?php 

					   $data = get_userdata($t->arm_user_id);

					   if (!empty($data)) {

						   echo $data->user_login;

					   }

					   ?>
					   <!-- </a> -->
					</td>

					   <td><?php 

					   $plan_name = $arm_subscription_plans->arm_get_plan_name_by_id($t->arm_plan_id);

					   echo (!empty($plan_name)) ? $plan_name : '<span class="arm_empty">--</span>';

					   ?></td>
					   <td><?php echo date_i18n($date_format,$t->arm_created_date);?></td>
					   <td><?php  $plan_data=get_user_meta($t->arm_user_id, "arm_user_plan_".$t->arm_plan_id, true);               
			                        $arm_expire = !empty($plan_data['arm_expire_plan']) ? $plan_data['arm_expire_plan'] : '';
			                        $arm_next_recurring = !empty($plan_data['arm_next_due_payment']) ? $plan_data['arm_next_due_payment'] : '';
			                        echo date_i18n($date_format,$arm_next_recurring);
?></td>

					   <td class="arm_center"><?php 

					   if (!empty($t->arm_amount) && $t->arm_amount > 0 ) {

						   $t_currency = isset($t->arm_currency) ? strtoupper($t->arm_currency) : strtoupper($global_currency);

						   $currency = (isset($all_currencies[$t_currency])) ? $all_currencies[$t_currency] : $global_currency_sym;

						   echo $arm_payment_gateways->arm_prepare_amount($t->arm_currency, $t->arm_amount);

						   if ($global_currency_sym == $currency && strtoupper($global_currency) != $t_currency) {

								   echo ' ('.$t_currency.')';

						   }

					   } else {

						   echo $arm_payment_gateways->arm_prepare_amount($t->arm_currency, $t->arm_amount);

					   }    

					   ?></td>
					   <td>Online</td>
					   

					   <td class="arm_center"><?php echo $arm_transaction->arm_get_transaction_status_text($t->arm_transaction_status);?></td>

				   </tr>

			   <?php endforeach;?>

			   </tbody>

		   </table>
      </div>
		   <div class="armclear"></div>

		   <!-- <div class="arm_view_all_link">

			   <a href="<?php //echo admin_url('admin.php?page='.$arm_slugs->transactions);?>"><?php //_e('View All Transactions', 'ARMember');?></a>

		   </div> -->

	   </div>

	   <?php

   } else {

	   ?>

	   <div class="arm_dashboard_error_box"><?php _e('There is no any recent transactions found.', 'ARMember');?></div>

	   <?php

   }?>
   </div>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
   <script>
	jQuery(document).ready( function () {
    jQuery('#payment_table').DataTable({
       "order": [[ 0, "asc" ]],
        "pageLength" : 10,
    });
} );
	</script>
