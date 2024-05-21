<?php
/* Template Name: Wharehouse Detail*/
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
if (isset($_GET["id"])) {
?>
    <div class="main-content">
        <div class="content-inner">
            <div id="filter_form" class="left-sidebar">
                <div class="left-inner">

                </div>
            </div>
            <div class="middel-content">
                <div class="md-6 2222">
                    <?php
                    $result4 = array();
                    $result4[] = GFAPI::get_entry($_GET['id']);

                    $sql = $wpdb->prepare("select e.created_by from {$wpdb->prefix}gf_entry e where e.id = %d
and e.created_by is not null limit 1;",  $_GET['id']);

                    $user_id = (int) $wpdb->get_var($sql);
                    $Comapny_name = get_user_meta($user_id, 'company', true);
                    $user_data = get_userdata($user_id);
                    $current_user = wp_get_current_user();    
                                
                    // echo "<pre>";
                    // print_r($current_user->ID);exit;
                    ?>
                    <div class="viewmore_detail mt-5" id="viewdetails">
                        <div class="d-flex justify-content-between mb-4 align-items-start">
                            <div>
                                <h2 class="blue-heading mb-0">View more details</h2>
                                <h3 class="company_name"><?php echo ($Comapny_name ? $Comapny_name : 'No Business'); ?></h3>
                            </div>
                            <a class="btn btn-primary close" href="../wharehouses">Back</a>
                        </div>
                        <?php
                        foreach ($result4 as $key => $entry_data) {

                        ?>
                            <div class="form_moredetail bg-light p-4">
                                <form>
                                    <div class="row">
                                        <div class="col-12  my-3">
                                            <label>Subject</label>
                                            <p><?php echo $entry_data['15']; ?></p>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <label>City</label>
                                            <p><?php echo $entry_data['1']; ?></p>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <label>State</label>
                                            <p><?php echo $entry_data['3']; ?></p>
                                        </div>
                                        <div class="col-12 my-3">
                                            <label>Arrival Date</label>
                                            <p><?php echo $entry_data['5']; ?></p>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <label>Equipment Size</label>
                                            <p><?php echo $entry_data['7']; ?></p>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <label>Load Method</label>
                                            <p><?php echo $entry_data['14']; ?></p>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <label>Shipping From</label>
                                            <p><?php echo $entry_data['10']; ?></p>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <label>Deliver To</label>
                                            <p><?php echo $entry_data['11']; ?></p>
                                        </div>
                                        <div class="col-12 my-3">
                                            <label>Message</label>
                                            <p><?php echo $entry_data['12']; ?></p>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <label>Attached Files</label>
                                            <?php
                                            $remove_first_square = trim($entry_data['13'], '[');
                                            $remove_last_square = trim($entry_data['13'], ']');
                                            // $remove_first_square = str_replace($entry_data['13'],'[', " ");
                                            // $remove_last_square = str_replace($remove_first_square,']', " ");
                                            $links = explode(',', $remove_last_square);

                                            ?>
                                            <div class="download_links">
                                                <?php
                                                foreach ($links as $key => $link) {
                                                    $linksy = trim($link, '[');
                                                    $myFile = pathinfo($linksy);
                                                    $basename = $myFile["basename"];
                                                    $name = str_replace('"', " ", $basename);

                                                ?>

                                                    <a class="view-more mb-3 d-block px-3" target="_blank" href='<?php echo esc_url($linksy); ?>'><?php echo $name; ?> </a>

                                                <?php
                                                }   ?>
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-12 my-3">
                                            <div class="contact_status">
                                                <p class="status_msg error">Please login first to contact this user!</p>
                                            </div>
                                            <div class="contact_button col-6 m-auto" data-currentUser="<?=$current_user->ID?>" data-email="<?=$user_data->data->user_email?>">
                                                <a class="view-more mb-3 d-block px-3 py-2" target="_blank" >Contact </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
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
<?php
} else {
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
                    foreach ($result2 as $key => $entry_data) {
                        $no = $key;
                        $user_name = get_userdata($entry_data['created_by']);
                        $created_date = strtotime($entry_data['date_created']);
                    ?>

                        <div class="blog-item home_items">
                            <h4><?= ucfirst(strtolower($user_name->data->user_login)) ?> is looking for a Wharehouse in <?= $entry_data['1'] ?></h4>
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
                                <p><?= $text ?></p>
                            </div>
                            <a class="custom-btn" href="#">See Details</a>
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
<?php
}
?>

<?php get_footer(); ?>