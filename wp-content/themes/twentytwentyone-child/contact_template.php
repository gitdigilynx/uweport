<?php /* Template Name: Contact */ ?>
<?php get_header();?>
<div class="main-content">
	<div class="content-inner">
			<div id = "filter_form" class="left-sidebar" >
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
		<div class="md-6 middel-content">
			<?php 
			// the_title();
			the_content();?>
		
		</div>
		<div class="md-3 right-sidebar">
			<h2 class="white-heading">Ads</h2>
			<?php if ( is_active_sidebar( 'add_sidebar' ) ) : ?>
    <div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar( 'add_sidebar' ); ?>
    </div>
<?php endif; ?>
	</div>
</div>

<?php get_footer();?>

