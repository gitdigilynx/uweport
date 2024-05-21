<?php /* Template Name: ownerlisting */ ?>
<?php get_header();
global $wpdb,$current_user;  
//    ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 
	    $user = wp_get_current_user();
  $user_id = get_current_user_id();
      $userEmail = wp_get_current_user()->user_email;
      $userplan = wp_get_current_user()->arm_user_plan_ids;
    //echo $userEmail;

 
    $roles = ( array ) $user->roles;
 $us_state_abbrevs_names = array(
   'AL'=>'ALABAMA',
    'AK'=>'ALASKA',
    'AS'=>'AMERICAN SAMOA',
    'AZ'=>'ARIZONA',
    'AR'=>'ARKANSAS',
    'CA'=>'CALIFORNIA',
    'CO'=>'COLORADO',
    'CT'=>'CONNECTICUT',
    'DE'=>'DELAWARE',
    'DC'=>'DISTRICT OF COLUMBIA',
    //'FM'=>'FEDERATED STATES OF MICRONESIA',
    'FL'=>'FLORIDA',
    'GA'=>'GEORGIA',
    'GU'=>'GUAM GU',
    'HI'=>'HAWAII',
    'ID'=>'IDAHO',
    'IL'=>'ILLINOIS',
    'IN'=>'INDIANA',
    'IA'=>'IOWA',
    'KS'=>'KANSAS',
    'KY'=>'KENTUCKY',
    'LA'=>'LOUISIANA',
    'ME'=>'MAINE',
   // 'MH'=>'MARSHALL ISLANDS',
    'MD'=>'MARYLAND',
    'MA'=>'MASSACHUSETTS',
    'MI'=>'MICHIGAN',
    'MN'=>'MINNESOTA',
    'MS'=>'MISSISSIPPI',
    'MO'=>'MISSOURI',
    'MT'=>'MONTANA',
    'NE'=>'NEBRASKA',
    'NV'=>'NEVADA',
    'NH'=>'NEW HAMPSHIRE',
    'NJ'=>'NEW JERSEY',
    'NM'=>'NEW MEXICO',
    'NY'=>'NEW YORK',
    'NC'=>'NORTH CAROLINA',
    'ND'=>'NORTH DAKOTA',
   // 'MP'=>'NORTHERN MARIANA ISLANDS',
    'OH'=>'OHIO',
    'OK'=>'OKLAHOMA',
    'OR'=>'OREGON',
    //'PW'=>'PALAU',
    'PA'=>'PENNSYLVANIA',
    'PR'=>'PUERTO RICO',
    'RI'=>'RHODE ISLAND',
    'SC'=>'SOUTH CAROLINA',
    'SD'=>'SOUTH DAKOTA',
    'TN'=>'TENNESSEE',
    'TX'=>'TEXAS',
    'UT'=>'UTAH',
    'VT'=>'VERMONT',
    'VI'=>'VIRGIN ISLANDS',
    'VA'=>'VIRGINIA',
    'WA'=>'WASHINGTON',
    'WV'=>'WEST VIRGINIA',
    'WI'=>'WISCONSIN',
    'WY'=>'WYOMING',
    //'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
    //'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
   // 'AP'=>'ARMED FORCES PACIFIC'
);


    
if(is_user_logged_in() && in_array('warehouse',$roles)) {

   $args =  array(
                    'post_type' => 'warehouse',
                    'posts_per_page' => -1,
                     "post_status" => array('publish','draft'),
                    'meta_query' => array(
                        array(
                            'key'     => 'ware_house_email',
                            'value'   => $userEmail,
                           // 'compare' => '=',
                        ),
                    ),

            ) ;
   // $args1 = array(
   //                  'post_type' => 'warehouse',
   //                  'author' => $user_id,                   

   //          ) ;
  
   $users_query = new WP_Query($args);

	 ?>

   


<div class="main-content admin-login">
	<div class="content-inner">
		<div id = "" class="left-sidebar" >
			<!-- <p>Filter</p> -->
			<div class="left-inner">
				<h4 class="">Dashboard</h4>
			<div class="commodity listing"><a href="<?php echo home_url();?>/owner_panel/" class="filter_titles active">My warehouse</a></div>
			<!-- <div class="commodity payment"><a href="<?php //echo home_url();?>/owner_panel/payment-gateway/" class="filter_titles">Subscription</a></div> -->
			<div class="commodity subscrip"><a href="<?php echo home_url();?>/owner_panel/subscription-management/" class="filter_titles">Current Subscription</a></div>
			<div class="commodity billing"><a href="<?php echo home_url();?>/owner_panel/billing-and-invoices/" class="filter_titles">Billing and invoicing</a></div>
      <div class="my_profile"><a href="<?php echo home_url();?>/my-profile" class="filter_titles">My Profile</a></div>
			<!-- <div class="commodity"><a href="https://staggingweb.com/logicore/owner_panel/customer-posts/" class="filter_titles">Automated Reminders</a></div> -->
			</div>
		</div>
		<div id="notification" class="notice is-dismissible" style="display:none"></div>
		<div class="middel-content owner_paneldetail" >
			

<div class="dashboar_container">
  <div id="notification" class="notice is-dismissible" style="display:none"></div>


  <?php if ($_GET["warehouse_id"]) {
      $post_id = $_GET["warehouse_id"]; ?>
    <div class="d-flex align-items-center justify-content-between">
      <h3 class="blue-heading">Edit Warehouse</h3>
<a class="back btn btn-primary" href="<?php echo home_url('owner_panel');?>">Back</a>
    </div>

    <div id="manage_warehouse" class="edit_popup form_moredetail viewmore_detail" >
     <?php
     global $wpdb;
     $commodity_terms= get_terms("commodity", [
         "hide_empty" => false,
         "parent" => 0,
     ]);
     $service_terms = get_terms("services", [
         "hide_empty" => false,
         "parent" => 0,
     ]);
     $certification_terms = get_terms("certification", [
         "hide_empty" => false,
         "parent" => 0,
     ]);
     $area_terms = get_terms("area", ["hide_empty" => false, "parent" => 0]); //$certification_terms = get_terms('certification');
     $additional_services = get_terms("additional_service", [
         "hide_empty" => false,
         "parent" => 0,
     ]);
     ?>

    <form class="p-2 row" id="update_warehouse_form" name="update_warehouse" method="post" enctype='multipart/form-data'>
<?php //echo get_the_content($post_id); ?>
 <div class="col-12">
                 <h4 class="blue-heading mt-3">1. Warehouse Basic Information</h4>
              </div>
             
 <div class="col-12 col-md-6 my-2">
   <label>Business Name</label>
   <input class="form-control" type="" placeholder="Business Name" id ="warehouse_title" name="warehouse_title" value="<?php echo get_the_title($post_id); ?>">
 </div>
 <div class="col-12 col-md-6 my-2">
   <?php $phone_number = get_post_meta($post_id,'phone_number',true);?>
    <label>Phone Number</label>
   <input class="form-control" type="" name="phone_number" placeholder="Phone Number" maxlength="15" minlength="10" onkeypress="return isNumber(event)" value="<?php echo ($phone_number?$phone_number:''); ?>">
 </div>
 <div class="col-12 col-md-6 my-2">
 <?php $email_address = get_post_meta($post_id,'ware_house_email',true);?>
 <label>Email</label>
 <input class="form-control" type="" name="email_address" placeholder="Email Address" value="<?php echo ($email_address?$email_address:''); ?>">
</div>
<div class="col-12 col-md-6 my-2">
<?php $website = get_post_meta($post_id,'website',true);?>
<label>Website</label>
<input class="form-control" type="" name="website" placeholder="Website" value="<?php echo ($website?$website:''); ?>">
</div>
<div class="col-12 col-md-12 my-2">
 <?php $address = get_post_meta($post_id,'warehouse-address',true);?>
 <label>Address</label>
 <input class="form-control" type="" name="Address" placeholder="Address" value="<?php echo ($address?$address:''); ?>">
</div>

 <div class="col-12 col-md-4 my-2">
   <?php $city = get_post_meta($post_id,'city',true);?>
   <label>City</label>
   <input class="form-control" type="" name="City" placeholder="City" value="<?php echo ($city?$city:''); ?>">
 </div>
 <div class="col-12 col-md-4 my-2">
  <?php $state = get_post_meta($post_id,'state',true);?>
   <label>State</label>
  <select name="State">
    <option value="">Select State</option>
   </div><?php foreach($us_state_abbrevs_names as $key => $states){

    if ($state == $key)
    {
        $selected = 'selected';
    }
    else{
        $selected = '';
    }

    ?>

  <option <?php echo $selected;?> value="<?php echo $key; ?>"><?php echo $key; ?></option>

  <?php }?>
</select>
</div>
<div class="col-12 col-md-4 my-2">
 <?php $zipcode = get_post_meta($post_id,'zipcode',true);?>
 <label>Zipcode</label>
 <input class="form-control" type="" name="Zipcode" placeholder="Zipcode" onkeypress="return isNumber(event)" minlength="5" maxlength="5" value="<?php echo ($zipcode?$zipcode:''); ?>">
</div>
<div class="col-12">
    <h3 class="blue-heading mt-4">2. Business Description</h3>
  </div>
<div class="col-12 col-md-12 my-2">
<?php //echo get_the_content($post_id);
$content_post = get_post($post_id);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
 ?>
  
      <textarea class="form-control" placeholder="Business Summary" name="warehouse_desc"  id="desc-textarea" maxlength="2000" placeholder="Start Typin..." ><?php echo wp_strip_all_tags($content);?></textarea>           
 
  <div id="desc-count">
    <span id="desc-current">0</span>
    <span id="desc-maximum">/ 2000</span>
  </div>


</div>
<div class="col-12">
  <h3 class="blue-heading mt-4">3. Additional Details</h3>
</div>

<div class="col-12 col-md-6 my-2">
 <?php $parking_space = get_post_meta($post_id,'parking_space',true);?>
<label>Parking Space (Number of parking spots)</label>
 <input class="form-control" type="" name="parking_space" placeholder="Parking Space" onselectstart="return false" onpaste="return false;"  autocomplete=off onkeypress="return isNumber(event)" value="<?php echo ($parking_space?$parking_space:''); ?>">
</div>
<div class="col-12 col-md-6 my-2">
 <?php $clear_height = get_post_meta($post_id,'clear_height',true);?>
<label>Clear height (feet)</label>
 <input class="form-control" type="" name="clear_height" placeholder="Clear height" onselectstart="return false" onpaste="return false;"  autocomplete=off onkeypress="return isNumber(event)" value="<?php echo ($clear_height?$clear_height:''); ?>">
</div>
<div class="col-12 col-md-6 my-2">
 <?php $dock_doors = get_post_meta($post_id,'dock_doors',true);?>
  <label>Dock Doors ( number of dock)</label>
 <input class="form-control" type="" name="dock_doors" placeholder="Dock Doors" onselectstart="return false" onpaste="return false;"  autocomplete=off onkeypress="return isNumber(event)" onkeypress="return isNumber(event)" value="<?php echo ($dock_doors?$dock_doors:''); ?>">
</div>

<div class="col-12 col-md-6 my-2">
<?php $rail = get_post_meta($post_id,'rail',true);?>
 <label>Rail Access</label>
  <div class="rail_field">
    
<div class="rail_options">
 <label for ="rail-no">No</label>
  <input class="form-control" type="radio" name="rail" id="rail-no" value="NO" <?php echo($rail== "NO"?"checked='checked'":'');?>>
</div>
<div class="rail_options">
<label for ="rail-yes">Yes</label>
<input class="form-control" type="radio" name="rail" id="rail-yes" placeholder="Rail" value="Yes" <?php echo($rail== "Yes"?"checked='checked'":'');?>>
</div>
</div>
</div>
<!-- <div class="col-12 col-md-4 my-2">
<?php //$map = get_post_meta($post_id,'map',true);?>
<label>Google Map Location</label>
<input class="form-control" type="" name="map" placeholder="Google Map Location" value="<?php// echo ($map?$map:''); ?>">
</div> -->
 <div class="col-12">
   <h3 class="blue-heading mt-4">4. Service, Cert. Commodity, Additional Services and Capacity Sq. ft.</h3>
 </div>

<!-- <div class="col-12 col-md-6 my-2">
<?php //$area = get_post_meta($post_id,'area',true);?>
<input class="form-control" type="" name="area" placeholder="Area in Sq. Feet" value="<?php// echo ($area?$area:''); ?>">
</div> -->

<div class="col-12 col-md-12 my-2">
  <?php
  $datas = wp_get_post_terms($post_id, "services", [
    'fields' => 'all',
  ]);
 
  ?>
 <label>Services</label>
    <input class="services_select" value="Services" readonly>
                <div class="services_options checkbox-btn">

 <?php if(isset($datas) && !empty($datas)){
    foreach ($datas as $data_term) { 
                    
                    $slug = $data_term->slug;
                    $dd[] = $data_term->term_id;
                    ?>
                     <input class="" checked= "checked" type="checkbox" id="<?php echo $data_term->term_id; ?>" data-term="<?php echo $data_term->slug; ?>"  data-id="<?php echo $data_term->term_id; ?>" name="services[]" value="<?php echo $data_term->term_id; ?>">
                    <label for="<?php echo $data_term->term_id; ?>"> <?php echo $data_term->name; ?></label>
                   <?php } 
               

 foreach ($service_terms as $term) { 
                    if(in_array($term->term_id,$dd))
{
  continue;
}
 $slug = $term->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $term->term_id; ?>" data-term="<?php echo $term->slug; ?>" type="checkbox" data-id="<?php echo $term->term_id; ?>" name="services[]" value="<?php echo $term->term_id; ?>">
                    <label for="<?php echo $term->term_id; ?>"> <?php echo $term->name; ?></label>
                   <?php }
                   }
                   else{
                     foreach ($service_terms as $term) { 
//                     if(in_array($term->term_id,$dd))
// {
//   continue;
//}
 $slug = $term->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $term->term_id; ?>" data-term="<?php echo $term->slug; ?>" type="checkbox" data-id="<?php echo $term->term_id; ?>" name="services[]" value="<?php echo $term->term_id; ?>">
                    <label for="<?php echo $term->term_id; ?>"> <?php echo $term->name; ?></label>
                   <?php }

                   } ?>
                  </div> 
</div>
<div class="col-12 col-md-12 my-2">
  
  <?php
  $datace = wp_get_post_terms($post_id, "certification", [
     'fields' => 'all',
  ]);
 
  ?>
 <label>Certification</label>
    <input class="services_select" value="Certification" readonly>
                <div class="services_options checkbox-btn">
                   <?php if(isset($datace) && !empty($datace)){
                    foreach ($datace as $data_term) { 
                    
                    $slug = $data_term->slug;
                    $dd[] = $data_term->term_id;
                    ?>
                     <input class="" checked= "checked" type="checkbox" id="<?php echo $data_term->term_id; ?>" data-term="<?php echo $data_term->slug; ?>"  data-id="<?php echo $data_term->term_id; ?>" name="warehouse_certification[]" value="<?php echo $data_term->term_id; ?>">
                    <label for="<?php echo $data_term->term_id; ?>"> <?php echo $data_term->name; ?></label>
                   <?php } 


                   foreach ($certification_terms as $certification_term) { 
                    if(in_array($certification_term->term_id,$dd))
{
  continue;
}
                    
                    $slug = $certification_term->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $certification_term->term_id; ?>" data-term="<?php echo $certification_term->slug; ?>" type="checkbox" data-id="<?php echo $certification_term->term_id; ?>" name="warehouse_certification[]" value="<?php echo $certification_term->term_id; ?>">
                    <label for="<?php echo $certification_term->term_id; ?>"> <?php echo $certification_term->name; ?></label>
                   <?php } 
               }
                   else{
                    foreach ($certification_terms as $certification_term) { 
//                     if(in_array($certification_term->term_id,$dd))
// {
//   continue;
// }
                    
                    $slug = $certification_term->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $certification_term->term_id; ?>" data-term="<?php echo $certification_term->slug; ?>" type="checkbox" data-id="<?php echo $certification_term->term_id; ?>" name="warehouse_certification[]" value="<?php echo $certification_term->term_id; ?>">
                    <label for="<?php echo $certification_term->term_id; ?>"> <?php echo $certification_term->name; ?></label>
                   <?php } 
                   }?>
                  
                  </div> 
</div>

<div class="col-12 col-md-12 my-2">
  <?php
  $datac = wp_get_post_terms($post_id, "commodity", [
   'fields' => 'all',
  ]);
 
  ?>
 <label>Commodity</label>
    <input class="services_select" value="Commodity" readonly>
                <div class="services_options checkbox-btn">

                   <?php 
                   if(isset($datac) && !empty($datac)){
                    foreach ($datac as $data_term) { 
                    
                    $slug = $data_term->slug;
                    $dd[] = $data_term->term_id;
                    ?>
                     <input class="" checked= "checked" type="checkbox" id="<?php echo $data_term->term_id; ?>" data-term="<?php echo $data_term->slug; ?>"  data-id="<?php echo $data_term->term_id; ?>" name="warehouse_commodity[]" value="<?php echo $data_term->term_id; ?>">
                    <label for="<?php echo $data_term->term_id; ?>"> <?php echo $data_term->name; ?></label>
                   <?php } 
 foreach ($commodity_terms as $commodity_term) { 
                    if(in_array($commodity_term->term_id,$dd))
{
  continue;
}
                    
                    $slug = $commodity_term->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $commodity_term->term_id; ?>" data-term="<?php echo $commodity_term->slug; ?>" type="checkbox" data-id="<?php echo $commodity_term->term_id; ?>" name="warehouse_commodity[]" value="<?php echo $commodity_term->term_id; ?>">
                    <label for="<?php echo $commodity_term->term_id; ?>"> <?php echo $commodity_term->name; ?></label>
                   <?php }
                   }
                   else{
                    foreach ($commodity_terms as $commodity_term) { 
//                     if(in_array($commodity_term->term_id,$dd))
// {
//   continue;
// }
                    
                    $slug = $commodity_term->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $commodity_term->term_id; ?>" data-term="<?php echo $commodity_term->slug; ?>" type="checkbox" data-id="<?php echo $commodity_term->term_id; ?>" name="warehouse_commodity[]" value="<?php echo $commodity_term->term_id; ?>">
                    <label for="<?php echo $commodity_term->term_id; ?>"> <?php echo $commodity_term->name; ?></label>
                   <?php }

                   } ?>

                  
                  </div> 
</div>
<div class="col-12 col-md-12 my-2">
  <label>Additionl Services</label>
  <?php
  $dataa = wp_get_post_terms($post_id, "additional_service", [
     'fields' => 'all',
  ]);
 
  ?>
 
    <input class="services_select" value="Additionl Services" readonly>
                <div class="services_options checkbox-btn">

 <?php  if(isset($dataa) && !empty($dataa)){
    foreach ($dataa as $data_term) { 
                    
                    $slug = $data_term->slug;
                    $dd[] = $data_term->term_id;
                    ?>
                     <input class="" checked= "checked" type="checkbox" id="<?php echo $data_term->term_id; ?>" data-term="<?php echo $data_term->slug; ?>"  data-id="<?php echo $data_term->term_id; ?>" name="warehouse_additional_services[]" value="<?php echo $data_term->term_id; ?>">
                    <label for="<?php echo $data_term->term_id; ?>"> <?php echo $data_term->name; ?></label>
                   <?php } 


                   foreach ($additional_services as $additional_services) { 
                    if(in_array($additional_services->term_id,$dd))
{
  continue;
}
                    
                    $slug = $additional_services->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $additional_services->term_id; ?>" data-term="<?php echo $additional_services->slug; ?>" type="checkbox" data-id="<?php echo $additional_services->term_id; ?>" name="warehouse_additional_services[]" value="<?php echo $additional_services->term_id; ?>">
                    <label for="<?php echo $additional_services->term_id; ?>"> <?php echo $additional_services->name; ?></label>
                   <?php }
                   }
                   else{
                     foreach ($additional_services as $additional_services) { 
//                     if(in_array($additional_services->term_id,$dd))
// {
//   continue;
// }
                    
                    $slug = $additional_services->slug;
                    ?>
                     <input class=""  type="checkbox" id="<?php echo $additional_services->term_id; ?>" data-term="<?php echo $additional_services->slug; ?>" type="checkbox" data-id="<?php echo $additional_services->term_id; ?>" name="warehouse_additional_services[]" value="<?php echo $additional_services->term_id; ?>">
                    <label for="<?php echo $additional_services->term_id; ?>"> <?php echo $additional_services->name; ?></label>
                   <?php }
                   } ?>

                  </div> 
</div>

 <div class="col-12 col-md-12 my-2">
  
  <?php
  $data = wp_get_post_terms($post_id, "area", [
    'fields' => 'all',
  ]);
  
 
  ?>
 <label>Capacity Sq. ft.(Number in Sq. Ft.)</label>
  
               
                    <input type="text" name="warehouse_capacity" placeholder = "Available Capacity sq. ft." onkeypress="return isNumber(event)" value="<?php echo get_post_meta($post_id,'warehouse_capacity',true);?>" >
                
</div>
  <div class="col-12">
    <h3 class="blue-heading mt-4">5. Speciality Services</h3>
  </div>
  <div class="col-12 col-md-12 my-2">
<?php //echo get_the_content($post_id); ?>
  

                 <textarea class="form-control"  name="spciality_services"  id="specialty-textarea" maxlength="200" placeholder="List top 2-3 services your warehouse good at.." ><?php echo get_post_meta($post_id,'specialty_services',true);?></textarea>           
 
  <div id="spec-count">
    <span id="spec-current">0</span>
    <span id="spec-maximum">/ 200</span>
  </div>
</div>
<div class="col-12">
 <h3 class="blue-heading mt-4">6. Logos and Photos</h3>
</div>
<div class="col-12 col-md-6 my-2">
  <!-- <label>Company Logo</label> -->
<input class="form-control company_logoadmin" type="file" name="upload_file" id="logo">

     
            <div class="mt-3" id="logo_wrapper">
                <div id="logo_box_container">
                   <img src="<?php echo get_the_post_thumbnail_url($post_id);?>"> 
                   
        </div>
    </div>
</div>

 <div class="col-12 col-md-6 my-2">
        <!-- <label class="form-label upload-image-label" for="inputEmail">Photos to show your warehouse outside and inside -->
          <input type="file" class="upload-image-input" id="files" name="image[]" multiple>
        <!-- </label> -->
     <?php $gallery_data = get_post_meta( $post_id, 'gallery_data', true );?>
     
            <div class="mt-3" id="gallery_wrapper">
                <div id="img_box_container">
                    <?php 
                    if ( isset( $gallery_data['image_url'] ) ){
                        for( $i = 0; $i < count( $gallery_data['image_url'] ); $i++ ){
                            ?>
                            <div class="gallery_single_row dolu">
                              <div class="gallery_area image_container ">
                                <img class="gallery_img_img" src="<?php esc_html_e( $gallery_data['image_url'][$i] ); ?>" style="    width: 55px; height: 55px;"/>
                                <input type="hidden"
                                class="meta_image_url"
                                name="gallery[image_url][]"
                                value="<?php esc_html_e( $gallery_data['image_url'][$i] ); ?>"
                                />
                            </div>
                            <div class="gallery_area">
                                <span class="button remove" onclick="remove_img(this)" title="Remove"/>X</span>
                            </div>
                            <div class="clear" />
                        </div> 
                    </div>
                    <?php
                }
            }

            ?>
        </div>
    </div>  
    <ol id="myFiless"></ol>  
     <div class="content d-grid w-100">
               <p class="text-center mt-2 mb-0">Upload a new Photo. Minimum dimensions should be 400px x 400 px, Larger image will be resized automatically.</p>
                  <p class="text-center mb-0">Maximum upload size is 1 MB</p>
                </div> 
      </div>
<div class="col-12 my-2">
<input class="btn create_btn mr-2 px-4 text-white" id="submit" type="submit" tabindex="3" value="<?php esc_attr_e( 'Update warehouse', 'simple-fep' ); ?>" />    
<input type="hidden" name="warehouse_id" value="<?php echo $post_id;?>">               
<input type="hidden" name="action" value="Update_Warehouse" />
<?php //wp_nonce_field( 'new-post' ); ?>
</div>
</form>
</div>

<?php
  } else {
       ?>
 <div class="d-md-flex align-items-center justify-content-between">
  <h2 class="blue-heading mb-2 mb-md-0">My Warehouse</h2>
  <button class="btn btn-primary add_warehouse" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Warehouse Business</button>
</div>
<div class="bg-white p-0 rounded listing_table mt-md-4 mt-0">  
  <table id="warehouse_enteries" class="">
   <thead>
     <tr>
      <th>Warehouse ID</th>
      <th>Warehouse Name</th>
      <th>Address</th>
      <th>City</th>
      <th>State</th>     
      <th>Zipcode</th>
      <th>Approval Status</th>
      <th>Subscription Status</th>  
    </tr>
  </thead>
  <tbody>
     <?php
if ($users_query->have_posts()){ 

   
    while ($users_query->have_posts()): $users_query->the_post();
    
            $address = get_post_meta(get_the_ID(),"warehouse-address",true);
            $state = get_post_meta(get_the_ID(), "state", true);
            $city = get_post_meta(get_the_ID(), "city", true);
            $zipcode = get_post_meta(get_the_ID(), "zipcode", true);
            $approval_status = get_post_status();;
            ?>
        <tr>
          <td><a class="mx-2 edit_warehouse btn btn-primary"  href="<?php
          echo home_url("owner_panel?warehouse_id=");
          echo get_the_ID();
          ?>"  class="edit_warehouse"  data-warehouse_id="<?php echo get_the_ID(); ?>"><?php the_ID(); ?></a></td>
          <td><?php the_title(); ?></td>
          <td><?php echo ($address?$address:'');?></td>
          <td><?php echo ($city?$city:'');?></td>
          <td><?php echo ($state?$state:'');?></td>
          <td><?php echo ($zipcode?$zipcode:'');?></td> 
           <td><?php echo ($approval_status == 'publish'?'Approved':'UnApproved');?></td>             
          <td> <?php if(isset($userplan) && !empty($userplan)){
            echo "Yes"; }else{
              echo "No";
            }?> </td>
        </tr>
      <?php
        endwhile;
    } 
    else{?>
     <tr><td>No Warehouse in the list</td></tr>
   <?php }?>
    </tbody>
  </table>
</div> 
<a target="_blank" rel="noopener noreferrer" class="btn btn-primary mt-3 float-end" href="<?php echo home_url('payment-gateway');?>"> Subscription Options</a>
<?php
  } ?>





</div>  


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title blue-heading" id="exampleModalLabel">Add New Warehouse Business</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div id="add_warehouse" class="edit_popup">
          <?php
          global $post;
          $commodity_terms= get_terms("commodity", [
         "hide_empty" => false,
         "parent" => 0,
     ]);
          $service_terms = get_terms("services", [
              "hide_empty" => false,
              "parent" => 0,
          ]);
          $certification_terms = get_terms("certification", [
              "hide_empty" => false,
              "parent" => 0,
          ]);
          $area_terms = get_terms("area", [
              "hide_empty" => false,
              "parent" => 0,
          ]);
          $additional_services = get_terms("additional_service", [
              "hide_empty" => false,
              "parent" => 0,
          ]);
          ?>
          <div class="form_moredetail p-2 viewmore_detail">
            <form class="row" id="add_warehouse_form" name="new_warehouse" method="post" enctype='multipart/form-data' >
               <div class="col-12">
                 <h3 class="blue-heading mt-3">1. Warehouse Basic Information</h3>
              </div>
              <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" placeholder="Business Name" id ="warehouse_title" name="warehouse_title" required>
              </div>
              <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" name="phone_number" placeholder="Phone Number" maxlength="15" minlength="10" onkeypress="return isNumber(event)" required>
              </div>
               <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" name="email_address" placeholder="Email Address" value="<?php echo $userEmail;?>" readonly>
              </div>
               <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" name="website" placeholder="Website">
              </div>
              <div class="col-12 my-2">
                <input class="form-control" type="" name="Address" placeholder="Address" required>
              </div>
              <div class="col-12 col-md-4 my-2">
                <input class="form-control" type="" name="City" placeholder="City" required>
              </div>
              <div class="col-12 col-md-4 my-2">
                  <select name="State">
    <option value="">Select State</option>
   </div><?php foreach($us_state_abbrevs_names as $key => $states){?>

  <option value="<?php echo $key; ?>"><?php echo $key; ?></option>

  <?php }?>
</select>
                <!-- <input class="form-control" type="" name="State" placeholder="State" required> -->
              </div>
              <div class="col-12 col-md-4 my-2">
                <input class="form-control" type="" name="Zipcode" placeholder="Zipcode" onkeypress="return isNumber(event)" minlength="5" maxlength="5" required>
              </div>
              <div class="col-12">
             <h3 class="blue-heading mt-4">2. Business Description</h3>
           </div>
               <div class="col-12 my-2">
                <textarea class="form-control" placeholder="Business Summary" name="warehouse_desc"  id="desc-textarea" maxlength="2000" ></textarea> 
 
                 <div id="desc-count">
                    <span id="desc-current">0</span>
                    <span id="desc-maximum">/ 2000</span>
                  </div>

                </div>
              <div class="col-12">
                <h3 class="blue-heading mt-3">3. Additional Details</h3>
              </div>
               <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" name="parking_space" onselectstart="return false" onpaste="return false;"  autocomplete=off placeholder="Parking Space (Number of parking spots)" onkeypress="return isNumber(event)">
              </div>
              <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" name="clear_height" placeholder="Clear height (feet)" onselectstart="return false" onpaste="return false;"  autocomplete=off onkeypress="return isNumber(event)">
              </div>
              <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" name="dock_doors" placeholder="Dock Doors ( number of dock)" onselectstart="return false" onpaste="return false;"  autocomplete=off onkeypress="return isNumber(event)">
              </div>
             
             <!--  <div class="col-12 col-md-4 my-2">
                <input class="form-control" type="" name="rail" placeholder="Rail">
              </div> -->
               <div class="col-12 col-md-6 my-2">
                
                <div class="rail_field">
                   <label>Rail Access</label>
                <div class="rail_options">
                <label for="rail-yes">Yes</label>
                <input class="form-control" id="rail-yes" type="radio" name="rail" value="Yes">
              </div>
              <div class="rail_options">
                <label for="rail-no">No</label>
                 <input class="form-control" id="rail-no" type="radio" name="rail" value="NO" checked="checked">
               </div>
             </div>
              </div>
              <!-- <div class="col-12 col-md-6 my-2">
                <input class="form-control" type="" name="map" placeholder="Google Map Location">
              </div>
              -->
               <div class="col-12">
               <h3 class="blue-heading mt-4 text-start">4. Service, Cert. Commodity, Additional Services and Capacity Sq. ft.</h3>
             </div>
               <div class="col-12 col-md-12 my-2">
                <input class="services_select" value="Services" readonly>
                <div class="services_options checkbox-btn">
                  <?php foreach ($service_terms as $term) { ?>
                     <input class="" type="checkbox" id="<?php echo $term->term_id; ?>" data-term="<?php echo $term->slug; ?>" type="checkbox" data-id="<?php echo $term->term_id; ?>" name="services[]" value="<?php echo $term->term_id; ?>">
                    <label for="<?php echo $term->term_id; ?>"> <?php echo $term->name; ?></label>
                   <?php } ?>
                  </div> 
              </div>
               <div class="col-12 col-md-12 my-2">
              <input class="services_select" value="Certifications" readonly>
                <div class="services_options checkbox-btn">
                  <?php foreach (
                      $certification_terms
                      as $certification_term
                  ) { ?>
                    <input class="" type="checkbox" id="<?php echo $certification_term->term_id; ?>" data-term="<?php echo $certification_term->slug; ?>" type="checkbox" data-id="<?php echo $certification_term->term_id; ?>" name="warehouse_certification[]" value="<?php echo $certification_term->term_id; ?>">
                            <label for="<?php echo $certification_term->term_id; ?>"> <?php echo $certification_term->name; ?></label>                     
                  <?php } ?>
                  </div>
              </div>
             
               <div class="col-12 col-md-12 my-2">
              <input class="services_select" value="Commodity" readonly>
                <div class="services_options checkbox-btn">
                
                  <?php foreach ($commodity_terms as $commodity_term) { ?>
                  
                    <input class="" type="checkbox" id="<?php echo $commodity_term->term_id; ?>" data-term="<?php echo $commodity_term->slug; ?>" type="checkbox" data-id="<?php echo $commodity_term->term_id; ?>" name="warehouse_commodity[]" value="<?php echo $commodity_term->term_id; ?>">
                            <label for="<?php echo $commodity_term->term_id; ?>"> <?php echo $commodity_term->name; ?></label>                     
                                    
                  <?php } ?>
                  </div>
              </div>
              <!-- <div class="col-12 col-md-6 my-2" class="input-container">
                <input type="" name="area" placeholder="Area in Sq. Feet">
              </div> -->
             
              <div class="col-12 col-md-12 my-2">
              <input class="services_select" value="Additional Services" readonly>
                <div class="services_options checkbox-btn">
                  <?php foreach (
                      $additional_services
                      as $additional_service
                  ) { ?>
                    <input class="" type="checkbox" id="<?php echo $additional_service->term_id; ?>" data-term="<?php echo $additional_service->slug; ?>" type="checkbox" data-id="<?php echo $additional_service->term_id; ?>" name="warehouse_additional_services[]" value="<?php echo $additional_service->term_id; ?>">
                            <label for="<?php echo $additional_service->term_id; ?>"> <?php echo $additional_service->name; ?></label>                    
                  <?php } ?>
                  </div> 
                
              </div>
            
               <div class="col-12 col-md-12 my-2">
              
              
                    <input type="text" name="warehouse_capacity" placeholder = "Capacity Sq. ft.(Number in Sq. Ft.)" onkeypress="return isNumber(event)"value="" >
                
                  <!-- <?php //foreach ($area_terms as $area_term) { ?>
                  
                    <input class="" type="checkbox" id="<?php //echo $area_term->term_id; ?>" data-term="<?php// echo $area_term->slug; ?>" type="checkbox" data-id="<?php //echo $area_term->term_id; ?>" name="warehouse_area[]" value="<?php //echo $area_term->term_id; ?>">
                            <label for="<?php //echo $area_term->term_id; ?>"> <?php //echo $area_term->name; ?></label>                     
                                    
                  <?php //} ?> -->
                  </div>
              
              <div class="col-12">
                 <h3 class="blue-heading mt-4">5. Speciality Services</h3>
              </div>
              <div class="col-12 col-md-12 my-2">
<?php //echo get_the_content($post_id); ?>
  

                 <textarea class="form-control"  name="spciality_services"  id="specialty-textarea" maxlength="200" placeholder="List top 2-3 services your warehouse good at.." ><?php echo get_post_meta($post_id,'specialty_services',true);?></textarea>           
 
  <div id="spec-count">
    <span id="spec-current">0</span>
    <span id="spec-maximum">/ 200</span>
  </div>
</div>
<div class="col-12">
                 <h3 class="blue-heading mt-4">6. Logo and Photos</h3>
              </div>
         <div class="col-12 col-md-6 my-2">
                <!-- <label class="form-label upload-image-label warehouse_logo" for="inputEmail">Upload Photo -->
                  <input type="file" class="addlist_logo" name="upload_file" id="logo">
                    <div class="mt-3" id="logo_wrapper">
                <div id="logo_box_container">
                 
                   
        </div>
    </div>
                <!-- </label> -->
              </div>

      <div class="col-12 col-md-6 my-2">
        <!-- <label class="form-label upload-image-label" for="inputEmail">Upload New Photo -->
          <input type="file" class="upload-image-input_ addlist_upload-imageinput" id="files" name="image[]" multiple>
          <div id="gallery_wrapper">
                     <div id="img_box_container">
                      <ol id="myFiless"></ol>   
                    </div>
                </div>

        <!-- </label> -->
      </div>
             <div class="content">
               <p class="text-center">Upload a new Photo. Minimum dimensions should be 400px x 400 px, Larger image will be resized automatically.</p>
                  <p class="text-center">Maximum upload size is 1 MB</p>
            </div> 

      <div class="col-12 textright">
        <input class="form-control" type="hidden" name="action" value="add_warehouses" />
        <input class="button button-primary create_btn btn" type="submit" value="Add Warehouse">
      </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
</div>
<div class="modal confirmation-popup" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="succ_icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
</svg>
         </div>   
        <h4 class="text-primary"></h4>
        <p class="pop-up-notification"></p>
      </div>
        <p class="popup-cls-btn">Ok</p>
  </div>
</div>
</div>
<?php }else{?>
    <div class="ownerwithout_login">
    <div class="ownerwithout_login_inner">
      <p> You are not allowed to view this panel.</p>
    <p> if you are warehouse owner then please login <a href="<?php echo home_url();?>/wp-login.php?action=logout&redirect_to=<?php echo home_url();?>/login">here</a></p>
    </div>
  </div>

<?php } get_footer();?>
</div>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
//   jQuery(document).ready( function () {
//     jQuery('#warehouse_enteries').DataTable({
//        "order": [[ 0, "asc" ]],
//         "pageLength" : 10,
//     });
// } );
//     jQuery(document).ready(function() {
//     jQuery('#flexSwitchCheckChecked').change(function() {
//         if(jQuery(this).is(":checked")) {
//             console.log("Approve it");           
//         }
//         else{
//             console.log("Unapprove it");
//         }
               
//     });
// });


jQuery('.popup-cls-btn').on('click',function(){
    jQuery('#exampleModal2').css('display','none');
    jQuery("#notification").css("display","block");
    jQuery('html, body').animate({
            scrollTop: jQuery("#notification").offset().top
          }, 2000);
    jQuery('#warehouse_enteries').load(document.URL + ' #warehouse_enteries');
    jQuery('#manage_warehouse').load(document.URL + ' #manage_warehouse'); 

})

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
jQuery('#desc-textarea').keyup(function() {
    
  var characterCount = jQuery(this).val().length,
      current = jQuery('#desc-current'),
      maximum = jQuery('#desc-maximum'),
      theCount = jQuery('#desc-count');
    
  current.text(characterCount);
 
  
  /*This isn't entirely necessary, just playin around*/
  if (characterCount < 570) {
    current.css('color', '#666');
  }
  if (characterCount > 570 && characterCount < 1190) {
    current.css('color', '#6d5555');
  }
  if (characterCount > 1190 && characterCount < 1300) {
    current.css('color', '#793535');
  }
  if (characterCount > 1300 && characterCount < 1520) {
    current.css('color', '#841c1c');
  }
  if (characterCount > 1520 && characterCount < 1839) {
    current.css('color', '#8f0001');
  }
  
  if (characterCount >= 1999) {
    maximum.css('color', '#8f0001');
    current.css('color', '#8f0001');
    theCount.css('font-weight','bold');
  } else {
    maximum.css('color','#666');
    theCount.css('font-weight','normal');
  }
  
      
});

jQuery('#specialty-textarea').keyup(function() {
    
  var characterCount = jQuery(this).val().length,
      current = jQuery('#spec-current'),
      maximum = jQuery('#spec-maximum'),
      theCount = jQuery('#spec-count');
    
  current.text(characterCount);
 
  
  /*This isn't entirely necessary, just playin around*/
  if (characterCount < 70) {
    current.css('color', '#666');
  }
  if (characterCount > 70 && characterCount < 90) {
    current.css('color', '#6d5555');
  }
  if (characterCount > 90 && characterCount < 100) {
    current.css('color', '#793535');
  }
  if (characterCount > 100 && characterCount < 120) {
    current.css('color', '#841c1c');
  }
  if (characterCount > 120 && characterCount < 139) {
    current.css('color', '#8f0001');
  }
  
  if (characterCount >= 140) {
    maximum.css('color', '#8f0001');
    current.css('color', '#8f0001');
    theCount.css('font-weight','bold');
  } else {
    maximum.css('color','#666');
    theCount.css('font-weight','normal');
  }
  
      
});

 // if (window.File && window.FileList && window.FileReader) {
            var filesToUpload = []; // Array to store files
                  const fileInput = document.querySelector('input[type="file"]');

                  jQuery("#files").on("change", function(e) {

                  for (let i = 0; i < e.target.files.length; i++) {
                  let myFile = e.target.files[i];
                  let myFileID = "FID" + (1000 + Math.random() * 9000).toFixed(0);

                  filesToUpload.push({
                  file: myFile,
                  FID: myFileID
                  });
                  };
                  display();
                  //reset the input to null - nice little chrome bug!
                  e.target.value = null;
                  });

                  const removeFile = (x) => {
                  for (let i = 0; i < filesToUpload.length; i++) {
                  if (filesToUpload[i].FID === x)
                  filesToUpload.splice(i, 1);
                  }
                  display();
                  }

                  const display = () => {
                  document.getElementById("myFiless").innerHTML = "";
                  for (let i = 0; i < filesToUpload.length; i++) {
                  var fileReader = new FileReader();
                  fileReader.onload = (function(e) {

                  document.getElementById("myFiless").innerHTML += `<li><button onclick="removeFile('${filesToUpload[i].FID}')">X</button><img style="width: 55px; height: 55px;" src="${e.target.result}" class="prescriptions"></li>`;

                  });
                  fileReader.readAsDataURL(filesToUpload[i].file);


                  }
                  }
            jQuery("#logo").on("change", function(e) {         
              var files = e.target.files,
              filesLength = files.length;
              //   if(filesLength < 11){
              // for (var i = 0; i < filesLength; i++) {
               var f = files[0]
               var fileReader = new FileReader();
               fileReader.onload = (function(e) {
                 var file = e.target;
                 jQuery('#logo_box_container img').remove();
                 jQuery(".pip").remove();
               jQuery("<span class=\"pip\">" +
                   "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                   "<br/>" +
                   "</span>").insertAfter("#logo_box_container");
                 jQuery("<span class=\"pip\">" +
                   "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                   "<br/>" +
                   "</span>").insertAfter(".warehouse_logo");
                   jQuery(".remove").click(function(){
                    jQuery(this).parent(".pip").remove();
                 });          
               });
               fileReader.readAsDataURL(f);
          //    }
          // //}
          //  else{
          //   alert('Please Select Only 104 Images');
          //   return false;
          //  }
           });
     //    }
  jQuery(document).on('click', '.edit_warehouse', function(e){ 
    jQuery("#add_warehouse").css("display","none");
    jQuery("#manage_warehouse").css("display","block");   
  });


  jQuery(document).on('click', '.add_warehouse', function(e){ 
    jQuery("#manage_warehouse").css("display","none");
    jQuery("#add_warehouse").css("display","block");
 });

 jQuery(document).on('click', '.delete_warehouse', function(e){  
    event.preventDefault();
    var submit_button = $(this);
    var data_warehouse_id = $(this).attr("data-warehouse_id");
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url("admin-ajax.php"); ?>',
      data:{action:"delete_warehouse" ,warehouse_id:data_warehouse_id }, 
      beforeSend:function(){
        submit_button.addClass("disable_button");
      },
      success: function(response){  
        var message = JSON.parse(response);
        //$(this).parent().parent().closest('div').addClass("selected");
        submit_button.removeClass("disable_button");
        jQuery('html, body').animate({
          scrollTop: $("#notification").offset().top
        }, 2000);
        jQuery("#notification").css("display","block");
        jQuery("#notification").addClass("notice-success");
        jQuery("#notification").html("Warehouse Deleted");  
        jQuery('#warehouse_enteries').load(document.URL + ' #warehouse_enteries');
      },
    });
  });


  jQuery(document).on('submit', '#add_warehouse_form', function(e){   
    event.preventDefault();   
    var post_name = jQuery.trim(jQuery("#warehouse_title").val());
    if(post_name.length > 0){
      jQuery('.create_btn').attr("disabled", true);
      var formData = new FormData(this);
       for (let i = 0; i < filesToUpload.length; i++) {
              formData.append("image[]", filesToUpload[i].file);
            }

      jQuery.ajax({
        type:'POST',
        url:'<?php echo admin_url("admin-ajax.php"); ?>',
        data:formData, 
        processData: false,
        contentType: false,
        beforeSend: function() {
          jQuery(".create_btn").addClass("disable_button");
           add_loader('.edit_popup');
            jQuery(".edit_popup").addClass("loading");
        },        
        success: function(response){  
          var dataresponse = JSON.parse(response);
          //remove_loader(".edit_popup");
           jQuery("#add_warehouse_form").trigger("reset");
            remove_loader('.edit_popup');
           jQuery(".edit_popup").removeClass("loading");            
          //jQuery("#add_warehouse_form")[0].reset();
          jQuery(".btn-close").trigger("click");
          jQuery("#exampleModal2").css("display","block");
          jQuery('.pop-up-notification').html(dataresponse['board']['msg']);
          jQuery('.text-primary').html(dataresponse['board']['status']);
          jQuery('.succ_icon').addClass(dataresponse['board']['status']);
          jQuery("#notification").addClass(dataresponse['board']['status']);
          jQuery("#notification").html(dataresponse['board']['msg']);  
          jQuery('.create_btn').attr("disabled", false);    

        },
      });
    }
  });


  jQuery(document).on('submit', '#update_warehouse_form', function(e){
     event.preventDefault();   
    var post_name = jQuery.trim(jQuery("#warehouse_title").val()); 
    var imag = [];
    jQuery('.gallery_area img').each(function () {
     imag.push(jQuery(this).attr('src'));
      
    });
   
    if(post_name.length > 0){
      jQuery('.create_btn').attr("disabled", true);
      var formData = new FormData(this);
       formData.append("saved_images", imag);
       for (let i = 0; i < filesToUpload.length; i++) {
              formData.append("image[]", filesToUpload[i].file);
            }
      jQuery.ajax({
        type:'POST',
        url:'<?php echo admin_url("admin-ajax.php"); ?>',
        data:formData, 
        processData: false,
        contentType: false,
        beforeSend: function() {
          jQuery(".create_btn").addClass("disable_button");
           add_loader('.dashboar_container');
            jQuery(".dashboar_container").addClass("loading");
        },        
        success: function(response){  
          var dataresponse = JSON.parse(response);
         // console.log(dataresponse);
          jQuery(".create_btn").removeClass("disable_button");
          remove_loader('.dashboar_container');
          jQuery(".dashboar_container").removeClass("loading");
          jQuery("#exampleModal2").css("display","block");
          jQuery('.pop-up-notification').html(dataresponse['board']['msg']);             
          jQuery("#notification").addClass(dataresponse['board']['status']);
          jQuery("#notification").html(dataresponse['board']['msg']);  
          jQuery('.create_btn').attr("disabled", false);
           location.reload();
         
        },
      });
    }
  });
  jQuery('.services_select').click(function(){    
    if(jQuery(this).hasClass('active')){      
    jQuery(this).removeClass('active');
     jQuery(this).siblings('.services_options').removeClass('open');
}
else{ 
  jQuery('.col-12').each(function () {
      jQuery('.services_select ').removeClass('active');
      jQuery('.services_option').removeClass('open');
    });
      jQuery(this).addClass('active');
        jQuery(this).siblings('.services_options').addClass('open');
    }
    }); 


        function remove_img(value) {
            var parent=jQuery(value).parent().parent();
            parent.remove();
        }
jQuery(document).ready(function() {
    jQuery('#textbox_id').bind("cut copy paste", function(e) {
        e.preventDefault();
         alert("You cannot paste into this text field.");
        jQuery('#textbox_id').bind("contextmenu", function(e) {
            e.preventDefault();
        });
    });
});
</script>
