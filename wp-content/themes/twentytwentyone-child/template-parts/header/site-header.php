<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>

<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">

	<?php get_template_part( 'template-parts/header/site-branding' ); ?>
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>
    <?php if(!wp_is_mobile()){   ?>
    <div class="Top_cities_filter top_cities for-desktop">
        <h3>Top Cities: </h3><div class="cities-list"><?php $terms =  get_terms( array(
            'taxonomy'   => 'top_cities',
            'hide_empty' => false,
            'orderby' => 'ASC',
        ) );
        foreach( $terms as $term ){?>
<div class="checkbox-btn">
            <input type="checkbox"  id="<?php echo $term->slug;?>" name="top_cities" class="cities_name filter_fields" data-id ="<?php echo $term->term_id;?>" data-name="<?php echo $term->name;?>" value="<?php echo $term->name;?>">
            <label for="<?php echo $term->slug;?>"><?php echo $term->name;?></label>
        </div>
            
        <?php  }?>
    </div>
    </div>
<?php }?>
</header><!-- #masthead -->
<?php if(wp_is_mobile()){   ?>
 <div class="Top_cities_filter top_cities for-mobile">
        <h3>Top Cities: </h3><div class="cities-list"><?php $terms =  get_terms( array(
            'taxonomy'   => 'top_cities',
            'hide_empty' => false,
            'orderby' => 'ASC',
        ) );
        foreach( $terms as $term ){?>

<div class="checkbox-btn">
            <input type="checkbox"  id="<?php echo $term->slug;?>" name="top_cities" class="cities_name filter_fields" data-id ="<?php echo $term->term_id;?>" data-name="<?php echo $term->name;?>" value="<?php echo $term->name;?>">
            <label for="<?php echo $term->slug;?>"><?php echo $term->name;?></label>
        </div>
            
        <?php  }?>
    </div>
    </div>
<?php }?>
