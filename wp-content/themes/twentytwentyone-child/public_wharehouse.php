<?php
/* Template Name: Public Wharehouse */
?>
<?php get_header();
$us_state_abbrevs_names = array(
    'AL' => 'ALABAMA',
    'AK' => 'ALASKA',
    'AS' => 'AMERICAN SAMOA',
    'AZ' => 'ARIZONA',
    'AR' => 'ARKANSAS',
    'CA' => 'CALIFORNIA',
    'CO' => 'COLORADO',
    'CT' => 'CONNECTICUT',
    'DE' => 'DELAWARE',
    'DC' => 'DISTRICT OF COLUMBIA',
    //'FM'=>'FEDERATED STATES OF MICRONESIA',
    'FL' => 'FLORIDA',
    'GA' => 'GEORGIA',
    'GU' => 'GUAM GU',
    'HI' => 'HAWAII',
    'ID' => 'IDAHO',
    'IL' => 'ILLINOIS',
    'IN' => 'INDIANA',
    'IA' => 'IOWA',
    'KS' => 'KANSAS',
    'KY' => 'KENTUCKY',
    'LA' => 'LOUISIANA',
    'ME' => 'MAINE',
    // 'MH'=>'MARSHALL ISLANDS',
    'MD' => 'MARYLAND',
    'MA' => 'MASSACHUSETTS',
    'MI' => 'MICHIGAN',
    'MN' => 'MINNESOTA',
    'MS' => 'MISSISSIPPI',
    'MO' => 'MISSOURI',
    'MT' => 'MONTANA',
    'NE' => 'NEBRASKA',
    'NV' => 'NEVADA',
    'NH' => 'NEW HAMPSHIRE',
    'NJ' => 'NEW JERSEY',
    'NM' => 'NEW MEXICO',
    'NY' => 'NEW YORK',
    'NC' => 'NORTH CAROLINA',
    'ND' => 'NORTH DAKOTA',
    // 'MP'=>'NORTHERN MARIANA ISLANDS',
    'OH' => 'OHIO',
    'OK' => 'OKLAHOMA',
    'OR' => 'OREGON',
    //'PW'=>'PALAU',
    'PA' => 'PENNSYLVANIA',
    'PR' => 'PUERTO RICO',
    'RI' => 'RHODE ISLAND',
    'SC' => 'SOUTH CAROLINA',
    'SD' => 'SOUTH DAKOTA',
    'TN' => 'TENNESSEE',
    'TX' => 'TEXAS',
    'UT' => 'UTAH',
    'VT' => 'VERMONT',
    'VI' => 'VIRGIN ISLANDS',
    'VA' => 'VIRGINIA',
    'WA' => 'WASHINGTON',
    'WV' => 'WEST VIRGINIA',
    'WI' => 'WISCONSIN',
    'WY' => 'WYOMING',
    //'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
    //'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
    // 'AP'=>'ARMED FORCES PACIFIC'
);
?>
<div class="main-content">
    <input type="hidden" id="template-check" value="wharehouse">
    <div class="content-inner">
        <div id="filter_form" class="left-sidebar">
            <div class="left-inner">
                <?php
                echo '<div class="services filter_box">';
                echo '<h4 class="filter_titles">Services</h4><div class="checkbox-list">';
                $terms = get_terms('services', array('hide_empty' => false, 'parent' => 0));
                foreach ($terms as $term) { ?>
                    <div class="checkbox-btn">
                        <input class="filter_fields" onchange="field_function()" id="<?php echo $term->term_id; ?>" data-term="<?php echo $term->slug; ?>" type="checkbox" data-id="<?php echo $term->term_id; ?>" name="term_cat" value="<?php echo $term->name; ?>">
                        <label for="<?php echo $term->term_id; ?>"> <?php echo $term->name; ?></label>
                    </div>
                <?php }
                echo "</div></div>";
                echo '<div class="certification filter_box">';
                echo '<h4 class="filter_titles">Certification</h4><div class="checkbox-list">';
                $terms = get_terms('certification', array('hide_empty' => false, 'parent' => 0));
                foreach ($terms as $term) { ?>
                    <div class="checkbox-btn">
                        <input class="filter_fields" onchange="field_function()" id="<?php echo $term->term_id; ?>" data-term="<?php echo $term->slug; ?>" type="checkbox" data-id="<?php echo $term->term_id; ?>" name="term_cat" value="<?php echo $term->name; ?>">
                        <label for="<?php echo $term->term_id; ?>"> <?php echo $term->name; ?></label>
                    </div>
                <?php }
                echo "</div></div>";
                echo '<div class="additional_service filter_box">';
                echo '<h4 class="filter_titles">Additional Service</h4><div class="checkbox-list">';
                $terms = get_terms('additional_service', array('hide_empty' => false, 'parent' => 0));
                foreach ($terms as $term) { ?>
                    <div class="checkbox-btn">
                        <input class="filter_fields" onchange="field_function()" id="<?php echo $term->term_id; ?>" data-term="<?php echo $term->slug; ?>" type="checkbox" data-id="<?php echo $term->term_id; ?>" name="term_cat" value="<?php echo $term->name; ?>">
                        <label for="<?php echo $term->term_id; ?>"> <?php echo $term->name; ?></label>
                    </div>
                <?php }
                echo "</div></div>";
                echo '<div class="commodity filter_box">';
                echo '<h4 class="filter_titles">Commodity</h4><div class="checkbox-list">';
                $terms = get_terms('commodity', array('hide_empty' => false, 'parent' => 0));
                foreach ($terms as $term) { ?>
                    <div class="checkbox-btn">
                        <input class="filter_fields" onchange="field_function()" id="<?php echo $term->term_id; ?>" data-term="<?php echo $term->slug; ?>" type="checkbox" data-id="<?php echo $term->term_id; ?>" name="term_cat" value="<?php echo $term->name; ?>">
                        <label for="<?php echo $term->term_id; ?>"> <?php echo $term->name; ?></label>
                    </div>
                <?php }
                echo "</div></div>";
                //  echo '<div class="area filter_box">';
                // echo '<h4 class="filter_titles">Square Feet</h4><div class="checkbox-list">';
                // $terms = get_terms('area', array( 'hide_empty' => false, 'parent' => 0 ));
                // foreach ($terms as $term) { 
                ?>
                <!--  <div class="checkbox-btn">
                    //         <input class="filter_fields" onchange="filter_function()" id="<?php //echo $term->term_id; 
                                                                                                ?>" data-term="<?php //echo $term->slug; 
                                                                                                                                            ?>" type="checkbox" data-id="<?php //echo $term->term_id; 
                                                                                                                                                                                                ?>" name="term_cat" value="<?php //echo $term->name; 
                                                                                                                                                                                                                                                        ?>">
                    //         <label for="<?php //echo $term->term_id; 
                                            ?>"> <?php //echo $term->name; 
                                                                                ?></label>
                    //     </div> -->
                <?php //}
                // echo "</div></div>";
                ?>
            </div>
        </div>
        <div class="middel-content">
            <!--   <form class="navbar-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="form-group">
                        <input type="text" name="s" class="form-control search-autocomplete" placeholder="Search">
                    </div>
                    <button type="submit" class="fa fa-search"></button>
                </form>  -->
            <div class="search">
                <!-- <input type="text" name="s" class="form-control search-autocomplete" placeholder="Search"> -->
                <!-- <input type="text" id="site-search" name="q" class="filter_fields "  onkeyup="filter_function()"*/ placeholder="Search Business/City" > -->
                <input type="text" id="site-search" name="q" class="filter_fields " placeholder="Search City" onkeyup="enable_search_btn()">
                <!-- -->
                <select class="search-btn" onchange="wharehouse_filter_function()">
                    <option value="">Select a state</option>
                    <?php foreach ($us_state_abbrevs_names as $key => $states) { ?>

                        <option value="<?php echo $key; ?>"><?php echo $key; ?></option>

                    <?php } ?>
                </select>
                <button class="custom-btn search-btn search-input-btn" onclick="wharehouse_filter_function()" disabled="disabled">Search</button>
            </div>
            <div class="md-6 2222">
                <h2 class="blue-heading">Warehouse Requests</h2>
                <?php 
                global $wpdb;

                // Determine the current page number
                if (get_query_var("paged")) {
                    $paged = get_query_var("paged");
                } elseif (get_query_var("page")) {
                    $paged = get_query_var("page");
                } else {
                    $paged = 1;
                }
                
                // Number of results per page
                $per_page = 5;
                
                // Calculate the offset
                $offset = ($paged - 1) * $per_page;
                
                // Fetch the total number of results (without limit)
                $total_results = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}gf_entry WHERE `form_id` = '2'");
                $total_pages = ceil($total_results / $per_page);
                
                // Fetch limited results for the current page
                $result1 = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}gf_entry WHERE `form_id` = '2' ORDER BY `id` DESC LIMIT %d OFFSET %d", $per_page, $offset));
                
                $result2 = array();
                foreach ($result1 as $entry_form) {
                    $result2[] = GFAPI::get_entry($entry_form->id);
                }
                foreach($result2 as $key => $entry_data){
                    $no = $key ;
                    $user_name = get_userdata( $entry_data['created_by'] );
                    $created_date = strtotime($entry_data['date_created']);
                    ?>

                    <div class="blog-item home_items">
                        <h4><?= ucfirst(strtolower($user_name->data->user_login))?> is looking for a Wharehouse in <?=$entry_data['1']?></h4>
                        <p class="icon-date"><img src="/wp-content/uploads/2023/05/calander_icon.png"><?php echo date("F j, Y", $created_date); ?></p>
                        <?php
                        $limit = 25;
                        $text = $entry_data['12'];
                        if (str_word_count($text, 0) > $limit) {
                            $arr = str_word_count($text, 2);
                            $pos = array_keys($arr);
                            $text = substr($text, 0, $pos[$limit]) . "...";
                            $text = force_balance_tags($text);
                        }
                        ?>
                        <div itemprop="description" class="shop_desc">
                            <p><?=$text?></p>
                        </div>
                        <a class="custom-btn" href="../wharehouse?id=<?=$entry_data['id']?>">See Details</a>
                    </div>
                
                <?php
                }
                ?>
                
                
                <div class="pagination">
                    <?php
                    $big = 999999999;
                    echo paginate_links([
                        "base" => str_replace($big, "%#%", esc_url(get_pagenum_link($big))),
                        "format" => "?paged=%#%",
                        "prev_text" => __(" Previous"),
                        "next_text" => __("Next "),
                        "current" => max(1, get_query_var("paged")),
                        "total" => $total_pages,
                    ]); ?>
                </div>
                
            </div>
        </div>
        <div class="right-sidebar">
            <!-- <h2 class="white-heading">Ads</h2> -->
            <?php if (is_active_sidebar('add_sidebar')) : ?>
                <div id="secondary" class="widget-area" role="complementary">
                    <?php dynamic_sidebar('add_sidebar'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>