    <?php /* Template Name: Register */ ?>
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
	echo do_shortcode('[register_form]');
}
	
	get_footer();?>

<script>
	var myInput = document.getElementById("password");
	var letter = document.getElementById("letter");
	var capital = document.getElementById("capital");
	var number = document.getElementById("number");
	var length = document.getElementById("length");
jQuery.validator.addMethod("striptagfields", function(value, element, param) {
		var reg =/<(.|\n)*?>/g; 
		//var reg1 = /<\/?[^>]+(>|$)/g
		if (reg.test(value) == false) {
			return true;
		} else {
			return false;
		};
	});


	myInput.onfocus = function() {
		validatePassword()
	}

	
	
	// When the user starts to type something inside the password field
	myInput.onkeyup = function() {
		// Validate lowercase letters
		validatePassword()	
		
	}
function validatePassword(){
		var ispwdValid = false
		var lowerCaseLetters = /[a-z]/g;
		if(myInput.value.match(lowerCaseLetters)) {  
			letter.classList.remove("pwdinvalid");
			letter.classList.add("pwdvalid");
			ispwdValid = true
		} else {
			letter.classList.remove("pwdvalid");
			letter.classList.add("pwdinvalid");
			ispwdValid = false
		}
		
		// Validate capital letters
		var upperCaseLetters = /[A-Z]/g;
		if(myInput.value.match(upperCaseLetters)) {  
			capital.classList.remove("pwdinvalid");
			capital.classList.add("pwdvalid");
			ispwdValid = true
		} else {
			capital.classList.remove("pwdvalid");
			capital.classList.add("pwdinvalid");
			ispwdValid = false
		}

		// Validate numbers
		var numbers = /[0-9]/g;
		if(myInput.value.match(numbers)) {  
			number.classList.remove("pwdinvalid");
			number.classList.add("pwdvalid");
			ispwdValid = true
		} else {
			number.classList.remove("pwdvalid");
			number.classList.add("pwdinvalid");
			ispwdValid = false
		}
		
		if(myInput.value.length >= 8) {
			length.classList.remove("pwdinvalid");
			length.classList.add("pwdvalid");
			ispwdValid = true
		} else {
			length.classList.remove("pwdvalid");
			length.classList.add("pwdinvalid");
			ispwdValid = false
		}	
		if(ispwdValid){
			document.getElementById("pwdmessage").style.display = "none";
			jQuery('input[type="submit"]').removeAttr('disabled');
			reset('isPhoneValid')
		}else{
			jQuery('input[type="submit"]').attr('disabled','disabled');
			document.getElementById("pwdmessage").style.display = "block";
		}
	}	

	jQuery("#pippin_registration_form" ).validate({
		rules: {
			name: {
				required:true,
				striptagfields:true,
				minlength: 3,
				maxlength: 250
			},
			email:{required:true,striptagfields:true,email:true},
			contact:{required:true,striptagfields:true},
			password:{required:true, striptagfields:true},
			pippin_user_pass_confirm: {equalTo: "#password"},
			address: {
				required:true,
				striptagfields:true
			},
			
		} 
	});
</script>