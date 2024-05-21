
<?php get_header();?>
<div class="main-content">
	<div class="content-inner">
		<div id = "filter_form" class="md-3 left-sidebar" >
			<!-- <p>Filter</p> -->
		
			<div class="left-inner">
			<?php 
			$taxonomies = get_object_taxonomies( array( 'post_type' => 'warehouse' ) ); 
			  foreach( $taxonomies as $taxonomy ) {
			if ( $taxonomy == 'top_cities' || $taxonomy == 'top_cities' )
continue;
				$taxonomy_details = get_taxonomy( $taxonomy );
				echo '<div class="'.$taxonomy.'">';			
				echo '<h4 class="filter_titles">'. $taxonomy_details->label.'</h4><div class="checkbox-list">';
				$terms = get_terms( $taxonomy );

				foreach( $terms as $term ){?>
					<div class="checkbox-btn">
				<input class="filter_fields" id="<?php echo $term->term_id;?>" data-term="<?php echo $term->slug;?>" type="checkbox" data-id="<?php echo $term->term_id;?>" name="term_cat" value="<?php echo $term->name;?>">
				<label for="<?php echo $term->term_id;?>"> <?php echo $term->name;?></label>
				</div>
				<?php  }
				echo '</div></div>';
			}  ?> 
		</div>
		</div>
		<div class="md-6 middel-content" >

			<?php 
			while ( have_posts() ) :
	the_post();

	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide">
		<?php


 the_title( '<h1 class="entry-title blue-heading">', '</h1>' ); ?>
		<?php //twenty_twenty_one_post_thumbnail(); ?>
	
<?php					
											
						$postData = get_post_meta( get_the_ID() );
					
						
						if(isset($postData['gallery_data']) && !empty($postData['gallery_data'])){
							$photos_query = $postData['gallery_data'][0];
						$photos_array = unserialize($photos_query);
						$url_array = $photos_array['image_url'];
						$count = sizeof($url_array);?>
						<div class="thumbnail_slider owl-theme">
						<?php for( $i=0; $i<$count; $i++ ){
						?>
						<div class="col-sm-12 slide_img">
								<img class="img-fluid gallery-img" src="<?php echo $url_array[$i]; ?>" alt=""/>
						</div>
						<?php
							if ($i == 0) { $i=0; }
						}
						
					?>
				</div>
						<?php }
						else{
							twenty_twenty_one_post_thumbnail(); 
						}
							?>
						
						
					</header><!-- .entry-header -->
				<?php $speciality_services = get_field('specialty_services');?>
				
						<div class="add-services spacey-30">
				<h2 class="blue-heading"> Speciality Services</h2>
				<?php if($speciality_services){?>
				<?php echo $speciality_services;?>
	<?php }?>
		</div>

					<div class="detail spacey-30">
												
						<div class="content">
								<h2  class="blue-heading"> Details</h2>
								
						 		<h4><img src="/wp-content/uploads/2023/05/location.png" alt="icon">Address</h4>
						   		<?php $location = get_field('warehouse-address');?>
						 		<?php //echo "<pre>"; print_R($location);?>
						   		<p><?php if($location){
						   			echo $location;
						   		}
						    $city = get_field('city');
						    if($city){
						    	echo ', '.$city;
						    }
						     $state = get_field('state');
						    if($state){
						    	echo ', '.$state;
						    }
						     $zipcode = get_field('zipcode');
						    if($zipcode){
						    	echo ', '.$zipcode;
						    }
						    ?>
						    </p> 
						   

						     <?php 
						  //    $area = get_field('area');
						  //    if($area){?>
						  <!-- //   <p><img src="/wp-content/uploads/2023/05/area.png" alt="icon"><strong>Area in Sq. Feet:</strong> <?php //echo $area;?></p> -->
							<?php //}?>

						     <?php
						     $ware_house_email = get_field('ware_house_email'); 
						     if($ware_house_email){?>
						   <p><img src="/wp-content/uploads/2023/05/email-black.png" alt="icon"><?php echo $ware_house_email;?></p>
						     <?php } ?>

						    <?php
						    $phone_number = get_field('phone_number');
						     if($phone_number){?>
						  <p><img src="/wp	-content/uploads/2023/05/call-black.png" alt="icon"><?php echo $phone_number;?></p>
						   <?php } ?>

						   <?php $website = get_post_meta(get_the_ID(),'website',true);
						   if($website){?>
						  <p><img src="/wp	-content/uploads/2023/05/website.png" alt="icon"><?php echo $website;?></p>
						   <?php } ?>

					
						</div>
						    <div class="map">
<?php



// 						    	// TODO your field name here
// $mapInfo = get_field("address");

// $zoom = $mapInfo['zoom'] ?? '16';
// $lat = $mapInfo['lat'] ?? '';
// $lng = $mapInfo['lng'] ?? '';

// // zoom level - gets from every specific map (when admins zoom out and saves a page, the zoom is also saved)
// printf(
//     '<div class="my-map" style="width:100%%;height:400px;" data-zoom="%s">',
//     $zoom
// );

// printf(
//     '<div class="my-map__marker" data-lat="%s" data-lng="%s"></div>',
//     esc_attr($lat),
//     esc_attr($lng)
// );

// echo "</div>";
$address = $location.' '.$city.' '.$state.' '.$zipcode;
	$prepAddr = str_replace(' ','+',$address);


  $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c');
  $output= json_decode($geocode);  

  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng; 
  $lat = deg2rad($latitude);
  $long = deg2rad($longitude);   

  
// 		$long = get_post_meta(get_the_ID(),'longitude',true);
// $lat = get_post_meta(get_the_ID(),'latitude',true);

  $address_field = $acf_map_field['address'];
  echo $address_field;
    $encoded_address = urlencode( $address_field );

    ?>
   <!-- <div id="googleMap" style="width:100%;height:100%;"></div> -->


     <iframe
            width="600"
            height="300"
            frameborder="0" style="border:0" style="width:100% !important"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c&q='<?php echo $prepAddr;?>'" allowfullscreen>
        </iframe> 
          <!--  <embed width="1000px" height="1000px" frameborder="3px" style="border: 0px" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c&q=65+Spring+Ln+Farmington+CT+6032">
          <button onclick="<embed>" ondbclick="<div>">embed</button>
          </embed> -->
       
						    	
						   <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d421800.6140493029!2d-106.02160779235231!3d38.77826006614811!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8714ab43baabf2d3%3A0xb4229da3ad749c8f!2sPike%20and%20San%20Isabel%20National%20Forest!5e0!3m2!1sen!2sin!4v1684140581630!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
						    </div>


					</div>
<div class="description spacey-30 bg-light">

<h2 class="blue-heading">Description</h2>
	
<?php the_content();?>


</div>
<div class="spacey-30 additional_detail">

<h2 class="blue-heading">Additional Details</h2>

<div class="commodity spacey-30">


				<!-- <p> Square feet					
				<?php// $commodity_terms = get_the_terms( get_the_ID(), 'area' );
				//foreach($commodity_terms as $commodity_term ){
				//	echo $commodity_term->name;}?>
			</p> -->
			<p> <strong>Parking Space:</strong>
			<?php $parking_space = get_post_meta(get_the_ID(),'parking_space',true);?>
	<?php echo($parking_space?$parking_space:'No');?></p>
			<p> <strong>Clear Height:</strong>
			<?php $clear_height = get_post_meta(get_the_ID(),'clear_height',true);?>
		<?php echo($clear_height?$clear_height:'No');?></p>
			<p> <strong>Dock Doors:</strong>
			<?php $dock_doors = get_post_meta(get_the_ID(),'dock_doors',true);?>
	<?php echo($dock_doors?$dock_doors:'No');?></p>
			<p><strong> Rail:</strong>
			<?php $rail = get_post_meta(get_the_ID(),'rail',true);?>
	<?php echo($rail?$rail:'No');?></p>
	<p><strong>Available Capacity Sq. Ft:</strong>
<?php $warehouse_capacity = get_post_meta(get_the_ID(),'warehouse_capacity',true);?>
<?php echo $warehouse_capacity;?>

			
		</div>

</div>
<div class="services  spacey-30 bg-light">
							<h2 class="blue-heading"> Services</h2>
							<ul>
							<?php $services_terms = get_the_terms( get_the_ID(), 'services' );
							foreach($services_terms as $services_term ){?>	
								<li><img alt="icon" src="/wp-content/uploads/2023/05/list-icon.png">
								 <?php echo $services_term->name; ?>
								</li>
								<?php
							}?>	
							</ul>
					</div>	
						<div class="certifications spacey-30">
				<h2 class="blue-heading"> Certifications</h2>
				<ul>
				<?php $certification_terms = get_the_terms( get_the_ID(), 'certification' );
				foreach($certification_terms as $certification_term ){?>
					<li> <img alt="icon" src="/wp-content/uploads/2023/05/list-icon.png">
					<?php echo $certification_term->name;?>
					</li>
				<?php	}?>
				</ul>
		</div>
	<div class="commodity spacey-30">

				<h2 class="blue-heading"> Commodity</h2>
				<ul>
				<?php $commodity_terms = get_the_terms( get_the_ID(), 'commodity' );
				foreach($commodity_terms as $commodity_term ){?>
					<li> <img alt="icon" src="/wp-content/uploads/2023/05/list-icon.png">
					<?php echo $commodity_term->name;?>
					</li>
			<?php	}?>
			</ul>
		</div>

	
		<div class="add-services spacey-30">
				<h2 class="blue-heading"> Additional Services</h2>
				<ul>
				<?php $additional_service_terms = get_the_terms( get_the_ID(), 'additional_service' );
					foreach($additional_service_terms as $additional_service_term ){?>
					<li> <img alt="icon" src="/wp-content/uploads/2023/05/list-icon.png">
					<?php echo $additional_service_term->name;?>
					</li>
				<?php	}?>
				</ul>
		</div>





					
	





</article>
	<?php endwhile; ?>
			
		</div>

		<div class="right-sidebar md-3">
			<h2 class="white-heading">Ads</h2>
			<?php if ( is_active_sidebar( 'add_sidebar' ) ) { ?>
    <div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar( 'add_sidebar' ); ?>
		</div>
		<?php }?>
		</div>
	</div>
</div>

<?php get_footer();

?>

<script>
function myMap() {
	var longlat = {lat: <?php echo $lat;?>,lng: <?php echo $long;?>};
console.log(longlat);
var mapProp= {
  center:new google.maps.LatLng(longlat),
  zoom:10,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
const marker = new google.maps.Marker({
    // The below line is equivalent to writing:
    // position: new google.maps.LatLng(-34.397, 150.644)
    position: { lat: <?php echo $lat;?>,lng: <?php echo $long;?>},
    map: map,
  });
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlDjd-dYXyfFKfQeBtiQC09NSyUntIP1c&callback=myMap"></script>