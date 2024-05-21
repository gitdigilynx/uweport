<?php

global $wpdb;

$result2 = array();

$result1 = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gf_entry WHERE `form_id` = '2' ORDER BY `id` DESC ");

foreach ($result1 as $entry_form) {
    //   echo $entry_form->id;

    $result2[] = GFAPI::get_entry($entry_form->id);
}

?>
<div class="dashboar_container">

    <?php
    if ($_GET['post_entry']) {

        $result4 = array();
        $result4[] = GFAPI::get_entry($_GET['post_entry']);
        $sql = $wpdb->prepare("select e.created_by from {$wpdb->prefix}gf_entry e where e.id = %d
and e.created_by is not null limit 1;",  $_GET['post_entry']);

        $user_id = (int) $wpdb->get_var($sql);
        $Comapny_name = get_user_meta($user_id, 'company', true);
    ?>
        <div class="viewmore_detail mt-5" id="viewdetails">
            <div class="d-flex justify-content-between mb-4 align-items-start">
                <div>
                    <h2 class="blue-heading mb-0">View more details</h2>
                    <h3 class="company_name"><?php echo ($Comapny_name ? $Comapny_name : 'No Business'); ?></h3>
                </div>
                <a class="btn btn-primary close" href="<?php echo admin_url(); ?>/admin.php?page=customer_posts">Close</a>
            </div>
            <?php
            foreach ($result4 as $key => $entry_data) {

            ?>
                <div class="form_moredetail bg-light p-4">
                    <form>
                        <div class="row">
                            <div class="col-12  my-3">
                                <label>Subject</label>
                                <input type="text" placeholder="Cityabc" class="form-control" value="<?php echo $entry_data['15']; ?>" readonly>
                            </div>
                            <div class="col-12 col-md-6 my-3">
                                <label>City</label>
                                <input type="text" placeholder="Cityabc" class="form-control" value="<?php echo $entry_data['1']; ?>" readonly>
                            </div>
                            <div class="col-12 col-md-6 my-3">
                                <label>State</label>
                                <input type="text" placeholder="Stateabc" class="form-control" value="<?php echo $entry_data['3']; ?>" readonly>
                            </div>
                            <div class="col-12 my-3">
                                <label>Arrival Date</label>
                                <input type="text" placeholder="03/04/2023" class="form-control" value="<?php echo $entry_data['5']; ?>" readonly>
                            </div>
                            <div class="col-12 col-md-6 my-3">
                                <label>Equipment Size</label>
                                <input type="text" placeholder="20 feet container" class="form-control" value="<?php echo $entry_data['7']; ?>" readonly>
                            </div>
                            <div class="col-12 col-md-6 my-3">
                                <label>Load Method</label>
                                <input type="text" placeholder="Floor loaded" class="form-control" value="<?php echo $entry_data['14']; ?>" readonly>
                            </div>
                            <div class="col-12 col-md-6 my-3">
                                <label>Shipping From</label>
                                <input type="text" placeholder="locationabc" class="form-control" value="<?php echo $entry_data['10']; ?>" readonly>
                            </div>
                            <div class="col-12 col-md-6 my-3">
                                <label>Deliver To</label>
                                <input type="text" placeholder="locationefc" class="form-control" value="<?php echo $entry_data['11']; ?>" readonly>
                            </div>
                            <div class="col-12 my-3">
                                <label>Message</label>
                                <textarea type="text" placeholder="description will show here" class="form-control" readonly><?php echo $entry_data['12']; ?></textarea>
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

                                        <a class="view-more mb-3 d-block px-3" traget="_blank" href='<?php echo esc_url($linksy); ?>'><?php echo $name; ?> </a>

                                    <?php
                                        // Path of the file stored under pathinfo
                                        // $myFile = pathinfo($linksy);

                                        // Show the file name
                                        // echo $myFile['basename'], "\n";
                                    }   ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>

    <?php } else { ?>


        <div class="d-flex">
            <h2 class="blue-heading">Customer Warehouse Needs Post</h2>

        </div>
        <div class="bg-white p-0 rounded listing_table mt-4">
            <table id="customer_post_enteries" class="">
                <thead>
                    <tr>
                        <th>S no</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Post date</th>
                        <th>Arrival date</th>
                        <th>Equipment size</th>
                        <th>Load Method</th>
                        <th>View More</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>


                    <?php
                    foreach ($result2 as $key => $entry_data) {

                        $no = $key;
                        $user_name = get_userdata($entry_data['created_by']);

                    ?>
                        <tr>
                            <td><?php echo ++$key; ?></td>
                            <td><?php echo $entry_data['1']; ?></td>
                            <td> <?php echo $entry_data['3']; ?></td>
                            <td><?php echo date("Y-m-d", strtotime($entry_data['date_created'])); ?></td>
                            <td><?php echo $entry_data['5']; ?></td>
                            <td><?php echo $entry_data['7']; ?></td>
                            <td> <?php echo $entry_data['14']; ?></td>
                            <td><a class="view-more btn btn-primary" href="<?php echo admin_url('admin.php?page=customer_posts&post_entry='); ?><?php echo $entry_data['id']; ?>">View More</a> </td>
                            <td><?php echo $user_name->data->user_login; ?></td>
                            <td><?php echo $user_name->data->user_email; ?></td>
                            <td> <?php echo get_user_meta($entry_data['created_by'], 'phone_number', true); ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    <?php  } ?>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#customer_post_enteries').DataTable({
            "order": [
                [0, "asc"]
            ],
            "pageLength": 10,
        });
    });
</script>