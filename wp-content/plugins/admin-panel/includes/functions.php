<?php
add_action("wp_ajax_delete_warehouse", "delete_warehouse_callback");
add_action("wp_ajax_nopriv_delete_warehouse", "delete_warehouse_callback");
function delete_warehouse_callback(){
    global $wpdb;

    $id = $_POST['warehouse_id'];
    wp_delete_post($id);
    echo json_encode("Warehouse deleted");
    die;
}



add_action("wp_ajax_unapproved_user", "unapproved_user_callback");
add_action("wp_ajax_nopriv_unapproved_user", "unapproved_user_callback");
function unapproved_user_callback(){
    global $wpdb;
$user_id = intval($_POST['user_id']);
update_user_meta($user_id,'wp-approve-user','1');
$user_info = get_userdata($user_id);

 $home_url = home_url();
    $html = 'Hi '.$user_info->user_login.',<br/><br/>';
     $html.= 'Your registration for Logicore now been approved.<br/><br/>';
    $html.= 'You can log in, using your username and password that you created when registering for our website, at the following URL:<br/><br/>';
     $html.= '<a href="'.$home_url.'/login">Login</a><br/><br/>';
     $html.= 'If you have any questions, or problems, then please do not hesitate to contact us.<br/><br/>';
     $html.= 'Logicoreapp <br/><br/>';
     $html.= '<a href='.$home_url.'> Logicoreapp.com</a>';

 
    // send an email out to user
    wp_mail( $user_info->user_email,'Registeration approved', $html,'Content-type: text/html');

  echo json_encode("This user is approved");

    die;
}

add_action("wp_ajax_approved_user", "approved_user_callback");
add_action("wp_ajax_nopriv_approved_user", "approved_user_callback");
function approved_user_callback(){
    global $wpdb;
$user_id = intval($_POST['user_id']);
$approve_user = update_user_meta($user_id,'wp-approve-user','');
  echo json_encode("This user is unapproved");

    die;
}

add_action("wp_ajax_warehouse_filter","warehouse_filter_callback");
add_action("wp_ajax_nopriv_warehouse_filter","warehouse_filter_callback");
function warehouse_filter_callback(){
    global $wpdb;
$args = [
    "post_type" => "warehouse",
    "post_status" => array('publish','draft'),
    "posts_per_page" => -1,
    "s"  => $_POST['input'],
];
$query = new WP_Query($args);
 if ($query->have_posts()) {
  $i = 1;
        while ($query->have_posts()):

            $query->the_post();
            $address = get_post_meta(
                get_the_ID(),
                "warehouse-address",
                true
            );
            $state = get_post_meta(get_the_ID(), "state", true);
            $city = get_post_meta(get_the_ID(), "city", true);
            $zipcode = get_post_meta(get_the_ID(), "zipcode", true);
            ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php the_ID(); ?></td>
          <td><?php the_title(); ?></td>
           <td><?php $author_id = get_post_field( 'post_author', get_the_ID() ); echo $author_id;?></td>
         <td><?php //echo $author_id;
          $theAuthorDataRoles = get_userdata($author_id);
          $theRolesAuthor = $theAuthorDataRoles -> roles;
         
          if(in_array('armember',$theRolesAuthor)){
            echo "Yes";
          }
          else{
            echo "No";
          }?></td>
          <td><?php echo $address .
              ($city ? "," . $city : "") .
              ($state ? "," . $state : "") .
              ($zipcode ? "," . $zipcode : ""); ?></td>
          <td class="edit"> <a class="mx-2 edit_warehouse"  href="<?php
          echo admin_url("admin.php?page=warehouse_listing&warehouse_id=");
          echo get_the_ID();
          ?>"  class="edit_warehouse"  data-warehouse_id="<?php echo get_the_ID(); ?>"><img src="<?php echo home_url();?>/wp-content/uploads/2023/05/edit_icon.png"></a>
                 <div class="form-check form-switch">
                      <input data-warehouse_id="<?php echo get_the_ID();?>" class="form-check-input"  type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo (get_post_status() == 'publish'?'checked':'');?> />
                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                    </div> 
                    
            <!-- <a href="javascript:void(0)"  class="delete_warehouse mx-2" data-warehouse_id="<?php //echo get_the_ID(); ?>"><img src="https://staggingweb.com/logicore/wp-content/uploads/2023/05/delete_icon.png"></a> </td> -->
        </tr>
      <?php
        endwhile;

    } 
    else{?>
 <div class="empty">No Warehouse found with your search criteria.</div>
<?php }


wp_reset_postdata();
?>
<script>
   jQuery('.form-check-input').on('change', function() {
      // alert(jQuery(this).attr("data-warehouse_id"));
        var warehouse_id = jQuery(this).attr("data-warehouse_id");
       
        if(jQuery(this).is(":checked")) {
             status = "publish";                      
        }
        else{
            status = "draft";
        }
    
       
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url("admin-ajax.php"); ?>',
      data:{action:"approve_warehouse" ,warehouse_id:warehouse_id, status:status }, 
      beforeSend:function(){},
      success: function(response){  
        var message = JSON.parse(response);
        jQuery('html, body').animate({
          scrollTop: jQuery("#notification").offset().top
        }, 2000);
        jQuery("#notification").css("display","block");
        jQuery("#notification").addClass("notice-success");
        if(status == "publish"){
        jQuery("#notification").html("Warehouse Approved");  
        }
        else{
            jQuery("#notification").html("Warehouse UnApproved");
        }
        //jQuery('#warehouse_enterie').load(document.URL + ' #warehouse_enterie');
      },
     });
               
  });

   // jQuery('#warehouse_enteries').DataTable({
   //  "searching": false,
   //      "order": [[ 0, "asc" ]],
   //      "pageLength" : 10,
   //  });


    </script>

<?php
    die;
}


add_action("wp_ajax_unblock_user", "unblock_user_callback");
add_action("wp_ajax_nopriv_unblock_user", "unblock_user_callback");
function unblock_user_callback(){
    global $wpdb;
$user_id = intval($_POST['user_id']);
$user_meta=get_userdata($user_id);
$user_roles=$user_meta->roles; 
$user = new WP_User($user_id); //123 is the user ID
$user->roles; // ["subscriber"]
$user->add_role('warehouse');
$user->remove_role('blocked');
$user->roles; // ["subscriber", "power_member"]
$args = array(
    'meta_key' => 'ware_house_email',
    'meta_value' => $user_meta->data->user_email,
    'post_type' => 'warehouse',
    'post_status'   => 'draft'
    
);
$posts = get_posts($args);
$status = 'publish';

foreach($posts as $post){
     wp_update_post(array(
        'ID'    =>  $post->ID,
        'post_status'   => $status,
        ));
     //echo $status;
}
 
 $to = $user_meta->data->user_email;
$subject = 'UnBlocked by admin.';
        $html = "You are Unblocked by admin.Now You can login in you dashboard";
        wp_mail( $to, $subject, $html ,'Content-type: text/html');   

    
  // if ( wp_delete_user( $user_id ) ) {
    echo json_encode("The user has been successfully deleted.");
//} else {
 //   echo json_encode("This user can't be deleted");
//}
    die;
}

add_action("wp_ajax_delete_user", "delete_user_callback");
add_action("wp_ajax_nopriv_delete_user", "delete_user_callback");
function delete_user_callback(){
    global $wpdb;
$user_id = intval($_POST['user_id']);
$user_meta=get_userdata($user_id);
$args = array(
    'meta_key' => 'ware_house_email',
    'meta_value' => $user_meta->data->user_email,
    'post_type' => 'warehouse',
    
);
$posts = get_posts($args); 
$user_roles=$user_meta->roles; 
$user = new WP_User($user_id); //123 is the user ID
$user->roles; // ["subscriber"]
 $user->remove_role('warehouse');
$user->add_role('blocked');
$user->roles; // ["subscriber", "power_member"]
foreach($posts as $post){
     wp_update_post(array(
        'ID'    =>  $post->ID,
        'post_status'   => 'draft'
        ));
}
$to = $user_meta->data->user_email;
$subject = 'Blocked by admin.';
        $html = "You are blocked by admin. Please contact for any queries";
        wp_mail( $to, $subject, $html ,'Content-type: text/html');    
 

    
  // if ( wp_delete_user( $user_id ) ) {
    echo json_encode("The user has been successfully deleted.");
//} else {
 //   echo json_encode("This user can't be deleted");
//}
    die;
}

add_action("wp_ajax_approve_warehouse", "approve_warehouse_callback");
add_action("wp_ajax_nopriv_approve_warehouse", "approve_warehouse_callback");
function approve_warehouse_callback(){
    global $wpdb;

    $id = $_POST['warehouse_id'];
    $status = $_POST['status'];
    
    wp_update_post(array(
        'ID'    =>  $id,
        'post_status'   => $status
        ));

   
    if($status="publish")
    {

    echo json_encode("Warehouse Approved");
}
else{
echo json_encode("Warehouse UnApproved");
}
    die;

}


add_action("wp_ajax_add_warehouse", "add_warehouse_callback");
add_action("wp_ajax_nopriv_add_warehouse", "add_warehouse_callback");

function add_warehouse_callback() {
   
      require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
    
 global $wpdb, $current_user; 

 if(!isset($_POST['warehouse_title']) || empty($_POST['warehouse_title'])){
    return;
}

      
$error = array();
$warehouse_title = $_POST['warehouse_title'];
$warehouse_description = ($_POST['warehouse_desc']?$_POST['warehouse_desc']:'');

 // $query = $wpdb->prepare(
 //        'SELECT ID FROM ' . $wpdb->posts . '
 //        WHERE post_title = %s
 //        AND post_type = \'warehouse\'',
 //        $warehouse_title
 //    );
 //    $wpdb->query( $query );

 //    if ( $wpdb->num_rows ) {
 //        $error['board']['status'] = 'Error';
 //    $error['board']['msg'] = $_POST['warehouse_title'].' warehouse is already exist';
       
 //    } else {
        $user_id  = $current_user->ID;
        $new_post = array(
            'post_title' => $warehouse_title,
            'post_content' => $warehouse_description,
            'post_status' => 'publish',
            'post_date' => date('Y-m-d H:i:s'),
            'post_author' => $user_id,
            'post_type' => 'warehouse',
            //'post_category' => array(0)
        );

 
        
        $post_id = wp_insert_post($new_post);
         $address = $_POST['Address'];
            $city = $_POST['City'];
            $state = $_POST['State'];
            $zipcode = $_POST['Zipcode'];
            $email_address = $_POST['email_address'];
            $phone_number = $_POST['phone_number'];
            $area = $_POST['area'];
            $parking_space = $_POST['parking_space'];
            $clear_height = $_POST['clear_height'];
            $dock_doors = $_POST['dock_doors'];
              $rail = ($_POST['rail']?$_POST['rail']:"NO");
            $website = $_POST['website'];
             $specialty_services = $_POST['spciality_services'];
           $capacity = $_POST['warehouse_capacity'];
            
          if ( isset( $_FILES['upload_file'] ) && !empty($_FILES['upload_file']['name'])) {
            
          
        $upload = wp_upload_bits( $_FILES["upload_file"]["name"], null, file_get_contents( $_FILES["upload_file"]["tmp_name"] ) );
 
        if ( ! $upload['error'] ) {
            $post_id = $post_id; //set post id to which you need to add featured image
            $filename = $upload['file'];
            $wp_filetype = wp_check_filetype( $filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name( $filename ),
                'post_content' => '',
                'post_status' => 'inherit'
            );
 
            $attachment_id = wp_insert_attachment( $attachment, $filename, $post_id );
            
          
 
            if ( ! is_wp_error( $attachment_id ) ) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
 
                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
                wp_update_attachment_metadata( $attachment_id, $attachment_data );
                set_post_thumbnail( $post_id, $attachment_id );
            }
        }
    }
    if ( isset( $_FILES['image'] ) && !empty($_FILES['image'])) {
        $files = $_FILES["image"];
            foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
            $file = array(
            'name' => $files['name'][$key],
            'type' => $files['type'][$key],
            'tmp_name' => $files['tmp_name'][$key],
            'error' => $files['error'][$key],
            'size' => $files['size'][$key]
            );
            $_FILES = array("upload_file" => $file);
            $attachment_id = media_handle_upload("upload_file", 0);
            $image_ids[] =  $attachment_id;
             }
         }
           if(isset($image_ids) && !empty($image_ids)){
            foreach($image_ids as $image_id){
                $gallery_data['image_url'][] = wp_get_attachment_image_url($image_id,'full');
    
            }       
           update_post_meta( $post_id, 'gallery_data', $gallery_data );    
           }
        }
        $full_address =$address.','.$city.','.$state.','.$zipcode; // Google HQ
            
  $prepAddr = str_replace(' ','+',$full_address);
  $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
  $output= json_decode($geocode);
  
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;

                update_post_meta($post_id,'_city','field_6476ee1cc3336');
                update_post_meta($post_id,'_meta_title','field_6495664da7f9a');
                update_post_meta($post_id,'_location','field_645a1b13d4ad4');
                update_post_meta($post_id,'_warehouse-address','field_649282e5b8dcf');
                update_post_meta($post_id,'_address','field_645a1a3334091');
                update_post_meta($post_id,'_state','field_646c9eb180784');
                update_post_meta($post_id,'_zipcode','field_646c9eb880785');
                update_post_meta($post_id,' _ware_house_email','field_6465bf2a63fef');
                update_post_meta($post_id,'_phone_number','field_6465bf3c63ff0');
                update_post_meta($post_id,'_area','field_6465bf7863ff1');
                update_post_meta($post_id,'_miles','field_645c8c50d2bd9');
                update_post_meta($post_id,'_parking_space','field_646c9e9f80783');
                update_post_meta($post_id,'_clear_height','field_646c9f0a9bf3d');
                update_post_meta($post_id,'_dock_doors','field_646c9f239bf3e');
                update_post_meta($post_id,'_rail','field_646c9f3a9bf3f');
                update_post_meta($post_id,'_website','field_646c9f489bf40');
                update_post_meta($post_id,'_specialty_services','field_648bf41f284cf');
                update_post_meta($post_id,'_warehouse_capacity','field_648fee64270e6');
                update_post_meta($post_id,'_longitude','field_6492ad994660b');
                update_post_meta($post_id,'_latitude','field_6492ada44660c');
                update_post_meta($post_id,'miles','200');
                update_post_meta($post_id,'address','');
                update_post_meta($post_id,'location','');               

                update_post_meta($post_id,'warehouse-address',$address);
                update_post_meta($post_id,'city',$city);
                update_post_meta($post_id,'meta_title',$warehouse_title);
                update_post_meta($post_id,'state',$state);
                update_post_meta($post_id,'zipcode',$zipcode);
                update_post_meta($post_id,'ware_house_email',$email_address);  
                update_post_meta($post_id,'phone_number',$phone_number);
                update_post_meta($post_id,'area',$area); 
                update_post_meta($post_id,'parking_space',$parking_space);
                update_post_meta($post_id,'clear_height',$clear_height);
                update_post_meta($post_id,'dock_doors',$dock_doors);
                update_post_meta($post_id,'rail',$rail);
                update_post_meta($post_id,'website',$website);
                update_post_meta($post_id,'specialty_services',$specialty_services);
                update_post_meta($post_id,'warehouse_capacity',$capacity); 
                update_post_meta($post_id,'longitude',$longitude);
                  update_post_meta($post_id,'latitude',$latitude);
                wp_set_post_terms($post_id, $_POST['services'], 'services');
                wp_set_post_terms($post_id, $_POST['warehouse_commodity'], 'commodity');
                wp_set_post_terms($post_id, $_POST['warehouse_certification'], 'certification');
                wp_set_post_terms($post_id, $_POST['warehouse_additional_services'], 'additional_service');
              //  wp_set_post_terms($post_id, $_POST['warehouse_area'], 'area');
                
    
    if($post_id){
        $error['board']['status'] = 'Success';
        $error['board']['msg'] = 'warehouse is created.';
        
    }else{
        $error['board']['status'] = 'Error';
        $error['board']['msg'] = 'Unable to create board.';
    }
//}
echo json_encode($error);
die;
}




add_action("wp_ajax_edit_owner", "edit_owner_callback");
add_action("wp_ajax_nopriv_edit_owner", "edit_owner_callback");

function edit_owner_callback() {
    
 global $wpdb; 
$error = array();
if(isset($_POST['owner_name']))
wp_update_user(
    ['ID' => $_POST['user_id'], 'display_name' => $_POST['owner_name']] 
);
if(isset($_POST['owner_email']))
wp_update_user(
    ['ID' => $_POST['user_id'], 'user_email' => $_POST['owner_email']] 
);
if(isset($_POST['owner_company_name']))
update_user_meta($_POST['user_id'], 'company' , $_POST['owner_company_name']);
if(isset($_POST['owner_phone']))
update_user_meta($_POST['user_id'], 'phone_number' , $_POST['owner_phone']);

    // if($post_id){
         $error['owner']['status'] = 'notice-success';
         $error['owner']['msg'] = 'Owner updated Successfully.';
        
    // }else{
    //     $error['owner']['status'] = 'notice-error';
    //     $error['owner']['msg'] = 'Unable to edit owner.';
    // }

echo json_encode($error);
die;
}


add_action("wp_ajax_Update_Warehouse", "update_warehouse_callback");
add_action("wp_ajax_nopriv_Update_Warehouse", "update_warehouse_callback");

function update_warehouse_callback() {
 global $wpdb, $current_user;    
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
    

 if(!isset($_POST['warehouse_title']) || empty($_POST['warehouse_title'])){
    return;
}
$error = array();


$warehouse_title = $_POST['warehouse_title'];
$warehouse_description = ($_POST['warehouse_desc']?$_POST['warehouse_desc']:'');
$author_id = get_post_field( 'post_author',  $_POST['warehouse_id'] );
$status = get_post_status($_POST['warehouse_id']);


        $user_id  = $current_user->ID;
        $new_post = array(
            'ID' => $_POST['warehouse_id'],
            'post_title' => $warehouse_title,
            'post_content' => $warehouse_description,
            'post_status' => $status,
            'post_date' => date('Y-m-d H:i:s'),
            'post_author' => $author_id,
            'post_type' => 'warehouse',
            //'post_category' => array(0)
        );

        $post_id = wp_update_post($new_post);
        
        $post_id = $_POST['warehouse_id'];
         $address = $_POST['Address'];
            $city = $_POST['City'];
            $state = $_POST['State'];
            $zipcode = $_POST['Zipcode'];
            $email_address = $_POST['email_address'];
            $phone_number = $_POST['phone_number'];
            $area = $_POST['area'];
            $parking_space = $_POST['parking_space'];
            $clear_height = $_POST['clear_height'];
            $dock_doors = $_POST['dock_doors'];
             $rail = ($_POST['rail']?$_POST['rail']:"NO");
            $website = $_POST['website'];
            $specialty_services = $_POST['spciality_services'];
           $capacity = $_POST['warehouse_capacity'];
            
          if ( isset( $_FILES['upload_file'] ) && !empty($_FILES['upload_file']['name'])) {          
          
        $upload = wp_upload_bits( $_FILES["upload_file"]["name"], null, file_get_contents( $_FILES["upload_file"]["tmp_name"] ) );
 
        if ( ! $upload['error'] ) {
            $post_id = $post_id; //set post id to which you need to add featured image
            $filename = $upload['file'];
            $wp_filetype = wp_check_filetype( $filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name( $filename ),
                //'post_content' => '',
                'post_status' => 'inherit'
            ); 
            $attachment_id = wp_insert_attachment( $attachment, $filename, $post_id );        
           if ( ! is_wp_error( $attachment_id ) ) {
                require_once(ABSPATH . 'wp-admin/includes/image.php'); 
                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
                wp_update_attachment_metadata( $attachment_id, $attachment_data );
                set_post_thumbnail( $post_id, $attachment_id );
            }
        }
    }     


     if ( isset( $_FILES['image'] ) && !empty($_FILES['image'])) {
    $files = $_FILES["image"];
        foreach ($files['name'] as $key => $value) {
        if ($files['name'][$key]) {
        $file = array(
        'name' => $files['name'][$key],
        'type' => $files['type'][$key],
        'tmp_name' => $files['tmp_name'][$key],
        'error' => $files['error'][$key],
        'size' => $files['size'][$key]
        );
       $_FILES = array("upload_file" => $file);
        $attachment_id = media_handle_upload("upload_file", 0);
       $image_ids[] =  $attachment_id;
       
        }
        }
     
       if(isset($image_ids) && !empty($image_ids)){
        foreach($image_ids as $image_id){
            $gallery_data['image_url'][] = wp_get_attachment_image_url($image_id,'full');

        }        

       }
    }


      if(isset($_POST['saved_images']) && !empty($_POST['saved_images'])){
       
        $images_data = explode(',',$_POST['saved_images']);        
        if(isset($gallery_data['image_url']) && !empty($gallery_data['image_url'])){
           $gallery_data['image_url'] =  array_merge($gallery_data['image_url'],$images_data);    
             
        }
        else{
            

            foreach($images_data as $image_data){

            $gallery_data['image_url'][] =  $image_data; 
            }
        }        
    }


 if($gallery_data){
    
        update_post_meta( $post_id, 'gallery_data', $gallery_data );
}
else{
     delete_post_meta( $post_id, 'gallery_data' );

}
 $full_address =$address.','.$city.','.$state.','.$zipcode; // Google HQ
            
  $prepAddr = str_replace(' ','+',$full_address);
  $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
  $output= json_decode($geocode);
  
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;
   
                  update_post_meta($post_id,'_city','field_6476ee1cc3336');
                  update_post_meta($post_id,'_meta_title','field_6495664da7f9a');
//}
                update_post_meta($post_id,'_location','field_645a1b13d4ad4');
                update_post_meta($post_id,'_warehouse-address','field_649282e5b8dcf');
                update_post_meta($post_id,'_address','field_645a1a3334091');
                update_post_meta($post_id,'_state','field_646c9eb180784');
                update_post_meta($post_id,'_zipcode','field_646c9eb880785');
                update_post_meta($post_id,' _ware_house_email','field_6465bf2a63fef');
                update_post_meta($post_id,'_phone_number','field_6465bf3c63ff0');
                update_post_meta($post_id,'_area','field_6465bf7863ff1');
                update_post_meta($post_id,'_miles','field_645c8c50d2bd9');
                update_post_meta($post_id,'_parking_space','field_646c9e9f80783');
                update_post_meta($post_id,'_clear_height','field_646c9f0a9bf3d');
                update_post_meta($post_id,'_dock_doors','field_646c9f239bf3e');
                 update_post_meta($post_id,'_rail','field_646c9f3a9bf3f');
                  update_post_meta($post_id,'_website','field_646c9f489bf40');
                  update_post_meta($post_id,'_specialty_services','field_648bf41f284cf');
                  update_post_meta($post_id,'_warehouse_capacity','field_648fee64270e6');
                   update_post_meta($post_id,'_longitude','field_6492ad994660b');
                  update_post_meta($post_id,'_latitude','field_6492ada44660c');
                  update_post_meta($post_id,'miles','200');
                   update_post_meta($post_id,'address','');
                  update_post_meta($post_id,'location','');

                

                update_post_meta($post_id,'warehouse-address',$address);
                update_post_meta($post_id,'city',$city);
                 update_post_meta($post_id,'meta_title',$warehouse_title);
                update_post_meta($post_id,'state',$state);
                update_post_meta($post_id,'zipcode',$zipcode);
                update_post_meta($post_id,'ware_house_email',$email_address);  
                update_post_meta($post_id,'phone_number',$phone_number);
                update_post_meta($post_id,'area',$area); 
                update_post_meta($post_id,'parking_space',$parking_space);
                update_post_meta($post_id,'clear_height',$clear_height);
                update_post_meta($post_id,'dock_doors',$dock_doors);
                update_post_meta($post_id,'rail',$rail);
                update_post_meta($post_id,'website',$website);
                update_post_meta($post_id,'specialty_services',$specialty_services);
                update_post_meta($post_id,'warehouse_capacity',$capacity); 
                update_post_meta($post_id,'longitude',$longitude);
                  update_post_meta($post_id,'latitude',$latitude);
               wp_set_post_terms($post_id, $_POST['services'], 'services');
                wp_set_post_terms($post_id, $_POST['warehouse_commodity'], 'commodity');
                wp_set_post_terms($post_id, $_POST['warehouse_certification'], 'certification');
                wp_set_post_terms($post_id, $_POST['warehouse_additional_services'], 'additional_service');
              //  wp_set_post_terms($post_id, $_POST['warehouse_area'], 'area');
                
                
                
    
    if($post_id){
        $error['board']['status'] = 'Success';
        $error['board']['msg'] = 'warehouse is Updated.';
    }else{
        $error['board']['status'] = 'Error';
        $error['board']['msg'] = 'Unable to update board.';
    }
   

echo json_encode($error);
die;
}
function arm_chartPlanMembers($all_plans = array()) {

    global $wpdb, $ARMember, $arm_global_settings, $arm_subscription_plans;

    $plans_info = $wpdb->get_results("SELECT `arm_subscription_plan_id` as id, `arm_subscription_plan_name` as name FROM `" . $ARMember->tbl_arm_subscription_plans . "` WHERE `arm_subscription_plan_is_delete`='0' AND `arm_subscription_plan_post_id`='0'");



    if (!empty($plans_info)) {

        $plan_name = $plan_users = "[";

        $plan_name  .= "' ', ";

        $plan_users .= "0, ";

        foreach ($plans_info as $plan) {

            $user_arg = array(

                'meta_key'     => 'arm_user_plan_ids',

                'meta_value'   => '',

                'meta_compare' => '!=',

                'role__not_in' => array('administrator'),

                'date_query'   => array(

                    'after'    => '1 month ago',

                )

            );

            $users = get_users($user_arg);

            $total_users = 0;

            if (!empty($users)) {

                foreach ($users as $user) {

                    $plan_ids = get_user_meta($user->ID, 'arm_user_plan_ids', true);

                    if (!empty($plan_ids) && is_array($plan_ids)) {

                        if (in_array($plan->id, $plan_ids)) {

                            $total_users++;

                        }

                    }

                }

            }



            if ($total_users > 0) {

                $plan_name  .= "'".$plan->name."', ";

                $plan_users .= "{$total_users}, ";

            }

        }

        $plan_name  .= "]";

        $plan_users .= "]";

        if (!empty($plan_name) && !empty($plan_users)) { ?>

            <div id="arm_chart_wrapper_plan_members" class="arm_chart_wrapper_plan_members arm_chart_wrapper"></div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/11.0.1/highcharts.min.js"></script>
            <script type="text/javascript">

                jQuery(document).ready(function ($) {

                    var plan_users = <?php echo $plan_users; ?>;

                    var plan_names = <?php echo $plan_name; ?>;

                    jQuery('#arm_chart_wrapper_plan_members').highcharts({

                        chart: {type: 'areaspline'},

                        title: {text: "<?php echo __('Recent Members By Plans', 'ARMember');?>"},

                        credits : {

                            enabled : false

                        },

                        xAxis: {

                            categories: plan_names,

                            crosshair: true,

            labels: {rotation: - 60},

                            min : 0.5

                        },

                        yAxis: {

                            min: 0,

                            allowDecimals: false,

                            title: {text: 'Members'}

                        },

                        legend: {enabled: false},

                        plotOptions: {

                            areaspline: {

                                fillOpacity: 0.05,

                                dataLabels: {enabled: false, format: '{point.y}'},

                                lineColor: '#005aee',

                            }

                        },

                        tooltip: {

                            formatter: function() {

                                var tooltip = "";

                                var index = this.point.index;

                                var name  = plan_names[index];

                                if (index == 0) {

                                    name = '0';

                                }

                                tooltip   = '<span style="font-size:12px">' + name + ':</span>';

                                tooltip   += '<div style="color:' + this.series.color + '">(</div><b>' + this.y + '</b><div style="color:' + this.series.color + '">)</div>';

                                return tooltip;

                            }

                        },

                        colors: ['#766ed2;', '#fbc32b', '#fc6458', '#a7db1b', '#20d381', '#005aee', '#4da4fe'],

                        series: [{

                            name: "Membership",

                            color: 'rgb(0,90,238)',

                            colorByPoint: true,

                            lineWidth: 2,

                            data: plan_users,

                        }],

                    });

                });

            </script>

            <?php

        }

    }

}

add_shortcode('arm_chartPlanMembers','arm_chartPlanMembers');

function arm_chartRecentMembers() {

    global $wpdb, $ARMember, $arm_global_settings, $arm_subscription_plans;

    $user_table = $wpdb->users;

    $usermeta_table = $wpdb->usermeta;

    $capability_column = $wpdb->get_blog_prefix($GLOBALS['blog_id']) . 'capabilities';



    $super_admin_ids = array();

    if (is_multisite()) {

        $super_admin = get_super_admins();

        if (!empty($super_admin)) {

            foreach ($super_admin as $skey => $sadmin) {

                if ($sadmin != '') {

                    $user_obj = get_user_by('login', $sadmin);

                    if ($user_obj->ID != '') {

                        $super_admin_ids[] = $user_obj->ID;

                    }

                }

            }

        }

    }



    $user_where = " WHERE 1=1";

    if (!empty($super_admin_ids)) {

        $user_where .= " AND u.ID NOT IN (" . implode(',', $super_admin_ids) . ")";

    }



    $operator = " AND ";



    $user_where .= " {$operator} um.meta_key = '{$capability_column}' AND um.meta_value NOT LIKE '%administrator%' ";



    $user_where .= " AND u.user_registered >= DATE_SUB(DATE(NOW()), INTERVAL 1 MONTH)";



    $users_details = $wpdb->get_results("SELECT u.ID,u.user_registered FROM `{$user_table}` u LEFT JOIN `{$usermeta_table}` um ON u.ID = um.user_id {$user_where} GROUP BY u.ID ORDER BY u.user_registered ASC");



    $day_records = array();

    foreach ($users_details as $users_det) {

        $users_registered = date('d-M', strtotime($users_det->user_registered));

        $day_records[$users_registered][] = $users_det;

    }



    if (!empty($day_records)) {

        for ($i = 0; $i <=31; $i++) {

            $date = date('d-M', strtotime("-{$i} days"));;

            $keys[$date] = $date;

        }

        $keys = array_reverse($keys);

        $disCnt = 0;

        $day_var = $val_var = $custom_key = "[";

        foreach ($keys as $day) {

            $custom_key .= "'{$day}', ";

            if (!array_key_exists($day, $day_records)) {

                if ($disCnt == 0) {

                    $disCnt++;

                    $day_var .= "'{$day}', ";

                    $val_var .= '0, ';

                } else {

                    $disCnt = 0;

                    $day_var .= "' ', ";

                    $val_var .= '0, ';

                }

            } else {

                $total_users = count($day_records[$day]);

                if ($disCnt == 0) {

                    $disCnt++;

                    $day_var .= "'{$day}', ";

                    $val_var .= $total_users. ', ';

                } else {

                    $disCnt = 0;

                    $day_var .= "' ', ";

                    $val_var .= $total_users. ', ';

                }

            }

        }

        $day_var .= "]";

        $val_var .= ']';

        $custom_key .= ']';

        unset($disCnt); ?>

        <div id="arm_chart_wrapper_recent_members" class="arm_chart_wrapper_recent_members arm_chart_wrapper"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/11.0.1/highcharts.min.js"></script>
        <script type="text/javascript">

            jQuery(document).ready(function ($) {

                var line1 = <?php echo $val_var; ?>;

                var line2 = <?php echo $custom_key; ?>;

                jQuery('#arm_chart_wrapper_recent_members').highcharts({

                    chart: {type: 'areaspline'},

                    title: {text: "<?php echo __('Recent Members', 'ARMember');?>"},

                    xAxis: {

                        categories: <?php echo $day_var; ?>,

                        crosshair: true

                    },

                    credits : {

                        enabled : false

                    },

                    yAxis: {

                        min: 0,

                        allowDecimals: false,

                        title: {text: 'Members'}

                    },

                    legend: {enabled: false},

                    plotOptions: {

                        areaspline: {

                            fillOpacity: 0.05,

                            dataLabels: {enabled: false, format: '{point.y}'},

                            lineColor: '#005aee',

                        }

                    },

                    tooltip: {

                        formatter: function() {

                            var tooltip = "";

                            var index = this.point.index;

                            var name  = line2[index];

                            tooltip   = '<span style="font-size:12px"></span>';

                            tooltip   += '<div style="color:' + this.series.color + '">' + name + ': <b>' + this.y + '</b> <?php _e("Members", 'ARMember'); ?></div>';

                            return tooltip;

                        }

                    },

                    colors: ['#766ed2;', '#fbc32b', '#fc6458', '#a7db1b', '#20d381', '#005aee', '#4da4fe'],

                    series: [{

                        name: "Members",

                        color: 'rgb(0,90,238)',

                        colorByPoint: true,

                        lineWidth: 2,

                        data: line1,

                    }],

                });

            });

        </script>

        <?php

    }

}

add_shortcode('arm_chartRecentMembers','arm_chartRecentMembers');


?>
