<?php /* Template Name: Post History*/ ?>
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
					<span>User Profile</span>
					<span>Post warehouse Need</span>
					<span class="active">My post history</span>
				</div>
				
		</div>
		</div>
	</div>
</div>
		<div class="middel-content" >
			<div class="profile-content dynamic-id">
				
				<?php $userdata = wp_get_current_user();?>
				<span> <img alt="profile" src="/wp-content/uploads/2023/05/profile-img.png"> </span>
				<h2 class="blue-heading"><?php echo $userdata->user_nicename;?> </h2>
				<p><strong> Company Name: </strong> <?php echo get_user_meta($userdata->ID,'company',true);?> </p>
				
				<p><strong> Phone: </strong> <?php echo get_user_meta($userdata->ID,'phone_number',true);?> </p>
				
				<p><strong> Email Address: </strong><?php echo $userdata->user_email;?></p>
					
				<p><strong> Address: </strong><?php echo get_user_meta($userdata->ID,'address',true);?>,<?php echo get_user_meta($userdata->ID,'city',true);?>,<?php echo get_user_meta($userdata->ID,'state',true);?>,<?php echo get_user_meta($userdata->ID,'zipcode',true);?></p>
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
	<script>
		gform.addFilter( 'gform_datepicker_options_pre_init', function( optionsObj, formId, fieldId ) {
    // Apply to field 2 only 
    if ( fieldId == 5 ) {
        optionsObj.minDate = '+1d';
    }
    return optionsObj;
});

	</script>


