<?php
 global $wpdb;
 $args = [    
    'role__not_in' => ['administrator','subscriber','contributor','author','editor','super_admin'],
    'orderby' => 'nicename',
    'order' => 'ASC',
    'fields' => 'all',
];
$users = get_users($args);   
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="dashboar_container">
    <div class="viewmore_detail">
      <div id="notification" class="notice is-dismissible" style="display:none"></div>
  <?php 
  if($_GET['edit_user']){
  $data = get_userdata($_GET['edit_user']);
    $company_name = get_user_meta($_GET['edit_user'],'company',true);
  $phone_number = get_user_meta($_GET['edit_user'],'phone_number',true)
  ?>
      <div class="col-12 d-flex align-items-center justify-content-between mb-4 mt-3">
        <h2 class="blue-heading">Edit details</h2>
        <a class="btn btn-primary" href="<?php echo admin_url('admin.php?page=warehouse_customers');?>">Back</a>
      </div>
      <form method="post" id="edit_owner_form" name="edit_owner">
        <div class="bg-light p-4 row">
          <div class="col-12 col-md-6 my-3">
            <label>Name</label>
            <input type="text" name="owner_name" placeholder="Name" class="form-control" value="<?php echo $data->data->user_nicename;?>">
          </div>
          <div class="col-12 col-md-6 my-3">
             <label>Email</label>
            <input type="email" name="owner_email" placeholder="Email" class="form-control" value="<?php echo $data->data->user_email;?>">
          </div>
          <div class="col-12 col-md-6 my-3">
             <label>Company Name</label>
            <input type="text" name="owner_company_name"  class="form-control" value="<?php echo ($company_name?$company_name:'');?>">
          </div>
          <div class="col-12 col-md-6 my-3">
            <label>Phone Number</label>
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

	 <div class="d-flex">
      <h2 class="blue-heading">Warehouse Customer Listing</h2>
      
   </div>
  <div class="bg-white p-0 rounded listing_table mt-4 w-100 overflow-xscroll d-block">  
    <table id="warehouse_enter" class="">
      	<thead>
          	<tr>
          		<th>S no</th>
          		<th>Name</th>
          		<th>Company Name</th>
          		<th>Email</th>
          		<th>Phone</th>			
              <th>User Type</th>
               <th>Status</th>
              <th>Actions</th>
          	</tr>
         </thead>
        <tbody>
             <?php 
             $i = 1;
             foreach ( $users as $user ) {
             
              $role = '';
  $company_name = get_user_meta($user->ID,'company',true);
  $phone_number = get_user_meta($user->ID,'phone_number',true);
  
  if ($user->roles[0] == 'armember') {
$role = '3PL Warehouse';
} 
if ($user->roles[0] == 'warehouse') {
$role = '3PL Warehouse';
} 
if ($user->roles[0] == 'express_selivery_service') {
$role ='Express/local delivery service';
} 
if ($user->roles[0] == 'equipment_supplier') {
$role = 'Equipment Supplier';
} 
if ($user->roles[0] == 'ocean_railroad') {
$role = 'Ocean Line/ Railroad';
} 
if ($user->roles[0] == 'shipper') {
$role = 'Shipper';
} 
if ($user->roles[0] == 'motor_trucking') {
$role = 'Motor Trucking';
} 
if ($user->roles[0] == 'freight_broker') {
$role = 'Freight Forwarder/broker';
} 


?>
              <tr>
              	<td><?php echo $i++;?></td>
              
          <td><?php echo esc_html( $user->display_name );?></td>
          <td><?php echo ($company_name?$company_name:'');?></td>
          <td> <?php echo esc_html( $user->user_email );?></td>
          <td><?php echo ($phone_number?$phone_number:'');?></td>
              	<td><?php echo $role;?></td>
                <td class="status">
              <?php $status = get_user_meta($user->ID,'wp-approve-user',true);
              
              if($status == 1){ ?>
             <a class="mx-2 approved_user" href="javascript:void(0)" data-user_id="<?php echo $user->ID;?>">Approved</a>
              <?php }else{?>            
             <a class="mx-2 unapproved_user" href="javascript:void(0)" data-user_id="<?php echo $user->ID;?>">Unapproved</i></a>
            <?php }?>
           </td>
              <td class="edit">
              <?php if(in_array('blocked',$user->roles)){ ?>
             <a class="mx-2 unblock_user" href="javascript:void(0)" data-user_id="<?php echo $user->ID;?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>
              <?php }else{?>            
             <a class="mx-2 delete_user" href="javascript:void(0)" data-user_id="<?php echo $user->ID;?>"><i class="fa fa-ban" aria-hidden="true"></i></a>
            <?php }?>
          <a class="mx-2 " href="<?php echo admin_url('admin.php?page=warehouse_customers&edit_user=');?><?php echo $user->ID;?>"> <img src="https://staggingweb.com/logicore/wp-content/uploads/2023/05/edit_icon.png"></a>  </td>
              </tr>


              <?php    }
              ?>
        </tbody>
    </table>
  </div>  

    <?php }?>

</div>    
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
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
          jQuery('#warehouse_enter').load(document.URL + ' #warehouse_enter');
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
   jQuery(document).on('click', '.unblock_user', function(e){  
    event.preventDefault();
    var submit_button = jQuery(this);
    var data_user_id = jQuery(this).attr("data-user_id");
    console.log(data_user_id);
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data:{action:"unblock_user" ,user_id:data_user_id }, 
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
        jQuery("#notification").html("User is Unblock");  
        jQuery('#warehouse_enter').load(document.URL + ' #warehouse_enter');


      },
    });

  });

 jQuery(document).on('click', '.unapproved_user', function(e){  
    event.preventDefault();
    var submit_button = jQuery(this);
    var data_user_id = jQuery(this).attr("data-user_id");
    console.log(data_user_id);
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data:{action:"unapproved_user" ,user_id:data_user_id }, 
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
        jQuery("#notification").html("User is approved");  
        jQuery('#warehouse_enter').load(document.URL + ' #warehouse_enter');


      },
    });

  });
 jQuery(document).on('click', '.approved_user', function(e){  
    event.preventDefault();
    var submit_button = jQuery(this);
    var data_user_id = jQuery(this).attr("data-user_id");
    console.log(data_user_id);
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data:{action:"approved_user" ,user_id:data_user_id }, 
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
        jQuery("#notification").html("User is unapproved");  
        jQuery('#warehouse_enter').load(document.URL + ' #warehouse_enter');


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
        jQuery("#notification").html("User is Blocked");  
        jQuery('#warehouse_enter').load(document.URL + ' #warehouse_enter');


      },
    });

  });
         jQuery(document).ready(function () {
    jQuery('#warehouse_enter').DataTable({
      "order": [[ 0, "asc" ]],
        "pageLength" : 10,
    });
});
</script>