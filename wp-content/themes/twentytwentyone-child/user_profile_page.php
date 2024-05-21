<?php /* Template Name: User Pages */ ?>
<?php get_header();
global $wpdb;
if(is_user_logged_in()) {
	$user = wp_get_current_user();
  // $user_id = get_current_user_id();
  //     $userEmail = wp_get_current_user()->user_email;
     // $userplan = wp_get_current_user()->arm_user_plan_ids;
    //echo $userEmail;
 
    $roles = ( array ) $user->roles;
    // echo "<pre>";
    // print_r($roles);
    
if(in_array('warehouse',$roles) ){
	?>
 	<script>
            window.location.href = "<?php echo home_url();?>/my-profile";
        </script> 
	<?php
}

if(in_array('blocked',$roles) ){
	?>
 	<script>
            window.location.href = "<?php echo home_url();?>";
        </script> 
	<?php
}
if(in_array('super_admin',$roles) || in_array('administrator',$roles)){
	?>
 	<script>
            window.location.href = "<?php echo admin_url();?>/profile.php";
        </script> 
	<?php
}
	?>


<div class="main-content">
	<div class="content-inner">
		<div id = "" class="left-sidebar" >
			<!-- <p>Filter</p> -->
			<div class="left-inner">
			<div class="user-profile">
				<h4 class="filter_titles active">User Pages</h4>
				<div class="checkbox-list open">
				
				<div class="checkbox-btn dynamic-target">
					<span id="user_prof" class="active">User Profile</span>
					<span class="user_post" >Post warehouse Need</span>
					<span class="post_history" >My post history</span>
				</div>
				
		</div>
		</div>
	</div>
</div>
		<div class="middel-content" >
			<div class="profile-content dynamic-id">

				
				<?php $userdata = wp_get_current_user();
				if(isset($_GET['user_id']) && !empty($_GET['user_id']) && $userdata->ID == $_GET['user_id']){
						$data = get_userdata($_GET['user_id']);
						
				$company_name = get_user_meta($_GET['user_id'],'company',true);
			$phone_number = get_user_meta($_GET['user_id'],'phone_number',true);
			$address = get_user_meta($_GET['user_id'],'address',true);
			$city = get_user_meta($_GET['user_id'],'city',true);
			$state = get_user_meta($_GET['user_id'],'state',true);
			$zipcode = get_user_meta($_GET['user_id'],'zipcode',true);
			?>
		
			<a class="back btn-primary btn" href="<?php echo home_url();?>/user-profile">Back</a>
			<div id="notification" class="notice is-dismissible" style="display:none"></div>
			<h2 class="blue-heading mb-4 mt-3">Edit details</h2>
			<form method="post" id="edit_owner_form" name="edit_owner">
				<div class="bg-light p-4 row rounded">
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
						<input type="hidden" name="user_id" value="<?php echo $_GET['user_id'];?>">
						  <input type="hidden" name="action" value="edit_user" />
						<button class="btn btn-primary edit_owner_btn">Submit</button>
					</div>
				</div>
			</form>
					
				<?php }else{?>
					<a class=" btn btn-primary"  href="<?php echo home_url('user-profile?user_id=');?><?php echo $userdata->ID;?>">Update My Profile</a>
				<div class="user_promain">
					 <img alt="profile" src="/wp-content/uploads/2023/05/profile-img.png">
					 <div class="profile_details">
					 	<h3 class="blue-heading"><?php echo $userdata->user_nicename;?> </h3>
						<p><strong> Company Name: </strong> <?php echo get_user_meta($userdata->ID,'company',true);?> </p>
						<p><strong> Phone: </strong> <?php echo get_user_meta($userdata->ID,'phone_number',true);?> </p>
						<p><strong> Email Address: </strong><?php echo $userdata->user_email;?></p>
						<p><strong> Address: </strong><?php echo get_user_meta($userdata->ID,'address',true);?>,<?php echo get_user_meta($userdata->ID,'city',true);?>,<?php echo get_user_meta($userdata->ID,'state',true);?>,<?php echo get_user_meta($userdata->ID,'zipcode',true);?></p>
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
   $result1 = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}gf_entry WHERE `form_id` = '2' AND `created_by` = '".$user_id."' ORDER BY `id` DESC" );
  
   

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
			<p class="w-100 mb-0"><strong>Subject: </strong><?php echo $entry_data['15'];?> </p>
        	<p class="w-100 mb-0"><strong>City: </strong><?php echo $entry_data['1'];?> </p>
        	<p class="w-100 mb-0"><strong>State: </strong> <?php echo $entry_data['3'];?></p>
        	<p class="w-100 mb-0"><strong>Estimate Time Arrival: </strong> <?php echo $entry_data['5'];?></p>
        	<p class="w-100 mb-0"><strong>Equipment Size: </strong><?php echo $entry_data['7'];?> </p>
        	<p class="w-100 mb-0"><strong>Load Method: </strong>  <?php echo$entry_data['14'];?></p>
        	<p class="w-100 mb-0"><strong>Shipping From: </strong> <?php echo $entry_data['10'];?></p>
        	<p class="w-100 mb-0"><strong>Deliver to: </strong><?php echo $entry_data['11'];?> </p>
        	<p class="w-100 mb-0 discruption"><strong class="d-block">Description: </strong><span><?php echo $entry_data['12'];?></span></p>
        	<p class="w-100 mb-0"><strong>Attached File: </strong></p>
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
        				$myFile = pathinfo($linksy);
        				$basename = $myFile["basename"];
        				$name = str_replace('"', " ", $basename);

        				?>

        		<a class="view-more mb-3 d-block px-3" traget="_blank" href='<?php echo esc_url($linksy);?>'><?php echo $name;?> </a>

        		<?php 
        	 // Path of the file stored under pathinfo
 // $myFile = pathinfo($linksy);
  
  // Show the file name
 // echo $myFile['basename'], "\n";
}	?>
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



	<script>
		gform.addFilter( 'gform_datepicker_options_pre_init', function( optionsObj, formId, fieldId ) {
    // Apply to field 2 only 
    if ( fieldId == 5 ) {
        optionsObj.minDate = '+1d';
    }
    return optionsObj;
});

	</script>