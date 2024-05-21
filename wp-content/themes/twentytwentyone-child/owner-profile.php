<?php /* Template Name: Owner Profile */ ?>
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
			<div class="commodity listing"><a href="<?php echo home_url();?>/owner_panel/" class="filter_titles ">My warehouse</a></div>
			<!-- <div class="commodity payment"><a href="<?php // echo home_url();?>/owner_panel/payment-gateway/" class="filter_titles">Subscription</a></div> -->
			<div class="commodity subscrip"><a href="<?php echo home_url();?>/owner_panel/subscription-management/" class="filter_titles">Current Subscription</a></div>
			<div class="commodity billing"><a href="<?php echo home_url();?>/owner_panel/billing-and-invoices/" class="filter_titles">Billing and invoicing</a></div>
			 <div class="my_profile"><a href="<?php echo home_url();?>/my-profile" class="filter_titles active">My Profile</a></div>
			<!-- <div class="commodity"><a href="https://staggingweb.com/logicore/owner_panel/customer-posts/" class="filter_titles">Automated Reminders</a></div> -->
			</div>
	
</div>
		<div class="middel-content" >
			<div class="profile-content dynamic-id">

				
				<?php $userdata = wp_get_current_user();
				if(isset($_GET['owner_id']) && !empty($_GET['owner_id']) && $userdata->ID == $_GET['owner_id']){
						$data = get_userdata($_GET['owner_id']);
						
				$company_name = get_user_meta($_GET['owner_id'],'company',true);
			$phone_number = get_user_meta($_GET['owner_id'],'phone_number',true);
			$address = get_user_meta($_GET['owner_id'],'address',true);
			$city = get_user_meta($_GET['owner_id'],'city',true);
			$state = get_user_meta($_GET['owner_id'],'state',true);
			$zipcode = get_user_meta($_GET['owner_id'],'zipcode',true);
			?>
		
			<a class="back btn-primary btn" href="<?php echo home_url();?>/my-profile">Back</a>
			<div id="notification" class="notice is-dismissible" style="display:none"></div>
			<h2 class="blue-heading mb-4 mt-3">Edit details</h2>
			<form method="post" id="edit_owner_form" name="edit_owner">
				<div class="bg-light p-4 row">
					<div class="col-12 col-md-6 my-3">
						<label>Name</label>
						<input type="text" name="owner_name" placeholder="Name" class="form-control" value="<?php echo $data->data->display_name;?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<label>Company Name</label>
						<input type="text" name="owner_company_name"  class="form-control" value="<?php echo ($company_name?$company_name:'');?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<label>Phone Number</label>
						<input type="text" name="owner_phone" placeholder="9988998899" class="form-control" value="<?php echo ($phone_number?$phone_number:'');?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<label>Email</label>
						<input type="email" name="owner_email" placeholder="Email" class="form-control" value="<?php echo $data->data->user_email;?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<label>Address</label>
						<input type="text" name="owner_address" placeholder="Email" class="form-control" value="<?php echo $address;?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<label>City</label>
						<input type="text" name="owner_city" placeholder="Email" class="form-control" value="<?php echo $city;?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<label>State</label>
						<input type="text" name="owner_state" placeholder="Email" class="form-control" value="<?php echo $state;?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<label>Zipcode</label>
						<input type="text" name="owner_zipcodes" placeholder="Email" class="form-control" value="<?php echo $zipcode;?>">
					</div>

					
					
					<div class="col-12 my-3 textright mt-4">
						<input type="hidden" name="user_id" value="<?php echo $_GET['owner_id'];?>">
						  <input type="hidden" name="action" value="edit_user" />
						<button class="btn btn-primary edit_owner_btn">Submit</button>
					</div>
				</div>
			</form>
					
				<?php }else{?>
					<a class=" btn btn-primary"  href="<?php echo home_url('my-profile?owner_id=');?><?php echo $userdata->ID;?>">Update My Profile</a>
				<div class="user_promain">
					 <img alt="profile" src="/wp-content/uploads/2023/05/profile-img.png">
					 <div class="profile_details">
					 	<h3 class="blue-heading"><?php echo $userdata->user_nicename;?> </h3>
						<p><strong> Company Name: </strong> <?php echo get_user_meta($userdata->ID,'company',true);?> </p>
						<p><strong> Phone: </strong> <?php echo get_user_meta($userdata->ID,'phone_number',true);?> </p>
						<p><strong> Email Address: </strong><?php echo $userdata->user_email;?></p>
						<p><strong> Address: </strong><?php echo get_user_meta($userdata->ID,'address',true);?>,<?php echo ' '.get_user_meta($userdata->ID,'city',true);?>,<?php echo ' '.get_user_meta($userdata->ID,'state',true);?>,<?php echo ' '.get_user_meta($userdata->ID,'zipcode',true);?></p>
					 </div>
				</div>	
			<?php }?>
			</div>
			<div class="form-content dynamic-id">
				

			<?php echo do_shortcode('[gravityform id="2" title="true" description="false" ajax="true"]');?>
			</div>
			
				
			<?php    
         // $current_user = get_current_user(); 
         // echo "<pre>";
         // print_R($current_user);      
        $user_id  = get_current_user_id();;
        $meta_key = 'gform_entry_id';
        $single = true;
        $entry_id = get_user_meta( $user_id, $meta_key, $single );
       
$result2 = array();
   $result1 = $wpdb->get_results( "SELECT * FROM `ckUW6Emnn_gf_entry` WHERE `form_id` = '2' AND `created_by` = '".$user_id."'" );
  
   

   foreach($result1 as $entry_form){
   //	echo $entry_form->id;

   $result2[] = GFAPI::get_entry( $entry_form->id );
   }
    
   ?>
<div class="post-history  dynamic-id">
	<h2 class="blue-heading">My Post History</h2>
<table id="post_enteries" class="display salonist_tables">
	<thead>
	<tr>
		<th>S no</th>
		<th>City</th>
		<th>State</th>
		<th>Arrival date</th>
		<th>Equipment Size</th>
		<th>Load Method</th>
		<th>View More</th>
		
	</tr>
</thead>
    <tbody>

	

<?php foreach($result2 as $key => $entry_data){
	$no = $key ;
	?>
<tr>
	<td><?php echo ++$key;?></td>
	<td><?php echo $entry_data['1'];?></td>
	<td> <?php echo $entry_data['3'];?></td>
	<td><?php echo $entry_data['5'];?></td>
	<td><?php echo $entry_data['7'];?></td>
	<td> <?php echo $entry_data['14'];?></td>
	<td><a class="view-more"  href="<?php echo home_url().'/user-profile';?>?id=<?php echo $entry_data['id'];?>">View More</a> </td>
</tr>
<?php }?>
	
	


    </tbody>
</table>
</div>
	<?php  if($_GET['id']){
		$result4 = array();?>
		<script> 
		jQuery('.dynamic-id').css('display','none');  </script>
   
   <?php $result4[] = GFAPI::get_entry( $_GET['id'] );
  
 if( strlen( $entry_id ) > 0 && is_numeric( $entry_id ) ) {
           
            ?>
            <h2>Entries</h2>
            <?php
        } ?>
        <div class="post-history-detail">


	

<?php foreach($result4 as $key => $entry_data){

	?>
<h2 class="blue-heading">View More details</h2>
<div class="detail-inner">

        	<p><strong>City: </strong><?php echo $entry_data['1'];?> </p>
        	<p><strong>State: </strong> <?php echo $entry_data['3'];?></p>
        	<p><strong>Arrival Date: </strong> <?php echo $entry_data['5'];?></p>
        	<p><strong>Equipment Size: </strong><?php echo $entry_data['7'];?> </p>
        	<p class="w-100"><strong>Load Method: </strong>  <?php echo$entry_data['14'];?></p>
        	<p><strong>Shipping From: </strong> <?php echo $entry_data['10'];?></p>
        	<p><strong>Deliver to: </strong><?php echo $entry_data['11'];?> </p>
        	<p class="w-100 discruption"><strong class="d-block">Description: </strong><span><?php echo $entry_data['12'];?></span></p>
        	<p><strong>Attached File: </strong></p>
        		<?php 
        		$remove_first_square = trim($entry_data['13'], '[');
        		$remove_last_square = trim($entry_data['13'], ']');
        		// $remove_first_square = str_replace($entry_data['13'],'[', " ");
        		// $remove_last_square = str_replace($remove_first_square,']', " ");
        			$links = explode(',',$remove_last_square);
        			
        		?>
        		<div class="download_links">
        		<?php
        			foreach($links as $key => $link){
        				$linksy = trim($link,'[');
        				?>

        		<a class="view-more" traget="_blank" href='<?php echo esc_url($linksy);?>'>Download <?php echo $key+1;?></a>
        		<?php }	?>
        	</div>
</div>

<?php }?>
	
	


</div>
  <?php }?>
			</div>
		
		<div class="right-sidebar">
			<h2 class="white-heading">Ads</h2>
			<?php if ( is_active_sidebar( 'add_sidebar' ) ) { ?>
    <div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar( 'add_sidebar' ); ?>
		</div>
		<?php }?>
	</div>
<?php
}
else{?>
<script>
            window.location.href = "<?php echo home_url();?>/login";
        </script>
<?php } get_footer();?>



