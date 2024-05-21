 <?php
 global $wpdb;
$data =  $wpdb->get_results( 'SELECT `arm_log_id` FROM wp_arm_payment_log where `arm_transaction_status` = "success"');


$args = [
       
    'post_type'      => 'warehouse',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    
];

?>

<?php $query = new WP_Query($args);?>

<div class="dashboar_container">
	<?php 
	if($_GET['edit_user']){
	$data = get_userdata($_GET['edit_user']);
		$company_name = get_user_meta($_GET['edit_user'],'company',true);
	$phone_number = get_user_meta($_GET['edit_user'],'phone_number',true)
	?>
		<div class="viewmore_detail">
			<div id="notification" class="notice is-dismissible" style="display:none"></div>
			<h2 class="blue-heading mb-4 mt-3">Edit details</h2>
			<form method="post" id="edit_owner_form" name="edit_owner">
				<div class="bg-light p-4 row">
					<div class="col-12 col-md-6 my-3">
						<input type="text" name="owner_name" placeholder="Name" class="form-control" value="<?php echo $data->data->user_nicename;?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<input type="email" name="owner_email" placeholder="Email" class="form-control" value="<?php echo $data->data->user_email;?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<input type="text" name="owner_company_name"  class="form-control" value="<?php echo ($company_name?$company_name:'');?>">
					</div>
					<div class="col-12 col-md-6 my-3">
						<input type="text" name="owner_phone" placeholder="9988998899" class="form-control" value="<?php echo ($phone_number?$phone_number:'');?>">
					</div>
					<div class="col-12 my-3">
						<input type="hidden" name="user_id" value="<?php echo $_GET['edit_user'];?>">
						  <input type="hidden" name="action" value="edit_owner" />
						<button class="btn btn-primary edit_owner_btn">Submit</button>
					</div>
				</div>
			</form>
		</div>

	<?php }

	else{?>




	<div class="row dashboard_topbox mt-0">
		<div class="col-12 col-sm-3">
			<div class="p-3 first text-center rounded">
				<a href="<?php echo admin_url();?>/admin.php?page=warehouse_payments">
				<img src="<?php echo home_url();?>/wp-content/uploads/2023/05/payment.png">				
				<h5 class="mb-2 mt-3 p-0 fw-bold">payments</h5>
				<h3><?php echo count($data);?></h3>
		</a>
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="p-3 two text-center rounded">
				<a href="<?php echo admin_url();?>/admin.php?page=warehouse_owner">
				<img src="<?php echo home_url();?>/wp-content/uploads/2023/05/owner.png">				
				<h5 class="mb-2 mt-3 p-0 fw-bold">Warehouse Users</h5>
				<h3><?php echo do_shortcode('[users_count_bro]');?></h3>
			</a>
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="p-3 three text-center rounded">
					<a href="<?php echo admin_url();?>/admin.php?page=warehouse_customers">
				<img src="<?php echo home_url();?>/wp-content/uploads/2023/05/user.png">				
				<h5 class="mb-2 mt-3 p-0 fw-bold">All User</h5>
				<h3><?php echo do_shortcode('[users_count_bro2]');?></h3>
				</a>
			</div>
		</div>
		<div class="col-12 col-sm-3">
			<div class="p-3 four text-center rounded">
			<a href="<?php echo admin_url();?>/admin.php?page=warehouse_listing">
				<img src="<?php echo home_url();?>/wp-content/uploads/2023/05/house.png">			
				<h5 class="mb-2 mt-3 p-0 fw-bold">Warehouses</h5>
				<h3><?php $count_posts = wp_count_posts( 'warehouse' )->publish;
				echo $count_posts;?></h3>
		</a>
			</div>
		</div>
	</div>
	<div class="bg-light p-4 rounded charts mt-5">
		<div class="row">
			<div class="col-12 col-md-8">
				<!-- <h4>Recent members</h4> -->
				<div class="bg-white rounded p-3 mt-5">
				<?php echo do_shortcode('[arm_chartRecentMembers]');?>
				</div>

			</div>	
			<div class="col-12 col-md-4">
				<h4>Current Graph</h4>
				<div class="bg-white rounded p-3 mt-3">
					<canvas id="myChart2"></canvas>
				</div>	
			</div>
		</div>
	</div>
	<div class="bg-light p-4 rounded charts_three mt-5">
		<div class="row">
			<div class="col-12">
				<div class="p-3 mt-3">
				 <?php echo do_shortcode('[arm_chartPlanMembers]');?>
				</div>
			</div>
		</div>
	</div>

<?php }?>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title blue-heading" id="exampleModalLabel">Add New Warehouse Owner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="viewmore_detail2">
       
               <div class="form_moredetail bg-light p-4">
       <!--    <form>
            <div class="row">
              <div class="col-12 col-md-6 my-3">
                 <input type="text" placeholder="Name" class="form-control">
              </div>
              <div class="col-12 col-md-6 my-3">
                 <input type="email" placeholder="Email" class="form-control">
              </div>
               <div class="col-12 my-3">
                 <input type="text" placeholder="Company Name" class="form-control">
              </div>
              <div class="col-12 col-md-6 my-3">
                 <input type="number" placeholder="Phone" class="form-control">
              </div>
            </div>    
          </form> -->
       <form id="pippin_registration_form" class="pippin_form row mx-0" action="" method="POST">
        <!-- <h3 class="pippin_header"><?php //_e('Register'); ?></h3> -->

        <div class="col-12 col-md-6 my-2">
            <input name="pippin_user_login" placeholder="Name" id="pippin_user_login" class="required" type="text" required/>
        </div>
        <div class="col-12 col-md-6 my-2">
            <input name="pippin_user_company" placeholder="Company"  id="pippin_user_company" type="text" required/>
        </div>
        <div class="col-12 col-md-6 my-2">
            <input name="pippin_user_email" placeholder="Email"  id="pippin_user_email" class="required" type="email" required/>
        </div>
        <div class="col-12 col-md-6 my-2">
            <input name="pippin_user_phone" placeholder="Phone Number"  id="pippin_user_phone" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required/>
        </div>
        
        <div class="col-12 col-md-4 my-2">
            <input name="pippin_user_state" placeholder="State"  id="pippin_user_state" type="text" required/>
        </div>
        <div class="col-12 col-md-4 my-2">
            <input name="pippin_user_city" placeholder="City"   id="pippin_user_city" type="text" required/>
        </div>
        <div class="col-12 col-md-4 my-2">
            <input name="pippin_user_zip" placeholder="Zip Code"  id="pippin_user_zip" type="text" minlength="5" maxlength="6" required/>
        </div>
        <div class="col-12 col-md-12 my-2">
            <input name="pippin_user_address" placeholder="Address"  id="pippin_user_address" class="required" type="text" required/>
        </div>
        <div class="col-12 col-md-6 my-2">
            <input name="pippin_user_pass" placeholder="Password"  id="password" class="required" type="password" required/>
        </div>
        <div class="col-12 col-md-6 my-2">
            <input name="pippin_user_pass_confirm" placeholder="Confirm Password"  id="password_again" class="required" type="password" required/>

        </div>
     		<input type="hidden" id="" name="user_role" value="warehouse" >
        <div id="pwdmessage" class="position-relative" style="display:none">
              <h6>Password must contain the following:</h6>
              <p id="letter" class="pwdinvalid">A <b>lowercase</b> letter</p>
              <p id="capital" class="pwdinvalid">A <b>capital (uppercase)</b> letter</p>
              <p id="number" class="pwdinvalid">A <b>number</b></p>
              <p id="length" class="pwdinvalid">Minimum <b>8 characters</b></p>
        </div>  
        <?php 
        pippin_show_error_messages(); ?>
        <div class="col-12">
        	<button class="custom-btn register_btn my-2">
            <input type="hidden" name="pippin_register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
            <img src="/logicore/wp-content/uploads/2023/05/login.png" alt="icon">
            <input type="submit" value="<?php _e('Register'); ?>"/>
        </button>
        </div>
        
    </form>
       </div>  
         
   	</div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

	 jQuery(document).on('submit', '#edit_owner_form', function(e){   
    event.preventDefault();   
   
      jQuery('.edit_owner_btn').attr("disabled", true);
      var formdata =    jQuery('#edit_owner_form' ).serialize();   
      jQuery.ajax({
        type:'POST',
        url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
        data:formdata, 
        beforeSend: function() {
          jQuery(".edit_owner_btn").addClass("disable_button");
        },        
        success: function(response){  
          jQuery('#warehouse_enteries').load(document.URL + ' #warehouse_enteries');
          jQuery(".edit_owner_btn").removeClass("disable_button");
          var dataresponse = JSON.parse(response);
          jQuery('html, body').animate({
            scrollTop: jQuery("#notification").offset().top
          }, 2000);
          jQuery("#notification").css("display","block");
          jQuery("#notification").addClass(dataresponse['owner']['status']);
          jQuery("#notification").html(dataresponse['owner']['msg']);  
          jQuery('.edit_owner_btn').attr("disabled", false);    
          //jQuery("#edit_owner_form")[0].reset();
           jQuery('.viewmore_detail').load(document.URL + ' .viewmore_detail');
          
         
        },
      });
   
  });


	 jQuery(document).on('click', '.delete_user', function(e){  
    event.preventDefault();
    var submit_button = jQuery(this);
    var data_user_id = jQuery(this).attr("data-user_id");
    console.log(data_user_id);
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data:{action:"delete_user" ,user_id:data_user_id }, 
      beforeSend:function(){
        submit_button.addClass("disable_button");
      },
      success: function(response){  
        var message = JSON.parse(response);
        //$(this).parent().parent().closest('div').addClass("selected");
        submit_button.removeClass("disable_button");
        jQuery('html, body').animate({
          scrollTop: jQuery("#notification").offset().top
        }, 2000);
        jQuery("#notification").css("display","block");
        jQuery("#notification").addClass("notice-success");
        jQuery("#notification").html("User Deleted");  
        jQuery('#warehouse_enteries').load(document.URL + ' #warehouse_enteries');


      },
    });

  });

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

// When the user clicks on the password field, show the message box
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
			$('input[type="submit"]').removeAttr('disabled');
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
			address: {
				required:true,
				striptagfields:true
			},
			
		} 
	});
 



  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['Paid Warehouse Owners', 'Free Warehouse Owners', 'Others'],
      datasets: [{
        label: '# of Users',
        data: [1, 2, 4],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


  const ctx3 = document.getElementById('myChart3');

  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  
</script>

