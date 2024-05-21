<?php /* Template Name: Login */ ?>

<?php 
get_header();
if(is_user_logged_in()) {
	$user = wp_get_current_user();
    $roles = ( array ) $user->roles;    
if(in_array('warehouse',$roles) ){
	?>
 	<script>
            window.location.href = "<?php echo home_url();?>/my-profile";
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
if(!in_array('super_admin',$roles) && !in_array('administrator',$roles) && !in_array('warehouse',$roles)){
	?>
 	<script>
            window.location.href = "<?php echo home_url();?>";
        </script> 
	<?php

}
}
else{
	echo do_shortcode('[login_form]');
}
	
	get_footer();?>

