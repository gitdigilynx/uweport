<?php
/**
* Template Name: Custom Page
*/
get_header(); 
 global $post; 
  $service_terms = get_terms('services', array( 'hide_empty' => false, 'parent' => 0 ));
  $certification_terms = get_terms('certification', array( 'hide_empty' => false, 'parent' => 0 ));
  //$certification_terms = get_terms('certification');
  $additional_services = get_terms('additional_service', array( 'hide_empty' => false, 'parent' => 0 ));
?>
<div id="simple-fep-postbox" class="<?php if(is_user_logged_in()) echo 'closed'; else echo 'loggedout'?>">
        <div class="simple-fep-inputarea">
        <?php if(is_user_logged_in()) { ?>
            <form id="fep-new-post" name="new_post" method="post" action="<?php the_permalink(); ?>">
        <div class="input-container">
          <input type="" placeholder="Business Name" id ="fep-post-title" name="post-title">
        </div>
        <div class="input-container">
          <input type="" name="Address" placeholder="Address">
        </div>
        <div class="input-container">
          <input type="" name="City" placeholder="City">
        </div>
        <div class="input-container">
          <input type="" name="State" placeholder="State">
        </div>
        <div class="input-container">
          <input type="" name="Zipcode" placeholder="Zipcode">
        </div>
        <div class="input-container">
          <input type="" name="phone_number" placeholder="Phone Number">
        </div>
        <div class="input-container">
          <input type="" name="parking_space" placeholder="Parking Space">
        </div>
        <div class="input-container">
          <input type="" name="clear_height" placeholder="Clear height">
        </div>
        <div class="input-container">
          <textarea placeholder="Business Summary" class="fep-content" name="posttext" id="fep-post-text" tabindex="1" rows="4" cols="60"></textarea>
        </div>

      

      <h2 class="blue-heading mt-40">Additional Details</h2>
      
        <div class="input-container">
          <input type="" name="dock_doors" placeholder="Dock Doors">
        </div>
        <div class="input-container">
          <input type="" name="email_address" placeholder="Email Address">
        </div>
        <div class="input-container">
          <input type="" name="rail" placeholder="Rail">
        </div>
        <div class="input-container">
          <input type="" name="map" placeholder="Google Map Location">
        </div>
        <div class="input-container">
          <input type="" name="website" placeholder="Website">
        </div>
        <div class="input-container">
          <select>
            <option>Available Area in Sq. Feet</option>

          </select>
        </div>
        <div class="input-container">
          <input type="" name="area" placeholder="Area in Sq. Feet">
        </div>
        <div class="input-container">
          <select>
            <option>Warehouse Certification</option>
             <?php foreach ($certification_terms as $certification_term) { ?>
                <option value="<?php echo $certification_term->term_id; ?>"><?php echo $certification_term->name; ?></option>                      
                    <?php }?>
          </select>
        </div>
        <div class="input-container">
          <select>
            <option>Additional Services</option>
             <?php foreach ($additional_services as $additional_service) { ?>
                <option value="<?php echo $additional_service->term_id; ?>"><?php echo $additional_service->name; ?></option>                      
                    <?php }?>
          </select>
        </div>
        <div class="input-container">
          <input type="file" name="file">
        </div>
        <div class="input-container">
          <select>
            <option>Specialed Service</option>
              <?php foreach ($service_terms as $term) { ?>
                <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>                      
                    <?php }?>
          </select>
        </div>
          <input id="submit" type="submit" tabindex="3" value="<?php esc_attr_e( 'Post', 'simple-fep' ); ?>" />                   
                <input type="hidden" name="action" value="post" />
                <input type="hidden" name="empty-description" id="empty-description" value="1"/>
                <?php wp_nonce_field( 'new-post' ); ?>
            </form>
        <?php } else { ?>       
                <h4>Please Log-in To Post</h4>
        <?php } ?>
        </div>
 
</div> <!-- #simple-fep-postbox -->

        <?php get_footer();