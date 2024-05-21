<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
</main><!-- #main -->
</div><!-- #primary -->
</div><!-- #content -->

<?php get_template_part('template-parts/footer/footer-widgets'); ?>

<footer id="colophon" class="site-footer">
    <?php if (is_active_sidebar('footer-top')) { ?>
        <div class="footer-left">
            <?php dynamic_sidebar('footer-top');  ?>
        </div>

    <?php   } ?>

    <?php if (is_active_sidebar('copyrights-footer')) { ?>
        <div class="copyrights-footer">
            <?php dynamic_sidebar('copyrights-footer');  ?>
        </div>

    <?php   } ?>




</footer><!-- #colophon -->

</div><!-- #page -->
<script type="text/javascript" id="zsiqchat">
    var $zoho = $zoho || {};
    $zoho.salesiq = $zoho.salesiq || {
        widgetcode: "6ab9fdc79f9fcf2e92e498f216026fc54bf08ccc853a369eeda106ebdb9202a3",
        values: {},
        ready: function() {}
    };
    var d = document;
    s = d.createElement("script");
    s.type = "text/javascript";
    s.id = "zsiqscript";
    s.defer = true;
    s.src = "https://salesiq.zoho.com/widget";
    t = d.getElementsByTagName("script")[0];
    t.parentNode.insertBefore(s, t);
</script>

<?php wp_footer(); ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    /* globals global */

    jQuery('#check').click(function() {
        // alert($(this).is(':checked'));
        jQuery(this).is(':checked') ? jQuery('#pippin_user_pass').attr('type', 'text') : jQuery('#pippin_user_pass').attr('type', 'password');
    });

    // jQuery(function($){
    // 	var searchRequest;
    // 	$('.search-autocomplete').autoComplete({
    // 		minChars: 2,
    // 		source: function(term, suggest){
    // 			try { searchRequest.abort(); } catch(e){}
    // 			searchRequest = $.post(global.ajax, { search: term, action: 'search_site' }, function(res) {
    // 				suggest(res.data);
    // 			});
    // 		}
    // 	});
    // });

    jQuery(document).ready(function() {

        jQuery('#post_enteries').DataTable({
            "order": [
                [0, "asc"]
            ],
            "pageLength": 10,
        });
        jQuery('#DataTables_Table_0').DataTable({
            "order": [
                [0, "asc"]
            ],
            "pageLength": 10,
        });


        jQuery('#arm_tm_table').DataTable({
            "order": [
                [1, "asc"]
            ],
            "pageLength": 10,
        });
    });

    jQuery(document).on('submit', '#edit_owner_form', function(e) {
        event.preventDefault();

        jQuery('.edit_owner_btn').attr("disabled", true);
        var formdata = jQuery('#edit_owner_form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: formdata,
            beforeSend: function() {
                jQuery(".edit_owner_btn").addClass("disable_button");
            },
            success: function(response) {
                jQuery('#warehouse_enteries').load(document.URL + ' #warehouse_enteries');
                jQuery(".edit_owner_btn").removeClass("disable_button");
                var dataresponse = JSON.parse(response);
                jQuery('html, body').animate({
                    scrollTop: jQuery("#notification").offset().top
                }, 2000);
                jQuery("#notification").css("display", "block");
                jQuery("#notification").addClass(dataresponse['owner']['status']);
                jQuery("#notification").html(dataresponse['owner']['msg']);
                jQuery('.edit_owner_btn').attr("disabled", false);
                //jQuery("#edit_owner_form")[0].reset();
                jQuery('.viewmore_detail').load(document.URL + ' .viewmore_detail');


            },
        });

    });

    jQuery(document).ready(function() {
        jQuery('.arm_user_current_membership_list_table ').DataTable({
            "order": [
                [1, "asc"]
            ],
            "pageLength": 10,
        });
    });


    //  function changeValue(newVal) {
    // let output = document.getElementById('output');
    //     output.innerHTML = "The selected input value in the range input is " + newVal;      

    //  }


    jQuery('.cities_name').on('change', function() {
        jQuery('.cities_name').not(this).prop('checked', false);
        if (jQuery(":checkbox[name='top_cities']").is(":checked")) {
            jQuery("option:selected").removeAttr("selected");
            var templete_check = jQuery("#template-check").val();
            if (templete_check) {
                topCityWharehouseFilter();
            } else {
                topCityFilter();
            }
            jQuery(".range-wrap").css("display", "block");
            //jQuery('.bubble').css( left: 100% + -7px );

            //resetSlider();

        } else {

            jQuery(".range-wrap").css("display", "none");
        }
    });

    function range_function() {
        var newval = jQuery('.bubble').val();
        var cities_name = jQuery(".top_cities input:checked").attr('data-name');
        var input_value = jQuery('#site-search').val();
        var optVal = jQuery(".search-btn option:selected").val();
        jQuery.ajax({
            type: "post",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: 'range_filter',
                //top_cities : cities,
                top_cities_name: cities_name,
                input: input_value,
                state: optVal,
                mile: newval,
            },
            beforeSend: function() {
                add_loader(".search");
            },
            success: function(res) {
                remove_loader(".search")

                jQuery(".md-6").html(res);
            },
        });

    }

    function topCityWharehouseFilter() {
        jQuery('#site-search').val('');

        var cities = jQuery(".top_cities input:checked").attr('data-id');
        var cities_name = jQuery(".top_cities input:checked").attr('data-name');

        jQuery.ajax({
            type: "post",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: 'toCityWharehouse_filter',
                top_cities: cities,
                top_cities_name: cities_name,
            },
            beforeSend: function() {
                add_loader(".search");
            },
            success: function(res) {
                remove_loader(".search")

                jQuery(".md-6").html(res);
            },
        });

    }

    function topCityFilter() {
        jQuery('#site-search').val('');

        var cities = jQuery(".top_cities input:checked").attr('data-id');
        var cities_name = jQuery(".top_cities input:checked").attr('data-name');
        var commodity = [];
        jQuery.each(jQuery(".commodity input:checked"), function() {
            commodity.push(jQuery(this).attr('data-id'));
        });
        var certification = [];
        jQuery.each(jQuery(".certification input:checked"), function() {
            certification.push(jQuery(this).attr('data-id'));
        });
        var additional_service = [];
        jQuery.each(jQuery(".additional_service input:checked"), function() {
            additional_service.push(jQuery(this).attr('data-id'));
        });
        var services = [];
        jQuery.each(jQuery(".services input:checked"), function() {
            services.push(jQuery(this).attr('data-id'));
        });
        var miles = parseInt(jQuery(".range").val());
        if (isNaN(miles) || (miles <= 10)) {
            miles = "";
        }
        jQuery.ajax({
            type: "post",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: 'toCity_filter',
                top_cities: cities,
                top_cities_name: cities_name,
                commodity: commodity,
                certification: certification,
                additional_service: additional_service,
                services: services,
                //top_cities : cities,
                //area: area,
                miles: jQuery('.bubble').val(),
            },
            beforeSend: function() {
                add_loader(".search");
            },
            success: function(res) {
                remove_loader(".search")

                jQuery(".md-6").html(res);
            },
        });

    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function enable_search_btn() {
        var input_field = jQuery('#site-search').val();
        if (input_field.length >= 1) {
            jQuery(".search-input-btn").attr("disabled", false);
            jQuery('.cities_name:checked').removeAttr('checked');

        }

    }

    function field_function() {
        if (jQuery('input.cities_name').is(':checked')) {
            topCityFilter();

        } else {
            filter_function();
        }


    }

    function wharehouse_filter_function() {
        var input_field = jQuery('#site-search').val();
        if (input_field.length >= 1) {
            jQuery(".search-input-btn").attr("disabled", false);
            jQuery('.cities_name:checked').removeAttr('checked');
        } else {
            jQuery(".search-input-btn").attr("disabled", true);
        }
        var optVal = jQuery(".search-btn option:selected").val();
        jQuery.ajax({
            type: "post",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: 'wharehouse_product_filter',
                city: input_field,
                state: optVal,
            },
            beforeSend: function() {
                add_loader(".search");
            },
            success: function(res) {
                remove_loader(".search")

                jQuery(".md-6").html(res);
            },
        });
    }


    function filter_function() {
        var input_field = jQuery('#site-search').val();
        if (input_field.length >= 1) {
            jQuery(".search-input-btn").attr("disabled", false);
            jQuery('.cities_name:checked').removeAttr('checked');
        } else {
            jQuery(".search-input-btn").attr("disabled", true);
        }
        var optVal = jQuery(".search-btn option:selected").val();

        //jQuery('.cities_name:checked').removeAttr('checked');
        var commodity = [];
        jQuery.each(jQuery(".commodity input:checked"), function() {
            commodity.push(jQuery(this).attr('data-id'));
        });
        var certification = [];
        jQuery.each(jQuery(".certification input:checked"), function() {
            certification.push(jQuery(this).attr('data-id'));
        });
        var additional_service = [];
        jQuery.each(jQuery(".additional_service input:checked"), function() {
            additional_service.push(jQuery(this).attr('data-id'));
        });
        var services = [];
        jQuery.each(jQuery(".services input:checked"), function() {
            services.push(jQuery(this).attr('data-id'));
        });
        var miles = parseInt(jQuery(".range").val());
        if (isNaN(miles) || (miles <= 10)) {
            miles = "";
        }

        // if (jQuery('input.cities_name').is(':checked') &&  jQuery(commodity.length==0) && jQuery(certification.length==0) && jQuery(additional_service.length==0) && jQuery(services.length==0)) {
        // topCityFilter();
        // return;


        //	 }
        jQuery.ajax({
            type: "post",
            //dataType: "json",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: 'product_filter',
                commodity: commodity,
                certification: certification,
                additional_service: additional_service,
                services: services,
                //top_cities : cities,
                //area: area,
                miles: jQuery('.bubble').val(),
                input: jQuery('#site-search').val(),
                state: optVal,
            },
            beforeSend: function() {
                add_loader(".search");
            },
            success: function(res) {
                remove_loader(".search")

                jQuery(".md-6").html(res);
            },
        });

        // }

        // else{
        // 		jQuery.ajax({
        // 			type: "post",
        // 			//dataType: "json",
        // 			url: "<?php echo admin_url('admin-ajax.php'); ?>",
        // 			data: {
        // 				action: 'blog_data',          
        // 			},
        // 			beforeSend: function() {},
        // 			success: function(res) {

        // 				jQuery(".md-6").html(res);
        // 			},
        // 		});
        // }
    }

    jQuery(document).ready(function($) {
        var owl = jQuery('.thumbnail_slider');
        owl.owlCarousel({
            items: 2,
            loop: true,
            navigation: true,
            autoplay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            navigationText: ["<img alt='down' src='/wp-content/uploads/2023/05/arrow.png'>", "<img alt='down' src='/wp-content/uploads/2023/05/arrow.png'>"]

        });

        jQuery('.filter_titles').click(function() {

            if (jQuery(this).hasClass('active')) {

                jQuery(this).removeClass('active');
                jQuery(this).siblings('.checkbox-list').removeClass('open');
            } else {

                jQuery('.left-inner .filter_box').each(function() {
                    jQuery('.filter_titles ').removeClass('active');
                    jQuery('.checkbox-list').removeClass('open');
                });
                jQuery(this).addClass('active');
                jQuery(this).siblings('.checkbox-list').addClass('open');
            }
        });
        jQuery('.contact_button').click(function() {
            if (!jQuery(this).hasClass("disabled")) {
                var elem = jQuery(this);
                jQuery(this).addClass("disabled");
                var cur_user_id = jQuery(this).attr("data-currentuser");
                var user_email = jQuery(this).attr("data-email");
                if (cur_user_id == 0) {
                    jQuery('.status_msg').removeClass('success').addClass('error').text("Please login first to contact this user!");
                    jQuery('.contact_status').fadeIn('slow', function() {
                        jQuery(this).delay(5000).fadeOut('slow');
                    });
                } else {
                    jQuery.ajax({
                        type: "post",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: 'wharehouse_contact_request',
                            userId: cur_user_id,
                            userEmail: user_email,
                        },
                        success: function(res) {
                            elem.removeClass("disabled");
                            jQuery('.status_msg').removeClass('error').addClass('success').text(res.message);
                            jQuery('.contact_status').fadeIn('slow', function() {
                                jQuery(this).delay(5000).fadeOut('slow');
                            });
                        },
                    });
                }
            }
        });
    });




    const allRanges = document.querySelectorAll(".range-wrap");
    allRanges.forEach(wrap => {
        const range = wrap.querySelector(".range");
        const bubble = wrap.querySelector(".bubble");

        range.addEventListener("input", () => {
            setBubble(range, bubble);
        });
        setBubble(range, bubble);

    });

    function setBubble(range, bubble) {
        const val = range.value;
        const min = range.min ? range.min : 0;
        const max = range.max ? range.max : 100;
        const newVal = Number(((val - min) * 100) / (max - min));
        bubble.innerHTML = val + ' miles';
        bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
    }



    // user profile page script

    jQuery('.dynamic-id').each(function(i, e) {
        jQuery(this).attr("id", "id_" + i);
    });
    jQuery('.dynamic-target').children().each(function(i, e) {
        jQuery(this).attr("data-target", "id_" + i);
    });

    jQuery('.dynamic-target span').click(function() {
        jQuery(this).addClass('active').siblings().removeClass('active');
        var target = jQuery(this).attr('data-target');
        jQuery('#' + target).slideDown().siblings().slideUp();
    });


    jQuery('.gfield_label').click(function() {
        jQuery(this).siblings('.ginput_container_radio, .ginput_container_checkbox').slideToggle();
    });
    jQuery('.gchoice').click(function() {
        var text = jQuery(this).find('label').text();
        jQuery(this).parents('.ginput_container_radio').slideUp().siblings('.gfield_label').text(text);
        jQuery(this).parents('.ginput_container_checkbox').siblings('.gfield_label').text(text);
    });



    function add_loader(parent_div, position_absolute = false) {
        var position = '';
        if (position_absolute == true) {
            var position = 'position-absolute';
        }
        if (!jQuery(parent_div).find('.spinner_wrapper').length) {
            jQuery(parent_div).append('<div class="spinner_wrapper"><div class="spinner_overlay"></div><div class="spinner_container ' + position + '"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div></div>');
        }
    }

    function remove_loader(parent_div) {
        if (jQuery(parent_div).find('.spinner_wrapper').length) {
            jQuery(parent_div).find('.spinner_wrapper').remove();
        }
    }
</script>
<style>
    @charset "UTF-8";

    #wpfooter {
        display: none
    }

    #adminmenuwrap {
        margin-bottom: -3px
    }

    #adminmenuback {
        z-index: 0
    }

    #wpwrap {
        background-color: var(--arm-cl-white)
    }

    a {
        color: var(--arm-dt-black-300);
        text-decoration: none;
        transition: none
    }

    .woocommerce-message {
        display: none !important
    }

    .disabled {
        opacity: .6;
        cursor: text
    }

    .arm_page_wrapper {
        margin: 0;
        font-size: 15px;
        line-height: 24px;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        color: #5c5c60;
        font-weight: 400;
        font-style: normal;
        font-variant: normal
    }

    .arm_admin_notices_container {
        background: var(--arm-cl-white);
        border-left: 4px solid #4dd2e2;
        -webkit-box-shadow: 0 0 1px 1px #eef1f2;
        -moz-box-shadow: 0 0 1px 1px #eef1f2;
        -o-box-shadow: 0 0 1px 1px #eef1f2;
        box-shadow: 0 0 1px 1px #eef1f2;
        margin: 10px 15px 5px;
        padding: 5px;
        border-radius: 2px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -o-border-radius: 2px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: block
    }

    .arm_admin_notices_container ul {
        margin: 0;
        padding: 0
    }

    .arm_admin_notices li {
        margin: 3px 0;
        padding: 5px;
        border: 1px solid transparent;
        border-radius: 1px;
        -webkit-border-radius: 1px;
        -moz-border-radius: 1px;
        -o-border-radius: 1px
    }

    .arm_admin_notices .arm_notice_success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6
    }

    .arm_admin_notices .arm_notice_error {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1
    }

    .arm_admin_notices .arm_notice_info {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1
    }

    .arm_admin_notices .arm_notice_warning {
        color: #8a6d3b;
        background-color: #fcf8e3;
        border-color: #faebcc
    }

    .arm_ref_info_links,
    .arm_ref_info_links:focus,
    .arm_ref_info_links:hover,
    a.arm_ref_info_links,
    a.arm_ref_info_links:focus,
    a.arm_ref_info_links:hover {
        color: var(--arm-pt-theme-blue);
        font-weight: 700;
        text-decoration: none;
        outline: 0;
        border: 0;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none
    }

    .page_sub_content {
        padding: 0 40px;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 100%
    }

    .arm_page [ng-messages] {
        display: none
    }

    .arm_page .postbox {
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        border-radius: 3px
    }

    .arm_page_title_link {
        float: right;
        display: inline-block;
        font-size: 16px;
        text-decoration: none
    }

    .wrap.arm_feature_settings_main_wrapper {
        background: #eef2f8
    }

    .wrap.arm_manage_form_main_wrapper {
        position: relative;
        padding: 0
    }

    .armember_page_arm_manage_forms #adminmenuwrap:hover {
        z-index: 10000
    }

    .border_top {
        border-top: #4dd2e2 2px solid
    }

    .wrap h2 {
        font-size: 23px;
        font-weight: 400;
        line-height: 29px
    }

    .arm_add_payment_cycle_link,
    .arm_login_conditional_redirection_add_new_condition,
    .arm_setup_signup_conditional_redirection_add_new_condition.arm_edit_profile_conditional_redirection_add_new_condition,
    .arm_signup_conditional_redirection_add_new_condition {
        font-size: 16px;
        text-decoration: none
    }

    .paid_subscription_options_recurring_payment_cycles_child_box {
        width: 61%;
        margin-bottom: 10px;
        float: left;
        margin-left: 10px
    }

    .paid_subscription_options_recurring_payment_cycles_child_box th {
        min-width: 100px !important;
        width: 113px !important
    }

    .paid_subscription_options_recurring_payment_cycles_main_box {
        float: left;
        width: 100%
    }

    .paid_subscription_options_recurring_payment_cycle_switch {
        float: left;
        margin-top: 7px
    }

    .paid_subscription_options_recurring_payment_cycles_link {
        float: left;
        width: 100%
    }

    .arm_remove_login_redirection_condition {
        float: right;
        font-size: 22px;
        margin: 7px 11px 5px 10px;
        right: 70px;
        text-decoration: none
    }

    .arm_remove_edit_profile_redirection_condition,
    .arm_remove_setup_signup_redirection_condition,
    .arm_remove_signup_redirection_condition {
        float: right;
        font-size: 22px;
        margin: 5px 10px;
        right: 70px;
        text-decoration: none
    }

    .arm_remove_recurring_payment_cycle {
        float: right;
        font-size: 22px;
        margin: 0 10px;
        position: absolute;
        right: 28px;
        text-decoration: none
    }

    .arm_plan_cycle_no {
        float: left;
        position: absolute;
        font-size: 15px;
        background-color: #09c4e3;
        color: var(--arm-cl-white);
        padding: 0 15px;
        left: 0;
        border-bottom-right-radius: 5px;
        border-top-left-radius: 5px;
        font-weight: 700
    }

    .arm_colorpicker_label {
        max-width: 120px;
        width: 120px;
        height: 34px;
        max-height: 35px;
        padding: 0;
        margin-bottom: 5px !important;
        text-align: right;
        display: inline-block !important;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-shadow: 0 0 1px 1px #dbe1e8;
        -moz-box-shadow: 0 0 1px 1px #dbe1e8;
        -o-box-shadow: 0 0 1px 1px #dbe1e8;
        box-shadow: 0 0 1px 1px #dbe1e8;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        cursor: pointer
    }

    .arm_colorpicker {
        font-size: 13px;
        width: 85px;
        max-width: 85px;
        height: 100%;
        margin: 0 -1px 0 30px !important;
        padding: 5px !important;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        background: 0 0;
        border: 1px solid #dbe1e8 !important;
        border-width: 0 1px 0 1px !important;
        border-top-right-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        -webkit-border-bottom-right-radius: 5px;
        -moz-border-bottom-right-radius: 5px;
        -o-border-bottom-right-radius: 5px
    }

    button:focus {
        -webkit-box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        -moz-box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        -o-box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -ms-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
        outline: 0 !important
    }

    input[type=checkbox].disabled,
    input[type=checkbox].disabled:checked:before,
    input[type=checkbox]:disabled,
    input[type=checkbox]:disabled:checked:before,
    input[type=radio].disabled,
    input[type=radio].disabled:checked:before,
    input[type=radio]:disabled,
    input[type=radio]:disabled:checked:before {
        opacity: .7
    }

    input:-webkit-autofill,
    select:-webkit-autofill,
    textarea:-webkit-autofill {
        background-color: var(--arm-cl-white) !important
    }

    option {
        padding: 5px;
        min-height: 25px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_email_helptip_icon,
    .arm_helptip_icon:not(.arm_add_plan_icon, .armemailaddbtn),
    i.arm_email_helptip_icon,
    i.arm_helptip_icon:not(.arm_add_plan_icon, .armemailaddbtn),
    span.arm_email_helptip_icon,
    span.arm_helptip_icon:not(.arm_add_plan_icon, .armemailaddbtn) {
        cursor: pointer;
        color: var(--arm-gt-gray-300);
        font-size: 16px;
        font-weight: 700;
        height: 20px;
        width: 20px;
        text-align: center;
        vertical-align: middle;
        line-height: 20px
    }

    .arm_left {
        float: left
    }

    .arm_right {
        float: right
    }

    .arm_table_label_on_top {
        padding-top: 15px;
        padding-bottom: 15px
    }

    .arm_table_label_on_top tr {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_table_label_on_top tr td,
    .arm_table_label_on_top tr th {
        display: inline-block;
        float: left;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 5px 20px 12px
    }

    .arm_table_label_on_top tr th {
        text-align: left;
        padding: 10px 20px 0 20px;
        color: var(--arm-dt-black-300);
        font-size: 14px;
        font-weight: 500;
        vertical-align: top
    }

    .add_new_user_badges_wrapper .arm_table_label_on_top tr th,
    .arm_add_achievements_wrapper .arm_table_label_on_top tr th,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr th {
        padding: 10px 20px 5px 20px
    }

    .arm_table_label_on_top .chosen-container {
        min-width: 500px;
        margin-bottom: 2px
    }

    .arm_add_new_drip_rule_wrapper_frm .arm_table_label_on_top .chosen-container,
    .arm_edit_drip_rule_wrapper_frm .arm_table_label_on_top .chosen-container {
        max-width: 100% !important;
        width: 100% !important
    }

    .arm-row-actions {
        color: #ddd;
        font-size: 13px;
        padding: 2px 0 0
    }

    .arm-row-actions a {
        margin-right: 9px;
        display: inline-block;
        height: 20px;
        width: 17px;
        vertical-align: middle
    }

    .arm_members_list_detail_popup_text #armember_datatable_1_wrapper .dataTables_paginate,
    .arm_members_list_detail_popup_text #armember_datatable_2_wrapper .dataTables_paginate,
    .arm_members_list_detail_popup_text #example_1_wrapper .dataTables_paginate {
        margin: 0
    }

    .arm_members_list_detail_popup_text #armember_datatable_1_wrapper .ui-widget-header,
    .arm_members_list_detail_popup_text #armember_datatable_1_wrapper div.footer,
    .arm_members_list_detail_popup_text #armember_datatable_2_wrapper .ui-widget-header,
    .arm_members_list_detail_popup_text #armember_datatable_2_wrapper div.footer,
    .arm_members_list_detail_popup_text #example_1_wrapper .ui-widget-header,
    .arm_members_list_detail_popup_text #example_1_wrapper div.footer {
        padding: 14px 15px;
        width: calc(100% - 30px)
    }

    .arm_members_list_detail_popup_text #armember_datatable_1_wrapper .dataTables_info,
    .arm_members_list_detail_popup_text #armember_datatable_2_wrapper .dataTables_info,
    .arm_members_list_detail_popup_text #example_1_wrapper .dataTables_info {
        width: auto;
        padding: 5px 0
    }

    #armember_datatable_1_wrapper #armember_datatable_1_length,
    #example_1_wrapper #example_1_length,
    .wrap #armember_datatable_wrapper #armember_datatable_length,
    .wrap #example_wrapper #example_length {
        width: auto;
        float: right;
        margin-top: 3px
    }

    #armember_datatable_1_wrapper #armember_datatable_1_filter,
    #armember_datatable_2_wrapper #armember_datatable_2_filter,
    #example_1_wrapper #example_1_filter,
    .wrap #armember_datatable_1_wrapper #armember_datatable_1_filter,
    .wrap #armember_datatable_2_wrapper #armember_datatable_2_filter,
    .wrap #armember_datatable_wrapper #armember_datatable_filter,
    .wrap #example_1_wrapper #example_1_filter,
    .wrap #example_wrapper #example_filter {
        float: right;
        width: auto;
        margin: 0
    }

    #armember_datatable_1_filter #armmanagesearch,
    #example_1_filter #armmanagesearch,
    .wrap #armember_datatable_1_filter #armmanagesearch,
    .wrap #armember_datatable_filter #armmanagesearch,
    .wrap #example_1_filter #armmanagesearch,
    .wrap #example_filter #armmanagesearch {
        color: #5c5c60;
        border: 1px solid #dbe1e8;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        min-width: 250px;
        height: 35px;
        padding: 0 10px 0 35px;
        margin: 0 0 0 10px;
        background-image: url(../images/search_icon.png);
        background-repeat: no-repeat;
        background-position: 10px center;
        outline: 0 !important;
        box-shadow: none
    }

    .arm_datatable_filters_options {
        display: inline-block
    }

    .arm_datatable_filters .arm_dt_filter_fields {
        float: right
    }

    #arm_search_coupon_filter_item.arm_datatable_searchbox input:not([type=checkbox]) {
        width: 170px
    }

    #paid_post_transactions_list_form .arm_datatable_filters div .arm_filter_ppstatus_label {
        position: relative
    }

    .arm_datatable_filters select {
        padding-left: 5px;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border: 1px solid #e4e5e5;
        height: 35px;
        cursor: pointer
    }

    #armember_datatable_1_wrapper tr.odd .dataTables_empty,
    #armember_datatable_2_wrapper tr.odd .dataTables_empty,
    #example_1_wrapper tr.odd .dataTables_empty,
    .wrap #armember_datatable_1_wrapper tr.odd .dataTables_empty,
    .wrap #armember_datatable_2_wrapper tr.odd .dataTables_empty,
    .wrap #armember_datatable_wrapper tr.odd .dataTables_empty,
    .wrap #example_1_wrapper tr.odd .dataTables_empty,
    .wrap #example_wrapper tr.odd .dataTables_empty {
        height: 40px;
        vertical-align: middle;
        text-align: center !important
    }

    .arm_filter_wrapper {
        float: left;
        margin-right: 15px
    }

    .arm_email_templates_list #armember_datatable_wrapper table.dataTable tr td:first-child,
    .arm_email_templates_list #armember_datatable_wrapper table.dataTable tr th:first-child,
    .arm_email_templates_list #example_wrapper table.dataTable tr td:first-child,
    .arm_email_templates_list #example_wrapper table.dataTable tr th:first-child,
    .arm_members_list_detail_popup_text #armember_datatable_1_wrapper table.dataTable tr td:first-child,
    .arm_members_list_detail_popup_text #armember_datatable_1_wrapper table.dataTable tr th:first-child,
    .arm_members_list_detail_popup_text #armember_datatable_2_wrapper table.dataTable tr td:first-child,
    .arm_members_list_detail_popup_text #armember_datatable_2_wrapper table.dataTable tr th:first-child,
    .arm_members_list_detail_popup_text #example_1_wrapper table.dataTable tr td:first-child,
    .arm_members_list_detail_popup_text #example_1_wrapper table.dataTable tr th:first-child,
    .arm_membership_setups_list #armember_datatable_wrapper table.dataTable tr td:first-child,
    .arm_membership_setups_list #armember_datatable_wrapper table.dataTable tr th:first-child,
    .arm_membership_setups_list #example_wrapper table.dataTable tr td:first-child,
    .arm_membership_setups_list #example_wrapper table.dataTable tr th:first-child,
    .arm_paid_posts_list #armember_datatable_wrapper table.dataTable tr td:first-child,
    .arm_paid_posts_list #armember_datatable_wrapper table.dataTable tr th:first-child,
    .arm_subscription_plans_list #armember_datatable_wrapper table.dataTable tr td:first-child,
    .arm_subscription_plans_list #armember_datatable_wrapper table.dataTable tr th:first-child,
    .arm_subscription_plans_list #example_wrapper table.dataTable tr td:first-child,
    .arm_subscription_plans_list #example_wrapper table.dataTable tr th:first-child,
    .wrap #armember_datatable_wrapper table.dataTable.arm_achievements_list_grid tr td:first-child,
    .wrap #armember_datatable_wrapper table.dataTable.arm_achievements_list_grid tr th:first-child,
    .wrap #example_wrapper table.dataTable.arm_achievements_list_grid tr td:first-child,
    .wrap #example_wrapper table.dataTable.arm_achievements_list_grid tr th:first-child {
        padding-left: 20px;
        text-align: left
    }

    .cb-select-all-th .DataTables_sort_wrapper {
        padding: 0 !important
    }

    .arm_grid_td_arm_switch,
    .arm_grid_th_arm_switch {
        max-width: 90px;
        width: 90px
    }

    #armember_datatable_1_wrapper tr td.arm_grid_td_avatar,
    #example_1_wrapper tr td.arm_grid_td_avatar,
    .wrap #armember_datatable_1_wrapper tr td.arm_grid_td_avatar,
    .wrap #armember_datatable_wrapper tr td.arm_grid_td_avatar,
    .wrap #example_1_wrapper tr td.arm_grid_td_avatar,
    .wrap #example_wrapper tr td.arm_grid_td_avatar {
        text-align: center;
        padding-top: 0 !important;
        padding-bottom: 0 !important
    }

    #armember_datatable_1_wrapper .form_entries a,
    #armember_datatable_2_wrapper .form_entries a,
    #example_1_wrapper .form_entries a,
    .wrap #armember_datatable_1_wrapper .form_entries a,
    .wrap #armember_datatable_2_wrapper .form_entries a,
    .wrap #armember_datatable_wrapper .form_entries a,
    .wrap #example_1_wrapper .form_entries a,
    .wrap #example_wrapper .form_entries a {
        color: #113e71;
        text-decoration: none
    }

    #armember_datatable_1_wrapper tr.even td.sorting_1,
    #armember_datatable_1_wrapper tr.odd td.sorting_1,
    #armember_datatable_2_wrapper tr.even td.sorting_1,
    #armember_datatable_2_wrapper tr.odd td.sorting_1,
    #example_1_wrapper tr.even td.sorting_1,
    #example_1_wrapper tr.odd td.sorting_1,
    .wrap #armember_datatable_1_wrapper tr.even td.sorting_1,
    .wrap #armember_datatable_1_wrapper tr.odd td.sorting_1,
    .wrap #armember_datatable_2_wrapper tr.even td.sorting_1,
    .wrap #armember_datatable_2_wrapper tr.odd td.sorting_1,
    .wrap #armember_datatable_wrapper tr.even td.sorting_1,
    .wrap #armember_datatable_wrapper tr.odd td.sorting_1,
    .wrap #example_1_wrapper tr.even td.sorting_1,
    .wrap #example_1_wrapper tr.odd td.sorting_1,
    .wrap #example_wrapper tr.even td.sorting_1,
    .wrap #example_wrapper tr.odd td.sorting_1 {
        background: 0 0
    }

    #armember_datatable_1_wrapper div.ColVis,
    #example_1_wrapper div.ColVis,
    .wrap #armember_datatable_1_wrapper div.ColVis,
    .wrap #armember_datatable_wrapper div.ColVis,
    .wrap #example_1_wrapper div.ColVis,
    .wrap #example_wrapper div.ColVis {
        margin-bottom: 0
    }

    .wrap #armember_datatable_1_wrapper tr td[data-key=armGridActionTD],
    .wrap #armember_datatable_1_wrapper tr th[data-key=armGridActionTD],
    .wrap #armember_datatable_wrapper tr td[data-key=armGridActionTD],
    .wrap #armember_datatable_wrapper tr th[data-key=armGridActionTD],
    .wrap #example_wrapper tr td[data-key=armGridActionTD],
    .wrap #example_wrapper tr th[data-key=armGridActionTD] {
        visibility: hidden;
        position: absolute !important;
        right: 2px;
        background: 0 0 !important;
        border: 0 !important;
        padding: 0 !important;
        height: auto !important;
        box-shadow: none !important;
        vertical-align: middle
    }

    .wrap_content {
        margin-top: 65px;
        margin-left: 35px;
        margin-right: 30px;
        padding: 25px;
        background-color: var(--arm-cl-white);
        border: solid 1px #d8d8d8;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -o-border-radius: 10px;
        border-radius: 10px
    }

    .arm_confirm_back_wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #fbfbfb;
        opacity: .5;
        z-index: 9991
    }

    .arm_confirm_box_plan_change {
        display: none;
        position: absolute;
        margin-top: 6px;
        font-size: 16px;
        font-weight: 400;
        z-index: 9992
    }

    .arm_confirm_box.arm_confirm_box_arm_clear_login,
    .arm_confirm_box.arm_confirm_box_arm_clear_login_history {
        left: 0;
        right: 0
    }

    .arm_confirm_box.arm_confirm_box_arm_clear_login .arm_confirm_box_arrow,
    .arm_confirm_box.arm_confirm_box_arm_clear_login_history .arm_confirm_box_arrow {
        float: left
    }

    .arm_confirm_box_add_user_achievements {
        margin: 20px 10px 0 0
    }

    [dir=rtl] .arm_confirm_box_add_user_achievements {
        margin: 20px 0 0 10px;
        left: 0;
        right: auto
    }

    [dir=rtl] .arm_confirm_box_add_user_achievements .arm_confirm_box_arrow {
        float: left
    }

    .arm_confirm_box.arm_member_edit_confirm_box .arm_confirm_box_arrow {
        float: left
    }

    .arm_user_plan_change_action_btn {
        margin-left: 20px;
        text-decoration: none
    }

    .arm_confirm_box_btn_container {
        margin-top: 10px
    }

    .arm_confirm_box_btn.arm_change_user_status_ok_btn,
    .arm_confirm_box_btn.arm_resend_verify_email_ok_btn {
        margin: 0 10px 0 0;
        color: var(--arm-cl-white)
    }

    .wrap .h2 {
        color: #353942;
        font-weight: 400;
        line-height: normal;
        font-size: 30px;
        text-shadow: none
    }

    .wrap .h2-img {
        display: none
    }

    #armember_datatable_1_wrapper #armember_datatable_1_paginate .ui-state-default,
    #example_1_wrapper #example_1_paginate .ui-state-default,
    .wrap #armember_datatable_1_wrapper #armember_datatable_1_paginate .ui-state-default,
    .wrap #armember_datatable_wrapper #armember_datatable_paginate .ui-state-default,
    .wrap #example_1_wrapper #example_1_paginate .ui-state-default,
    .wrap #example_wrapper #example_paginate .ui-state-default {
        height: 24px
    }

    .dotted_line {
        border-bottom: 2px solid #e3e4e7
    }

    .actions {
        overflow: visible;
        padding: 5px 0;
        margin-bottom: 20px
    }

    .actions2 {
        overflow: visible;
        padding: 5px 0;
        margin-bottom: 5px;
        margin-top: 20px
    }

    .btn_sld {
        font-weight: 400;
        font-size: 17px;
        cursor: pointer;
        background: var(--arm-cl-white);
        padding: 0;
        border: 1px solid #dee0e1;
        border-bottom: none;
        height: 54px;
        color: #353942;
        border-radius: 0;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0;
        -o-border-radius: 0;
        width: 217px
    }

    .active_button {
        float: left;
        display: none;
        background-repeat: no-repeat;
        background-position: bottom center;
        height: 52px
    }

    .arm_member_change_to_plan_wrapper,
    .wrap .sltstandard {
        display: inline-block;
        margin-right: 10px;
        vertical-align: top
    }

    .wrap .arm_member_coupon_report_chart .sltstandard {
        margin-right: 0
    }

    .wrap .btn-group .armbtn.dropdown-toggle {
        color: #5c5c60;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #dbe1e8;
        background-color: var(--arm-cl-white);
        background-image: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        padding-left: 15px;
        min-width: 140px;
        height: 35px;
        vertical-align: middle
    }

    .wrap .btn-group .armbtn.dropdown-toggle:focus {
        outline: 0 !important
    }

    .wrap .btn-group.open .armbtn.dropdown-toggle {
        background-color: var(--arm-cl-white);
        background-image: none;
        border-bottom-left-radius: 0;
        -webkit-border-bottom-left-radius: 0px;
        -moz-border-radius-bottomleft: 0px;
        border-bottom-right-radius: 0;
        -webkit-border-bottom-right-radius: 0px;
        -moz-border-radius-bottomright: 0px;
        -webkit-box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        -moz-box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        -o-box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        box-shadow: 0 0 2px rgba(81, 203, 238, .5);
        border: 1px solid #53e2f3;
        transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -ms-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
        outline: 0 !important
    }

    .wrap .btn-group.open .armdropdown-menu {
        border: solid 1px #53e2f3;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        border-top: none;
        margin: 0;
        margin-top: -1px;
        border-top-left-radius: 0;
        -webkit-border-top-left-radius: 0px;
        -moz-border-top-left-radius: 0;
        -o-border-top-left-radius: 0;
        border-top-right-radius: 0;
        -webkit-border-top-right-radius: 0px;
        -moz-border-top-right-radius: 0;
        -o-border-top-right-radius: 0;
        top: auto
    }

    .arm_pointer {
        cursor: pointer !important
    }

    .wrap .ui-state-disabled {
        display: none
    }

    .wrap .howto {
        letter-spacing: .8px;
        text-align: center
    }

    #frm-keys-and-actions {
        min-height: 270px !important
    }

    .wrap .arm_access_rules_grid_wrapper .dataTable,
    .wrap .arm_access_rules_grid_wrapper .dataTables_scroll {
        padding: 0
    }

    .wrap .arm_access_rules_grid_wrapper #armember_datatable_wrapper .DTFC_ScrollWrapper {
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        padding: 0;
        border: 0
    }

    .wrap .arm_access_rules_grid_wrapper #armember_datatable_wrapper div.footer {
        border-top: 1px solid #e8e8e8
    }

    .wrap .arm_access_rules_grid_wrapper .DTFC_LeftWrapper .dataTable {
        padding: 0 3px
    }

    .wrap .arm_access_rules_grid_wrapper .dataTables_scroll {
        padding-right: 3px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .wrap .btn-group.open ul.dropdown-menu {
        border: none
    }

    .wrap .dropdown-menu>li>a {
        padding: 3px 12px
    }

    .wrap ol,
    .wrap ul {
        margin: 0;
        padding: 0
    }

    .wrap .sltstandard .armdropdown-menu>li>a {
        word-wrap: break-word;
        white-space: normal;
        text-decoration: none
    }

    .armmodal {
        float: left;
        width: 560px;
        height: 200px;
        border: none;
        border-radius: 0;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0;
        -o-border-radius: 0;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none
    }

    .armmodal .arm_modal_title {
        font-size: 24px;
        color: #d1d6e5;
        margin-top: 25px;
        text-align: center;
        min-height: 30px
    }

    .armmodal .arm_modal_msg {
        font-size: 16px;
        color: #353942;
        margin-top: 30px;
        line-height: normal;
        text-align: center;
        margin-bottom: 10px
    }

    .armmodal .armmodal_left {
        display: block;
        width: 50%;
        float: left;
        background: #1bbae1;
        font-size: 18px;
        cursor: pointer;
        color: var(--arm-cl-white);
        margin-top: 28px;
        padding-top: 18px;
        height: 42px;
        text-align: center
    }

    .armmodal .armmodal_right {
        display: block;
        width: 50%;
        float: right;
        background: #d9dbe4;
        font-size: 18px;
        cursor: pointer;
        color: #353942;
        margin-top: 28px;
        padding-top: 18px;
        height: 42px;
        text-align: center
    }

    .armnewmodalclose {
        font-size: 15px;
        font-weight: 700;
        height: 19px;
        position: absolute;
        right: 3px;
        top: 5px;
        width: 19px;
        cursor: pointer;
        color: #d1d6e5
    }

    .arm_toast_container {
        position: fixed;
        right: 10px;
        z-index: 99999;
        top: 60px;
        -webkit-overflow-scrolling: touch;
        transition: opacity 0s .25s;
        -moz-transition: opacity 0s .25s;
        -webkit-transition: opacity 0s .25s;
        -ms-transition: opacity 0s .25s;
        -o-transition: opacity 0s .25s
    }

    .arm_message {
        border: 1px solid #49a049;
        border-radius: 4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        -o-border-radius: 4px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: none;
        height: 40px;
        line-height: 26px;
        font-size: 16px;
        font-weight: 400;
        margin: 10px 0;
        padding: 8px 8px 8px 40px
    }

    .arm_toast {
        display: block;
        transition: all .5s;
        -webkit-transition: all .5s;
        -moz-transition: all .5s;
        -ms-transition: all .5s;
        -o-transition: all .5s;
        transform: translate(100%);
        -webkit-transform: translate(100%);
        -moz-transform: translate(100%);
        -ms-transform: translate(100%);
        -o-transform: translate(100%)
    }

    .arm_toast_open {
        transform: translate(0);
        -webkit-transform: translate(0);
        -moz-transform: translate(0);
        -ms-transform: translate(0);
        -o-transform: translate(0)
    }

    .arm_toast_close {
        transform: translate(110%);
        -webkit-transform: translate(110%);
        -moz-transform: translate(110%);
        -ms-transform: translate(110%);
        -o-transform: translate(110%)
    }

    .arm_message_text {
        height: auto;
        font-size: inherit;
        vertical-align: middle
    }

    .arm_message.arm_success_message {
        background: url("../images/success-icon.png") no-repeat scroll 10px 10px #5cb85c;
        border: 1px solid #49a049;
        color: var(--arm-cl-white)
    }

    .arm_message.arm_error_message {
        background: url("../images/error-icon.png") no-repeat scroll 10px 10px #e66b6b;
        border: 1px solid #e25555;
        color: var(--arm-cl-white)
    }

    .arm_message.arm_warning_message {
        border: 1px solid #449cb9;
        background: rgba(62, 199, 245, .8);
        color: var(--arm-cl-white)
    }

    .arm_warning_message:before {
        content: "\f129";
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        position: absolute;
        left: 20px;
        top: 15px;
        color: var(--arm-cl-white)
    }

    .arm_message ul li {
        margin: 0;
        line-height: 22px
    }

    .arm_switch {
        display: inline-block;
        vertical-align: middle;
        padding: 5px
    }

    .arm_form_settings_style_block .arm_switch {
        padding: 4px 0
    }

    label.arm_switch_label {
        float: left;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 0;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        -o-border-radius: 0;
        font-size: 14px;
        text-align: center;
        line-height: normal;
        color: #333;
        min-width: 40px;
        padding: 4px 9px;
        margin: 0
    }

    label.arm_switch_label:first-child {
        padding: 4px 7px 4px 10px;
        border-top-left-radius: 15px;
        -webkit-border-top-left-radius: 15px;
        -moz-border-top-left-radius: 15px;
        -o-border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
        -webkit-border-bottom-left-radius: 15px;
        -moz-border-bottom-left-radius: 15px;
        -o-border-bottom-left-radius: 15px
    }

    label.arm_switch_label:nth-child(2),
    label.arm_switch_label:nth-child(3),
    label.arm_switch_label:nth-child(4) {
        padding: 4px 10px 4px 7px;
        border-top-right-radius: 15px;
        -webkit-border-top-right-radius: 15px;
        -moz-border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
        -webkit-border-bottom-right-radius: 15px;
        -moz-border-radius-bottomright: 15px
    }

    .arm_switch3 label.arm_switch_label:nth-child(2) {
        padding: 4px 6px;
        border-top-right-radius: 0;
        -webkit-border-top-right-radius: 0;
        -moz-border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        -webkit-border-bottom-right-radius: 0;
        -moz-border-radius-bottomright: 0
    }

    .arm_switch4 label.arm_switch_label {
        width: 68px;
        height: 30px
    }

    .arm_switch4 label.arm_switch_label:nth-child(2),
    .arm_switch4 label.arm_switch_label:nth-child(3) {
        border-top-right-radius: 0;
        -webkit-border-top-right-radius: 0;
        -moz-border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        -webkit-border-bottom-right-radius: 0;
        -moz-border-radius-bottomright: 0
    }

    label.arm_switch_label.active {
        background-color: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white)
    }

    .arm_switch input {
        display: none
    }

    .arm_form_settings_style_block label.arm_switch_label {
        font-size: 13px
    }

    .arm_form_rtl.arm_form_layout_writer .arm_form_settings_icon,
    .arm_form_rtl.arm_form_layout_writer_border .arm_form_settings_icon {
        left: 5px;
        right: auto
    }

    .arm_form_rtl.arm_form_layout_writer .arm_form_field_settings_menu_wrapper {
        left: 0;
        right: auto
    }

    .arm_form_rtl.arm_form_layout_writer .arm_form_field_settings_menu_wrapper .arm_form_field_settings_menu_arrow {
        margin-right: 400px
    }

    .arm_form_rtl.arm_form_layout_writer .arm-df__form-group .arm_confirm_box {
        right: auto;
        left: 0
    }

    .arm_form_rtl.arm_form_layout_writer .arm-df__form-group .arm_confirm_box .arm_confirm_box_arrow {
        margin-left: 5px;
        float: left;
        margin-right: 0
    }

    .armswitch.disabled:before,
    .armswitch[disabled]:before {
        content: "";
        position: absolute;
        top: -5px;
        left: -5px;
        height: 27px;
        width: 50px;
        z-index: 99;
        cursor: not-allowed
    }

    .arm_profile_setting_switch {
        display: inline-block;
        float: right;
        margin-top: 4px;
        right: 20px;
        vertical-align: top;
        width: 40px
    }

    .arm_coupon_setting_switch,
    .arm_global_setting_switch,
    .arm_payment_setting_switch {
        display: inline-block;
        vertical-align: middle;
        width: 40px
    }

    .arm_coupon_setting_switch_label,
    .arm_global_setting_switch_label {
        padding-left: 10px
    }

    .armswitch.armswitch_user_ban .armswitch_input:checked+.armswitch_label {
        background-color: #e9aeb5
    }

    .armswitch.armswitch_user_ban .armswitch_input:checked+.armswitch_label,
    .armswitch.armswitch_user_ban .armswitch_input:checked+.armswitch_label:before {
        border-color: #e9aeb5
    }

    .armswitch.armswitch_user_ban .armswitch_input:checked+.armswitch_label:before {
        left: auto;
        right: 0;
        background-color: #d56d7a
    }

    .arm_email_helptip_icon.tipso_style,
    .arm_email_new_helptip_icon.tipso_style,
    .arm_helptip_icon.tipso_style,
    .armhelptip.tipso_style,
    .armhelptip_front.tipso_style {
        cursor: pointer;
        border: 0
    }

    .arm_global_settings_main_wrapper {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin: 0 10px
    }

    .arm_global_settings_main_wrapper .arm_sub_section {
        padding: 10px 30px
    }

    .arm_email_notifications_main_wrapper {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin: 0
    }

    .arm_email_notifications_main_wrapper .page_sub_title {
        padding: 0 40px
    }

    .arm_email_notifications_main_wrapper .page_sub_content {
        padding: 20px 0
    }

    .arm_regular_select {
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        height: 30px;
        margin-top: -3px;
        width: auto;
        min-width: 30%;
        padding: 3px 5px
    }

    .arm_custom_currency_options_container {
        position: relative;
        display: inline-block;
        padding: 5px 5px 5px 0;
        min-width: 200px
    }

    .arm_admin_form textarea {
        min-width: 350px;
        padding: 10px;
        border: 1px solid #d2d2d2;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px
    }

    .arm_admin_form textarea.wp-editor-area {
        border: 0;
        max-width: 100%
    }

    .arm_admin_form .wp-editor-container input {
        width: auto
    }

    .arm_page_settings .arm_error_msg {
        margin: 5px
    }

    .arm_page_settings .arm_check,
    .arm_page_settings .arm_refresh,
    .arm_page_settings .arm_remove,
    .arm_social_settings_form .arm_check,
    .arm_social_settings_form .arm_refresh,
    .arm_social_settings_form .arm_remove {
        margin: 0 5px;
        font-size: 16px
    }

    .arm_page_settings .arm_no_error,
    .arm_social_settings_form .arm_no_error {
        display: none
    }

    .arm_page_setup_view_edit_links {
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        width: 100%;
        padding: 8px 5px 2px
    }

    .arm_page_setup_view_edit_links a {
        font-size: 16px;
        color: #0292c8;
        text-decoration: none;
        padding-right: 15px;
        border-right: #dbe1e8 thin solid
    }

    .arm_page_setup_view_edit_links a:last-child {
        margin-left: 15px;
        border: none
    }

    .arm_page_setup_view_edit_links a:hover {
        color: #333
    }

    .failed_login_lockdown input {
        float: none;
        margin: 0 5px
    }

    .arm_info_text {
        color: #676767;
        margin: 5px;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_info_text_select_page {
        margin: 5px;
        display: inline-block
    }

    .arm-form-table-login-security {
        margin-left: 40px
    }

    .arm-form-table-login-security td {
        width: 265px
    }

    .arm-form-table-login-security td.arm-form-table-login-security-title {
        padding-bottom: 0 !important
    }

    .add_new_form_redirection_field .arm_info_text,
    .arm_forgot_password_link_options .arm_info_text,
    .arm_lable_shortcode_wrapper_conditional_redirect .arm_info_text,
    .arm_lable_shortcode_wrapper_referral .arm_info_text,
    .arm_lable_shortcode_wrapper_url .arm_info_text,
    .arm_registration_link_options .arm_info_text {
        line-height: normal;
        font-size: 12px;
        color: #949494
    }

    .restrict_site_access .arm_info_text {
        margin: 8px 5px
    }

    .arm_payment_geteway_form .arm_info_text {
        line-height: normal
    }

    .arm_warning_text {
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        color: var(--arm-sc-error);
        margin: 0 10px 5px
    }

    .arm_admin_form table tr td .arm_warning_text {
        margin: 0 10px 5px 40px
    }

    .arm_redirect_restricted_page_label span {
        margin: 0 5px
    }

    .arm_redirection_access_rules_blocked_specific,
    .arm_redirection_access_rules_drip_specific,
    .arm_redirection_access_rules_logged_in_specific,
    .arm_redirection_access_rules_pending_specific,
    .arm_redirection_access_rules_specific {
        padding: 10px 10px
    }

    .arm_form_action_setup_change_page_require,
    .arm_form_action_setup_change_url_require,
    .arm_form_action_setup_paid_post_page_require,
    .arm_form_action_setup_renew_page_require,
    .arm_form_action_setup_signup_page_require,
    .arm_redirection_access_rules_blocked_specific_error,
    .arm_redirection_access_rules_drip_specific_blank_error,
    .arm_redirection_access_rules_drip_specific_error,
    .arm_redirection_access_rules_loggedin_specific_blank_error,
    .arm_redirection_access_rules_loggedin_specific_error,
    .arm_redirection_access_rules_non_loggedin_specific_blank_error,
    .arm_redirection_access_rules_non_loggedin_specific_error,
    .arm_redirection_access_rules_pending_specific_blank_error,
    .arm_redirection_access_rules_pending_specific_error,
    .arm_redirection_edit_profile_conditional_redirection_selection,
    .arm_redirection_edit_profile_default_message,
    .arm_redirection_edit_profile_page_selection,
    .arm_redirection_edit_profile_url_selection,
    .arm_redirection_login_conditional_redirection_selection,
    .arm_redirection_login_page_selection,
    .arm_redirection_login_referel_selection,
    .arm_redirection_login_url_selection,
    .arm_redirection_plan_signup_url_selection,
    .arm_redirection_plan_signup_url_selection_require,
    .arm_redirection_signup_conditional_redirection_selection,
    .arm_redirection_signup_page_selection,
    .arm_redirection_signup_referel_selection,
    .arm_redirection_signup_url_selection,
    .arm_redirection_social_page_selection,
    .arm_redirection_social_url_selection,
    .arm_setup_renew_redirection_url_require,
    .arm_setup_signup_redirection_url_require {
        padding: 5px;
        color: red;
        display: none;
        float: left;
        width: 100%
    }

    .arm_social_login_icon_container {
        display: inline-block;
        vertical-align: middle;
        padding: 5px 0;
        margin-right: 10px;
        max-width: 31.5%;
        min-width: 31%;
        position: relative
    }

    .arm_social_network_icons_block .arm_social_login_icon_container label {
        width: auto
    }

    .arm_social_login_icon_container img {
        vertical-align: middle;
        max-width: 90%;
        max-height: 100px
    }

    .arm_social_network_list_ul {
        margin: 0 0 10px;
        padding: 0;
        width: 100%;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_social_network_list_li,
    .arm_social_network_list_ul li {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        max-width: 30%;
        width: 30%;
        margin: 6px 5px;
        padding: 0;
        list-style: outside none none;
        vertical-align: top;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        box-shadow: 0 0 1px 1px #e5e5e5
    }

    .arm_social_network_list_li_place_holder {
        max-width: 30%;
        width: 30%;
        height: 60px;
        border: 2px dashed #dfdfdf !important;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        list-style: none;
        list-style-type: none;
        box-shadow: none !important
    }

    .arm_social_network_list_li .arm_sn_heading_wrapper {
        border-bottom: 1px solid #ddd;
        padding: 8px 10px 7px;
        margin: 0;
        font-size: 15px;
        color: #3c3e4f;
        position: relative;
        cursor: move
    }

    .arm_social_network_list_li .arm_list_sortable_icon {
        display: block;
        width: 50px;
        background: url(../images/drag.png) no-repeat center;
        cursor: move;
        position: absolute;
        right: 0;
        top: 0;
        height: 40px
    }

    .arm_social_network_list_li:hover .arm_list_sortable_icon {
        background: url(../images/drag_hover.png) no-repeat center
    }

    .arm_social_network_list_li .arm_sn_options_wrapper {
        margin: 0;
        padding: 10px 15px
    }

    .arm_social_network_list_li .arm_sn_options_wrapper .arm_sn_options_block {
        margin: 5px 0;
        display: inline-block;
        width: 100%
    }

    .arm_social_network_list_li .arm_sn_options_wrapper label {
        width: 100%;
        display: inline-block;
        margin-bottom: 5px;
        color: #191818
    }

    .arm_social_network_list_li .arm_sn_options_wrapper span.arm_invalid,
    .arm_social_network_list_li .arm_sn_options_wrapper span.error {
        margin: 5px 0 0
    }

    .arm_social_network_icons_block {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 100%;
        padding: 5px 0
    }

    .arm_custom_image_label {
        float: left;
        margin-top: 10px;
        vertical-align: middle !important;
        width: 15% !important
    }

    .arm_social_network_icons_block label {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 100%;
        margin-bottom: 5px
    }

    .arm_remove_social_network_icon {
        text-decoration: none;
        display: inline-block;
        font-size: 20px;
        color: #333;
        margin: 3px 6px;
        vertical-align: top
    }

    .arm_dashboard_block {
        padding: 10px
    }

    .member-summary-container {
        width: 100%;
        float: left;
        margin-top: 20px
    }

    .member-summary-container .pd_animation {
        visibility: hidden
    }

    .member-summary-container .pd_animation.pd_delay {
        -webkit-animation-delay: .6s;
        -moz-animation-delay: .6s;
        -o-animation-delay: .6s;
        animation-delay: .6s
    }

    .member-summary-container .pd_animation.pd_animating {
        visibility: visible;
        -webkit-animation-duration: .9s;
        -moz-animation-duration: .9s;
        -o-animation-duration: .9s;
        animation-duration: .9s
    }

    .member-summary-container .fadeInDown {
        -webkit-animation-name: fadeInDown;
        -moz-animation-name: fadeInDown;
        -o-animation-name: fadeInDown;
        animation-name: fadeInDown
    }

    .member-summary-container .fadeInUp {
        -webkit-animation-name: fadeInUp;
        -moz-animation-name: fadeInUp;
        -o-animation-name: fadeInUp;
        animation-name: fadeInUp
    }

    .member-summary-container a {
        text-decoration: none
    }

    .member-summary-main {
        width: 18%;
        float: left;
        height: 78px;
        background: var(--arm-cl-white);
        margin-right: 2%;
        border: 1px solid silver
    }

    .member-summary-main_last {
        width: 18.9%;
        float: left;
        height: 78px;
        background: var(--arm-cl-white);
        margin-right: 0;
        border: 1px solid silver
    }

    .member-summary-icon1 {
        width: 32%;
        float: left;
        height: 55px;
        text-align: center;
        padding-top: 23px;
        background: #63d3e9
    }

    .member-summary-icon2 {
        width: 32%;
        float: left;
        height: 55px;
        text-align: center;
        padding-top: 23px;
        background: #5cb85c
    }

    .member-summary-icon3 {
        width: 32%;
        float: left;
        height: 55px;
        text-align: center;
        padding-top: 23px;
        background: #d9544f
    }

    .member-summary-icon4 {
        width: 32%;
        float: left;
        height: 55px;
        text-align: center;
        padding-top: 23px;
        background: #5c8fde
    }

    .member-summary-icon5 {
        width: 32%;
        float: left;
        height: 55px;
        text-align: center;
        padding-top: 23px;
        background: #f0ad4e
    }

    .member-summary-detail {
        width: 68%;
        float: left;
        text-align: center;
        padding-top: 17px
    }

    .member-summary-total {
        width: 100%;
        float: left;
        font-size: 20px;
        font-weight: 700
    }

    .member-summary-title {
        width: 100%;
        float: left;
        text-transform: uppercase
    }

    .chart_mian {
        width: 100%;
        margin-top: 40px
    }

    .chart_content {
        width: 100%;
        float: left;
        margin-top: 20px;
        background: var(--arm-cl-white);
        border: 1px solid silver
    }

    .chart1 {
        width: 47.8%;
        float: left;
        text-align: center;
        margin-right: 2%
    }

    .chart2 {
        width: 47.8%;
        float: left;
        text-align: center;
        margin-left: 2%
    }

    .arm_email_settings_content {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        float: left;
        padding: 10px 10px 0;
        width: 100%
    }

    .arm_email_settings_select_text_inner {
        display: inline-block
    }

    .arm_mail_port_field {
        display: inline-block;
        width: 110px
    }

    .arm_smtp_slide_form {
        width: 600px;
        margin-top: 20px;
        display: none
    }

    .arm_required {
        border-color: red !important
    }

    .arm_shortcode_row {
        padding: 0 35px 0 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: block;
        margin-bottom: 5px;
        width: 100%;
        border: 1px solid #e8ebef;
        border-right: 2px solid var(--arm-pt-theme-blue);
        position: relative
    }

    .arm_add_profile_shortcode_row {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: block;
        margin-bottom: 5px;
        width: 97%;
        max-width: 300px;
        border: 1px solid #e8ebef;
        border-right: 2px solid var(--arm-pt-theme-blue);
        position: relative
    }

    .arm_communication_message_wrapper_frm .arm_shortcode_row {
        padding: 0
    }

    .arm_communication_message_wrapper_frm .arm_table_label_on_top .chosen-container,
    .arm_communication_message_wrapper_frm td>input {
        width: 510px !important
    }

    .arm_shortcode_row.armhelptip.tipso_style {
        border: 1px solid #e8ebef;
        border-right: 2px solid var(--arm-pt-theme-blue)
    }

    .arm_add_profile_shortcode_row.armhelptip.tipso_style {
        border: 1px solid #eaedf1;
        font-size: 15px
    }

    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_member_fields_label .arm_add_profile_variable_code,
    .arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper .arm_display_member_fields_label {
        width: 70%;
        padding: 0;
        font-size: 15px;
        color: #565765;
        cursor: pointer;
        display: inline-block;
        -o-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box
    }

    .arm_variable_code {
        background: url(../images/left_arrow_icon.png) no-repeat;
        background-position: 10px center;
        width: 100%;
        padding: 8px 0 8px 25px;
        font-size: 16px;
        color: #565765;
        cursor: pointer;
        display: inline-block;
        -o-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box
    }

    .arm_shortcode_row i.arm_email_helptip_icon {
        margin: 0 !important;
        position: absolute;
        right: 0;
        height: 100%;
        width: auto;
        padding: 8px 9px 0 9px;
        background: var(--arm-cl-white);
        border: 1px #e9ecf0 solid;
        border-width: 0 0 0 1px;
        display: inline-block;
        -o-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box
    }

    .arm_coupon_input_fields {
        display: inline-block;
        max-width: 350px;
        vertical-align: middle
    }

    input.arm_datepicker,
    input.arm_datepicker_coupon,
    input.arm_user_plan_date_picker,
    input.arm_user_plan_expiry_date_picker {
        background: url(../images/date_icon.jpg) no-repeat right;
        background-position: 96% center;
        padding-right: 30px !important
    }

    .arm_cancel_edit_user_expiry_date {
        cursor: pointer;
        vertical-align: middle;
        margin: 0 0 0 5px
    }

    .arm_member_cancel_save_plan {
        vertical-align: middle
    }

    input.arm_datepicker_coupon {
        background-position: 98% center
    }

    #arm_restrict_access_select {
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        height: 200px !important;
        width: 245px !important;
        margin-bottom: 5px;
        padding: 10px
    }

    .arm_warning_text_coupon {
        color: var(--arm-cl-white);
        background-color: #727373;
        display: inline-block;
        padding: 7px 10px;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        position: relative;
        border-bottom: 1px solid var(--arm-cl-white);
        border-right: 1px solid var(--arm-cl-white);
        -webkit-box-shadow: 1px 1px 10px 1px #ccc;
        -moz-box-shadow: 1px 1px 10px 1px #ccc;
        -o-box-shadow: 1px 1px 10px 1px #ccc;
        box-shadow: 1px 1px 10px 1px #ccc;
        margin: 0 0 0 10px
    }

    .arm_warning_text_coupon i {
        position: absolute;
        color: #727373;
        left: -9px;
        top: 10px;
        width: 0;
        height: 0;
        border-top: 6px solid transparent;
        border-bottom: 7px solid transparent;
        border-right: 10px solid #727373
    }

    .arm_global_setting_currency_warring {
        margin: 5px
    }

    .arm_global_setting_currency_warring,
    span.arm_error_msg,
    span.arm_invalid,
    span.error {
        display: inline-block;
        width: 100%;
        color: var(--arm-sc-error);
        font-size: 13px;
        margin-top: 4px
    }

    .paid_subscription_options span.error {
        margin-left: 25px
    }

    .arm_add_new_drip_rule_wrapper_frm span.arm_invalid,
    .arm_add_new_drip_rule_wrapper_frm span.error,
    .arm_add_user_badges_wrapper_frm span.arm_invalid,
    .arm_add_user_badges_wrapper_frm span.error {
        margin: 3px 0
    }

    span.arm_success_msg,
    span.success {
        display: inline-block;
        color: green;
        font-size: 14px;
        width: 100%
    }

    input.arm_error_msg,
    input.arm_invalid,
    input.error {
        border: 1px solid var(--arm-sc-error) !important
    }

    select.arm_chosen_selectbox.arm_invalid~.chosen-container,
    select.arm_chosen_selectbox.error~.chosen-container {
        border-color: var(--arm-sc-error)
    }

    input[type=hidden].error+dl.arm_multiple_selectbox dt,
    input[type=hidden].error+dl.arm_selectbox dt {
        border-color: var(--arm-sc-error) !important
    }

    .arm_drop_area_box {
        width: 100%;
        border: 1px dashed #9d9e9f;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -o-border-radius: 6px;
        border-radius: 6px;
        text-align: center;
        vertical-align: middle;
        padding: 15px 0;
        margin: 15px 0;
        clear: both;
        font-size: 14px
    }

    .arm_module_options {
        width: 100%;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_setup_style_label {
        margin: 10px
    }

    .arm_setup_note_container {
        display: block;
        margin: 10px 10px 5px;
        vertical-align: top;
        min-width: 550px;
        width: 550px
    }

    .arm_setup_note_container .wp-editor-wrap {
        margin: 15px 0
    }

    .arm_setup_two_step_labels {
        display: inline-block;
        margin: 10px 10px 5px;
        vertical-align: top;
        min-width: 40%
    }

    .arm_setup_two_button_labels .arm_setup_two_step_labels {
        margin: 0
    }

    .arm_setup_two_button_labels label,
    .arm_setup_two_step_labels label {
        display: block;
        margin: 5px 10px
    }

    .arm_setup_two_button_labels label span,
    .arm_setup_two_step_labels label span {
        margin-right: 5px;
        min-width: 170px;
        width: 170px;
        display: inline-block
    }

    .arm_setup_style_options {
        width: 49%;
        min-height: 380px;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 20px;
        vertical-align: top;
        background-color: #fafafa;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -o-border-radius: 6px;
        margin: 0
    }

    .arm_setup_style_container .arm_setup_style_options:first-child {
        margin-right: 10px
    }

    .arm_setup_style_options .arm_setup_style_option_item {
        display: block;
        margin: 5px 10px
    }

    .arm_font_style_options {
        display: inline-block
    }

    .arm_font_style_options .arm_font_style_label {
        display: inline-block;
        margin: 0 0 0 6px;
        border-radius: 50px;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        -o-border-radius: 50px;
        width: 32px;
        height: 32px;
        line-height: normal;
        text-align: center;
        vertical-align: middle;
        padding: 4px 5px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_font_style_options .arm_font_style_label:focus,
    .arm_font_style_options .arm_font_style_label:hover {
        border-color: var(--arm-pt-theme-blue)
    }

    .arm_font_style_options .arm_font_style_label:first-child {
        margin: 0
    }

    .arm_setup_style_options span {
        margin-right: 5px;
        min-width: 200px;
        display: inline-block
    }

    .arm_setup_style_options .arm_colorpicker_label {
        max-height: 35px;
        height: 35px;
        max-width: 110px;
        width: 100px
    }

    .arm_setup_style_options .arm_colorpicker_label input,
    .arm_setup_style_options .arm_colorpicker_label input[type=text] {
        max-height: 35px;
        height: 35px !important;
        width: auto !important;
        max-width: 70px !important;
        border-top-left-radius: 0;
        -webkit-border-top-left-radius: 0;
        -moz-border-top-left-radius: 0;
        -o-border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        -webkit-border-bottom-left-radius: 0;
        -moz-border-bottom-left-radius: 0;
        -o-border-bottom-left-radius: 0;
        direction: ltr !important
    }

    .arm_membership_setup_sub_ul,
    ul.arm_membership_setup_sub_ul {
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border: 1px solid #e1e1e1;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px
    }

    .arm_plan_payment_cycle_ul li {
        position: relative;
        width: 100%;
        float: none;
        display: inline-block;
        vertical-align: top;
        margin-bottom: 40px
    }

    .arm_membership_setup_sub_ul li {
        position: relative;
        width: 99%;
        height: 40px;
        line-height: 40px;
        margin: 5px 0;
        padding: 0 30px 0 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        float: none;
        display: inline-block;
        vertical-align: top;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden
    }

    .arm_membership_setup_sub_ul .arm_membership_setup_sub_li,
    arm_plan_payment_cycle_ul li {
        background-color: #f3f3f3;
        border: 1px solid #e2e2e2;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px
    }

    .arm_membership_setup_sub_ul li:hover .arm_membership_setup_sortable_icon {
        background: url(../images/drag_hover.png) no-repeat center
    }

    .arm_plan_cycle_sortable_icon:hover {
        background: url(../images/drag_plan_hover.png) no-repeat center
    }

    .arm_setup_section_body .arm_membership_setup_sub_ul.arm_column_2,
    .arm_setup_section_body .arm_membership_setup_sub_ul.arm_column_3 {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        position: relative
    }

    .paid_subscription_options_recurring_payment_cycle_label {
        width: 100% !important;
        max-width: 100% !important
    }

    .paid_subscription_options_recurring_payment_cycle_amount {
        width: 65px !important
    }

    .arm_setup_option_field {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        position: relative
    }

    .arm_setup_option_field .arm_setup_option_label {
        color: #191818;
        padding: 15px 10px 10px;
        vertical-align: middle;
        display: inline-block;
        max-width: 21%;
        width: 210px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        float: left
    }

    .arm_setup_option_field .arm_setup_option_input {
        padding: 10px;
        display: inline-block;
        width: 78%;
        max-width: 78%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        position: relative;
        float: left
    }

    .arm_setup_option_input.arm_setup_items_box_gateways .arm_setup_module_box .arm_setup_gateway_opt_wrapper,
    .arm_setup_option_input.arm_setup_plans_container .arm_setup_module_box .arm_setup_plan_opt_wrapper {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        vertical-align: top;
        padding: 0 20px 10px 0;
        min-width: 250px
    }

    .arm_setup_option_input.arm_setup_items_box_gateways .arm_setup_module_box #arm_setup_gateway_opt_wrapper_id {
        min-width: 272px !important
    }

    .arm_setup_option_input.arm_setup_items_box_gateways .arm_setup_module_box label,
    .arm_setup_option_input.arm_setup_plans_container .arm_setup_module_box label {
        margin-right: 5px;
        max-width: 190px;
        vertical-align: middle;
        line-height: normal;
        line-break: anywhere
    }

    .arm_admin_form .arm_coupon_enable_radios .iradio_minimal-red+label {
        min-width: 50px
    }

    .arm_membership_setup_sub_ul .hidden_section {
        display: none !important
    }

    .arm_setup_color_options {
        display: inline-block;
        width: 120px;
        vertical-align: top;
        text-align: center;
        position: relative
    }

    .arm_setup_color_options span {
        display: inline-block;
        width: 100%;
        text-align: center
    }

    .arm_plan_payment_cycle_ul {
        margin-bottom: 10px !important
    }

    .arm_setup_color_options .arm_colorpicker_label {
        width: 25px;
        height: 25px
    }

    .arm_setup_color_options input {
        opacity: 0;
        width: 0 !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important
    }

    .arm_setup_section_body .arm_membership_setup_sub_ul.arm_column_2 li {
        max-width: 47%;
        width: 47%;
        float: none;
        display: inline-block;
        vertical-align: top
    }

    .arm_setup_section_body .arm_membership_setup_sub_ul.arm_column_3 li {
        min-width: 230px;
        width: 30%;
        float: none;
        display: inline-block;
        vertical-align: top
    }

    .arm_setup_section_body .arm_membership_setup_sub_ul.arm_column_4 li {
        min-width: 175px;
        width: 23%;
        float: none;
        display: inline-block;
        vertical-align: top;
        margin: 8px 6px
    }

    .arm_login_redirection_condition_sortable_icon {
        display: block;
        background: url(../images/drag.png) no-repeat center;
        cursor: move;
        right: 40px;
        width: 40px;
        height: 40px;
        float: right
    }

    .arm_plan_cycle_sortable_icon {
        background: rgba(0, 0, 0, 0) url("../images/drag_plan.png") no-repeat scroll center center;
        cursor: move;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    .arm_plan_cycle_plus_icon {
        background: rgba(0, 0, 0, 0) url("../images/add_plan.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    tr.shown div.arm_show_user_more_plans {
        background: rgba(0, 0, 0, 0) url("../images/member_grid_down_arrow_hover.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    tr:not(shown) div.arm_show_user_more_plans {
        background: rgba(0, 0, 0, 0) url("../images/member_grid_down_arrow.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    .arm_plan_cycle_plus_icon:hover {
        background: rgba(0, 0, 0, 0) url("../images/add_plan_hover.png") no-repeat scroll center center
    }

    .arm_plan_cycle_minus_icon {
        background: rgba(0, 0, 0, 0) url("../images/remove_plan.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    .arm_plan_cycle_minus_icon:hover {
        background: rgba(0, 0, 0, 0) url("../images/remove_plan_hover.png") no-repeat scroll center center
    }

    .arm_membership_setup_sub_ul li input {
        margin-right: 10px
    }

    .arm_membership_setup_sortable_icon {
        display: block;
        background: url(../images/drag.png) no-repeat center;
        cursor: move;
        position: absolute;
        right: 0;
        width: 40px;
        height: 40px
    }

    .paid_subscription_options_recurring_default_payment_cycle_label {
        width: 75% !important
    }

    .arm_plan_payment_cycle_li_placeholder {
        width: 100%;
        height: 80px;
        border: 1px dashed #9d9e9f;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        -khtml-border-radius: 6px;
        -o-border-radius: 6px;
        border-radius: 6px;
        clear: both
    }

    .arm_membership_setup_li_placeholder {
        max-width: 95%;
        height: 40px;
        border: 1px dashed #9d9e9f;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        -khtml-border-radius: 6px;
        -o-border-radius: 6px;
        border-radius: 6px;
        text-align: center;
        vertical-align: middle;
        margin: 0 auto 15px;
        clear: both
    }

    li.arm_module_option_box {
        margin-bottom: 15px
    }

    li.arm_module_option_box .postbox {
        margin: 0
    }

    .arm_module_option_box_placeholder {
        width: 95%;
        border: 1px dashed #9d9e9f;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        -khtml-border-radius: 6px;
        -o-border-radius: 6px;
        border-radius: 6px;
        text-align: center;
        vertical-align: middle;
        padding: 20px 0;
        margin: 0 auto 15px;
        clear: both
    }

    .arm_membership_setup_forms_container label {
        padding: 10px;
        font-weight: 700
    }

    .arm_membership_setup_forms_container select {
        min-width: 200px
    }

    .arm_stripe_plan_container {
        margin: 15px 0 0;
        padding: 0;
        display: none;
        max-width: 90%;
        width: 85%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_stripe_plan_container h4 {
        margin: 5px 0
    }

    .arm_stripe_plan_container label {
        display: inline-block;
        padding: 1px 10px;
        width: 100%
    }

    .arm_stripe_plan_container label span {
        display: inline-block;
        width: 100%
    }

    .arm_stripe_plan_container .arm_stripe_planid_warning {
        display: inline-block;
        width: 100%;
        font-size: 14px;
        line-height: normal;
        padding: 0
    }

    .arm_stripe_plan_container label.arm_stripe_plans input {
        display: inline-block;
        margin: 5px 0
    }

    .arm_setup_pg_notice {
        display: none;
        margin: 0 15px
    }

    .arm_payment_gateway_warnings span {
        width: 100%;
        line-height: normal;
        margin: 5px 0 0
    }

    .arm_2checkout_not_support_plans,
    .arm_authorize_net_not_support_plans,
    .arm_bank_transfer_not_support_plans,
    .arm_stripe_not_support_plans {
        font-weight: 700
    }

    li.arm_rules_block {
        padding: 2px 10px;
        background: var(--arm-cl-white);
        border: 1px solid #eee;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 0 0 8px 0 #ccc;
        -moz-box-shadow: 0 0 8px 0 #ccc;
        -o-box-shadow: 0 0 8px 0 #ccc;
        box-shadow: 0 0 8px 0 #ccc;
        list-style: outside none none;
        min-width: 200px
    }

    li.arm_rules_block a {
        padding: 5px 0;
        width: 100%;
        display: inline-block;
        text-decoration: none
    }

    .arm_setup_items_empty_msg {
        padding: 10px 20px;
        vertical-align: top;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -o-border-radius: 6px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        background-color: #fafafa;
        margin: 0
    }

    .arm_setup_modules_container {
        position: relative;
        margin: 10px 0 10px 20px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: block
    }

    .arm_right_border {
        position: absolute;
        height: 100%;
        width: 1px;
        background: var(--arm-pt-theme-blue)
    }

    .arm_setup_section_title {
        font-size: 20px;
        z-index: 100;
        position: relative;
        color: var(--arm-pt-theme-blue)
    }

    .arm_title_round {
        color: var(--arm-cl-white);
        font-size: 26px;
        background: var(--arm-pt-theme-blue);
        border-radius: 50px;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        -o-border-radius: 50px;
        display: inline-block;
        text-align: center;
        height: 20px;
        width: 20px;
        padding: 10px;
        margin-right: 10px;
        margin-left: -20px
    }

    .arm_setup_section_title_last {
        height: 20px
    }

    .arm_setup_section_title_last .arm_title_round {
        height: 3px;
        width: 3px;
        padding: 10px;
        margin: 0 0 0 -11px;
        line-height: normal
    }

    .arm_setup_forms_container,
    .arm_setup_module_box {
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 0;
        margin: 0;
        position: relative;
        display: block
    }

    .arm_setup_forms_container .arm_info_text {
        margin: 5px 0 6px
    }

    .arm_setup_section_body {
        padding: 15px 10px 15px 40px;
        margin: 0;
        width: 100%;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_setup_section_body table.form-table tr td,
    .arm_setup_section_body table.form-table tr th {
        padding: 10px;
        vertical-align: middle
    }

    .arm_setup_section_body table.form-table tr th.arm_setup_font_title {
        min-width: 115px;
        width: auto;
        text-align: left
    }

    .arm_membership_setup_sub_ul .arm_membership_setup_sub_li.arm_required_text,
    .arm_required_text {
        color: var(--arm-sc-error);
        border: 1px solid var(--arm-sc-error)
    }

    .arm_membership_setup_sub_ul .arm_membership_setup_sub_li label {
        display: block;
        display: inline-block;
        padding: 8px 5px 5px
    }

    .arm_membership_setup_sub_ul .arm_membership_setup_sub_li.arm_required_text label {
        color: var(--arm-sc-error)
    }

    .arm_setup_module_column_layout_types {
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 100%;
        padding: 0;
        margin-bottom: 20px
    }

    .arm_setup_module_refresh {
        float: right;
        padding: 10px;
        display: inline-block;
        cursor: pointer
    }

    .arm_setup_summary_tags li {
        font-size: 14px;
        margin: 0
    }

    .arm_column_layout_types_container {
        margin-bottom: 20px
    }

    .arm_column_layout_types_container label {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        text-align: center;
        padding: 2px;
        margin: 0 10px 0 0;
        line-height: normal;
        cursor: pointer;
        position: relative;
        font-weight: 700;
        color: #3c3e4f;
        background-color: var(--arm-cl-white);
        border: 1px solid #e1e1e1;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        position: relative
    }

    .arm_column_layout_types_container label.arm_active_label {
        background-color: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white)
    }

    .arm_column_layout_types_container label input {
        position: absolute;
        left: 0;
        top: 10px;
        -moz-opacity: 0;
        -khtml-opacity: 0;
        opacity: 0
    }

    .arm_column_layout_types_container img {
        float: left
    }

    .arm_column_layout_types_container .arm_active_img {
        display: none
    }

    .arm_column_layout_types_container .arm_active_label .arm_inactive_img {
        display: none
    }

    .arm_column_layout_types_container .arm_active_label .arm_active_img {
        display: block
    }

    .four_column_img,
    .single_column_img,
    .three_column_img,
    .two_column_img {
        width: 25px;
        height: 25px;
        display: inline-block;
        vertical-align: middle
    }

    .single_column_img {
        background: url(../images/single_column.png) no-repeat center;
        background-size: contain
    }

    .two_column_img {
        background: url(../images/two_column.png) no-repeat center;
        background-size: contain
    }

    .three_column_img {
        background: url(../images/three_column.png) no-repeat center;
        background-size: contain
    }

    .four_column_img {
        background: url(../images/three_column.png) no-repeat center;
        background-size: contain
    }

    .arm_active_label .two_column_img {
        background: url(../images/two_column_hover.png) no-repeat center;
        background-size: contain
    }

    .arm_active_label .three_column_img {
        background: url(../images/three_column_hover.png) no-repeat center;
        background-size: contain
    }

    .arm_active_label .four_column_img {
        background: url(../images/three_column_hover.png) no-repeat center;
        background-size: contain
    }

    .arm_setup_items_box_coupon {
        display: block;
        margin: 15px 10px 5px
    }

    .arm_setup_modules_container li.ui-draggable-dragging {
        min-width: 200px
    }

    li.arm_setup_module_block {
        list-style: outside none none;
        background: url(../images/drag.png) no-repeat right center;
        background-position-x: 95%;
        border-bottom: #eff1f1 1px solid;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -o-border-radius: 6px;
        padding: 10px 10px 8px 20px;
        color: #939499;
        text-align: left;
        margin: 5px;
        display: block;
        cursor: pointer
    }

    li.arm_setup_module_block .module_block {
        padding-right: 20px
    }

    li.arm_setup_module_block a {
        color: #939499;
        width: auto;
        display: block;
        text-decoration: none
    }

    li.arm_setup_module_block:hover {
        background: url(../images/drag_hover.png) no-repeat right center;
        background-position-x: 95%;
        color: #3c3e4f;
        background-color: #f6f8f8
    }

    li.arm_setup_module_block:hover a {
        color: #3c3e4f
    }

    .arm_setup_redirection_content input {
        margin-left: 40px
    }

    .arm_main_category_container {
        float: left;
        display: block;
        margin: 5px
    }

    .arm_main_content_label {
        font-weight: 700
    }

    .arm_main_admin_menu_container {
        min-width: 29%;
        max-width: 29%
    }

    .arm_main_admin_menu_container label span {
        display: none
    }

    .arm_category_posts_container,
    .arm_sub_admin_menu_container {
        margin: 5px 0 5px 20px
    }

    .arm_admin_menu_content,
    .arm_category_posts_content,
    .arm_pages_content {
        padding: 2px
    }

    .arm_pages_content {
        min-width: 29%;
        max-width: 29%
    }

    .arm_post_content,
    .arm_taxonomies_content {
        width: 28%;
        max-width: 28%;
        padding: 5px;
        float: left
    }

    .arm_sub_category_container {
        width: 100%;
        margin: 0 10px 5px
    }

    .meta-box-sortables .postbox .handlediv:before,
    .sidebar-name .sidebar-name-arrow:before {
        content: '\f142'
    }

    .arm_loading {
        position: fixed;
        top: 0;
        z-index: 99990;
        text-align: center;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, .5)
    }

    .arm_loading img {
        position: absolute;
        left: 40%;
        top: 45%;
        z-index: 99991;
        border-radius: 10px;
        background: var(--arm-pt-theme-blue);
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -o-border-radius: 10px;
        box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        -webkit-box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        -moz-box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        -o-box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        text-align: center;
        width: 88px;
        padding: 16px;
        box-sizing: border-box
    }

    .arm_sidebar_drawer_content .arm_loading {
        background: rgba(255, 255, 255, .5)
    }

    .arm_filter_grid_list_container {
        position: relative
    }

    .arm_loading_grid {
        position: absolute;
        top: 0;
        z-index: 99990;
        text-align: center;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(255, 255, 255, .6)
    }

    .arm_loading_grid img {
        position: relative;
        top: 40%;
        z-index: 99991;
        background: var(--arm-pt-theme-blue);
        border-radius: var(--arm-radius-8px);
        -webkit-border-radius: var(--arm-radius-8px);
        -moz-border-radius: var(--arm-radius-8px);
        -o-border-radius: var(--arm-radius-8px);
        box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        -webkit-box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        -moz-box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        -o-box-shadow: 0 0 12px rgba(0, 0, 0, .2);
        text-align: center;
        width: 88px;
        padding: 16px;
        box-sizing: border-box
    }

    .arm_status_loader_img {
        background: url(../images/arm_loader.gif) no-repeat;
        background-position: center center;
        background-size: cover;
        width: 20px;
        height: 20px;
        position: relative;
        top: 5px;
        left: 5px;
        display: none
    }

    #arm_drip_rules_wrapper tr td .arm_status_loader_img {
        left: -2px
    }

    .arm_status_loader_img#arm_card_upload_company_logo_img {
        top: -25px
    }

    .armswitch .arm_status_loader_img {
        position: absolute;
        top: 2px
    }

    .arm_belt_block {
        display: table-cell;
        padding: 0;
        margin: 0
    }

    .arm_belt_box .arm_belt_block .arm_shortcode_text {
        margin-left: 10px;
        width: 200px
    }

    .arm_plan_access_shortcode_col span {
        display: block;
        font-size: 13px
    }

    .postbox h3.hndle {
        background: none repeat scroll 0 0 #eee;
        border: 1px solid #eee;
        -webkit-border-top-right-radius: 4px;
        -moz-border-top-right-radius: 4px;
        -o-border-top-right-radius: 4px;
        border-top-right-radius: 4px;
        -moz-border-top-left-radius: 4px;
        -webkit-border-top-left-radius: 4px;
        -o-border-top-left-radius: 4px;
        border-top-left-radius: 4px
    }

    .arm_subscription_types_container {
        vertical-align: middle;
        width: 100%;
        display: block
    }

    .arm_plan_payment_types_container label,
    .arm_subscription_types_container label {
        margin-right: 20px
    }

    .hidden_section2,
    div.hidden_section2,
    li.hidden_section2,
    span.hidden_section2,
    tr.hidden_section2 {
        display: none !important
    }

    .hidden_section,
    div.hidden_section,
    li.hidden_section,
    span.hidden_section,
    tr.hidden_section {
        display: none
    }

    label.arm_switch_label.disable_section {
        cursor: no-drop
    }

    label.arm_switch_label.disable_section:not(.active) {
        background-color: #f6f9ff;
        opacity: .8
    }

    .arm_price_box_content table tr td {
        padding: 5px
    }

    .arm_form_field_subscription_plan_payment_gateways_options {
        margin: 5px 20px
    }

    .arm_form_field_plan_gateway {
        margin: 5px 0
    }

    .arm_admin_form .page_sub_content .arm_enable_up_down_action th,
    .arm_enable_up_down_action table th {
        text-align: left
    }

    .arm_import_export_container {
        padding: 0 0 15px 0;
        background-color: var(--arm-cl-white);
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_import_export_left_box,
    .arm_import_export_right_box {
        float: left;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        min-height: 400px;
        min-width: 465px;
        width: 50%
    }

    .arm_import_export_left_box {
        border-right: 1px solid #ddd;
        padding-right: 20px
    }

    .arm_import_export_right_box {
        padding-left: 20px
    }

    [dir=rtl] .arm_import_export_left_box,
    [dir=rtl] .arm_import_export_right_box {
        float: right
    }

    [dir=rtl] .arm_import_export_left_box {
        border-right: 0;
        padding-left: 20px;
        padding-right: 0
    }

    [dir=rtl] .arm_import_export_right_box {
        border-right: 1px solid #ddd;
        padding-right: 20px;
        padding-left: 0
    }

    .arm_import_export_container .page_title {
        height: 35px;
        font-size: 18px;
        font-weight: 500;
        padding-top: 0;
        padding-left: 0;
        padding-left: 0
    }

    .arm_import_export_container table tr th {
        min-width: 100px !important;
        width: 100px
    }

    .arm_import_export_container .armemailaddbtn {
        margin-right: 15px;
        margin-bottom: 10px
    }

    .arm_import_export_date_fields {
        position: relative
    }

    .arm_import_export_date_fields input {
        width: 150px !important;
        margin-bottom: 5px
    }

    .arm_import_export_date_fields input:first-child {
        margin-right: 15px
    }

    .arm_export_settings_container label {
        display: inline-block !important;
        margin-bottom: 10px !important;
        vertical-align: middle !important
    }

    .currency_warning {
        background: #fffdd5;
        padding: 2px 5px;
        display: inline-block;
        font-style: italic;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px
    }

    .arm_message_periodunit_days {
        float: left
    }

    .arm_message_periodunit_days_ms {
        float: left
    }

    .arm_message_periodunit_months,
    .arm_message_periodunit_weeks,
    .arm_message_periodunit_years {
        float: left;
        display: none
    }

    .arm_message_periodunit_months_ms,
    .arm_message_periodunit_weeks_ms,
    .arm_message_periodunit_years_ms {
        float: left;
        display: none
    }

    .arm_message_period_section {
        float: left;
        display: none
    }

    .arm_message_period_section_form_manual_subscription {
        float: left;
        display: none
    }

    .arm_message_period_section_for_dripped_content {
        float: left;
        display: none
    }

    .arm_message_period_post {
        float: left
    }

    .arm_message_periodunit_type {
        display: inline-block
    }

    .arm_view_memeber_top_belt .page_title {
        margin: 0;
        padding: 0;
        line-height: normal;
        display: inline-block
    }

    .arm_view_memeber_top_belt a {
        border-radius: 30px;
        -webkit-border-radius: 30px;
        -moz-border-radius: 30px;
        -o-border-radius: 30px;
        padding: 5px 10px
    }

    .arm_member_detail_confirm_wrapper {
        position: relative
    }

    .arm_member_detail_confirm_wrapper .arm_confirm_box_body {
        min-width: 400px;
        max-width: 100%
    }

    .arm_member_detail_confirm_wrapper .arm_confirm_box_text {
        text-align: left;
        line-height: normal
    }

    .arm_effective_detail_rows {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        font-size: 14px
    }

    .arm_effective_detail_rows .arm_effective_detail_label {
        color: #191818;
        text-align: right;
        font-weight: 700;
        vertical-align: top;
        width: 170px;
        padding: 5px 10px;
        display: inline-block
    }

    .arm_effective_detail_rows .arm_effective_detail_value {
        max-width: 150px;
        padding: 5px 10px;
        margin: 0;
        vertical-align: middle;
        display: inline-block
    }

    .arm_member_detail_activities_section {
        margin: 10px auto 0;
        width: 150px
    }

    .arm_member_detail_login_section {
        margin: 5px auto;
        width: auto;
        padding: 0 12px
    }

    .arm_member_detail_login_section label {
        text-align: right;
        font-weight: 700;
        color: #191818;
        font-size: 14px
    }

    .arm_member_detail_login_section span {
        font-size: 14px
    }

    .arm_member_deatil_section {
        background-color: var(--arm-cl-white);
        border: 1px solid #dedede;
        float: left;
        width: 98%;
        border-radius: 10px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -o-border-radius: 10px;
        padding: 10px
    }

    .arm_member_details_container {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        position: relative;
        padding: 0 !important
    }

    .arm_view_member_sub_title {
        padding: 12px;
        margin: 30px 0 5px;
        font-size: 16px;
        font-weight: 700;
        color: #32323a;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_view_member_sub_content {
        position: relative;
        display: inline-block;
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_member_details_container .form-table td {
        word-break: break-word;
        height: auto !important
    }

    .arm_full_name_section {
        float: left;
        font-size: 22px;
        font-weight: bolder;
        margin-bottom: 10px;
        padding-left: 50px;
        width: 90%
    }

    .arm_transaction_list_paid_amount,
    .arm_transaction_list_plan_amount,
    .arm_transaction_list_trial_text {
        display: inline-block
    }

    .arm_transaction_list_plan_amount {
        text-decoration: line-through;
        margin-right: 5px;
        opacity: .8
    }

    .arm_transaction_list_trial_text {
        width: 100%;
        font-size: 12px
    }

    .arm_member_detail_profiledetail_section {
        float: left;
        width: 925px
    }

    .arm_member_detail_row {
        float: left;
        width: 100%;
        padding: 10px 0 10px 5px
    }

    .arm_member_detail_label {
        float: left;
        font-size: 16px;
        font-weight: bolder;
        text-align: right;
        width: 15%
    }

    .arm_member_detail_data {
        float: left;
        font-size: 14px;
        padding-left: 10px;
        width: 75%;
        max-width: 80%
    }

    .arm_member_detail_logindetail_section_div {
        float: left;
        padding: 10px;
        width: 100%
    }

    .arm_member_logindetail_row {
        float: left;
        width: 100%;
        padding: 10px 0 10px
    }

    .arm_member_logindetail_label {
        float: left;
        font-size: 16px;
        font-weight: bolder;
        text-align: right;
        width: 18%
    }

    .arm_member_logindetail_data {
        float: left;
        font-size: 14px;
        padding-left: 10px;
        width: 75%;
        max-width: 80%
    }

    .arm_member_detail_logindetail_heading {
        background-color: #6f6f6f;
        border-radius: 8px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -o-border-radius: 8px;
        color: var(--arm-cl-white);
        float: left;
        font-size: 18px;
        font-weight: 700;
        padding: 10px 0 10px 20px;
        width: 97%
    }

    .arm_edit_member_link,
    .arm_view_membership_card_btn {
        padding: 5px 25px;
        display: inline-block;
        margin: 0 auto
    }

    .arm_edit_member_link:hover {
        color: var(--arm-cl-white)
    }

    .arm_member_detail_act_more {
        padding: 10px;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        left: 230px;
        position: relative
    }

    .arm_member_detail_list_activity .arm_activity_avtar_section {
        width: 200px;
        padding: 0 20px 0 10px !important;
        text-align: right
    }

    .arm_member_detail_list_activity .arm_dashboard_block {
        padding: 0 10px
    }

    .arm_general_settings_wrapper {
        width: 100%;
        display: block
    }

    .armember_general_settings_wrapper {
        width: 100%;
        float: left;
        border: none;
        border-top: 2px solid var(--arm-gt-gray-50)
    }

    .arm_email_settings_content_text input {
        max-width: 200px
    }

    .arm_general_settings_tab_wrapper {
        width: 100%;
        padding: 0;
        margin-bottom: -1px;
        border-bottom: 1px solid #dee3e9
    }

    .arm_general_settings_tab {
        display: inline-block;
        font-size: 15px;
        line-height: normal;
        margin: 0 0 -1px 0;
        text-decoration: none;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 10px 9px;
        color: #5c5c60;
        border-bottom: 4px solid transparent;
        float: left;
        display: block;
        cursor: pointer;
        position: relative;
        z-index: 9
    }

    .arm_general_settings_tab:first-child {
        padding-left: 2px
    }

    a.arm_general_settings_tab_active,
    a.arm_general_settings_tab_active:hover {
        color: #000;
        font-weight: lighter;
        border-bottom: 4px solid var(--arm-pt-theme-blue)
    }

    .arm_general_settings_tab:hover {
        color: #000;
        font-weight: lighter;
        border-bottom: 4px solid #dee3e9
    }

    .armember_general_settings_wrapper .arm_general_settings_tab_wrapper {
        width: 16.99%;
        height: auto;
        float: left
    }

    .armember_general_settings_wrapper .arm_settings_container {
        width: 82.89%;
        float: right;
        padding-top: 30px;
        min-height: 630px;
        border-left: 1px solid #dee3eb
    }

    .arm_half_section {
        width: 48%;
        float: left;
        padding-right: 20px
    }

    .arm_half_section:last-child {
        padding-right: 0
    }

    .arm_report_analytics_inner_content {
        width: 100%;
        display: block;
        box-sizing: border-box;
        font-family: "Open Sans", sans-serif;
        padding: 15px
    }

    .arm_report_analytics_inner_content .arm_center {
        text-align: center
    }

    .arm_report_analytics_content table {
        width: 100%;
        box-sizing: border-box;
        border-radius: 0;
        table-layout: fixed;
        word-wrap: break-word
    }

    .arm_report_analytics_content table#arm_recent_members_table,
    .arm_report_analytics_content table#arm_recent_transactions_table {
        border: 1px solid var(--arm-gt-gray-50)
    }

    .arm_report_analytics_inner_content table tbody {
        min-height: 200px;
        display: block
    }

    .arm_report_analytics_inner_content table a {
        text-decoration: none
    }

    .arm_report_analytics_inner_content table tr {
        display: table;
        width: 100%
    }

    .arm_report_analytics_inner_content table tr:nth-child(odd) {
        background-color: var(--arm-cl-white)
    }

    .arm_report_analytics_inner_content table tr:nth-child(2n) {
        background-color: var(--arm-cl-white)
    }

    .arm_report_analytics_inner_content table tr:hover td {
        background-color: #e7eef9 !important
    }

    .arm_report_analytics_inner_content table td,
    .arm_report_analytics_inner_content table th {
        padding: 7px 5px;
        word-break: break-word;
        font-size: 13px
    }

    .arm_report_analytics_inner_content table th {
        background: 0 0;
        background-color: var(--arm-gt-gray-10-a);
        border: 0;
        border-bottom: 1.5px solid var(--arm-gt-gray-50);
        color: #3c3e4f;
        font-size: 14px;
        font-weight: 600;
        vertical-align: middle;
        height: 20px
    }

    [dir=rtl] .arm_report_analytics_inner_content table th {
        text-align: right
    }

    .arm_report_analytics_inner_content table td {
        border-bottom: 1px solid #f1f1f1;
        color: var(--arm-gt-gray-500)
    }

    .armchart_plan_section {
        width: 20%;
        float: left;
        box-sizing: border-box;
        border: 1.5px solid var(--arm-gt-gray-50);
        border-radius: 3px;
        margin-right: 20px;
        margin-bottom: 20px;
        height: 335px;
        overflow-y: auto
    }

    .armchart_view_section {
        width: 78%;
        float: left;
        box-sizing: border-box;
        border: 1.5px solid var(--arm-gt-gray-50);
        border-radius: 3px;
        margin-bottom: 20px;
        height: 335px
    }

    .armchart_plan_item {
        display: block;
        padding: 10px 15px;
        border-bottom: 1.5px solid var(--arm-gt-gray-50)
    }

    .armchart_plan_no_item {
        display: block;
        padding: 10px 15px
    }

    .armchart_plan_item .armchart_plan_title {
        font-weight: 700;
        cursor: auto
    }

    .armchart_plan_item .armchart_plan_item_desc {
        color: var(--arm-gt-gray-500);
        margin: 0 auto;
        padding: 0;
        font-size: 12px
    }

    .wrap .arm_report_analytics_content .armchart_display_title.arm_ml_5 {
        margin-left: 5px
    }

    .arm_member_form_additional_content {
        display: none
    }

    .arm_pd-20 {
        padding: 20px
    }

    #arm_member_social_ac_selection_chosen.chosen-container {
        border: none !important;
        margin-bottom: 10px
    }

    #arm_member_social_ac_selection_chosen .chosen-single {
        height: 35px;
        line-height: 35px;
        background: 0 0 !important;
        box-shadow: none;
        border: 1px solid #d2d2d2;
        border-radius: 3px
    }

    #arm_member_social_ac_selection_chosen .chosen-single div b {
        background-position: 0 7px;
        background-color: var(--arm-cl-white)
    }

    #arm_member_social_ac_selection_chosen.chosen-container-active .chosen-single div b {
        background-position: -18px 7px
    }

    #arm_member_social_ac_selection_chosen.chosen-container-single .chosen-search input[type=text] {
        min-width: 100%
    }

    #arm_member_social_ac_selection-error {
        display: none;
        margin-top: 5px
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        box-sizing: unset !important
    }

    .ColVis {
        float: right;
        margin-bottom: 1em
    }

    button.ColVis_Button::-moz-focus-inner {
        border: none !important;
        padding: 0
    }

    .ColVis_text_hover {
        border: 1px solid #999;
        background-color: #f0f0f0
    }

    div.ColVis_collection button.ColVis_Button {
        background-color: #fff;
        width: 100%;
        float: none;
        margin-bottom: 2px
    }

    div.ColVis_catcher {
        position: absolute;
        z-index: 1101
    }

    .disabled {
        color: #999
    }

    .dataTables_wrapper.no-footer .dataTables_scrollBody {
        border-bottom: 0 !important
    }

    .DTFC_LeftBodyLiner {
        overflow-y: unset !important
    }

    .ColVis_Button .ColVis_radio input {
        margin-top: -8px !important
    }

    .wrap #armember_datatable_1_wrapper div.ColVis,
    .wrap #armember_datatable_wrapper div.ColVis {
        margin-bottom: 0
    }

    .dataTables_wrapper .ColVis_Button .ColVis_radio input {
        margin-left: 10px;
        margin-right: 10px
    }

    .dataTables_wrapper .ColVis_collection .ColVis_Button {
        width: 100% !important;
        text-align: left;
        margin-bottom: 2px;
        padding-left: 0 !important;
        padding-right: 0 !important;
        background-color: #fff
    }

    table.display td.center,
    table.display th.center {
        text-align: center
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0 !important
    }

    @media only screen and (min-device-width: 1300px) and (max-device-width:1340px) {
        .armember_general_settings_wrapper .arm_settings_container {
            width: 82.82%
        }
    }

    @media screen and (min-width: 1024px) and (max-width:1280px) {

        .arm_bulk_coupon_form_fields_popup_div,
        .arm_member_manage_plan_detail_popup,
        .arm_preview_setup_shortcode_popup_wrapper {
            width: 86% !important;
            left: 7% !important
        }

        .arm_general_settings_main_wrapper .arm_global_settings_content {
            padding: 0 !important
        }

        .arm_half_section {
            width: 48%
        }

        .arm_report_analytics_inner_content table tbody {
            min-height: auto
        }
    }

    .arm_settings_container .arm_settings_title_wrapper {
        padding: 3px 40px 25px 40px
    }

    .arm_invoice_reset_btn_div {
        width: 30%;
        float: left
    }

    #arm_invoice_reset_btn {
        float: right
    }

    .arm_settings_container .arm_settings_title_wrapper .arm_setting_title {
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        font-size: 20px;
        color: var(--arm-pt-theme-blue);
        float: left;
        margin-bottom: 12px;
        width: 100%
    }

    .armember_general_settings_wrapper .arm_general_settings_tab {
        display: inline-block;
        font-size: 15px;
        line-height: 22px;
        margin: 0 0 -1px 0;
        text-decoration: none;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 14px 5px 14px 15px;
        color: #5c5c60;
        border-bottom: 4px solid transparent;
        float: left;
        display: block;
        cursor: pointer;
        position: relative;
        z-index: 9;
        width: 100%;
        border-bottom: 1px solid #dee3eb
    }

    .armPageContainer {
        padding-left: 10px
    }

    .armember_general_settings_wrapper .armPageContainer {
        padding-left: 0
    }

    .armember_general_settings_wrapper .arm_global_settings_main_wrapper {
        padding-left: 30px
    }

    .armember_general_settings_wrapper a.arm_general_settings_tab_active,
    .armember_general_settings_wrapper a.arm_general_settings_tab_active:hover {
        color: var(--arm-pt-theme-blue);
        font-weight: lighter;
        border-bottom: 2px solid var(--arm-pt-theme-blue);
        border-right: none;
        width: 101.1%;
        border-right: 1px solid var(--arm-cl-white)
    }

    .armember_general_settings_wrapper .arm_general_settings_tab:hover {
        color: #000;
        font-weight: lighter;
        border-bottom: 1px solid #dee3e9
    }

    .armember_general_settings_wrapper .arm_admin_form .form-table th {
        min-width: 150px;
        width: 150px
    }

    .armember_general_settings_wrapper .arm_import_export_container .arm_admin_form .form-table th {
        min-width: 150px;
        width: 150px
    }

    .armember_general_settings_wrapper .arm_admin_form .form-table th.armember_general_setting_lbl {
        min-width: 162px;
        padding: 15px 8px 15px 0
    }

    .arm_settings_container {
        padding-top: 10px
    }

    .arm_settings_container .arm_import_export_container,
    .arm_settings_container form.arm_admin_form {
        max-width: 1100px
    }

    .armPageContainer,
    .arm_settings_container {
        position: relative
    }

    .armBankTransferFields label {
        display: block !important;
        margin: 0 0 5px !important
    }

    .arm_block_settings_content {
        padding: 10px
    }

    .arm_block_urls_option_fields {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 0;
        margin: 10px 5px 5px
    }

    .arm_block_urls_option_fields label {
        display: block;
        width: 100%
    }

    .arm_block_urls_option_fields span {
        display: inline-block;
        margin-right: 10px
    }

    .arm_plan_list_metabox {
        float: left
    }

    .arm_access_rules_wrapper {
        float: left;
        width: 100%
    }

    .arm_rules_filters {
        display: block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_access_rules_grid_wrapper .hidden_col {
        width: 0;
        display: none
    }

    .arm_members_list_detail_popup_text .arm-no-sort,
    .arm_rule_grid_list .arm-no-sort {
        cursor: default !important
    }

    .arm_members_list_detail_popup_text .arm-no-sort .DataTables_sort_wrapper,
    .arm_rule_grid_list .arm-no-sort .DataTables_sort_wrapper {
        padding: 0 !important
    }

    .arm_members_list_detail_popup_text .arm-no-sort .DataTables_sort_wrapper .DataTables_sort_icon,
    .arm_rule_grid_list .arm-no-sort .DataTables_sort_wrapper .DataTables_sort_icon {
        display: none
    }

    .arm_rule_grid_list .arm_grid_main_header,
    .arm_rule_grid_list tr.arm_grid_main_header {
        background-color: var(--arm-cl-white) !important
    }

    .arm_rule_grid_list .arm_grid_filter_header th,
    .arm_rule_grid_list tr.arm_grid_filter_header th {
        max-height: 60px;
        height: 60px;
        border-bottom: 1px #e5e5e5 solid
    }

    .arm_rule_grid_list table.dataTable thead tr td,
    .arm_rule_grid_list table.dataTable thead tr th {
        height: 38px
    }

    .arm_rule_grid_list .dataTables_scroll table.dataTable tbody tr td {
        text-align: center
    }

    .arm_rule_grid_list .armGridSearchBox {
        min-width: 200px !important;
        font-weight: 400
    }

    .arm_rule_grid_list .arm_rule_item_description {
        display: inline-block;
        width: 100%;
        font-size: 12px;
        font-style: italic;
        line-height: normal;
        color: #999
    }

    .DTFC_LeftBodyWrapper table.dataTable tbody tr td:last-child {
        text-align: justify
    }

    .DTFC_LeftBodyWrapper table.dataTable tbody tr td:first-child {
        min-width: 222px
    }

    .DTFC_LeftBodyWrapper table.dataTable tbody tr td:nth-child(2) {
        min-width: 69px
    }

    .arm_menu_belt {
        background-color: var(--arm-cl-white);
        float: left;
        margin-top: 25px;
        width: 100%;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-box-shadow: 0 0 8px 0 #ccc;
        -moz-box-shadow: 0 0 8px 0 #ccc;
        -o-box-shadow: 0 0 8px 0 #ccc;
        box-shadow: 0 0 8px 0 #ccc
    }

    .arm_menu_belt_li {
        display: inline-block;
        margin: 0;
        float: left
    }

    .arm_menu_belt_link {
        cursor: pointer;
        display: inline-block;
        font-size: 15px;
        margin-left: 10px;
        padding: 15px 5px;
        text-decoration: none
    }

    .arm_access_container {
        float: left;
        width: 100%;
        margin-top: 30px
    }

    .arm_access_left_menu_container {
        float: left;
        width: 250px;
        position: relative;
        z-index: 9999
    }

    .arm_access_right_detail_container {
        border: 1px solid #394263;
        float: left;
        padding: 10px;
        width: 855px;
        position: relative;
        z-index: 999;
        min-height: 300px
    }

    .arm_left_menu_li {
        float: left;
        width: 100%;
        border: 1px solid #394263;
        background-color: #394263;
        color: var(--arm-cl-white);
        font-weight: 700;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        cursor: pointer;
        margin: 3px 0
    }

    .arm_left_menu_section_li {
        float: left;
        width: 100%;
        font-weight: 700;
        cursor: pointer
    }

    .arm_left_menu_section_label {
        font-size: 15px;
        font-weight: 700;
        padding: 10px 0;
        margin: 0;
        line-height: 1
    }

    .arm_left_menu_section_label span {
        font-weight: 700;
        float: left;
        padding: 0 5px 0 0
    }

    .arm_left_menu_sub_ul {
        margin-left: 20px !important
    }

    .arm_left_menu_sub_ul li:last-child {
        margin-bottom: 0 !important
    }

    .arm_right_title_div {
        border-bottom: 1px solid #000;
        float: left;
        font-size: 16px;
        font-weight: 700;
        padding: 10px;
        width: 95%
    }

    .arm_right_grid_div {
        float: left;
        width: 97%;
        padding: 10px
    }

    .arm_right_grid {
        width: 100%;
        border: 1px solid #e5e5e5;
        margin-top: 10px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px
    }

    .arm_right_grid_tr {
        margin-bottom: 10px
    }

    .arm_right_grid th {
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid#ddd
    }

    .arm_right_grid td {
        padding: 10px
    }

    .arm_left_menu_active {
        color: #000;
        background-color: var(--arm-cl-white);
        -webkit-box-shadow: 0 0 5px 1px #ccc;
        -moz-box-shadow: 0 0 5px 1px #ccc;
        -o-box-shadow: 0 0 5px 1px #ccc;
        box-shadow: 0 0 5px 1px #ccc;
        border-color: #ccc
    }

    .arm_left_menu_li:hover {
        color: #000;
        background-color: var(--arm-cl-white);
        -webkit-box-shadow: 0 0 5px 1px #ccc;
        -moz-box-shadow: 0 0 5px 1px #ccc;
        -o-box-shadow: 0 0 5px 1px #ccc;
        box-shadow: 0 0 5px 1px #ccc;
        border-color: #ccc
    }

    .arm_left_menu_a {
        color: var(--arm-cl-white);
        font-weight: bolder;
        text-decoration: none;
        display: block;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        padding: 7px 10px
    }

    .arm_left_menu_a:hover {
        color: #000 !important
    }

    .arm_left_menu_a:focus {
        color: var(--arm-cl-white) !important
    }

    .arm_left_menu_li:hover a {
        color: #000 !important
    }

    .arm_left_menu_active a {
        color: #000;
        background-color: var(--arm-cl-white);
        border-right: none
    }

    .arm_menu_belt_link_active {
        border-bottom: 3px solid #000;
        font-weight: 700
    }

    .arm_menu_belt_link:hover {
        border-bottom: 3px solid #000
    }

    .arm_chosen_selectbox,
    .chosen-container {
        min-width: 310px;
        margin: 0
    }

    .arm_rule_field_label {
        display: inline-block;
        margin: 5px 0
    }

    .arm_rule_field_label span {
        margin: 0 15px 0 7px;
        vertical-align: middle
    }

    .arm_rule_type_options {
        display: inline-block;
        width: 100%;
        height: 100%;
        min-height: 50px;
        max-height: 200px;
        overflow: auto
    }

    .arm_rule_type_options .arm_main_label {
        font-weight: 400;
        display: inline-block
    }

    .arm_admin_sub_menu_container {
        margin-left: 20px
    }

    .arm_access_rule_plans,
    .arm_access_rule_titles {
        color: var(--arm-gt-gray-500);
        text-decoration: none;
        line-height: 20px;
        display: inline-block
    }

    .arm_access_rule_plans a,
    .arm_access_rule_titles a {
        text-decoration: none;
        cursor: pointer;
        display: block
    }

    .arm_access_rule_titles p {
        margin: 0;
        padding: 0;
        display: inline;
        font-size: 11px
    }

    .arm_drip_rule_items,
    .arm_paid_post_items,
    .arm_private_content_items,
    .arm_users_multiauto_items {
        padding: 6px 0 0;
        width: 500px;
        display: inline-block
    }

    .arm_drip_rule_items ul,
    .arm_paid_post_items ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_drip_rule_items li,
    .arm_paid_post_items li {
        max-width: 47%;
        display: inline-block;
        width: 46%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin: 0 0 8px 0
    }

    .arm_drip_rule_items li label,
    .arm_paid_post_items li label {
        display: inline-block;
        max-width: 75%
    }

    .arm_drip_type_options_wrapper {
        margin-top: 25px
    }

    .arm_drip_type_options_wrapper .arm_drip_type_options_container {
        display: inline-block;
        margin-right: 20px;
        vertical-align: top;
        position: relative;
        margin-bottom: 25px
    }

    .arm_drip_type_options_wrapper:not(.arm_edit_drip_type_options_dates, .arm_drip_type_options_dates) .arm_drip_type_options_container {
        width: 100%
    }

    .arm_drip_type_options_wrapper .arm_drip_expire_after_immediate,
    .arm_drip_type_options_wrapper .arm_drip_type_options_container .arm_drip_expire_after_days,
    .arm_drip_type_options_wrapper .arm_drip_type_options_container .arm_drip_expire_post_modify,
    .arm_drip_type_options_wrapper .arm_drip_type_options_container .arm_drip_expire_post_publish,
    .arm_drip_type_options_wrapper .arm_drip_type_options_container .arm_edit_drip_expire_after_days,
    .arm_drip_type_options_wrapper .arm_drip_type_options_container .arm_edit_drip_expire_post_modify,
    .arm_drip_type_options_wrapper .arm_drip_type_options_container .arm_edit_drip_expire_post_publish,
    .arm_drip_type_options_wrapper .arm_edit_drip_expire_after_immediate {
        margin-top: 25px
    }

    .arm_drip_type_options_wrapper label {
        display: inline-block;
        text-align: center
    }

    .arm_drip_type_options_wrapper label.arm_hide_after_drip {
        min-width: 75px;
        text-align: left
    }

    .arm_drip_type_options_wrapper span {
        display: block;
        font-size: 12px;
        font-style: italic;
        text-align: right
    }

    .arm_drip_type_options_wrapper .arm_drip_duration_type {
        width: 115px;
        margin-left: 5px !important
    }

    .arm_drip_type_options_wrapper .arm_drip_type_time {
        width: 85px
    }

    .arm_drip_type_options_wrapper .arm_drip_duration_type span,
    .arm_drip_type_options_wrapper .arm_drip_type_time span {
        text-align: left;
        font-style: normal
    }

    .arm_drip_type_options_wrapper span.error {
        display: inline-block;
        font-size: 14px;
        font-style: normal;
        margin-left: 80px;
        text-align: left
    }

    .arm_add_new_drip_rule_wrapper_frm .arm_drip_enable_post_type_opts input[type=number],
    .arm_add_new_drip_rule_wrapper_frm .arm_drip_type_options_wrapper input[type=number],
    .arm_edit_drip_rule_wrapper .arm_drip_type_options_wrapper input[type=number],
    .arm_edit_drip_rule_wrapper_frm .arm_drip_enable_post_type_opts input[type=number] {
        width: 100px;
        min-width: 100px;
        margin-left: 5px
    }

    .arm_add_new_drip_rule_wrapper_frm .arm_drip_type_options_wrapper input[type=text],
    .arm_edit_drip_rule_wrapper .arm_drip_type_options_wrapper input[type=text] {
        width: 170px;
        min-width: 170px;
        margin-left: 5px
    }

    .arm_drip_post_type_label {
        margin-right: 10px;
        display: inline-block
    }

    div.arm_drip_post_type_label {
        margin-bottom: 5px
    }

    .arm_drip_post_type_name {
        margin-right: 10px;
        display: inline-block
    }

    .arm_drip_item_name_label {
        font-weight: 700
    }

    input[type=text].ui-autocomplete-input {
        background-position: 99% center;
        background-size: 20px
    }

    input[type=text].ui-autocomplete-loading {
        background: url(../images/arm_loader.gif) 99% center no-repeat;
        background-size: 20px
    }

    .arm_drip_rule_itembox,
    .arm_page_wrapper .arm_private_content_main_wrapper .arm_private_content_itembox,
    .arm_paid_post_itembox,
    .arm_users_auto_items,
    .arm_users_multiauto_items .arm_users_multiauto_itembox {
        display: inline-block;
        position: relative;
        padding: 6px 25px 5px 8px;
        margin: 0 5px 5px 0;
        background: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white);
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_drip_rule_itembox label,
    .arm_page_wrapper .arm_private_content_main_wrapper .arm_admin_form .form-table td label,
    .arm_paid_post_itembox label,
    .arm_users_multiauto_itembox label {
        cursor: default;
        display: inline-block
    }

    .arm_page_wrapper .arm_private_content_main_wrapper .arm_admin_form .form-table td label {
        color: var(--arm-cl-white)
    }

    .arm_drip_rule_itembox span,
    .arm_page_wrapper .arm_private_content_main_wrapper .arm_private_content_itembox span,
    .arm_paid_post_itembox span,
    .arm_remove_user_multiauto_selected_itembox {
        display: inline-block;
        width: 10px;
        padding: 0;
        margin: 0;
        position: absolute;
        top: 4px;
        right: 8px;
        text-align: center;
        font-weight: 700;
        font-size: 18px;
        cursor: pointer
    }

    .arm_private_content_main_wrapper table .arm_default_private_content_editor {
        width: 97%;
        float: left;
        margin-bottom: 20px
    }

    .arm_add_edit_private_content_form .arm_private_content_editor {
        width: 70%;
        float: left
    }

    .arm_private_content_wrapper .arm_admin_form input[type=text] {
        width: 575px
    }

    .arm_private_content_wrapper .arm_shortcode_label {
        font-size: 16px;
        float: left;
        margin-top: 6px;
        margin-right: 15px
    }

    .arm_private_content_wrapper #arm_default_private_content_save {
        margin-top: 30px
    }

    .arm_private_content_wrapper .arm_defualt_private_content_title {
        margin-bottom: 10px
    }

    .arm_private_content_wrapper .arm_shortcode_text {
        float: left
    }

    .arm_private_content_wrapper .armCopyText,
    .arm_private_content_wrapper .arm_click_to_copy_text .arm_private_content_wrapper .arm_copied_text {
        font-size: 16px
    }

    .arm_private_content_wrapper .arm_belt_box .arm_belt_block .arm_shortcode_text {
        width: 215px
    }

    .arm_auto_paid_post_field ul,
    .arm_auto_user_field .ui-menu,
    .arm_drip_rule_items_list_container .ui-menu,
    .arm_drip_rule_items_list_container ul,
    .arm_multiauto_user_field .ui-menu,
    .arm_paid_plan_auto_selection .ui-menu,
    .arm_paid_post_items_list_container .ui-menu,
    .arm_paid_post_items_list_container ul,
    .arm_private_content_main_wrapper .ui-menu,
    .arm_private_content_main_wrapper ul {
        list-style: none;
        max-width: 500px;
        padding: 0;
        background: var(--arm-cl-white);
        border: 1px solid #d2d2d2;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        border-top: none;
        border-radius: 0 0 3px 3px;
        -webkit-border-radius: 0 0 3px 3px;
        -moz-border-radius: 0 0 3px 3px;
        -o-border-radius: 0 0 3px 3px;
        color: #333;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        z-index: 99999
    }

    .arm_private_content_main_wrapper .ui-menu,
    .arm_private_content_main_wrapper ul {
        max-width: 575px
    }

    .arm_auto_paid_post_field .ui-menu .ui-menu-item,
    .arm_auto_user_field .ui-menu .ui-menu-item,
    .arm_drip_rule_items_list_container .ui-menu .ui-menu-item,
    .arm_drip_rule_items_list_container ul li,
    .arm_multiauto_user_field .ui-menu .ui-menu-item,
    .arm_paid_post_items_list_container .ui-menu .ui-menu-item,
    .arm_paid_post_items_list_container ul li,
    .arm_private_content_main_wrapper .ui-menu .ui-menu-item,
    .arm_private_content_main_wrapper ul li {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        font-size: 13px;
        line-height: 15px;
        padding: 0;
        width: 100%;
        margin-bottom: 0;
        border: 0;
        cursor: pointer;
        word-wrap: break-word;
        white-space: normal
    }

    .arm_auto_paid_post_field .ui-menu .ui-menu-item,
    .arm_auto_user_field .ui-menu .ui-menu-item,
    .arm_multiauto_user_field .ui-menu .ui-menu-item,
    .arm_private_content_main_wrapper .ui-menu .ui-menu-item,
    .arm_private_content_main_wrapper ul li {
        padding: 2px
    }

    .arm_private_content_main_wrapper .arm_shortcode_label {
        width: 100%
    }

    .arm_private_content_main_wrapper .arm_form_shortcode_box {
        margin-top: 10px
    }

    .arm_auto_paid_post_field .ui-menu .ui-menu-item a,
    .arm_auto_user_field .ui-menu .ui-menu-item a,
    .arm_drip_rule_items_list_container .ui-menu .ui-menu-item a,
    .arm_multiauto_user_field .ui-menu .ui-menu-item a,
    .arm_paid_post_items_list_container .ui-menu .ui-menu-item a,
    .arm_private_content_main_wrapper .ui-menu .ui-menu-item a {
        text-decoration: none;
        display: inline-block;
        width: 100%;
        color: inherit;
        border: 0;
        margin: 0;
        padding: 5px 6px;
        zoom: 1
    }

    .arm_auto_paid_post_field .ui-menu li.ui-state-focus,
    .arm_auto_paid_post_field .ui-menu li:focus,
    .arm_auto_paid_post_field .ui-menu li:hover,
    .arm_auto_user_field .ui-menu li.ui-state-focus,
    .arm_auto_user_field .ui-menu li:focus,
    .arm_auto_user_field .ui-menu li:hover,
    .arm_drip_rule_items_list_container .ui-menu-item:focus,
    .arm_drip_rule_items_list_container .ui-menu-item:hover,
    .arm_drip_rule_items_list_container .ui-state-focus,
    .arm_drip_rule_items_list_container li:focus,
    .arm_drip_rule_items_list_container li:hover,
    .arm_multiauto_user_field .ui-menu li.ui-state-focus,
    .arm_multiauto_user_field .ui-menu li:focus,
    .arm_multiauto_user_field .ui-menu li:hover,
    .arm_paid_post_items_list_container .ui-menu-item:focus,
    .arm_paid_post_items_list_container .ui-menu-item:hover,
    .arm_paid_post_items_list_container .ui-state-focus,
    .arm_paid_post_items_list_container li:focus,
    .arm_paid_post_items_list_container li:hover,
    .arm_private_content_main_wrapper .ui-menu-item:hover,
    .arm_private_content_main_wrapper li:hover {
        border: 0;
        background: var(--arm-pt-theme-blue) !important;
        color: var(--arm-cl-white) !important;
        outline: 0
    }

    .arm_drip_rule_items_list_container .ui-menu-item-selected,
    .arm_drip_rule_items_list_container .ui-menu-item-selected a,
    .arm_drip_rule_items_list_container .ui-menu-item-selected:hover,
    .arm_drip_rule_items_list_container li.ui-menu-item-selected,
    .arm_drip_rule_items_list_container li.ui-menu-item-selected:hover,
    .arm_paid_post_items_list_container .ui-menu-item-selected,
    .arm_paid_post_items_list_container .ui-menu-item-selected a,
    .arm_paid_post_items_list_container .ui-menu-item-selected:hover,
    .arm_paid_post_items_list_container li.ui-menu-item-selected,
    .arm_paid_post_items_list_container li.ui-menu-item-selected:hover {
        color: #ccc !important;
        background: 0 0 !important;
        outline: 0;
        cursor: default !important
    }

    .arm_drip_custom_content_shortcode {
        color: #72aa6b;
        background-color: #f3fff1;
        border: 1px solid rgba(114, 170, 107, .5);
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        display: inline-block;
        padding: 4px 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_add_new_drip_rule_wrapper .arm_drip_custom_content_shortcode,
    .arm_edit_drip_rule_wrapper .arm_drip_custom_content_shortcode {
        width: 500px
    }

    .arm_drip_custom_content_shortcode pre {
        padding: 3px 0;
        margin: 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_preview_log_detail_popup_wrapper .popup_content_text {
        padding: 0
    }

    .arm_private_content_wrapper .arm_belt_box .arm_add_new_item_box {
        margin: 0
    }

    .arm_preview_log_detail_popup_wrapper table td,
    .arm_preview_log_detail_popup_wrapper table th {
        color: #32323a;
        font-size: 14px;
        border-bottom: 1px solid #eaeaea;
        padding: 15px 10px;
        vertical-align: top
    }

    .arm_preview_log_detail_popup_wrapper table th {
        width: 244px;
        text-align: right
    }

    .arm_preview_log_detail_popup_wrapper table td {
        color: var(--arm-gt-gray-500);
        text-align: left
    }

    .arm_preview_access_rule_popup table th {
        font-size: 15px;
        text-align: right
    }

    .arm_preview_access_rule_popup table td,
    .arm_preview_access_rule_popup table th {
        padding: 10px 5px;
        color: #32323a
    }

    .arm_transactions_detail_popup_text table {
        margin-bottom: 25px
    }

    .arm_transactions_detail_popup_text table tr:last-child td,
    .arm_transactions_detail_popup_text table tr:last-child th {
        border-bottom: 0
    }

    .arm_preview_log_detail_popup_wrapper .popup_footer {
        background: #f5f5f5
    }

    .arm_mobile_wrapper .popup_content_text input:not([type=button], [type=file], [type=checkbox], [type=radio]) {
        min-width: 250px
    }

    .popup_content_text input[type=checkbox],
    .popup_content_text input[type=radio] {
        min-width: 20px
    }

    .arm_rule_item_sub_titles,
    .arm_rule_item_titles,
    .arm_rule_subscription_plan_names {
        margin: 0;
        padding: 0 10px;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_rule_item_sub_titles {
        margin: 0 0 0 10px
    }

    .arm_rule_item_titles_admin_menus .arm_rule_item_sub_titles {
        margin: 5px 0 0 20px
    }

    .arm_rule_item_titles li,
    .arm_rule_subscription_plan_names li {
        list-style: outside none none;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 400
    }

    .arm_rule_item_titles_admin_menus li {
        font-weight: 700
    }

    .arm_rule_item_titles_admin_menus .arm_rule_item_sub_titles li {
        list-style-type: square
    }

    .arm_rule_item_titles li:last-child {
        margin: 0
    }

    .arm_rule_item_sub_titles li {
        font-weight: 400
    }

    .arm_multiple_selectbox dd ul li {
        position: relative;
        cursor: pointer
    }

    .arm_multiple_selectbox dd ul li:before {
        content: '';
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        z-index: 9
    }

    .arm_multiple_selectbox dd ul li .icheckbox_minimal-red {
        margin: 0 6px 0 0;
        vertical-align: top
    }

    .arm_multiple_selectbox input[type=checkbox] {
        margin-right: 6px;
        vertical-align: middle;
        display: inline-block
    }

    .arm_multiple_selectbox dd ul li:hover .icheckbox_minimal-red {
        background: url(../images/icheck_icons_selectbox.png) no-repeat;
        background-position: -20px 0
    }

    .arm_multiple_selectbox dd ul li:hover .icheckbox_minimal-red.hover {
        background-position: -20px 0
    }

    .arm_multiple_selectbox dd ul li:hover .icheckbox_minimal-red.checked {
        background-position: -40px 0
    }

    .arm_multiple_selectbox dd ul li label {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        color: #333;
        font-size: 13px
    }

    .arm_multiple_selectbox.column_level_dd dd,
    .arm_selectbox.column_level_dd dd {
        float: left;
        width: 100%
    }

    .arm_user_plns_box .arm_member_form_dropdown.arm_selectbox {
        float: left;
        width: 95% !important
    }

    .arm_user_plns_box .arm_subscription_start_date_wrapper {
        position: relative;
        margin-top: 10px;
        float: left;
        width: 100%
    }

    .arm_divider {
        width: 100%;
        border-bottom: #eaedf1 2px dashed;
        display: block;
        margin: 20px 0
    }

    .arm_section_divider {
        width: 100%;
        height: 25px
    }

    .arm_section_divider:after,
    .arm_section_divider:before {
        display: table;
        content: "";
        line-height: 0
    }

    .arm_add_edit_member_form .required_icon {
        font-size: 15px;
        font-weight: 700;
        vertical-align: top;
        color: var(--arm-sc-error);
        display: inline-block;
        margin: 0;
        margin-left: 3px
    }

    .arm_add_edit_member_form .arm_selectbox .arm_autocomplete {
        width: 80%;
        min-width: 80%
    }

    .arm_admin_form .form-sub-table th {
        min-width: auto;
        text-align: left
    }

    .arm_admin_form .form-table th label {
        color: #191818
    }

    .arm_admin_form .arm_custom_currency_fields td,
    .arm_admin_form .arm_custom_currency_fields th {
        min-width: 140px;
        padding: 10px 5px;
        padding: 10px 5px
    }

    .arm_admin_form .arm_custom_currency_fields input[type=text] {
        width: 130px
    }

    .arm_admin_form .arm_sub_section .form-table th {
        min-width: 210px
    }

    .arm_icheckbox[disabled]+ins,
    .arm_iradio[disabled]+ins {
        opacity: .6 !important;
        cursor: not-allowed
    }

    .arm_admin_form button.disabled,
    .arm_admin_form button:disabled,
    .arm_admin_form input.disabled,
    .arm_admin_form input:disabled,
    .arm_admin_form select.disabled,
    .arm_admin_form select:disabled,
    .arm_admin_form textarea.disabled,
    .arm_admin_form textarea:disabled {
        opacity: .8;
        cursor: not-allowed
    }

    .arm_admin_form select option:checked {
        background-color: var(--arm-pt-theme-blue) !important;
        color: var(--arm-cl-white) !important
    }

    .arm_admin_form .form-table .arm_login_redirection_referel {
        width: 480px
    }

    .arm_admin_form input[type=number] {
        padding: 0 0 0 10px
    }

    .arm_admin_form input[readonly] {
        background: var(--arm-cl-white);
        opacity: .8;
        cursor: not-allowed;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        border-color: #dbe1e8 !important
    }

    .arm-form-table-content .arm_stripe_popup_title_note {
        font-size: 13px;
        display: inline-block
    }

    .arm_stripe_popup_icon_container .arm_stripe_popup_icon_wrapper {
        cursor: not-allowed
    }

    .arm_stripe_popup_icon_wrapper input[type=file][disabled] {
        z-index: -1
    }

    .form-table th,
    .form-wrap label {
        color: #5c5c60
    }

    .arm_profiles_directories_templates_container {
        position: relative;
        overflow: hidden
    }

    .arm_add_membership_card_templates,
    .arm_add_profiles_directories_templates,
    .arm_profiles_directories_content {
        position: absolute;
        width: 100%;
        transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -webkit-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -moz-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -ms-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -o-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -webkit-transition-delay: .05s;
        transition-delay: .05s;
        -webkit-transition-delay: .05s;
        -moz-transition-delay: .05s;
        -o-transition-delay: .05s;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden
    }

    .arm_profiles_directories_content {
        top: 0;
        left: -100%
    }

    .arm_add_membership_card_templates,
    .arm_add_profiles_directories_templates {
        max-width: 1100px;
        top: 0;
        left: 100%
    }

    .arm_add_membership_card_templates.arm_visible,
    .arm_add_profiles_directories_templates.arm_visible,
    .arm_profiles_directories_content.arm_visible {
        transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -webkit-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -moz-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -ms-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -o-transition: all .3s cubic-bezier(.215, .061, .355, 1);
        -webkit-transition-delay: .05s;
        transition-delay: .05s;
        -webkit-transition-delay: .05s;
        -moz-transition-delay: .05s;
        -o-transition-delay: .05s;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden
    }

    .arm_profiles_directories_content.arm_visible {
        left: 0
    }

    .arm_add_membership_card_templates.arm_visible,
    .arm_add_profiles_directories_templates.arm_visible {
        left: 0;
        padding: 0 40px
    }

    .arm_sticky_top_belt {
        position: fixed;
        width: 100%;
        left: 0;
        top: 0;
        z-index: 101;
        border-top: 0;
        background: #f2f2f2;
        box-shadow: 0 1px 4px 0 #c1c1c1;
        -moz-box-shadow: 0 1px 4px 0 #c1c1c1;
        -webkit-box-shadow: 0 1px 4px 0 #c1c1c1;
        -o-box-shadow: 0 1px 4px 0 #c1c1c1;
        margin: 0;
        padding: 0 0 0 160px;
        display: none;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_sticky_top_belt .arm_belt_box {
        padding: 10px 15px;
        margin: 35px 0 0 0
    }

    .folded .arm_sticky_top_belt {
        padding: 0 0 0 40px
    }

    .arm_membership_setup_navigation_link_box {
        margin-top: 10px
    }

    .arm_social_login_custom_image {
        max-width: 200px;
        height: auto
    }

    .arm_social_login_label_container {
        float: left;
        display: inline-block;
        width: 5%
    }

    .arm_social_login_custom_icon_container {
        float: right;
        width: 100% !important
    }

    .arm_social_login_icon_container .arm_old_file img {
        width: 200px;
        height: auto
    }

    .arm_social_login_icon_container1 {
        float: right;
        margin-top: 5px;
        width: 82%
    }

    .arm_social_login_icon_container1 .armFileRemoveContainer {
        display: none
    }

    .arm_current_status_text {
        display: inline-block
    }

    .remained_login_attempts_notice {
        font-size: 12px
    }

    .arm_payment_gateway_bank_transfer {
        padding-top: 15px
    }

    .arm_form_field_settings_field_input.arm_icon_search_input {
        width: 260px !important
    }

    .arm_prefix_suffix_icons_container .arm_icon_search {
        padding-bottom: 10px
    }

    .arm_setup_plan_skin_preview {
        float: right;
        margin-right: 10px;
        width: 224px
    }

    .arm_plan_skin1_preview_box .arm_setup_check_circle {
        min-width: 30px !important
    }

    .arm_plan_skin1_preview_box .arm_module_plan_description {
        color: #626676;
        font-size: 16px
    }

    .arm_badge_confirm_box_body {
        min-width: 305px !important
    }

    .arm_edit_admin_badge.arm_highlight {
        border: 3px solid #369 !important;
        cursor: pointer
    }

    .arm_edit_user_admin_badge {
        cursor: pointer
    }

    .arm_badge_error_red {
        color: red;
        font-size: 12px
    }

    @media only screen and (max-width: 960px) {
        .arm_sticky_top_belt {
            padding: 0 0 0 40px
        }

        .arm_half_section {
            width: 100%;
            float: left;
            padding-right: 0
        }

        .arm_report_analytics_inner_content table tbody {
            min-height: auto
        }

        .armchart_view_section {
            width: 77%
        }
    }

    @media screen and (max-width: 782px) {
        .arm_sticky_top_belt {
            padding: 0
        }

        .arm_sticky_top_belt .arm_belt_box {
            margin-top: 48px
        }

        .arm_half_section {
            width: 100%;
            float: left;
            padding-right: 0
        }

        .arm_report_analytics_inner_content table tbody {
            min-height: auto
        }

        .armchart_plan_section {
            width: 100%;
            margin-right: 0
        }

        .armchart_view_section {
            width: 100%
        }
    }

    @media screen and (max-width: 600px) {
        .arm_sticky_top_belt {
            top: -100%
        }

        .arm_half_section {
            width: 100%;
            float: left;
            padding-right: 0
        }

        .arm_report_analytics_inner_content table tbody {
            min-height: auto
        }
    }

    .arm_template_action_belt a {
        font-size: 18px;
        padding: 8px 20px 5px;
        margin: 3px 10px 3px 0;
        vertical-align: middle
    }

    .arm_template_action_belt .arm_temp_back_to_list {
        padding: 8px 10px 7px;
        margin-left: 15px
    }

    .arm_template_action_belt a img {
        margin-right: 5px
    }

    .arm_template_plans_select {
        min-width: 200px
    }

    .arm_setup_preview_btn {
        cursor: pointer;
        min-width: 110px;
        font-size: 18px;
        line-height: 24px;
        text-decoration: none;
        text-align: center;
        vertical-align: middle;
        text-decoration: none;
        padding: 8px 20px 7px;
        margin: 3px 10px 3px 0;
        border-radius: 50px;
        -webkit-border-radius: 50px;
        -o-border-radius: 50px;
        -moz-border-radius: 50px
    }

    .arm_add_temp_preview_btn,
    .arm_membership_card_prv_btn {
        border-radius: 50px;
        -webkit-border-radius: 50px;
        -o-border-radius: 50px;
        -moz-border-radius: 50px;
        cursor: pointer;
        min-width: 110px
    }

    .arm_add_membership_card_template_options_wrapper .page_sub_title,
    .arm_add_template_options_wrapper .page_sub_title {
        padding-left: 30px;
        color: #32323a;
        font-size: 20px;
        font-weight: 600
    }

    .arm_add_membership_card_template_options_wrapper .page_sub_title {
        padding-left: 0
    }

    .arm_add_membership_card_template_options_wrapper .arm_solid_divider,
    .arm_add_template_options_wrapper .arm_solid_divider {
        margin: 15px 0
    }

    .arm_template_option_block {
        padding: 5px 20px 5px 30px
    }

    .arm_add_membership_card_template_options_wrapper .arm_template_option_block {
        padding-left: 0
    }

    .arm_template_option_block .arm_opt_title {
        font-size: 18px;
        font-weight: 500;
        color: #32323a;
        margin-bottom: 10px
    }

    .arm_template_option_block .arm_opt_content {
        padding: 10px 10px 10px 15px
    }

    .arm_directory_template_name_div .arm_opt_content {
        padding-top: 0
    }

    .arm_temp_switch_wrapper {
        display: inline-block;
        max-width: 100%;
        width: 45%;
        margin: 10px 0
    }

    .arm_add_template_form .arm_info_text,
    .arm_common_message_settings .arm_info_text,
    .arm_communication_message_wrapper_frm .arm_info_text,
    .arm_import_export_container .arm_info_text,
    .arm_template_edit_form .arm_info_text {
        font-size: 12px
    }

    .arm_temp_switch_wrapper .armswitch {
        display: inline-block;
        margin-right: 12px;
        vertical-align: middle;
        line-height: normal
    }

    .arm_temp_switch_wrapper .armswitch+label {
        display: inline-block;
        vertical-align: middle;
        line-height: normal
    }

    .arm_opt_content .arm_temp_color_options {
        padding-top: 30px
    }

    .arm_template_option_block .arm_opt_label {
        color: #191818;
        min-width: 140px;
        max-width: 140px;
        vertical-align: top;
        margin-top: 5px;
        display: inline-block
    }

    .arm_add_profiles_directories_templates .arm_temp_font_opts_box .arm_opt_label,
    .arm_add_profiles_directories_templates .arm_temp_opt_box .arm_opt_label {
        width: 260px;
        max-width: 260px
    }

    .arm_temp_opt_box {
        display: inline-block;
        margin-bottom: 20px
    }

    .arm_custom_color_opts,
    .arm_temp_font_opts_box {
        margin-bottom: 20px
    }

    .arm_custom_color_opts .arm_custom_color_picker {
        display: inline-block;
        margin-right: 40px
    }

    .arm_temp_font_opts_box .arm_temp_font_opts .arm_selectbox {
        margin-right: 10px
    }

    .arm_opt_content_wrapper,
    .arm_temp_font_opts_box .arm_temp_font_opts {
        min-width: 500px;
        display: inline-block
    }

    .arm_display_members_fields_selection_wrapper,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper,
    .arm_profile_fields_selection_wrapper {
        display: inline-block;
        width: 480px;
        height: 152px;
        padding-left: 15px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -khtml-box-sizing: border-box;
        background: var(--arm-cl-white);
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px
    }

    .popup_wrapper.arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper,
    .popup_wrapper.arm_pdtemp_edit_popup_wrapper .arm_profile_fields_selection_wrapper {
        width: 95%
    }

    .popup_wrapper.arm_ptemp_add_popup_wrapper .arm_display_members_fields_selection_wrapper,
    .popup_wrapper.arm_ptemp_add_popup_wrapper .arm_profile_fields_selection_wrapper {
        width: 95%
    }

    .arm_display_members_fields_selection_wrapper .arm_display_members_fields_sortable_popup,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_members_fields_sortable_popup,
    .arm_profile_fields_selection_wrapper .arm_profile_fields_sortable,
    .arm_profile_fields_selection_wrapper .arm_profile_fields_sortable_popup {
        display: inline-block;
        min-height: 150px;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin: 0;
        padding: 0;
        max-height: 150px;
        overflow-x: hidden;
        overflow-y: auto
    }

    .arm_display_members_fields_selection_wrapper .arm_profile_fields_li,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_profile_fields_li,
    .arm_profile_fields_selection_wrapper .arm_profile_fields_li {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin: 5px 0;
        padding: 0;
        list-style: outside none none;
        vertical-align: top;
        cursor: move;
        position: relative
    }

    .arm_profile_fields_li .arm_list_sortable_icon {
        display: block;
        width: 25px;
        height: 25px;
        background: url(../images/drag.png) no-repeat center;
        cursor: move;
        position: absolute;
        right: 0;
        top: 0
    }

    .arm_profile_fields_li:hover .arm_list_sortable_icon {
        background: url(../images/drag_hover.png) no-repeat center
    }

    .arm_display_members_fields_selection_wrapper .arm_profile_fields_li.ui-sortable-helper,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_profile_fields_li.ui-sortable-helper,
    .arm_profile_fields_selection_wrapper .arm_profile_fields_li.ui-sortable-helper {
        margin-left: 10px
    }

    .arm_display_members_fields_selection_wrapper .arm_profile_fields_li_place_holder,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_profile_fields_li_place_holder,
    .arm_profile_fields_selection_wrapper .arm_profile_fields_li_place_holder {
        margin: 0;
        min-height: 30px
    }

    .arm_custom_color_opts .arm_custom_color_picker label,
    .arm_template_edit_form .arm_pdtemp_color_opts label.arm_colorpicker_label {
        border: 1px #d2d2d2 solid;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        overflow: hidden
    }

    .arm_custom_color_opts .arm_custom_color_picker label input,
    .arm_pdtemp_color_opts label.arm_colorpicker_label input {
        max-width: 85px;
        height: 100%;
        border: 1px solid #dbe1e8 !important;
        border-width: 0 0 0 1px !important;
        border-top-left-radius: 0;
        -webkit-border-top-left-radius: 0;
        -moz-border-top-left-radius: 0;
        -o-border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        -webkit-border-bottom-left-radius: 0;
        -moz-border-bottom-left-radius: 0;
        -o-border-bottom-left-radius: 0
    }

    .arm_custom_color_opts .arm_custom_color_picker label input:focus,
    .arm_pdtemp_color_opts label.arm_colorpicker_label input:focus {
        outline: 0;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        border: 1px solid #dbe1e8 !important;
        border-width: 0 0 0 1px !important
    }

    .arm_custom_color_opts .arm_custom_color_picker span {
        display: block;
        text-align: center
    }

    .popup_wrapper.arm_template_preview_popup {
        max-height: 90%;
        height: 90%;
        width: 100%;
        transition: all .3s linear 0s;
        -moz-transition: all .3s linear 0s;
        -ms-transition: all .3s linear 0s;
        -webkit-transition: all .3s linear 0s;
        -o-transition: all .3s linear 0s;
        position: fixed !important;
        top: 50px !important;
        margin: 0;
        overflow: hidden
    }

    .arm_template_preview_popup .popup_wrapper_inner {
        display: inline-block;
        max-height: 100%;
        overflow: hidden
    }

    .arm_template_preview_popup .popup_header {
        font-size: 24px;
        font-weight: 600;
        color: var(--arm-dt-black-200)
    }

    .arm_template_preview_popup .popup_header span {
        line-height: 26px
    }

    .arm_template_preview_popup .popup_content_text {
        overflow-x: hidden;
        overflow-y: auto;
        height: 80%
    }

    .arm_directory_templates,
    .arm_profile_templates {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin: 10px 0
    }

    .arm_temp_color_options {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_temp_font_settings_wrapper {
        display: inline-block;
        width: 100%;
        margin: 5px 0 10px
    }

    .arm_temp_font_settings_wrapper .arm_temp_font_setting_label {
        min-width: 140px;
        display: inline-block
    }

    .arm_add_template_box {
        display: inline-block;
        text-align: center;
        max-width: 260px;
        width: 250px;
        margin: 0 10px 20px 5px;
        border-radius: 2px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -o-border-radius: 2px;
        position: relative;
        vertical-align: top;
        cursor: pointer
    }

    .arm_add_template_box .arm_add_template_box_content {
        min-height: 300px;
        position: relative;
        overflow: hidden;
        border: 1.5px solid var(--arm-gt-gray-100);
        background-color: var(--arm-gt-gray-10-a);
        border-radius: var(--arm-radius-12px);
        -webkit-border-radius: var(--arm-radius-12px);
        -moz-border-radius: var(--arm-radius-12px);
        -o-border-radius: var(--arm-radius-12px)
    }

    @media screen and (max-width: 1320px) and (min-width:1310px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 295px
        }
    }

    @media screen and (max-width: 1310px) and (min-width:1300px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 290px
        }
    }

    @media screen and (max-width: 1300px) and (min-width:1280px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 285px
        }
    }

    @media screen and (max-width: 1280px) and (min-width:1260px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 280px
        }
    }

    @media screen and (max-width: 1260px) and (min-width:1240px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 275px
        }
    }

    @media screen and (max-width: 1240px) and (min-width:1220px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 270px
        }
    }

    @media screen and (max-width: 1220px) and (min-width:1200px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 265px
        }
    }

    @media screen and (max-width: 1200px) {
        .arm_add_template_box .arm_add_template_box_content {
            min-height: 260px
        }
    }

    .arm_tempalte_type_box,
    label.arm_tempalte_type_box {
        display: inline-block;
        padding: 6px;
        margin-right: 20px;
        position: relative;
        border: 1px solid #e1e5e6;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        margin-bottom: 20px !important
    }

    .arm_temp_selected_text {
        display: none
    }

    .arm_tempalte_type_box.arm_active_temp {
        border: 1px #00b2f1 solid
    }

    .arm_tempalte_type_box.arm_active_temp .arm_temp_selected_text {
        display: block;
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        text-align: center;
        text-transform: uppercase;
        background-color: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white);
        padding: 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        line-height: normal
    }

    .arm_tempalte_type_box input {
        opacity: 0;
        position: absolute
    }

    .arm_profile_template_selection label.arm_tempalte_type_box,
    .arm_tempalte_type_box {
        margin-right: 15px
    }

    .arm_profile_template_selection .arm_tempalte_type_box img {
        width: 180px;
        max-width: 180px
    }

    .arm_add_template_box .arm_add_template_box_content:hover {
        border-color: var(--arm-pt-theme-blue-darker)
    }

    .arm_add_template_box img {
        margin-top: 80px
    }

    .arm_add_template_box .arm_add_template_label {
        display: inline-block;
        font-size: 16px;
        color: var(--arm-dt-black-200);
        text-align: center;
        width: 100%;
        font-weight: 500;
        margin-top: 6px
    }

    .arm_add_template_box:hover .arm_add_template_label,
    .arm_add_template_box:hover .fa-stack-1x,
    .arm_add_template_box:hover .fa-stack-2x {
        color: var(--arm-pt-theme-blue)
    }

    .arm_add_template_box .arm_fa_add_icon {
        display: inline-block;
        margin: 20px 0 0;
        color: #c6c6c6;
        font-size: 3.5em
    }

    .arm_template_content_wrapper {
        display: inline-block;
        text-align: center;
        max-width: 320px;
        min-width: 250px;
        width: 29%;
        margin: 0 20px 20px 5px;
        border-radius: 2px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -o-border-radius: 2px;
        position: relative;
        float: left;
        min-height: 420px
    }

    .arm_template_content_main_box {
        height: auto;
        position: relative;
        overflow: hidden;
        border: 6px solid var(--arm-cl-white);
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, .2);
        -webkit-box-shadow: 0 0 5px 0 rgba(0, 0, 0, .2);
        -moz-box-shadow: 0 0 5px 0 rgba(0, 0, 0, .2);
        -o-box-shadow: 0 0 5px 0 rgba(0, 0, 0, .2);
        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -o-border-radius: 6px
    }

    .arm_template_content_main_box:hover {
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, .2);
        -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, .2);
        -moz-box-shadow: 0 0 20px 0 rgba(0, 0, 0, .2);
        -o-box-shadow: 0 0 20px 0 rgba(0, 0, 0, .2)
    }

    .arm_template_content_wrapper .arm_confirm_box {
        margin: -20px 10px 0
    }

    .arm_template_content_wrapper a {
        display: block;
        cursor: pointer;
        text-decoration: none
    }

    .arm_template_content_option_links {
        background-color: rgba(47, 64, 92, .8);
        text-align: right;
        padding: 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 100%;
        position: absolute;
        bottom: 0;
        transition: transform .5s;
        -webkit-transition: -webkit-transform .5s;
        -moz-transition: -moz-transform .5s;
        -ms-transition: -ms-transform .5s;
        -o-transition: -o-transform .5s;
        transform: translate(0, 110%);
        -webkit-transform: translate(0, 110%);
        -moz-transform: translate(0, 110%);
        -ms-transform: translate(0, 110%);
        -o-transform: translate(0, 110%)
    }

    .arm_template_name_div {
        background-color: rgba(47, 64, 92, .8);
        padding: 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 100%;
        height: 40px;
        line-height: 24px;
        overflow: hidden;
        position: absolute;
        top: -100px;
        color: var(--arm-cl-white);
        transition: transform .5s;
        -webkit-transition: -webkit-transform .5s;
        -moz-transition: -moz-transform .5s;
        -ms-transition: -ms-transform .5s;
        -o-transition: -o-transform .5s;
        transform: translate(0, -100px);
        -webkit-transform: translate(0, -100px);
        -moz-transform: translate(0, -100px);
        -ms-transform: translate(0, -100px);
        -o-transform: translate(0, -100px)
    }

    .arm_template_content_main_box:hover .arm_template_name_div {
        transform: translate(0);
        -webkit-transform: translate(0, 0);
        -moz-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0);
        top: 0
    }

    .arm_template_content_main_box:hover .arm_template_content_option_links,
    .armopen .arm_template_content_option_links {
        transform: translate(0);
        -webkit-transform: translate(0);
        -moz-transform: translate(0);
        -ms-transform: translate(0);
        -o-transform: translate(0)
    }

    .arm_template_content_option_links a {
        display: inline-block;
        cursor: pointer;
        text-decoration: none;
        padding: 5px;
        margin-right: 5px
    }

    .arm_template_content_main_box .arm_template_content_option_links img {
        vertical-align: top;
        box-shadow: none;
        display: inline-block;
        padding: 0;
        width: auto;
        height: auto
    }

    .arm_template_content_wrapper .arm_template_title {
        font-size: 20px;
        display: block;
        margin: 10px 0 5px;
        color: #3e3e3e;
        cursor: default
    }

    .arm_template_content_wrapper .arm_short_code_detail {
        margin: 10px 0;
        min-height: 60px
    }

    .arm_template_content_wrapper img {
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        text-align: center;
        max-width: 100%;
        width: 100%;
        max-height: 300px;
        height: auto
    }

    .arm_template_content_wrapper .arm_shortcode_text {
        font-size: 14px !important;
        max-height: 22px !important
    }

    .arm_template_content_wrapper.arm_active_template {
        -webkit-box-shadow: 0 0 1px 1px #61deec;
        -moz-box-shadow: 0 0 1px 1px #61deec;
        -o-box-shadow: 0 0 1px 1px #61deec;
        box-shadow: 0 0 1px 1px #61deec
    }

    .arm_edit_template_wrapper {
        display: none;
        position: absolute;
        bottom: 52px;
        left: -30px;
        border: 0;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        background-color: #ececec;
        -webkit-box-shadow: 0 0 10px 1px #aaa;
        -moz-box-shadow: 0 0 10px 1px #aaa;
        -o-box-shadow: 0 0 10px 1px #aaa;
        box-shadow: 0 0 10px 1px #aaa;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        z-index: 9990;
        padding: 10px;
        width: 400px
    }

    .arm_template_edit_form .arm_colorpicker_label input {
        min-width: 80px;
        width: 85px
    }

    .arm_edit_template_wrapper .arm_edit_template_arrow {
        position: absolute;
        right: 60px;
        bottom: -14px;
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border-top: 15px solid #ececec;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        margin: 0 37px 0 0;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 0;
        height: 0
    }

    .arm_template_edit_form .arm_edit_template_field {
        text-align: left;
        margin: 0 20px 5px 0;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_pdtemp_color_opts {
        display: inline-block;
        max-width: 48%;
        width: 350px;
        padding: 7px 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_pdtemp_color_opts span {
        display: inline-block;
        width: 160px;
        vertical-align: middle
    }

    .arm_pdtemp_color_opts label {
        display: inline-block;
        vertical-align: middle;
        margin: 0 !important
    }

    .arm_edit_template_wrapper .armemailaddbtn {
        height: auto;
        width: auto;
        min-width: 70px;
        margin: 5px
    }

    .arm_common_message_settings input[type=text] {
        max-width: 600px
    }

    .plan_duration_options label {
        min-width: 200px;
        margin: 5px 0
    }

    table.plan_duration_options tr td:first-child {
        vertical-align: top;
        padding-top: 15px
    }

    .social_setting_form_field_map {
        display: inline-block;
        margin-bottom: 15px;
        width: 48%
    }

    .social_setting_form_field_map label {
        margin-right: 5px;
        min-width: 100px
    }

    #arm_social_reg_email_name-error,
    #arm_social_reg_user_name-error {
        float: left;
        margin-left: 110px
    }

    .arm_communication_message_wrapper_frm .form-table th,
    .arm_responses_message_wrapper_frm .form-table th {
        min-width: 110px;
        width: 110px
    }

    .arm_communication_message_wrapper_frm .form-table th {
        width: 150px
    }

    .arm_communication_message_wrapper_frm textarea,
    .arm_responses_message_wrapper_frm textarea {
        min-height: 250px;
        max-height: 260px;
        border: 0
    }

    .arm_email_content_area_left {
        display: inline-block;
        float: left;
        width: 69%;
        margin-right: 15px;
        color: var(--arm-dt-black-300);
        font-size: 14px;
        font-weight: 500;
        vertical-align: top
    }

    .arm_email_content_area_right {
        display: inline-block;
        max-width: 350px;
        min-width: 195px;
        height: 350px;
        width: 29%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_email_content_area_right .arm_sec_head {
        color: #3c3e4f;
        margin-bottom: 5px;
        display: block;
        font-size: 18px
    }

    .arm_shortcode_wrapper {
        width: 100%;
        height: 90%;
        overflow-x: hidden;
        overflow-y: auto;
        border: 1px #dbe1e8 solid;
        padding: 10px 9px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_current_plan_warning {
        color: #dd3d36;
        padding-left: 40px;
        margin-bottom: 10px
    }

    .arm_editor_heading {
        background-color: var(--arm-cl-white);
        border-bottom: 1px solid #d5d5d5;
        position: fixed;
        top: 30px;
        display: block;
        width: 85%;
        max-height: 65px;
        height: 63px;
        z-index: 999;
        padding: 15px 0 10px
    }

    .arm_editor_heading .page_title {
        background: 0 0;
        margin: 0;
        padding: 10px 32px;
        min-height: 35px;
        height: auto;
        vertical-align: middle;
        line-height: 40px;
        font-size: 22px;
        font-weight: 500
    }

    .arm_editor_heading .arm_form_member_main_field_label span,
    .arm_editor_heading .arm_header_registration_form_title {
        font-size: 20px;
        font-weight: 300;
        line-height: normal;
        vertical-align: middle;
        display: inline-block
    }

    .arm_editor_heading .arm_editor_heading_action_btns {
        float: right;
        max-width: 400px;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 0 10px;
        text-align: center;
        vertical-align: middle
    }

    .arm_editor_heading .arm_form_shortcode_container {
        float: right;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 0;
        margin-right: 20px
    }

    .arm_editor_heading .arm_form_shortcode_container span {
        font-size: 20px;
        vertical-align: middle;
        line-height: normal
    }

    .arm_editor_heading_action_btns a {
        margin: 0 5px 5px 5px;
        max-width: 130px
    }

    .arm_editor_wrapper {
        position: relative;
        top: 85px;
        width: 100%;
        height: 100%;
        display: block
    }

    .arm_editor_left,
    .arm_editor_right {
        position: fixed;
        top: 118px;
        max-width: 40%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        bottom: 0;
        height: auto;
        margin: 0 !important;
        border: 1px solid #cfcfcf
    }

    .arm_editor_left {
        width: 270px
    }

    .arm_editor_right {
        width: 340px;
        right: 0
    }

    .arm_editor_right_wrapper {
        width: 100%;
        height: 100%;
        box-shadow: -2px 0 6px 0 rgba(50, 50, 50, .25);
        -webkit-box-shadow: -2px 0 6px 0 rgba(50, 50, 50, .25);
        -moz-box-shadow: -2px 0 6px 0 rgba(50, 50, 50, .25);
        -o-box-shadow: -2px 0 6px 0 rgba(50, 50, 50, .25)
    }

    .arm_editor_center {
        position: relative;
        width: 500px;
        top: 10px;
        left: 20px
    }

    .arm_editor_left+.arm_editor_center {
        left: 290px
    }

    .arm_form_width_belt,
    .arm_profile_width_belt {
        border-top: 1px solid #cfcfcf;
        border-left: 1px solid #cfcfcf;
        border-right: 1px solid #cfcfcf;
        border-bottom: none;
        height: 20px;
        margin: 35px auto;
        max-width: 100%;
        position: relative
    }

    .arm_editor_form_fileds_wrapper {
        width: 100%;
        float: left;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_editor_form_divider {
        display: inline-block;
        width: 100%;
        height: 20px
    }

    .arm_form_width_text,
    .arm_profile_width_text {
        border: 1px solid #cfcfcf;
        text-align: center;
        margin-top: -15px;
        display: inline-block;
        max-width: 70px;
        background: var(--arm-cl-white);
        padding: 3px 6px 0;
        line-height: normal;
        position: absolute;
        left: 45%
    }

    .arm_form_addnew_fields_section {
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 0 10px;
        width: 96%
    }

    .arm_form_addnew_title {
        font-size: 16px;
        color: #3c3e4f;
        padding: 10px 0
    }

    .arm_form_addnew_fields_container {
        width: 100%;
        display: table;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin-bottom: 5px
    }

    .arm_form_addnew_fields_separator {
        background-color: var(--arm-cl-white);
        height: 15px;
        margin: 10px 0 5px;
        -webkit-box-shadow: 0 0 5px 1px #ddd;
        -moz-box-shadow: 0 0 5px 1px #ddd;
        box-shadow: 0 0 5px 1px #ddd
    }

    .arm_form_addnew_user_fields {
        overflow-y: auto;
        overflow-x: hidden
    }

    .arm_form_addnew_field_wrapper {
        width: 360px;
        height: auto;
        position: absolute;
        right: 0;
        top: 30px;
        display: none;
        background: 0 0
    }

    .arm_form_addnew_field_inner {
        float: left;
        width: 100%;
        height: auto;
        padding: 0 10px;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        height: 450px;
        overflow-y: scroll
    }

    .arm_form_addnew_field_close_inner {
        float: left;
        width: 100%;
        height: auto;
        padding: 10px;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box
    }

    .arm_form_addnew_field_label {
        float: left;
        width: 90px;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        height: 30px
    }

    .arm_form_addnew_field_input {
        float: left;
        width: 200px;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box
    }

    .arm_form_addnew_form_ok_btn {
        float: left;
        width: auto
    }

    .arm_form_addnew_btn_field_inner {
        padding-top: 0 !important
    }

    .arm_form_addnew_field_arrow {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border-bottom: 25px solid #d4e4f4;
        border-left: 25px solid transparent;
        border-right: 25px solid transparent;
        float: right;
        height: 0;
        margin: 0 37px 0 0;
        width: 0
    }

    .arm_form_addnew_field_input_required_wrapper .arm_form_field_settings_field_label {
        height: 14px;
        line-height: 14px
    }

    .arm_field_type_list {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .frmfieldtypebutton {
        display: inline-block;
        max-width: 300px;
        width: 97%;
        background-color: var(--arm-cl-white);
        border: 1px #e8e9eb solid;
        padding: 5px 10px;
        font-size: 15px;
        line-height: 20px;
        color: var(--arm-pt-theme-blue);
        margin: 0 0 8px 8px;
        list-style: outside none none;
        cursor: pointer;
        z-index: 9999;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .frmfieldtypebutton:hover {
        box-shadow: 2px 2px 5px 0 rgba(169, 169, 169, .2);
        -webkit-box-shadow: 2px 2px 5px 0 rgba(169, 169, 169, .2);
        -moz-box-shadow: 2px 2px 5px 0 rgba(169, 169, 169, .2);
        -o-box-shadow: 2px 2px 5px 0 rgba(169, 169, 169, .2)
    }

    .arm_new_field a {
        text-decoration: none;
        text-align: left;
        vertical-align: middle;
        color: var(--arm-dt-black-100);
        font-size: 14px
    }

    .frmfieldtypebutton.arm_disabled {
        color: #a2a2a2;
        opacity: .8;
        cursor: not-allowed;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none
    }

    .frmfieldtypebutton.arm_disabled a {
        color: #abadbb;
        cursor: not-allowed
    }

    .arm_new_field a img {
        display: inline-block;
        margin-right: 6px;
        margin-top: 3px;
        float: left
    }

    .arm_disabled_img,
    .frmfieldtypebutton .arm_disabled_img,
    .frmfieldtypebutton.arm_disabled img {
        display: none !important
    }

    .frmfieldtypebutton.arm_disabled .arm_disabled_img {
        display: inline-block !important
    }

    .arm_new_field .fa {
        vertical-align: middle;
        margin: 0 5px
    }

    .arm_form_addnew_social_fields_container {
        margin: 0 0 40px
    }

    .arm_enable_social_profile_fields_link {
        display: inline-block;
        max-width: 300px;
        width: 97%;
        margin: 0 0 8px 8px;
        padding: 5px 10px;
        line-height: 22px;
        cursor: pointer;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border-radius: 2px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -o-border-radius: 2px
    }

    .arm_enable_social_profile_fields_link.arm_disabled {
        opacity: .8;
        cursor: not-allowed;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        background-color: #f5f5f5;
        border-color: #e8e9eb !important;
        color: #a2a2a2
    }

    .arm_configure_submission_redirection_link {
        display: inline-block;
        max-width: 300px;
        width: 97%;
        padding: 5px 10px;
        line-height: 22px;
        cursor: pointer;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border-radius: 2px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -o-border-radius: 2px
    }

    .arm_settings_form_addnew_form_btn {
        float: left;
        width: 80px;
        margin: 0 15px 0 0
    }

    .arm_form_settings_styles_container {
        overflow-y: auto;
        overflow-x: hidden;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        background: var(--arm-cl-white)
    }

    .arm_admin_member_form .arm-df__form-group_submit .arm-df__heading-text {
        overflow: visible
    }

    .arm_admin_member_form .arm-df__fields-wrapper li.arm-df__form-group:not(.arm-df__form-group_submit):not(.arm-df__heading):hover,
    .arm_admin_member_form .arm_field_content_settings_selected {
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        background-color: transparent;
        border: 1px dashed #9d9e9f
    }

    .arm_section_sortable li:last-child {
        margin-bottom: 0
    }

    .arm_section_fields_placeholder {
        float: left;
        width: 100%;
        height: auto;
        border: 2px dashed #dfdfdf !important;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        list-style: none;
        list-style-type: none;
        padding: 10px;
        text-align: center;
        font-size: 16px;
        margin: 5px 0 !important
    }

    .arm_form_settings_icon {
        padding: 0;
        margin: 0;
        width: auto;
        display: none;
        cursor: pointer;
        position: absolute;
        top: 0;
        right: 0;
        direction: ltr;
        unicode-bidi: bidi-override;
        z-index: 9 !important
    }

    .arm_admin_member_form .arm-df__form-group .arm_confirm_box {
        margin-top: 25px;
        cursor: default;
        top: 0;
        left: auto;
        right: 0
    }

    .arm_admin_member_form .arm-df__form-group .arm_confirm_box .arm_confirm_box_arrow {
        margin-right: 10px;
        float: right
    }

    .arm_admin_member_form .arm-df__form-group_social_fields:hover .arm_form_settings_icon,
    .arm_admin_member_form .arm_field_content_settings_selected .arm_form_settings_icon,
    .arm_admin_member_form .arm_form_field_sortable:hover .arm_form_settings_icon {
        display: block
    }

    .arm_admin_member_form .arm_field_content_settings_selected .arm-df__form-group .arm_form_settings_icon,
    .arm_admin_member_form .arm_form_field_sortable:hover .arm-df__form-group .arm_form_settings_icon {
        display: none
    }

    .arm_admin_member_form .arm_field_content_settings_selected .arm-df__form-group:hover .arm_form_settings_icon,
    .arm_admin_member_form .arm_form_field_sortable:hover .arm-df__form-group:hover .arm_form_settings_icon {
        display: block
    }

    .arm_admin_member_form input#arm_field_border_radius[readonly=readonly] {
        cursor: no-drop;
        background-color: #f6f9ff;
        opacity: .8
    }

    .arm_form_settings_icon a {
        text-decoration: none;
        margin: 6px 5px 0 0;
        display: inline-block;
        line-height: normal
    }

    .arm_no_sortable .arm_form_member_sortable_icon {
        display: none
    }

    .arm_member_form_label .arm-df__heading-text {
        display: inline-block;
        cursor: pointer !important;
        padding: 0 10px;
        min-height: 32px
    }

    .arm_form_member_main_field_label {
        display: inline-block;
        float: none;
        width: auto;
        height: auto;
        line-height: normal;
        padding: 0;
        vertical-align: middle
    }

    button.arm-df__field-label_text,
    input.arm-df__field-label_text {
        position: relative;
        display: inline-block;
        cursor: pointer
    }

    a.arm_form_btn_editable_link {
        display: none;
        position: absolute;
        text-decoration: none;
        line-height: normal;
        top: 0;
        height: 100%;
        width: 25px
    }

    .arm-df__form-group:hover a.arm_form_btn_editable_link {
        display: inline-block;
        background-image: url("../images/fe_edit_grey_icon.png");
        background-repeat: no-repeat;
        background-position: center center;
        top: 0;
        margin-left: 10px
    }

    .arm-df__form-group a.arm_form_btn_editable_link:hover {
        background-image: url("../images/fe_edit_icon.png");
        background-repeat: no-repeat;
        background-position: center center
    }

    .arm_admin_member_form .arm_form_label_wrapper {
        position: relative
    }

    .arm_manage_form_main_wrapper .arm-df__field-label_text {
        cursor: pointer;
        border-bottom: 1px dashed transparent;
        float: left
    }

    .arm_manage_form_main_wrapper .arm-df__field-label_text:hover,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .display_member_field_edit:hover,
    .arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper .display_member_field_edit:hover,
    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper .display_member_field_edit:hover {
        border-bottom: 1px dashed var(--arm-pt-theme-blue)
    }

    .arm_manage_form_main_wrapper .arm_editor_wrapper .arm_editable_form {
        min-width: 300px;
        width: 100%;
        text-align: left;
        position: absolute;
        top: -6px;
        left: 0;
        z-index: 99;
        padding: 0 0 0 5px
    }

    .arm_manage_form_main_wrapper .arm-df__field-label_text button,
    .arm_manage_form_main_wrapper .arm_editable_form button {
        width: 33px;
        height: 33px;
        margin-left: 6px;
        padding: 0;
        border: 0;
        float: left;
        background: 0 0;
        border: 0
    }

    .arm_manage_form_main_wrapper .arm-df__field-label_text i {
        width: 33px;
        height: 33px;
        display: inline-block;
        border: 1px solid #a9a9a9;
        color: #585a5b;
        background-color: #f5f5f5;
        padding: 8px 0;
        text-align: center;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        line-height: 16px;
        font-size: 16px;
        float: left;
        z-index: 99
    }

    .arm_editable_input_button .arm_editable_input_button_inner form input,
    .arm_manage_form_main_wrapper .arm-df__field-label_text input,
    .arm_manage_form_main_wrapper button.arm-df__field-label_text input,
    .arm_manage_form_main_wrapper input.arm-df__field-label_text input {
        padding: 0 6px !important;
        max-width: 80% !important;
        min-width: 210px;
        min-height: 33px;
        max-height: 33px;
        height: 33px;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border: 1px solid var(--arm-pt-theme-blue) !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        background: var(--arm-cl-white) !important;
        color: #5c5c60 !important;
        margin: 0;
        vertical-align: top;
        z-index: 9999;
        float: left;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        font-size: 16px;
        text-decoration: none !important;
        font-weight: 400 !important;
        font-style: normal !important
    }

    .arm_manage_form_main_wrapper button.arm-df__field-label_text .arm_editable_form,
    .arm_manage_form_main_wrapper div.arm_editable_input_button_inner .arm_editable_form,
    .arm_manage_form_main_wrapper input.arm-df__field-label_text .arm_editable_form {
        padding: 0;
        min-width: 100%;
        top: 50%;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -ms-transform: translateY(-50%)
    }

    .arm_manage_form_main_wrapper button.arm-df__field-label_text input,
    .arm_manage_form_main_wrapper button.arm-df__field-label_text input:hover,
    .arm_manage_form_main_wrapper div.arm_editable_input_button_inner input,
    .arm_manage_form_main_wrapper div.arm_editable_input_button_inner input:hover,
    .arm_manage_form_main_wrapper input.arm-df__field-label_text input,
    .arm_manage_form_main_wrapper input.arm-df__field-label_text input:hover {
        min-width: 100%;
        max-width: 100% !important;
        background: var(--arm-cl-white) !important;
        margin: 0 !important
    }

    .arm_manage_form_main_wrapper button.arm-df__field-label_text .arm_editable_form button,
    .arm_manage_form_main_wrapper div.arm_editable_input_button_inner .arm_editable_form button,
    .arm_manage_form_main_wrapper input.arm-df__field-label_text .arm_editable_form button {
        position: absolute;
        top: 0;
        right: -40px;
        background-color: transparent !important
    }

    .arm_manage_form_main_wrapper button.arm-df__field-label_text .arm_editable_form i.arm_editable_close,
    .arm_manage_form_main_wrapper div.arm_editable_input_button_inner .arm_editable_form i.arm_editable_close,
    .arm_manage_form_main_wrapper input.arm-df__field-label_text .arm_editable_form i.arm_editable_close {
        position: absolute;
        top: 0;
        right: -80px
    }

    .arm_manage_form_main_wrapper .arm-df__field-label_text input:focus,
    .arm_manage_form_main_wrapper button.arm-df__field-label_text input:focus,
    .arm_manage_form_main_wrapper input.arm-df__field-label_text input:focus {
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important
    }

    .arm_manage_form_main_wrapper .arm_form_member_main_field_label .arm-df__field-label_text .arm_editable_form {
        top: 0;
        padding: 0;
        float: left;
        min-width: auto;
        height: 30px;
        position: relative
    }

    .arm_manage_form_main_wrapper .arm-df__field-label_text i.arm_editable_ok {
        background: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white);
        border-color: var(--arm-pt-theme-blue)
    }

    .arm_manage_form_main_wrapper .arm-df__field-label_text i.arm_editable_close {
        margin-left: 6px
    }

    .arm_admin_member_form .arm_form_member_main_field_label .arm-df__field-label_text .arm_label_edit_icon,
    .arm_editable_form .arm_label_edit_icon,
    button.arm-df__field-label_text .arm_label_edit_icon,
    div.arm-df__field-label .arm_label_edit_icon,
    input.arm-df__field-label_text .arm_label_edit_icon {
        background-image: url("../images/fe_edit_icon.png");
        background-repeat: no-repeat;
        background-position: center center;
        float: left;
        display: inline-block;
        height: 30px;
        width: 25px;
        background-color: #f4f9fa;
        border: 1px #cacbcc solid;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border-bottom-left-radius: 0;
        -webkit-border-bottom-left-radius: 0;
        -moz-border-bottom-left-radius: 0;
        -o-border-bottom-left-radius: 0;
        border-top-left-radius: 0;
        -webkit-border-top-left-radius: 0;
        -moz-border-top-left-radius: 0;
        -o-border-top-left-radius: 0;
        margin-left: -2px;
        position: absolute;
        right: 0;
        z-index: 1
    }

    .arm-df__form-group .arm-df__field-label_text:not(.arm_editable_input_button_inner) {
        float: left;
        min-height: 25px;
        width: auto
    }

    .arm-df__form-group_place_holder {
        float: left;
        width: 100%;
        height: 60px;
        border: 2px dashed #dfdfdf !important;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        list-style: none;
        list-style-type: none
    }

    .armf_direction_horizontal .arm-df__form-group_place_holder {
        float: left;
        width: auto;
        min-width: 150px;
        height: 45px
    }

    .arm_form_action_options {
        margin: 5px
    }

    .arm_form_action_options input[type=text],
    .arm_form_action_options input[type=url],
    .arm_right_section_body input[type=text],
    .arm_right_section_body input[type=url] {
        margin: 0;
        padding: 3px 6px;
        max-width: 240px;
        width: 240px;
        min-height: 30px;
        display: inline-block;
        font-weight: 400;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px
    }

    .arm_forgot_password_link_options .arm_forgot_password_link_type_option,
    .arm_form_redirection_options .arm_lable_shortcode_wrapper,
    .arm_registration_link_options .arm_registration_link_type_option {
        padding: 6px 0 5px 32px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_editor_wrapper .arm_form_opt_label {
        color: var(--arm-dt-black-400);
        margin: 0 5px 5px 0;
        font-weight: 400
    }

    .arm_editor_wrapper .arm_form_opt_label+.armswitch {
        float: right;
        margin: 2px 10px 0 0
    }

    .arm_form_opt_input {
        margin: 5px 0 5px 5px
    }

    .arm_change_social_login_options,
    a.arm_change_social_login_options {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        text-align: center;
        line-height: normal;
        min-width: 30px;
        padding: 0;
        margin: 0;
        text-decoration: none;
        font-size: 12px;
        color: #717171;
        font-weight: 400
    }

    .arm_change_social_login_options img {
        display: inline-block;
        float: left
    }

    .arm_forgot_password_link_options .arm_forgot_password_link_type_option dt,
    .arm_form_redirection_options .arm_lable_shortcode_wrapper dt,
    .arm_registration_link_options .arm_registration_link_type_option dt {
        width: 220px;
        height: 22px
    }

    .arm_edit_profile_link_options input,
    .arm_forgot_password_link_options input,
    .arm_forgot_password_link_options input.forgot_password_link_label_input,
    .arm_form_opt_input input,
    .arm_form_opt_input input.form_submit_action_input,
    .arm_form_redirection_options .arm_lable_shortcode_wrapper input,
    .arm_registration_link_options input,
    .arm_registration_link_options input.registration_link_label_input {
        width: 270px;
        max-width: 270px;
        min-height: 32px;
        margin-left: 5px
    }

    .arm_form_redirection_options .arm_lable_shortcode_wrapper input.form_action_redirect_conditional_redirect,
    .arm_form_redirection_options .arm_lable_shortcode_wrapper input.form_action_redirect_referral,
    .arm_form_redirection_options .arm_lable_shortcode_wrapper input.form_action_redirect_url {
        width: 240px;
        max-width: 240px;
        min-height: 32px;
        margin-left: 4px
    }

    .arm_tbl_label_left_input_right tr.arm_form_social_btn_options td:last-child,
    .arm_tbl_label_left_input_right tr.arm_form_style_options td:last-child,
    .arm_tbl_label_left_input_right.arm_form_settings_style_block tr td:last-child {
        padding-right: 10px
    }

    .arm_form_existing_options label,
    .arm_form_redirection_options label,
    .arm_profile_form_existing_options label,
    .arm_social_connect_options label {
        font-size: 14px;
        color: #717171;
        font-weight: 400;
        display: inline-block;
        margin-bottom: 3px
    }

    .arm_add_new_edit_profile_form_field,
    .arm_add_new_form_field {
        margin: 2px 20px 2px 2px;
        display: inline-block;
        min-width: 35%
    }

    .arm_slider_box {
        display: none;
        height: auto;
        position: absolute;
        min-width: 150px;
        z-index: 998;
        margin: 15px 0 0 0
    }

    .arm_slider_box_arrow {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border-bottom: 15px solid #e6e6e6;
        border-left: 11px solid transparent;
        border-right: 11px solid transparent;
        float: right;
        height: 0;
        margin: -15px 20px 0 0;
        width: 0;
        position: relative
    }

    .arm_slider_box_container {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        width: 400px;
        -moz-border-radius: 2px;
        -o-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        cursor: auto !important;
        border: 1px solid #dbe1e8;
        -webkit-box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        -moz-box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        -o-box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        background-color: var(--arm-cl-white);
        padding: 0;
        position: relative
    }

    .arm_slider_box_container .arm_slider_box_heading {
        width: 100%;
        max-height: 40px;
        background-color: var(--arm-gt-gray-50-a);
        border-bottom: 1px solid var(--arm-gt-gray-200);
        color: var(--arm-dt-black-200);
        font-size: 16px;
        font-weight: 600;
        line-height: 40px;
        display: block;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        border-top-left-radius: 2px;
        -webkit-border-top-left-radius: 2px;
        -moz-border-top-left-radius: 2px;
        -o-border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        -webkit-border-top-right-radius: 2px;
        -moz-border-top-right-radius: 2px;
        -o-border-top-right-radius: 2px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 0 10px 0 15px
    }

    .arm_slider_box_container .arm_slider_box_body {
        padding: 20px 10px 10px
    }

    .arm_delete_field_confirm_box .arm_slider_box_arrow {
        margin-right: 10px
    }

    .arm_field_delete_btns_container .arm_slider_box_body {
        text-align: center
    }

    .arm_prefix_suffix_icons_container .arm_slider_box_arrow {
        margin-right: 30px
    }

    .arm_prefix_suffix_icons_container .arm_manage_form_fa_icons_container .arm_slider_box_body {
        overflow-x: hidden;
        overflow-y: auto;
        height: 308px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_slider_arrow {
        position: absolute;
        top: 0;
        max-height: 43px;
        height: 43px;
        width: 43px;
        padding: 0;
        margin: 0;
        background-color: var(--arm-cl-white);
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        z-index: 9999;
        color: var(--arm-pt-theme-blue);
        border-radius: 3px 0 0 3px;
        -webkit-border-radius: 3px 0 0 3px;
        -moz-border-radius: 3px 0 0 3px;
        -o-border-radius: 3px 0 0 3px;
        box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25);
        -webkit-box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25);
        -moz-box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25);
        -o-box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25)
    }

    .arm_slider_arrow:focus,
    .arm_slider_arrow:hover {
        -o-box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25) !important;
        -moz-box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25) !important;
        -webkit-box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25) !important;
        box-shadow: -2px 1px 4px 0 rgba(50, 50, 50, .25) !important
    }

    .arm_slider_arrow.arm_slider_arrow_left {
        background-image: url("../images/slider_arrow_left.png");
        background-repeat: no-repeat;
        background-position: center center;
        position: fixed;
        right: 0;
        top: 118px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border-bottom-right-radius: 0;
        -webkit-border-bottom-right-radius: 0;
        -moz-border-radius-bottomright: 0;
        border-top-right-radius: 0;
        -webkit-border-top-right-radius: 2px;
        -moz-border-top-right-radius: 2px
    }

    .arm_slider_arrow.arm_slider_arrow_right {
        background-image: url("../images/slider_arrow_right.png");
        background-repeat: no-repeat;
        background-position: center center;
        left: -43px
    }

    .arm_form_field_settings_menu {
        display: inline-block;
        width: 100%;
        font-size: 13px;
        cursor: auto !important
    }

    .arm_form_field_settings_menu_wrapper {
        width: 430px;
        position: absolute;
        right: 0;
        top: 30px;
        margin-bottom: 15px
    }

    .arm_set_editor_ul .arm_form_field_settings_menu_wrapper {
        right: -35px
    }

    .arm_delete_field_confirm_box {
        right: 0;
        top: 30px;
        width: auto;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_field_delete_btns_container a,
    .arm_field_delete_btns_container a:hover,
    .arm_field_delete_btns_container button,
    .arm_field_delete_btns_container button:hover {
        margin: 5px;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        vertical-align: middle
    }

    .arm_form_field_settings_menu_inner {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: block;
        padding: 5px 0;
        width: 100%
    }

    .arm_form_layout_writer .arm_placeholder_text_container {
        display: none
    }

    .arm_form_field_settings_field_label {
        display: inline-block;
        min-width: 160px;
        max-width: 160px;
        vertical-align: top;
        color: #5c5c60;
        font-size: 14px;
        text-align: right;
        padding: 4px 15px 0 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_field_settings_notice {
        display: inline;
        vertical-align: top;
        color: #5c5c60;
        font-size: 14px
    }

    .arm_form_field_settings_menu_arrow {
        margin-right: 40px
    }

    .arm_form_field_settings_field_val,
    .arm_profile_field_settings_field_val {
        display: inline-block;
        width: 240px;
        max-width: 240px;
        vertical-align: top;
        margin-bottom: 5px
    }

    .arm_form_field_settings_field_val.arm_role_field_options label {
        width: 100%;
        vertical-align: top;
        margin: 2px 0
    }

    .arm_form_field_settings_field_label.arm_html_field_options,
    .arm_form_field_settings_field_val.arm_html_field_options {
        display: inline-block;
        max-width: 100%;
        width: 100%;
        text-align: left;
        padding: 0 10px 5px;
        margin: 0;
        line-height: normal;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_field_settings_field_val.arm_html_field_options textarea {
        height: 90px;
        margin: 0 0 10px
    }

    .arm_form_field_settings_field_val_btn {
        float: left;
        width: 100px;
        margin: 0 15px 0 0
    }

    .arm_field_loader_img {
        float: right;
        position: relative;
        margin: 12px
    }

    .arm_form_field_settings_field_val_ok_btn {
        float: right;
        color: var(--arm-cl-white) !important
    }

    .arm_add_member_page {
        width: auto
    }

    .arm_add_edit_coupon_main_wrapper .armemailaddbtn {
        vertical-align: middle
    }

    .arm_add_member_page .arm_admin_form_field_container {
        cursor: auto
    }

    .arm_add_member_page .arm_form_field_input {
        padding: 10px 0
    }

    .arm_member_status_btns {
        position: relative;
        display: inline-block
    }

    .arm_member_status_btns .arm_ms_action_btn {
        font-size: 16px;
        text-decoration: none
    }

    .arm_manage_forms_content {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        float: left;
        padding: 0;
        width: 100%;
        margin-bottom: 10px;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS"
    }

    .arm_form_content_box {
        position: relative;
        min-width: 255px;
        background: var(--arm-cl-white);
        margin-bottom: 30px;
        padding: 0;
        line-height: 1
    }

    .arm_form_content_box a {
        text-decoration: none;
        color: #333
    }

    table.arm_sub_form_list tr {
        border: 0
    }

    .arm_form_content_box .arm_form_heading {
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        color: #3c3e4f;
        font-size: 20px;
        font-weight: 400;
        padding: 20px 40px 5px 40px;
        margin: 0 0 10px;
        vertical-align: middle
    }

    .arm_form_content_box .arm_form_heading span {
        vertical-align: middle;
        display: inline-block;
        margin-top: 10px
    }

    .arm_form_content_box .arm_add_new_form_btn,
    .arm_form_content_box .arm_add_new_other_forms_btn,
    .arm_form_content_box .arm_add_new_profile_forms_btn {
        height: auto;
        min-width: auto;
        display: inline-block;
        float: right;
        line-height: 2
    }

    .arm_reg_form_action_btns .arm_confirm_box_body {
        min-width: 320px;
        max-width: 320px
    }

    .arm_reg_form_action_btns .arm_confirm_box_body label {
        display: inline-block;
        width: 100%;
        margin: 2px 0
    }

    .arm_reg_form_action_btns .arm_confirm_box_body .armnote {
        font-size: 12px
    }

    .arm_form_content_box .arm_form_action_btns a {
        display: inline-block;
        margin: 0 4px
    }

    .arm_form_content_box .arm_form_action_btns img {
        display: block;
        width: 22px;
        height: 22px
    }

    .arm_form_content_box .arm_form_action_btns .arm_confirm_box {
        right: 20px
    }

    .arm_form_content_box .arm_form_shortcode_col {
        color: #777;
        min-width: 110px
    }

    .arm_drip_shortcode_box span,
    .arm_form_shortcode_box span {
        display: block;
        white-space: nowrap;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis
    }

    .arm_page div.arm_shortcode_text.arm_drip_shortcode_box {
        max-width: 220px
    }

    .arm_form_shortcode_box .arm_copied_text {
        z-index: 10;
        background: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white)
    }

    .arm_form_shortcode_box .arm_copied_text img {
        vertical-align: middle;
        margin: -2px 4px 0;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        width: auto;
        height: auto;
        display: inline-block;
        padding: 0
    }

    .arm_membership_setups_list .arm_form_content_box .arm_form_date_col {
        max-width: 150px;
        width: 150px;
        color: #a7a7a7
    }

    .arm_right_section_heading {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 10px;
        width: 100%;
        background-color: #f6f9ff;
        font-size: 16px;
        font-weight: 600;
        color: var(--arm-dt-black-500);
        position: relative;
        box-shadow: 0 0 1px 0 #ddd;
        -webkit-box-shadow: 0 0 1px 0 #ddd;
        -moz-box-shadow: 0 0 1px 0 #ddd;
        -o-box-shadow: 0 0 1px 0 #ddd;
        border: 0
    }

    .arm_right_section_body {
        padding: 10px 6px 15px 15px
    }

    .arm_form_special_section_heading {
        background: #e1e6ef
    }

    .arm_form_special_section_body {
        background: #f1f6ff
    }

    .arm_form_setting_options_head {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 10px;
        width: 100%;
        background-color: #f9f7f8;
        font-size: 16px;
        color: #3c3e4f;
        position: relative;
        box-shadow: 0 0 1px 0 #ddd;
        -webkit-box-shadow: 0 0 1px 0 #ddd;
        -moz-box-shadow: 0 0 1px 0 #ddd;
        -o-box-shadow: 0 0 1px 0 #ddd;
        font-weight: 700
    }

    .add_new_form_redirection_field {
        padding-left: 30px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_settings_style_container {
        padding: 5px 5px 5px 15px;
        background: var(--arm-cl-white)
    }

    .arm_form_settings_style_block {
        font-size: 14px;
        color: var(--arm-dt-black-400) !important;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_custom_css_wrapper {
        margin-top: 15px
    }

    .arm_form_custom_css_wrapper textarea {
        width: 96%;
        min-height: 180px;
        font-weight: 400;
        direction: ltr !important;
        text-align: left !important
    }

    .arm_form_settings_style_block .arm_form_settings_style_block {
        padding-left: 10px
    }

    .arm_form_settings_style_block tr td {
        padding: 5px 0;
        min-width: 41px
    }

    .arm_form_settings_style_block .arm_form_settings_style_block tr td {
        padding: 2px 0
    }

    .arm_form_settings_style_block input.arm_form_setting_input {
        min-height: 34px;
        display: inline;
        font-weight: 400;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        vertical-align: middle
    }

    .arm_form_style_color_schemes {
        position: relative
    }

    .arm_form_styles_fields_container .arm_form_bg_upload_wrapper {
        display: inline-block;
        width: 100%
    }

    .arm_form_styles_fields_container .arm_form_bg_upload_wrapper .armFileUploadWrapper {
        display: inline-block;
        width: 100%;
        vertical-align: top
    }

    .arm_form_styles_fields_container .arm_form_bg_upload_wrapper .armFileMessages {
        display: inline-block;
        line-height: normal
    }

    .arm_form_bg_upload_wrapper .armFileUploadWrapper .armFileRemoveContainer,
    .arm_form_bg_upload_wrapper .armFileUploadWrapper .armFileUploadContainer {
        margin-bottom: 5px;
        height: 30px;
        font-size: 14px;
        padding: 5px 10px;
        line-height: normal;
        margin-right: 0;
        float: right
    }

    .arm_form_bg_upload_wrapper .armFileUploadWrapper .armFileUpload-icon {
        margin: 1px 8px 0 0
    }

    .arm_form_bg_upload_wrapper .armFileUploadWrapper .armFileRemove-icon {
        margin: 2px 8px 0 0
    }

    .arm_form_bg_upload_wrapper .armFileUploadWrapper .arm_image_file_preview {
        max-width: 99%;
        width: 120px
    }

    .arm_form_bg_upload_wrapper .armFileUploadWrapper .arm_image_file_preview img {
        width: 100%;
        height: auto;
        vertical-align: top
    }

    .armFileUploadWrapper p.error_upload_size {
        color: red
    }

    .armFileUploadWrapper input.armFileUpload,
    .armFileUploadWrapper input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        min-width: auto;
        width: 100px;
        height: 40px;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        color: inherit;
        font: inherit;
        margin: 0
    }

    .armFileUploadWrapper .armFileUploadContainer input[type=file] {
        top: -25px;
        height: 60px
    }

    .c_schemes {
        padding: 5px 5px 5px 20px;
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .c_schemes label {
        width: 30px;
        height: 30px;
        margin-right: 5px;
        margin-bottom: 15px !important;
        text-align: center;
        border-radius: 100px;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        -o-border-radius: 100px;
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: transform .2s ease 0s;
        -webkit-transition: transform .2s ease 0s;
        -moz-transition: transform .2s ease 0s;
        -ms-transition: transform .2s ease 0s;
        -o-transition: transform .2s ease 0s
    }

    label.arm_profile_temp_color_scheme_block label.arm_temp_color_scheme_block {
        margin-bottom: 4px;
        padding: 1px;
        overflow: hidden;
        background-size: cover
    }

    .arm_profile_temp_color_scheme_block span,
    .arm_temp_color_scheme_block span {
        display: inline-block;
        height: 100%;
        width: 50%;
        position: absolute;
        top: 0;
        left: 0;
        padding: 0;
        margin: 0
    }

    .arm_profile_temp_color_scheme_block span:first-child,
    .arm_temp_color_scheme_block span:first-child {
        left: 0;
        border-radius: 100px 0 0 100px;
        -webkit-border-radius: 100px 0 0 100px;
        -moz-border-radius: 100px 0 0 100px;
        -o-border-radius: 100px 0 0 100px
    }

    .arm_profile_temp_color_scheme_block span:nth-child(2),
    .arm_temp_color_scheme_block span:nth-child(2) {
        left: 50%;
        border-radius: 0 100px 100px 0;
        -webkit-border-radius: 0 100px 100px 0;
        -moz-border-radius: 0 100px 100px 0;
        -o-border-radius: 0 100px 100px 0
    }

    .arm_profile_temp_color_scheme_block.arm_color_box_active:before,
    .arm_temp_color_scheme_block.arm_color_box_active:before {
        font-size: 11px;
        top: 3px;
        z-index: 9
    }

    .arm_template_font_style_options .arm_font_style_label {
        padding: 5px 5px
    }

    .c_schemes .arm_color_scheme_block_custom {
        margin-bottom: 15px
    }

    .c_schemes .arm_color_scheme_block_custom span {
        font-size: 12px;
        white-space: nowrap;
        margin: 30px 0 0 -60%;
        display: inline-block
    }

    .arm_color_scheme_block_custom:before {
        display: none
    }

    .arm_temp_color_scheme_block_custom,
    .c_schemes .arm_color_scheme_block_custom {
        background: url(../images/custom_color_icon.png) no-repeat center center;
        background-size: 30px 30px
    }

    .c_schemes .arm_color_scheme_block_custom:hover {
        background: url(../images/custom_color_icon_hover.png) no-repeat center center;
        background-size: 30px 30px
    }

    .arm_temp_color_scheme_block_custom.arm_color_box_active:before {
        color: var(--arm-pt-theme-blue)
    }

    .arm_temp_color_scheme_block_custom {
        margin-left: 5px
    }

    .arm_color_block_radio,
    .c_schemes input[type=radio] {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 center;
        border: 0 none;
        left: -9999em;
        margin-left: -10px;
        margin-top: -7px !important;
        opacity: 0;
        position: absolute;
        top: 50%
    }

    .arm_form_custom_style_opts {
        display: none;
        margin: 0;
        width: 290px;
        min-width: 290px;
        margin-bottom: 10px
    }

    .arm_form_custom_style_opts .arm_form_settings_style_block {
        padding: 0
    }

    label.arm_color_box_active {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: 18px;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        transform: translate(0, 0);
        -webkit-transform: translate(0, 0);
        -moz-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0)
    }

    label.arm_color_box_active:before {
        content: "\f111";
        color: var(--arm-cl-white);
        top: 5px;
        position: relative;
        font-size: 10px
    }

    .arm_custom_build {
        display: table;
        width: 100%;
        margin-top: 20px
    }

    .arm_custom_build_section {
        display: table-row;
        width: 100%;
        margin-top: 10px
    }

    .build_row {
        display: table-cell;
        vertical-align: middle;
        max-width: 110px;
        position: relative
    }

    .build_label {
        font-size: 13px;
        padding: 0 5px 0 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: block
    }

    .arm_form_settings_style_container .wp-picker-holder {
        position: absolute;
        z-index: 999;
        right: 0
    }

    .arm_etool_options_container {
        display: block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        margin: 5px 0
    }

    .arm_etool_list_container {
        padding: 5px 10px
    }

    .arm_custom_heading {
        font-weight: 700;
        display: table-row;
        margin-bottom: 5px
    }

    .arm_font_style_label {
        text-align: center;
        border: 1px solid #dbe1e8;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        min-height: 20px;
        line-height: normal;
        padding: 4px 5px;
        margin: 0 6px 0 0;
        width: 25px
    }

    .arm_font_style_label.arm_style_active,
    .arm_page label.arm_font_style_label.arm_style_active {
        color: var(--arm-cl-white);
        background: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue)
    }

    .arm_font_style_label i {
        font-size: inherit;
        background: 0 0 !important;
        line-height: normal;
        vertical-align: baseline
    }

    .arm_font_style_label input {
        display: none
    }

    .arm_button_margin_inputs_container,
    .arm_forgot_password_link_margin_inputs_container,
    .arm_registration_link_margin_inputs_container {
        display: block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_button_margin_inputs,
    .arm_forgot_password_link_margin_inputs,
    .arm_registration_link_margin_inputs {
        display: inline-block;
        width: 43px;
        max-width: 45px;
        font-size: 13px;
        text-align: center;
        vertical-align: middle
    }

    .arm_button_margin_inputs input,
    .arm_forgot_password_link_margin_inputs input,
    .arm_form_opt_input .arm_forgot_password_link_margin_inputs input,
    .arm_form_opt_input .arm_registration_link_margin_inputs input,
    .arm_registration_link_margin_inputs input {
        margin: 0;
        max-width: 38px;
        width: 38px;
        height: 30px;
        display: inline-block;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        text-align: center;
        padding: 3px
    }

    .arm_button_margin_inputs input::-webkit-inner-spin-button,
    .arm_button_margin_inputs input::-webkit-outer-spin-button,
    .arm_forgot_password_link_margin_inputs input::-webkit-inner-spin-button,
    .arm_forgot_password_link_margin_inputs input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none
    }

    .arm_custom_scheme_block {
        width: 300px;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        box-shadow: 1px 0 4px 0 rgba(50, 50, 50, .4);
        -webkit-box-shadow: 1px 0 4px 0 rgba(50, 50, 50, .4);
        -moz-box-shadow: 1px 0 4px 0 rgba(50, 50, 50, .4);
        -o-box-shadow: 1px 0 4px 0 rgba(50, 50, 50, .4);
        background-color: var(--arm-cl-white);
        padding: 0 5px !important
    }

    .arm_custom_scheme_block table {
        width: 100%
    }

    .arm_custom_scheme_arrow {
        margin: -15px 0 0 40px;
        border-bottom-color: #dedede;
        float: left
    }

    .arm_custom_scheme_main_label {
        color: #3c3e4f;
        padding-left: 10px;
        padding-top: 10px
    }

    .arm_custom_scheme_sub_label {
        width: 25%;
        text-align: center;
        vertical-align: top;
        padding: 0 0 5px 0 !important
    }

    .arm_custom_scheme_sub_label span {
        color: #727273;
        display: block;
        line-height: normal;
        margin-top: 8px;
        font-size: 12px
    }

    .arm_custom_scheme_sub_label label {
        width: 22px;
        height: 22px;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        margin-bottom: 0 !important;
        cursor: pointer
    }

    .arm_custom_scheme_colorpicker {
        opacity: 0;
        width: 10px;
        margin: 0 !important;
        padding: 0 !important;
        height: auto;
        cursor: pointer
    }

    .arm_custom_scheme_divider {
        border-bottom: 1px #dbe1e8 solid
    }

    .arm_custom_scheme_container {
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
        border: none !important;
        width: 320px;
        margin-top: 15px
    }

    .arm_custom_scheme_box {
        width: 320px !important;
        margin: -10px 0 10px -10px
    }

    .arm_form_btn_size_options {
        text-align: center;
        display: inline-block;
        width: 42%;
        margin-right: 10px
    }

    .arm_coupons_status_switch,
    .arm_email_notifications_switch,
    .arm_message_communication_switch,
    .arm_plans_status_switch {
        display: inline-block;
        vertical-align: middle
    }

    .arm_coupons_status_switch label,
    .arm_email_notifications_switch label,
    .arm_message_communication_switch label,
    .arm_plans_status_switch label {
        float: left;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        padding: 4px 6px;
        margin: 0;
        color: var(--arm-gt-gray-500);
        font-size: 14px;
        line-height: normal
    }

    .arm_coupons_status_switch label:first-child,
    .arm_email_notifications_switch label:first-child,
    .arm_message_communication_switch label:first-child,
    .arm_plans_status_switch label:first-child {
        border-top-right-radius: 0;
        -webkit-border-top-right-radius: 0;
        -moz-border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        -webkit-border-bottom-right-radius: 0;
        -moz-border-radius-bottomright: 0
    }

    .arm_coupons_status_switch label:nth-child(2),
    .arm_email_notifications_switch label:nth-child(2),
    .arm_message_communication_switch label:nth-child(2),
    .arm_plans_status_switch label:nth-child(2) {
        border-top-left-radius: 0;
        -webkit-border-top-left-radius: 0;
        -moz-border-top-left-radius: 0;
        -o-border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        -webkit-border-bottom-left-radius: 0;
        -moz-border-bottom-left-radius: 0;
        -o-border-bottom-left-radius: 0
    }

    .arm_coupons_status_switch label.active,
    .arm_email_notifications_switch label.active,
    .arm_message_communication_switch label.active,
    .arm_plans_status_switch label.active {
        background-color: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white)
    }

    .arm_coupons_status_switch input,
    .arm_email_notifications_switch input,
    .arm_message_communication_switch input,
    .arm_plans_status_switch input {
        display: none
    }

    .arm_custom_currency_text {
        float: left;
        width: 100%;
        margin: 5px 0 0 28px
    }

    .arm_custom_currency_text span {
        display: inline-block;
        padding: 5px;
        margin-bottom: 5px
    }

    .arm_custom_currency_text strong {
        font-weight: 700;
        margin: 0 2px
    }

    .arm_payment_gateway_currency_label {
        font-weight: 700
    }

    .arm_active_payment_gateways .payment_disabled {
        opacity: .8;
        cursor: not-allowed
    }

    .arm_payment_gateway_currency_link {
        padding-left: 10px;
        vertical-align: middle
    }

    .arm_subscription_plan_main_wrapper .wp-editor-wrap {
        width: 500px
    }

    .arm_enable_up_down_action .chosen-container {
        min-width: 380px
    }

    .chosen-container-multi:not(.chosen-container-active) .chosen-choices li.search-field input.default[type=text] {
        min-width: 250px
    }

    .arm_badge_auto_wrapper_inner_comp {
        margin-right: 15px;
        display: inline-block;
        min-width: 215px
    }

    .arm_badge_auto_wrapper_inner_comp_next {
        display: inline-block
    }

    .arm_add_admin_badge,
    .arm_add_user_badges,
    .arm_edit_admin_badge {
        cursor: pointer;
        display: inline-block;
        padding: 10px;
        background: var(--arm-cl-white);
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        border: 1px solid #aaa !important;
        margin: 0 8px 8px 0;
        opacity: .7;
        vertical-align: top
    }

    .arm_grid_user_badges_list {
        max-width: 350px
    }

    .wrap .arm_user_badges_grid_form .dataTable {
        overflow: visible
    }

    .arm_grid_user_badges_list .arm_edit_user_badge_icon_wrapper {
        display: inline-block;
        vertical-align: middle;
        margin: 0 8px 8px 0;
        position: relative
    }

    .arm_edit_user_badge_delete_link,
    .arm_edit_user_badge_icon_wrapper .arm_edit_user_badge_delete_link {
        display: none
    }

    .arm_grid_user_badges_list .arm_edit_user_badge_icon_wrapper:hover .arm_edit_user_badge_delete_link {
        position: absolute;
        top: 0;
        left: 0;
        display: inline-block;
        font-size: 20px;
        font-weight: 700 !important;
        width: 100%;
        text-align: center;
        height: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 30% 0
    }

    .arm_grid_user_badges_list .arm_edit_user_badge_icon_wrapper .arm_edit_admin_badge {
        margin: 0;
        opacity: 1
    }

    .arm_add_admin_badge img,
    .arm_add_user_badges img,
    .arm_edit_admin_badge img {
        display: block;
        overflow: hidden
    }

    .arm_add_admin_badge.active,
    .arm_add_admin_badge.active:hover,
    .arm_add_admin_badge:hover,
    .arm_add_user_badges.active,
    .arm_add_user_badges.active:hover,
    .arm_add_user_badges:hover {
        border: 1px solid #369 !important;
        box-shadow: 0 0 0 1px #369;
        -webkit-box-shadow: 0 0 0 1px #369;
        -moz-box-shadow: 0 0 0 1px #369;
        -o-box-shadow: 0 0 0 1px #369;
        opacity: 1
    }

    .arm_badge_icon_lists {
        border: 1px solid #ddd;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        float: left;
        height: auto;
        padding: 10px 0 6px 10px;
        width: 500px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    [dir=rtl] .arm_badge_icon_lists {
        float: right;
        padding: 10px 10px 6px 0;
        text-align: right
    }

    #arm_badge_lists {
        border: 1px solid #ddd;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -o-border-radius: 5px;
        float: left;
        height: auto;
        margin-left: 20px;
        margin-top: 5px;
        margin-bottom: 15px;
        padding: 10px 0 6px 10px;
        width: 500px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    [dir=rtl] #arm_badge_lists {
        float: right;
        padding: 10px 10px 6px 0;
        margin-right: 20px;
        margin-left: 0;
        text-align: right
    }

    .arm_badge_edit_tab {
        background-color: #1bbae1;
        color: #fff;
        float: left;
        min-height: 20px;
        margin-bottom: 30px;
        margin-top: 0;
        padding: 15px;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_badge_edit_res_inner_data {
        display: inline-block;
        width: 100%
    }

    .arm_badge_edit_res_inner_img {
        display: inline-block;
        margin-top: 5px;
        vertical-align: middle
    }

    .arm_delete_user_achievement_wrapper a {
        display: inline-block;
        vertical-align: middle
    }

    .arm_delete_user_achievement_wrapper {
        position: relative;
        display: inline-block;
        min-width: 250px
    }

    .arm_badge_edit_res_inner_data .arm_confirm_box {
        left: 0;
        margin-top: -10px
    }

    .arm_badge_edit_res_inner_data .arm_confirm_box .arm_confirm_box_arrow {
        float: left
    }

    .arm_badge_edit_res_inner_data .arm_confirm_box .arm_confirm_box_body {
        margin-top: 15px
    }

    .arm_badge_lable_wrapper {
        display: inline-block;
        float: left;
        margin-top: 17px;
        min-width: 200px;
        max-width: 200px;
        padding-left: 10px
    }

    .arm_user_achievements_name {
        color: #32323a;
        font-size: 18px;
        font-weight: 700 !important
    }

    .arm_navigation_link_detail {
        max-width: 500px;
        margin-top: 10px
    }

    .arm_navigation_link_detail .arm_form_shortcode_box {
        max-width: 330px
    }

    .arm_form_set_list_container .arm_form_shortcode_col ul li {
        display: inline-block;
        min-width: 210px;
        width: 32%;
        margin: 6px 0;
        float: left
    }

    .arm_form_additional_shortcodes .arm_form_shortcode_col h4,
    .arm_form_set_list_container .arm_form_shortcode_col h4 {
        margin: 0 0 8px
    }

    .arm_form_additional_shortcodes .arm_short_code_detail,
    .arm_form_set_list_container .arm_navigation_link_detail,
    .arm_form_set_list_container .arm_short_code_detail {
        display: inline-block;
        width: 100%;
        margin: 10px 0 5px
    }

    .arm_form_additional_shortcodes .arm_short_code_detail .arm_shortcode_title,
    .arm_form_set_list_container .arm_navigation_link_detail .arm_shortcode_title,
    .arm_form_set_list_container .arm_short_code_detail .arm_shortcode_title {
        display: inline-block;
        width: 100%;
        margin: 0 0 3px
    }

    .arm_form_additional_shortcodes .arm_form_shortcode_col {
        min-width: 200px;
        width: 30%
    }

    .arm_form_additional_shortcodes .arm_form_shortcode_col .arm_form_shortcode_box {
        max-width: 280px
    }

    .arm_form_additional_shortcodes .arm_navigation_link_detail .arm_form_shortcode_box,
    .arm_form_set_list_container .arm_navigation_link_detail .arm_form_shortcode_box {
        max-width: 80%
    }

    .arm_navigation_link_detail .arm_shortcode_title,
    .arm_short_code_detail .arm_shortcode_title {
        min-width: 120px;
        display: inline-block;
        cursor: default;
        -webkit-user-select: none;
        -moz-user-select: none;
        -o-user-select: none
    }

    .arm_clear_activities_wrapper {
        display: none;
        position: relative;
        width: 100%;
        text-align: right;
        float: right
    }

    .arm_clear_activities_wrapper.active {
        display: block
    }

    .arm_clear_activities_wrapper a.arm_clear_activities {
        text-decoration: none;
        outline: 0;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none
    }

    .arm_member_plan_role {
        position: relative;
        display: inline-block;
        margin: 0 20px 0 0
    }

    .arm_member_plan_role .arm_ms_action_btn {
        font-size: 16px;
        text-decoration: none
    }

    .arm_import_user_list_detail_popup_wrapper .popup_content_text,
    .arm_members_list_detail_popup_wrapper .popup_content_text,
    .arm_preview_badge_details_popup_wrapper .popup_content_text {
        padding: 0
    }

    .arm_import_user_list_detail_popup_wrapper .popup_content_text .arm_info_text {
        margin: 15px 20px
    }

    .arm_import_user_list_detail_popup_wrapper table td,
    .arm_import_user_list_detail_popup_wrapper table th,
    .arm_preview_badge_details_popup_wrapper table td,
    .arm_preview_badge_details_popup_wrapper table th {
        color: #32323a;
        font-size: 14px;
        border-bottom: 1px solid #eaeaea;
        padding: 15px 20px
    }

    .arm_import_user_list_detail_popup_wrapper table th {
        border-top: 1px solid #eaeaea
    }

    .arm_import_user_list_detail_popup_wrapper table th,
    .arm_preview_badge_details_popup_wrapper table th {
        width: 244px;
        text-align: left
    }

    .arm_import_user_list_detail_popup_wrapper table td,
    .arm_preview_badge_details_popup_wrapper table td {
        color: var(--arm-gt-gray-500);
        text-align: left
    }

    .arm_import_user_list_detail_popup_text {
        max-height: 450px;
        min-height: 200px;
        overflow: auto;
        position: relative
    }

    .arm_import_user_list_detail_popup_text table,
    .arm_preview_badge_details_popup_wrapper table {
        margin-bottom: 25px
    }

    .arm_import_user_list_detail_popup_text table tr:last-child td,
    .arm_import_user_list_detail_popup_text table tr:last-child th,
    .arm_preview_badge_details_popup_wrapper table tr:last-child td,
    .arm_preview_badge_details_popup_wrapper table tr:last-child th {
        border-bottom: 0
    }

    .arm_import_user_list_detail_popup_text table tr td:first-child,
    .arm_import_user_list_detail_popup_text table tr th:first-child,
    .arm_preview_badge_details_popup_wrapper table tr td:first-child,
    .arm_preview_badge_details_popup_wrapper table tr th:first-child {
        padding-left: 30px
    }

    .arm_import_user_list_detail_popup_text table tr td:first-child {
        text-align: center
    }

    .arm_import_user_list_detail_popup_wrapper .popup_footer {
        background: #f5f5f5
    }

    .arm_social_profile_fields_popup_wrapper table {
        width: 100%
    }

    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper,
    .profile_search_fields .arm_profile_search_fields_list_wrapper,
    .social_profile_fields .arm_social_profile_fields_list_wrapper {
        padding: 0
    }

    .profile_display_member_fields,
    .profile_search_fields,
    .social_profile_fields {
        width: 600px
    }

    .profile_display_member_fields {
        width: 680px
    }

    .arm_profile_display_member_fields_list_wrapper,
    .arm_profile_search_fields_list_wrapper,
    .arm_social_profile_fields_list_wrapper {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 15px 0
    }

    .arm_social_profile_fields_list_wrapper .arm_social_profile_field_item {
        display: inline-block;
        vertical-align: top;
        max-width: 180px;
        width: 180px;
        margin: 5px 5px 5px 0
    }

    .arm_profile_search_fields_list_wrapper .arm_profile_search_field_item {
        display: inline-block;
        vertical-align: top;
        max-width: 215px;
        width: 215px;
        margin: 5px 5px 5px 0
    }

    .arm_profile_display_member_fields_list_wrapper .arm_profile_display_member_field_item {
        display: inline-block;
        vertical-align: top;
        max-width: 215px;
        width: 215px;
        margin: 5px 5px 5px 0
    }

    .arm_profile_display_member_fields_list_wrapper .arm_profile_display_member_field_item .icheckbox_minimal-red+label,
    .arm_profile_search_fields_list_wrapper .arm_profile_search_field_item .icheckbox_minimal-red+label,
    .arm_social_profile_fields_list_wrapper .arm_social_profile_field_item .icheckbox_minimal-red+label {
        margin: 0 0 0 5px;
        font-size: 15px
    }

    .arm_member_detail_list_activity .arm_activities_pagination_block .arm_paging_wrapper .arm_page_numbers,
    .arm_member_detail_list_activity .arm_activities_pagination_block .arm_paging_wrapper .arm_page_numbers.arm_next,
    .arm_member_detail_list_activity .arm_activities_pagination_block .arm_paging_wrapper .arm_page_numbers.arm_prev,
    .arm_membership_history_list .arm_failed_attempt_loginhistory_pagination_block .arm_paging_wrapper .arm_page_numbers,
    .arm_membership_history_list .arm_failed_attempt_loginhistory_pagination_block .arm_paging_wrapper .arm_page_numbers.arm_next,
    .arm_membership_history_list .arm_failed_attempt_loginhistory_pagination_block .arm_paging_wrapper .arm_page_numbers.arm_prev,
    .arm_membership_history_list .arm_membership_history_pagination_block .arm_paging_wrapper .arm_page_numbers,
    .arm_membership_history_list .arm_membership_history_pagination_block .arm_paging_wrapper .arm_page_numbers.arm_next,
    .arm_membership_history_list .arm_membership_history_pagination_block .arm_paging_wrapper .arm_page_numbers.arm_prev {
        float: left;
        font-size: 15px;
        text-decoration: none;
        border: 1px solid var(--arm-gt-gray-100);
        background-color: var(--arm-cl-white);
        text-align: center;
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        border-radius: var(--arm-radius-6px);
        width: 32px;
        height: 32px;
        line-height: 1.5;
        padding: 5px;
        display: inline-block;
        cursor: pointer;
        vertical-align: middle;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_prefix_currency_symbol,
    .arm_suffix_currency_symbol {
        color: #5c5c60;
        font-size: 15px
    }

    .arm_prefix_currency_symbol {
        margin: 0 5px
    }

    .arm_suffix_currency_symbol {
        margin-left: 5px
    }

    .arm_plan_payment_cycle_li .arm_prefix_currency_symbol {
        margin: 0
    }

    .arm_plan_payment_cycle_li .arm_suffix_currency_symbol {
        margin-left: 1px
    }

    .arm_admin_form .arm_shortcode_text input:not([type=file]),
    .arm_admin_form .arm_shortcode_text input[type=text],
    .arm_shortcode_text input,
    .arm_shortcode_text input:focus,
    .arm_shortcode_text input:hover,
    .arm_shortcode_text input[type=text],
    .arm_shortcode_text input[type=text]:focus,
    .arm_shortcode_text input[type=text]:hover {
        min-width: 200px !important;
        width: 100%;
        height: auto;
        max-width: 300px !important;
        cursor: default !important;
        font-size: 16px !important;
        font-family: inherit;
        text-align: center;
        border: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        background: 0 0 !important
    }

    .arm_form_row {
        display: table-row;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_row .arm_form_row_input,
    .arm_form_row .arm_form_row_label {
        display: table-cell;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        font-size: 14px
    }

    .arm_form_row .arm_form_row_label {
        min-width: 220px;
        color: #191818;
        text-align: right;
        padding: 10px
    }

    .arm_form_row .arm_form_row_input {
        padding: 5px 10px;
        margin: 0
    }

    .arm_tempalte_type_box img {
        width: 190px;
        max-width: 190px;
        pointer-events: none
    }

    .arm_responsive_icons a {
        text-decoration: none !important;
        color: #333;
        display: inline-block;
        text-align: center;
        width: auto;
        height: 40px;
        margin: 0 20px
    }

    .arm_responsive_icons a.active {
        color: var(--arm-pt-theme-blue)
    }

    .arm_responsive_icons i {
        font-size: 40px;
        display: inline-block;
        vertical-align: middle
    }

    .arm_responsive_icons i.fa-desktop {
        font-size: 32px
    }

    .arm_custom_css_detail_link,
    .arm_section_custom_css_detail_link {
        padding-left: 10px;
        vertical-align: middle
    }

    .arm_section_custom_css_eg {
        font-size: 14px;
        word-break: break-all
    }

    .arm_custom_css_detail_popup_text,
    .arm_section_custom_css_detail_popup_text {
        width: 100%;
        padding: 0 !important;
        position: relative
    }

    .arm_custom_css_detail_list_left_box {
        float: left;
        max-width: 30%;
        width: 270px;
        position: absolute;
        top: 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: inline-block
    }

    .arm_custom_css_detail_list_right_box,
    .arm_section_custom_css_detail_list_right_box {
        width: 70%;
        float: right;
        min-width: 200px;
        min-height: 520px;
        height: 500px;
        overflow-x: hidden;
        overflow-y: auto;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: inline-block;
        border-left: 1px solid #e7e7e7
    }

    [dir=rtl] .arm_custom_css_detail_list_left_box {
        float: right
    }

    [dir=rtl] .arm_custom_css_detail_list_right_box,
    [dir=rtl] .arm_section_custom_css_detail_list_right_box {
        float: left;
        border-left: 0;
        border-right: 1px solid #e7e7e7
    }

    [dir=rtl] .arm_custom_css_detail_title,
    [dir=rtl] .arm_section_custom_css_detail_title {
        margin-right: 30px;
        margin-left: 0
    }

    [dir=rtl] .arm_custom_css_detail_cls,
    [dir=rtl] .arm_section_custom_css_detail_cls {
        padding-right: 30px;
        padding-left: 0
    }

    [dir=rtl] .arm_custom_css_detail_sub_note,
    [dir=rtl] .arm_section_custom_css_detail_sub_note {
        padding-right: 30px;
        padding-left: 0
    }

    .arm_section_custom_css_detail_list_right_box {
        width: 100%;
        border: none
    }

    .arm_custom_css_detail_list ul,
    .arm_custom_css_detail_list ul li {
        margin: 0
    }

    .arm_custom_css_detail_list ul li a {
        border-bottom: 1px solid #dee3e9;
        color: #a2a2a2;
        display: block;
        padding: 12px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        cursor: pointer;
        font-size: 16px;
        text-decoration: none
    }

    .arm_custom_css_detail_list ul li a:hover {
        color: #32323a;
        cursor: pointer
    }

    .arm_custom_css_detail_list ul li a.active,
    .arm_custom_css_detail_list ul li a.active:hover {
        border-bottom: 1px solid var(--arm-pt-theme-blue);
        color: #32323a
    }

    .arm_custom_css_detail_list_item,
    .arm_section_custom_css_detail_list_item {
        margin-bottom: 15px;
        margin-top: 15px
    }

    .arm_custom_css_detail_title,
    .arm_section_custom_css_detail_title {
        font-size: 20px;
        margin-bottom: 15px;
        margin-left: 30px
    }

    .arm_custom_css_detail_cls,
    .arm_section_custom_css_detail_cls {
        color: #e984fe;
        font-size: 16px;
        padding-left: 30px
    }

    .arm_custom_css_detail_sub_note,
    .arm_section_custom_css_detail_sub_note {
        color: grey;
        font-size: 14px;
        padding-left: 30px;
        margin-bottom: 15px
    }

    .arm_custom_css_detail_sub_note_text,
    .arm_section_custom_css_detail_sub_note_text {
        padding-left: 20px
    }

    .arm_member_activities_options_item {
        display: inline-block;
        width: 40%;
        margin: 5px 0
    }

    .arm_feature_list {
        display: inline-block;
        vertical-align: top;
        border: 1px solid #dee6fb;
        margin: 0 15px 15px 0;
        width: 300px;
        max-width: 94%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        background-position: left top;
        background-repeat: no-repeat;
        background-color: var(--arm-cl-white);
        min-height: 333px;
        position: relative;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -o-border-radius: 5px;
        -moz-border-radius: 5px;
        overflow: hidden
    }

    .arm_feature_list:nth-child(5n+5) {
        margin-right: 0
    }

    .arm_feature_list .arm_feature_icon {
        float: left;
        width: 100%;
        height: 100px;
        border-bottom: 1px solid #dee6fb;
        background-repeat: no-repeat;
        background-position: center center
    }

    .arm_feature_list.social_enable .arm_feature_icon {
        background-image: url(../images/social_feature_icon.png)
    }

    .arm_feature_list.social_login_enable .arm_feature_icon {
        background-image: url(../images/social_login_feature_icon.png)
    }

    .arm_feature_list.drip_content_enable .arm_feature_icon {
        background-image: url(../images/drip_content_feature_icon.png)
    }

    .arm_feature_list.opt_ins_enable .arm_feature_icon {
        background-image: url(../images/opt_ins_feature_icon.png)
    }

    .arm_feature_list.coupon_enable .arm_feature_icon {
        background-image: url(../images/coupon_feature_icon.png)
    }

    .arm_feature_list.multiple_membership_enable .arm_feature_icon {
        background-image: url("../images/multiple_membership_feature_enable.png")
    }

    .arm_feature_list.buddypress_enable .arm_feature_icon {
        background-image: url(../images/buddypress_feature_icon.png)
    }

    .arm_feature_list.invoice_tax_enable .arm_feature_icon {
        background-image: url(../images/invoice_tax_feature_icon.png)
    }

    .arm_feature_list.user_private_content_enable .arm_feature_icon {
        background-image: url(../images/user_private_content.png)
    }

    .arm_feature_list.pay_per_post_enable .arm_feature_icon {
        background-image: url(../images/pay_par_post_icon.png)
    }

    .arm_feature_list.api_service_enable .arm_feature_icon {
        background-image: url(../images/api_service_icon.png)
    }

    .arm_feature_list .arm_feature_title {
        display: inline-block;
        width: 100%;
        color: var(--arm-dt-black-500);
        font-size: 17px;
        margin-top: 20px;
        font-weight: 700;
        text-align: center
    }

    .arm_feature_list .arm_feature_text {
        display: inline-block;
        width: 100%;
        font-size: 14px;
        margin-top: 10px;
        min-height: 48px;
        text-align: center;
        line-height: normal;
        padding: 0 5px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -o-box-sizing: border-box;
        -moz-box-sizing: border-box
    }

    .arm_feature_list .arm_feature_active_icon {
        display: none;
        position: absolute;
        top: 0;
        right: 0;
        border-top: 30px solid #005aee;
        border-bottom: 30px solid transparent;
        border-left: 30px solid transparent;
        border-right: 30px solid #005aee
    }

    .arm_feature_list .arm_feature_active_icon .arm_check_mark {
        position: absolute;
        width: 100%;
        height: 100%;
        display: block;
        top: -15px;
        left: 10px
    }

    .arm_feature_list .arm_feature_active_icon .arm_check_mark::before {
        content: "";
        width: 18px;
        height: 3px;
        background: var(--arm-cl-white);
        display: block;
        transform: rotate(-50deg);
        position: absolute;
        left: -6px;
        top: 2px
    }

    .arm_feature_list .arm_feature_active_icon .arm_check_mark::after {
        content: "";
        background: var(--arm-cl-white);
        display: block;
        width: 10px;
        height: 3px;
        left: -10px;
        position: absolute;
        transform: rotate(40deg);
        top: 6px
    }

    .arm_feature_list .arm_feature_button_activate_wrapper,
    .arm_feature_list .arm_feature_button_deactivate_wrapper {
        float: left;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 45px;
        border-top: 1px solid #dee6fb
    }

    .arm_feature_list .arm_feature_activate_btn,
    .arm_feature_list .arm_feature_configure_btn,
    .arm_feature_list .arm_feature_deactivate_btn {
        float: left;
        width: 50%;
        height: 45px;
        line-height: 43px;
        text-align: center;
        text-decoration: none;
        border-right: 1px solid #dee6fb;
        color: var(--arm-dt-black-200);
        font-size: 18px;
        box-sizing: border-box
    }

    .arm_feature_list .arm_feature_activate_btn {
        width: 100%;
        border-right: none
    }

    .arm_feature_list .arm_feature_configure_btn {
        border-right: none
    }

    .arm_feature_list .arm_feature_deactivate_btn.arm_no_config_feature_btn {
        width: 100%;
        border-right: none
    }

    .arm_feature_list .arm_feature_activate_btn:hover,
    .arm_feature_list .arm_feature_configure_btn:hover,
    .arm_feature_list .arm_feature_deactivate_btn:hover {
        background: #005aee;
        color: var(--arm-cl-white)
    }

    .arm_feature_list.active {
        background-color: var(--arm-cl-white);
        box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        -o-box-shadow: 0 1px 3px rgba(0, 0, 0, .05)
    }

    .arm_feature_list.active .arm_feature_active_icon {
        display: inline-block
    }

    .arm_feature_list .arm_addon_loader_img {
        display: none;
        vertical-align: middle
    }

    @media screen and (max-width: 1000px) and (min-width:768px) {
        .arm_feature_list {
            width: 48%;
            max-width: 305px
        }

        .arm_feature_list.active {
            width: 48%;
            max-width: 305px
        }
    }

    .arm_add_user_achievements_btn {
        float: right
    }

    [dir=rtl] .arm_add_user_achievements_btn {
        float: left
    }

    .arm_import_export_container .bootstrap-datetimepicker-widget table th,
    .bootstrap-datetimepicker-widget table th {
        min-width: 20px !important;
        width: 20px;
        padding: 5px !important;
        text-align: center !important;
        font-weight: 700 !important
    }

    .arm_import_export_container .bootstrap-datetimepicker-widget table td,
    .bootstrap-datetimepicker-widget table td {
        padding: 5px
    }

    .arm_table_label_on_top .bootstrap-datetimepicker-widget table tr {
        display: table-row
    }

    .arm_table_label_on_top .bootstrap-datetimepicker-widget table tr td,
    .arm_table_label_on_top .bootstrap-datetimepicker-widget table tr th {
        display: table-cell;
        float: none
    }

    .arm_table_label_on_top .bootstrap-datetimepicker-widget table span {
        font-size: 14px;
        font-style: normal;
        text-align: center
    }

    .arm_front_font_color {
        display: inline-block;
        margin-right: 20px;
        margin-left: 10px
    }

    .arm_front_font_color .arm_colorpicker_label {
        width: 32px !important;
        height: 32px !important;
        padding: 0 !important;
        margin-bottom: 0 !important;
        display: inline-block !important;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        border: 4px solid #cfcfcf !important;
        border-radius: 100%;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -o-border-radius: 100%;
        cursor: pointer
    }

    .arm_front_font_color .arm_colorpicker {
        opacity: 0;
        cursor: pointer;
        font-size: 13px;
        width: 30px !important;
        max-width: 30px !important;
        height: 30px !important;
        margin: 0 !important;
        padding: 0 !important;
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        background: 0 0;
        border: none !important
    }

    .arm_admin_form .CodeMirror,
    .arm_admin_form .cm-s-default,
    .arm_profile_editor_right_div .CodeMirror,
    .arm_profile_editor_right_div .arm_admin_form .cm-s-default {
        color: #5c5c60;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        border: 1px solid #d2d2d2;
        width: 95%;
        height: 170px;
        margin-bottom: 5px;
        line-height: 18px
    }

    .arm_template_edit_form.arm_admin_form .CodeMirror,
    .arm_template_edit_form.arm_admin_form .cm-s-default {
        height: 150px
    }

    .arm_admin_form .arm_custom_css_wrapper {
        max-width: 700px
    }

    .arm_admin_form .CodeMirror,
    .arm_admin_form .cm-s-default,
    .arm_custom_css_wrapper {
        direction: ltr !important
    }

    [dir=rtl] .arm_admin_form .CodeMirror,
    [dir=rtl] .arm_admin_form .cm-s-default {
        float: right
    }

    .arm_custom_css_wrapper textarea {
        text-align: left !important
    }

    .arm_template_edit_form.arm_admin_form .arm_custom_css_wrapper {
        max-width: 650px;
        min-width: 100%
    }

    .arm_admin_form .arm_setup_admin_form_container .arm_custom_css_wrapper {
        max-width: 440px;
        min-width: 100%
    }

    .arm_admin_form .CodeMirror * {
        box-sizing: content-box !important;
        -webkit-box-sizing: content-box !important;
        -moz-box-sizing: content-box !important;
        -o-box-sizing: content-box !important
    }

    .arm_admin_form .CodeMirror span,
    .arm_admin_form .cm-s-default span {
        min-width: 1px;
        width: auto;
        margin: 0
    }

    .arm_wpadmin_page .mce-container .mce-menu-item .mce-text {
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS" !important
    }

    .arm_social_form_container {
        display: inline-block
    }

    .arm_import_processing_loader {
        background: rgba(0, 0, 0, .34);
        float: left;
        height: 100%;
        left: 0;
        position: absolute;
        text-align: center;
        top: 0;
        width: 100%
    }

    .arm_import_processing_text {
        color: var(--arm-cl-white);
        float: none;
        font-size: 30px;
        line-height: normal;
        margin: 0 auto;
        width: 100%;
        padding-top: 9%
    }

    .arm_buddypress_sync_progressbar,
    .arm_drip_rule_sync_progressbar,
    .arm_import_progressbar {
        display: none;
        float: left;
        background-color: var(--arm-cl-white);
        height: 30px;
        width: 100%;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        box-shadow: 0 0 1px 1px rgba(0, 0, 0, .1) inset;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .1) inset;
        -moz-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .1) inset;
        -o-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .1) inset;
        margin-top: 10px
    }

    .arm_buddypress_sync_progressbar,
    .arm_drip_rule_sync_progressbar {
        background-color: #f9f9f9
    }

    .arm_buddypress_sync_progressbar_inner,
    .arm_drip_rule_sync_progressbar_inner,
    .arm_import_progressbar_inner {
        float: left;
        display: inline-block;
        height: 30px;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        width: 0%;
        box-shadow: 0 1px 0 rgba(255, 255, 255, .5) inset;
        -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, .5) inset;
        -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, .5) inset;
        -o-box-shadow: 0 1px 0 rgba(255, 255, 255, .5) inset;
        transition: width .4s ease-in-out;
        -webkit-transition: width .4s ease-in-out;
        -moz-transition: width .4s ease-in-out;
        -ms-transition: width .4s ease-in-out;
        -o-transition: width .4s ease-in-out;
        background-color: var(--arm-pt-theme-blue);
        background-size: 30px 30px;
        background-image: linear-gradient(135deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -webkit-linear-gradient(135deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        animation: animate-stripes 3s linear infinite;
        -webkit-animation: animate-stripes 3s linear infinite;
        -moz-animation: animate-stripes 3s linear infinite;
        -o-animation: animate-stripes 3s linear infinite;
        font-size: 18px;
        color: var(--arm-cl-white);
        line-height: 30px;
        text-align: center
    }

    @keyframes animate-stripes {
        0% {
            background-position: 0 0
        }

        100% {
            background-position: 60px 0
        }
    }

    @-webkit-keyframes animate-stripes {
        0% {
            background-position: 0 0
        }

        100% {
            background-position: 60px 0
        }
    }

    .arm_import_user_send_mail_wrapper {
        float: left;
        font-size: 14px;
        position: relative;
        margin-top: 20px;
        width: 100%;
        display: none
    }

    .arm_import_user_send_mail_wrapper>input[type=checkbox] {
        margin: 0 5px 0 0
    }

    .arm_member_import_loader_wrapper {
        float: left;
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 999999;
        background: rgba(0, 0, 0, 0);
        left: 0;
        top: 0
    }

    .arm_add_new_other_forms_wrapper .popup_content_text {
        min-height: 400px
    }

    .arm_add_new_other_forms_wrapper.popup_wrapper .arm_form_redirection_options dl.arm_selectbox {
        margin-left: 30px
    }

    .arm_add_new_other_forms_wrapper .arm_form_redirection_options .add_new_form_redirection_field dt {
        width: 340px
    }

    .add_new_form_wrapper.popup_wrapper,
    .add_new_profile_form_wrapper.popup_wrapper {
        width: 800px !important
    }

    .add_new_form_wrapper.popup_wrapper table.arm_table_label_on_top,
    .add_new_profile_form_wrapper.popup_wrapper table.arm_table_label_on_top {
        width: 70%
    }

    .add_new_form_wrapper.popup_wrapper table.arm_table_label_on_top tr,
    .add_new_profile_form_wrapper.popup_wrapper table.arm_table_label_on_top tr {
        width: 98%
    }

    .add_new_form_wrapper.popup_wrapper table.arm_table_label_on_top td dl dt,
    .add_new_profile_form_wrapper.popup_wrapper table.arm_table_label_on_top td dl dt {
        width: 390px
    }

    .add_new_form_wrapper.popup_wrapper table.arm_table_label_on_top td input,
    .add_new_profile_form_wrapper.popup_wrapper table.arm_table_label_on_top td input {
        width: 85%
    }

    .add_new_form_wrapper.popup_wrapper .arm_add_new_form_field,
    .add_new_profile_form_wrapper.popup_wrapper .arm_add_new_form_field {
        min-width: 43%
    }

    .dataTables_processing {
        display: none
    }

    #armember_datatable tbody tr:hover .arm_grid_action_wrapper,
    #example tbody tr:hover .arm_grid_action_wrapper {
        display: inline-block !important
    }

    .arm_preview_setup_shortcode_popup_wrapper {
        min-width: 300px;
        max-width: 90% !important;
        top: 0;
        left: 0
    }

    .arm_preview_setup_shortcode_popup_wrapper .arm_setup_shortcode_html_wrapper {
        padding: 0;
        height: 500px;
        position: relative
    }

    .arm_preview_setup_shortcode_popup_wrapper iframe {
        width: 100%;
        height: 500px;
        display: inline-block
    }

    .arm_edit_user_badge_icon_wrapper .arm_edit_admin_badge {
        margin: 0
    }

    .arm_edit_user_badge_icon_wrapper {
        float: left;
        padding: 5px
    }

    #armember_datatable tbody tr .armGridActionTD,
    #example tbody tr .armGridActionTD {
        border: none !important
    }

    .arm_editable_input_button .arm_editable_input_button_inner form button:hover {
        border: none !important;
        border-radius: 0 !important;
        -webkit-border-radius: 0px !important;
        -o-border-radius: 0 !important;
        -moz-border-radius: 0 !important
    }

    .arm_editable_input_button .arm_editable_input_button_inner form input {
        border-radius: 0 !important;
        -webkit-border-radius: 0px !important;
        -o-border-radius: 0 !important;
        -moz-border-radius: 0 !important
    }

    .arm_image_edit_profile_placeholder_wrapper,
    .arm_image_placeholder_wrapper,
    .arm_image_register_placeholder_wrapper {
        display: none
    }

    .arm_other_forms_popup_inner_content_wrapper,
    .arm_profile_popup_inner_content_wrapper,
    .arm_registration_popup_inner_content_wrapper {
        float: left;
        width: 60%;
        position: relative
    }

    .arm_profile_popup_inner_content_wrapper:before,
    .arm_registration_popup_inner_content_wrapper:before {
        content: "";
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        border-right: 1px solid #e7e7e7;
        z-index: -1
    }

    .arm_template_preview_wrapper.arm_edit_profile_templates,
    .arm_template_preview_wrapper.arm_registration_templates {
        border: none
    }

    #arm_existing_type_fields {
        max-height: 225px;
        overflow-x: hidden;
        overflow-y: auto
    }

    .arm_selectbox_option_list {
        float: left;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -o-transofrm: translateY(-50%)
    }

    .arm_plan_skin_image {
        float: right;
        margin-right: 10px
    }

    .arm_editable_form .arm_editable_submit_button,
    .arm_form_member_main_field_label .arm-df__field-label_text .arm_editable_form .arm_editable_submit_button,
    .arm_form_member_main_field_label .arm-df__field-label_text .arm_editable_form .arm_editable_submit_button:hover,
    .arm_member_form_field_label .arm-df__field-label_text .arm_editable_form .arm_editable_submit_button,
    .arm_member_form_field_label .arm-df__field-label_text .arm_editable_form .arm_editable_submit_button:hover {
        border: none !important;
        background-color: transparent !important;
        cursor: pointer
    }

    .arm_clear_field_wrapper,
    .arm_select_user_meta_wrapper {
        float: left;
        width: 100%;
        padding: 25px !important
    }

    .arm_clear_field_wrapper .arm_account_detail_options,
    .arm_select_user_meta_wrapper .arm_account_detail_options {
        float: left;
        width: 30%;
        margin-bottom: 5px
    }

    .arm_clear_field_wrapper .arm_account_detail_options label,
    .arm_select_user_meta_wrapper .arm_account_detail_options_label {
        margin-right: 0 !important
    }

    @media only screen and (max-device-width: 1470px) {
        .arm_import_export_left_box {
            border-right: 0px;
            margin-bottom: 40px
        }

        .arm_import_export_container .page_title {
            margin-bottom: 0
        }

        .arm_import_export_left_box,
        .arm_import_export_right_box {
            min-height: auto
        }

        .arm_import_export_right_box {
            padding: 0
        }

        .armember_general_settings_wrapper .arm_admin_form .form-table th {
            min-width: 150px
        }

        .arm_import_export_left_box,
        .arm_import_export_right_box {
            width: 70%
        }
    }

    #arm_clear_form_fields_popup_div.popup_wrapper,
    #arm_select_user_meta_for_export.popup_wrapper,
    #arm_select_user_meta_for_import.popup_wrapper {
        width: 750px
    }

    .arm_setup_error_msg .arm_invalid:not(#setup_name-error) {
        margin-bottom: 6px
    }

    .arm_ref_info_links.arm_feature_link {
        float: right;
        text-align: right;
        padding: 0 40px 0 20px;
        margin-top: 20px;
        margin-bottom: 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -o-box-sizing: border-box;
        -moz-box-sizing: border-box;
        position: absolute;
        bottom: 45px;
        right: 0;
        color: var(--arm-pt-theme-blue)
    }

    .arm_ref_info_links.arm_feature_link:hover {
        color: var(--arm-pt-theme-blue)
    }

    .arm_ref_info_links.arm_feature_link:before {
        content: "";
        display: block;
        width: 10px;
        height: 3px;
        background: var(--arm-pt-theme-blue);
        right: 20px;
        position: absolute;
        top: 7px;
        transform: rotate(45deg)
    }

    .arm_ref_info_links.arm_feature_link:after {
        content: "";
        display: block;
        width: 10px;
        height: 3px;
        background: var(--arm-pt-theme-blue);
        right: 20px;
        position: absolute;
        top: 13px;
        transform: rotate(-45deg)
    }

    .arm_access_rules_grid_wrapper h4,
    .arm_drip_rules_grid_container h4,
    .arm_paid_post_grid_container h4 {
        text-align: center
    }

    .arm_drip_rules_grid_container .arm_datatable_searchbox #armmanagesearch_new_drip {
        width: 200px
    }

    .arm_membership_setup_sub_li label.arm_setup_plan_label {
        display: inline;
        padding: 5px !important
    }

    .arm_user_import_password_section {
        width: 100%;
        text-align: left;
        padding-top: 20px
    }

    .arm_user_import_type {
        display: inline-block;
        vertical-align: middle;
        color: #5c5c60;
        font-size: 15px
    }

    .arm_fixed_password {
        border: 1px solid #d2d2d2;
        border-radius: 3px;
        box-shadow: none;
        color: #5c5c60;
        height: 34px;
        max-width: 96%;
        padding: 0 10px;
        width: 300px !important;
        margin-left: 35px
    }

    .arm_send_mail_to_imported_users {
        margin-left: 35px !important
    }

    input[type=checkbox].arm_send_mail_to_imported_users:disabled:checked:before {
        height: 19px;
        width: 20px
    }

    .arm_member_login_history_wrapper {
        background: var(--arm-cl-white) none repeat scroll 0 0;
        border-radius: 3px;
        display: block;
        float: none;
        min-height: 250px;
        width: 1024px;
        max-height: 600px
    }

    .arm_member_login_history_title {
        float: left;
        width: 100%;
        height: 35px;
        line-height: 35px;
        font-size: 20px;
        padding: 15px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -o-box-sizing: border-box;
        -moz-box-sizing: border-box
    }

    .arm_member_login_history_title #arm_login_history_close {
        float: right;
        cursor: pointer;
        font-weight: 400;
        margin-top: -10px
    }

    .arm_member_login_history_content {
        float: left;
        width: 100%;
        padding: 30px 20px;
        box-sizing: border-box
    }

    .arm_member_login_history_content table {
        float: left;
        width: 100%;
        border: 1px solid #e5eaee
    }

    .arm_member_login_history_content table thead tr {
        height: 40px;
        background: #f6f8f7
    }

    .arm_member_login_history_content table tbody tr {
        height: 40px;
        background: var(--arm-cl-white)
    }

    .arm_member_login_history_content table tbody tr.even {
        background: #f6f8f8
    }

    .arm_rename_wpadmin_wrapper {
        line-height: 25px
    }

    .arm_tab_menu {
        width: 100%;
        height: 45px;
        display: table;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        background-color: var(--arm-cl-white);
        clear: both
    }

    .arm_tab_menu li:first-child {
        box-shadow: inset -2px -1px 3px 0 rgba(0, 0, 0, .2);
        -webkit-box-shadow: inset -2px -1px 3px 0 rgba(0, 0, 0, .2);
        -moz-box-shadow: inset -2px -1px 3px 0 rgba(0, 0, 0, .2);
        -o-box-shadow: inset -2px -1px 3px 0 rgba(0, 0, 0, .2)
    }

    .arm_tab_menu li:last-child {
        box-shadow: inset 2px -1px 3px 0 rgba(0, 0, 0, .2);
        -webkit-box-shadow: inset 2px -1px 3px 0 rgba(0, 0, 0, .2);
        -moz-box-shadow: inset 2px -1px 3px 0 rgba(0, 0, 0, .2);
        -o-box-shadow: inset 2px -1px 3px 0 rgba(0, 0, 0, .2)
    }

    .arm_tab_menu li {
        height: 100%;
        width: 50%;
        text-align: center;
        display: table-cell;
        border: 0;
        vertical-align: middle;
        z-index: 9
    }

    .arm_tab_menu li.current {
        position: relative;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none
    }

    .arm_tab_menu li a {
        padding: 10px;
        text-transform: none;
        color: #a2a2a2;
        text-decoration: none;
        line-height: normal;
        width: 100%;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_tab_menu li.current a,
    .arm_tab_menu li:hover a {
        color: #474747
    }

    .arm_form_fields_container_tab {
        background-color: var(--arm-cl-white);
        display: inline-block;
        margin-bottom: 20px;
        width: auto;
        overflow-x: hidden;
        overflow-y: auto
    }

    .arm_manage_form_content_wrapper {
        background: var(--arm-gt-gray-10-a);
        display: inline-block;
        width: 100%;
        min-height: 1000px;
        margin-bottom: -7px
    }

    .arm_member_form_label {
        cursor: pointer;
        position: relative;
        width: 100%
    }

    .arm_profile_field_label {
        width: 100%;
        float: left
    }

    .arm_profile_field_label .arm_editable_form input {
        width: 100%;
        border-radius: 3px;
        border: 1px solid #0073aa
    }

    .arm_editable_form input:focus,
    .arm_profile_field_label .arm_editable_form input:focus {
        outline: 0
    }

    .arm_admin_member_form .arm_section_fields_wrapper,
    .arm_admin_member_form li.arm_section_fields_wrapper {
        float: left;
        display: inline-block;
        margin: 20px 0;
        padding: 5px 0;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_admin_member_form.armf_label_placeholder .arm-df__field-label {
        margin: 8px 0 5px 0
    }

    .arm_admin_member_form iframe {
        width: 0;
        height: 0;
        border: none;
        position: absolute;
        left: -9999px
    }

    .arm_admin_member_form .arm-df__form-group.arm-df__form-group_submit {
        min-height: auto;
        margin: 10px 0 0 0 !important
    }

    .required_icon {
        color: red;
        font-size: 12px;
        vertical-align: top;
        margin: 0
    }

    .required_star {
        color: red;
        font-size: 12px;
        vertical-align: top;
        margin: 0
    }

    .arm_document_video_popup .popup_footer label {
        text-align: left;
        float: left;
        margin: 15px 0
    }

    .arm_preview_setup_shortcode_popup_wrapper .popup_wrapper_inner {
        padding-bottom: 20px
    }

    .arm_setup_form_inner_container {
        display: inline-block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_dashboard_member_summary {
        display: inline-block;
        margin: 0 20px;
        text-align: center;
        vertical-align: middle;
        width: 93%
    }

    .arm_dashboard_member_summary a {
        color: var(--arm-cl-white);
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_dashboard_member_summary a:focus,
    .arm_dashboard_member_summary a:focus .media-icon img {
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none
    }

    .arm_dashboard_member_summary .arm_member_summary {
        float: left;
        width: 48%;
        height: 50px;
        padding: 20px 0;
        margin-bottom: 8px;
        text-align: center;
        background-color: #aaa;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -o-border-radius: 6px
    }

    .arm_report_analytics_main_wrapper .arm_dashboard_member_summary .arm_member_summary {
        padding: 50px 0;
        margin-bottom: 18px
    }

    .arm_report_analytics_main_wrapper .arm_dashboard_member_summary .arm_member_summary_label {
        font-size: 18px
    }

    .arm_dashboard_member_summary .arm_member_summary_count {
        display: inline-block;
        font-size: 36px;
        line-height: 30px;
        margin-bottom: 10px
    }

    .arm_dashboard_member_summary .arm_member_summary_label {
        font-size: 14px
    }

    .arm_dashboard_member_summary .arm_total_members {
        background: #44425b;
        margin-right: 8px
    }

    .arm_report_analytics_main_wrapper .arm_dashboard_member_summary .arm_total_members {
        margin-right: 18px
    }

    .arm_dashboard_member_summary .arm_active_members {
        background: #4caf50
    }

    .arm_dashboard_member_summary .arm_inactive_members {
        background: #f44336;
        margin-right: 8px
    }

    .arm_report_analytics_main_wrapper .arm_dashboard_member_summary .arm_inactive_members {
        margin-right: 18px
    }

    .arm_dashboard_member_summary .arm_membership_plans {
        background: #23b7e5
    }

    .arm-tab-content {
        display: none
    }

    #tab-1,
    #tabsetting-1 {
        display: block
    }

    #arm_accordion,
    .arm_accordion_container {
        margin: 10px 0 !important;
        width: 100%
    }

    .arm_accordion,
    .arm_accordion_body {
        padding: 4px 4px 4px 15px;
        background: #fdfdfd;
        color: #999;
        display: none
    }

    .arm_accordion.default {
        display: block;
        background: var(--arm-cl-white)
    }

    #arm_accordion ul li .arm_accordion_header,
    .arm_accordion_container ul li .arm_accordion_header {
        text-decoration: none;
        display: block;
        padding: 10px;
        background-color: #f9f7f8;
        color: inherit
    }

    #arm_accordion ul li.arm_active_section .arm_accordion_header,
    .arm_accordion_container ul li.arm_active_section .arm_accordion_header {
        background-color: #f1faff;
        color: #3c3e4f
    }

    #arm_accordion ul li .arm_accordion_header i:not(.arm_helptip_icon),
    .arm_accordion_container ul li .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/plus_icon.jpg");
        background-repeat: no-repeat;
        background-position: center center;
        width: 10px;
        height: 10px;
        display: inline-block;
        float: right;
        vertical-align: middle;
        padding: 8px 3px
    }

    .arm_profile_editor_right_div #arm_accordion ul li .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/down_arrow.png");
        background-repeat: no-repeat;
        background-position: center center
    }

    #arm_accordion ul li.arm_active_section .arm_accordion_header i:not(.arm_helptip_icon),
    .arm_accordion_container ul li.arm_active_section .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/minus_icon.jpg");
        background-repeat: no-repeat;
        background-position: center center
    }

    .arm_profile_editor_right_div #arm_accordion ul li.arm_active_section .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/up_arrow.png");
        background-repeat: no-repeat;
        background-position: center center
    }

    #arm_accordion,
    .arm_accordion_container {
        margin: 10px 0 !important;
        width: 100%
    }

    .arm_accordion,
    .arm_accordion_body {
        padding: 4px 4px 4px 15px;
        background: #fdfdfd;
        color: #999;
        display: none
    }

    .arm_accordion.default {
        display: block;
        background: var(--arm-cl-white)
    }

    #arm_accordion ul li .arm_accordion_header,
    .arm_accordion_container ul li .arm_accordion_header {
        text-decoration: none;
        display: block;
        padding: 10px;
        background-color: #f6f9ff;
        color: inherit
    }

    #arm_accordion ul li.arm_active_section .arm_accordion_header,
    .arm_accordion_container ul li.arm_active_section .arm_accordion_header {
        background-color: #e3e8f3;
        color: var(--arm-dt-black-300)
    }

    .arm_profile_editor_right_div #arm_accordion ul li.arm_active_section .arm_accordion_header {
        font-size: 14px
    }

    #arm_accordion ul li .arm_accordion_header i:not(.arm_helptip_icon),
    .arm_accordion_container ul li .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/plus_icon.jpg");
        background-repeat: no-repeat;
        background-position: center center;
        width: 10px;
        height: 10px;
        display: inline-block;
        float: right;
        vertical-align: middle;
        padding: 8px 3px
    }

    .arm_profile_editor_right_div #arm_accordion ul li .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/down_arrow.png");
        background-repeat: no-repeat;
        background-position: center center
    }

    #arm_accordion ul li.arm_active_section .arm_accordion_header i:not(.arm_helptip_icon),
    .arm_accordion_container ul li.arm_active_section .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/minus_icon.jpg");
        background-repeat: no-repeat;
        background-position: center center
    }

    .arm_profile_editor_right_div #arm_accordion ul li.arm_active_section .arm_accordion_header i:not(.arm_helptip_icon) {
        background-image: url("../images/up_arrow.png");
        background-repeat: no-repeat;
        background-position: center center
    }

    .arm_form_conditional_redirect_field .arm_selectbox.column_level_dd>dt {
        width: 200px !important
    }

    .arm_form_conditional_redirect_field .arm_form_setting_input {
        width: 225px !important
    }

    .arm_arrow:after,
    .arm_helptip_ui_content {
        background: #939393
    }

    .arm_helptip_ui_content {
        padding: 10px 20px;
        border-radius: 20px;
        font: bold 14px "Helvetica Neue", Sans-Serif;
        max-width: 400px;
        opacity: 1 !important;
        background: #939393 !important;
        border: none !important;
        box-shadow: none !important;
        color: var(--arm-cl-white) !important;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        padding: 8px 10px;
        text-align: left !important;
        z-index: 99999 !important;
        position: absolute
    }

    .arm_arrow {
        width: 70px;
        height: 16px;
        overflow: hidden;
        position: absolute;
        left: 50%;
        margin-left: -35px;
        bottom: -16px
    }

    .arm_arrow.top {
        top: -16px;
        bottom: auto;
        background: 0 0;
        border: none;
        padding: 0
    }

    .arm_arrow.left {
        left: 20%;
        background: 0 0;
        border: none;
        padding: 0
    }

    .arm_arrow.bottom {
        background: 0 0;
        border: none;
        padding: 0
    }

    .arm_arrow:after {
        content: "";
        position: absolute;
        left: 20px;
        top: -20px;
        width: 25px;
        height: 25px;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg)
    }

    .arm_arrow.top:after {
        bottom: -20px;
        top: auto
    }

    .arm_helptip_icon_ui,
    i.arm_helptip_icon,
    span.arm_helptip_icon {
        margin: 2px !important;
        cursor: pointer;
        color: var(--arm-gt-gray-400);
        font-size: 16px !important;
        font-weight: 700;
        height: 20px;
        width: 20px;
        text-align: center;
        vertical-align: middle
    }

    .arm_feature_button_activate_container,
    .arm_feature_button_deactivate_container {
        float: none;
        display: inline-block
    }

    #arm_gateway_payment_mode_box {
        display: none;
        padding-left: 20px
    }

    .arm_gateway_payment_mode_box {
        display: none
    }

    #arm_gateway_payment_mode_box>label {
        font-size: 12px;
        font-style: italic
    }

    .arm_user_extend_renewal_date_action_btn,
    .arm_user_renew_next_cycle_action_btn {
        background-color: var(--arm-pt-theme-blue);
        padding: 7px;
        border-radius: 3px;
        color: var(--arm-cl-white);
        text-decoration: none;
        float: left;
        text-align: center
    }

    #arm_skip_next_cycle {
        margin-right: 5px
    }

    #arm_extend_cycle_days {
        margin-right: 6px
    }

    .arm_user_extend_renewal_date_action_btn:focus,
    .arm_user_extend_renewal_date_action_btn:hover,
    .arm_user_renew_next_cycle_action_btn:focus,
    .arm_user_renew_next_cycle_action_btn:hover {
        color: var(--arm-cl-white);
        text-decoration: none
    }

    .arm_paid_finite_expiry_based_on_joined_date,
    .arm_paid_finite_fixed_expiry_date {
        width: 100%;
        padding-bottom: 20px;
        float: left
    }

    .arm_expiry_fix_date_box,
    .arm_expiry_joined_date_box {
        width: 100%;
        float: left;
        padding: 5px 0 0 35px
    }

    .arm_select_all {
        -webkit-touch-callout: all;
        -webkit-user-select: all;
        -khtml-user-select: all;
        -moz-user-select: all;
        -ms-user-select: all;
        user-select: all
    }

    .arm_form_content_box .arm_form_action_btns a.arm_delete_set_link {
        margin-left: 2px
    }

    .arm_login_redirect_before_expire_days .arm_selectbox dt {
        width: 200px
    }

    .arm_stripe_plans.arm_stripe_plan_div {
        padding-left: 20px
    }

    .arm_stripe_plan_class {
        font-style: italic;
        font-weight: 700
    }

    .arm_profile_editable_field_close,
    .arm_profile_editable_field_submit {
        background-color: var(--arm-pt-theme-blue);
        border: 1px solid var(--arm-pt-theme-blue);
        border-radius: 4px;
        box-sizing: border-box;
        color: var(--arm-cl-white);
        cursor: pointer;
        display: inline-block;
        font-size: 16px;
        line-height: normal;
        min-height: 30px;
        min-width: 30px;
        margin-left: 4px;
        text-align: center;
        text-decoration: none
    }

    .arm_profile_temp_field_input:hover {
        border-bottom: 1px dashed #ccc
    }

    .arm_user_future_plan_div,
    .arm_user_plan_div {
        border: 1px solid #d2d2d2;
        border-radius: 3px;
        margin: 0 10px 10px 0;
        padding: 10px;
        width: 480px
    }

    .arm_remove_user_future_plan_div,
    .arm_remove_user_plan_div {
        background-image: url("../images/remove_icon.png");
        background-position: 8px center;
        background-repeat: no-repeat;
        border-radius: 4px;
        float: left;
        height: 3px;
        padding: 14px;
        background-color: var(--arm-pt-theme-blue)
    }

    .arm_remove_user_plan_div img {
        padding: 1px
    }

    #arm_add_new_user_plan_link,
    #arm_add_new_user_plan_link2,
    #arm_remove_user_plan,
    #arm_remove_user_plan2 {
        margin-top: 5px;
        cursor: pointer
    }

    .arm_child_user_row:not(:last-child)>td {
        height: 27px !important;
        border-bottom: none !important
    }

    td.arm_child_user_row>td {
        padding: 5px 45px !important;
        height: 27px !important
    }

    .arm_child_user_row:last-child>td {
        border-bottom: 1px solid #f5f5f5 !important
    }

    .conditionally_block_url_div {
        margin: 15px 0 0 5px
    }

    .conditionally_block_url_div label {
        margin-right: 29px
    }

    .conditionally_block_url_div .conditionally_block_urls_lbl {
        text-align: right;
        width: 136px
    }

    .conditionally_block_url_div .arm_global_setting_switch {
        margin-top: 10px
    }

    .arm_conditionally_block_urls_tbl {
        padding-top: 15px
    }

    .arm_conditionally_block_urls_tbl .arm_conditionally_block_urls_label {
        width: 143px;
        padding-left: 4px !important;
        vertical-align: top !important
    }

    .arm_conditionally_block_urls_tbl .arm_conditionally_block_urls_label label {
        float: right;
        vertical-align: top;
        margin-top: 8px
    }

    .arm_conditionally_block_urls_tbl textarea {
        min-width: 98%
    }

    .conditionalarm_conditionally_block_urls_tblly_block_urls_tbl dl.arm_selectbox {
        margin-right: 10px;
        width: 450px
    }

    .arm_conditionally_block_urls_tbl .arm_condition_icon {
        padding: 0 10px 0 0 !important;
        font-size: 22px
    }

    .arm_conditionally_block_urls_tbl .arm_condition_icon a {
        color: var(--arm-pt-theme-blue)
    }

    .arm_conditionally_block_urls_tbl .arm_condition_icon a img {
        border: none;
        width: 21px;
        height: 21px
    }

    #arm_access_page_for_restrict_site_chosen {
        width: 500px !important
    }

    .armfa.armfa-minus-circle,
    .armfa.armfa-plus-circle {
        color: var(--arm-pt-theme-blue);
        font-size: 25px;
        cursor: pointer;
        float: left;
        margin-top: 5px
    }

    .arm_buddypress_settings th:not(.arm_bp_tabel_th) {
        text-align: center;
        font-weight: 700 !important
    }

    .arm_buddypress_settings th.arm_bpl_th {
        text-align: center !important
    }

    .arm_buddypress_settings td:not(.arm_bp_th) {
        text-align: right !important
    }

    .arm_admin_form .arm_buddypress_settings th {
        font-weight: 700 !important;
        min-width: 200px !important
    }

    .form-table.arm_buddypress_settings {
        width: 90%
    }

    .arm_bp_field_map_div {
        border-radius: 5px;
        float: left;
        width: 100%;
        margin: 20px 0
    }

    .arm_buddypress_submit_btn {
        margin: 0 !important;
        text-align: center
    }

    .arm_buddypress_sync_btn_div {
        margin: 0 !important
    }

    tr.arm_child_user_row td.arm_child_user_row {
        background-color: var(--arm-gt-gray-50-a) !important
    }

    table.arm_user_child_row_table {
        width: 100%;
        max-width: 1645px
    }

    .arm_user_child_row_table tr:first-child {
        height: 55px
    }

    .arm_user_child_row_table tr:first-child th {
        font-size: 14px;
        color: #3c3e4f;
        padding: 15px 10px;
        text-align: left
    }

    .arm_user_child_row_table tr td {
        padding: 10px;
        text-align: left;
        position: relative
    }

    tr.arm_child_user_row {
        height: 50px;
        margin: 10px;
        background-color: var(--arm-cl-white)
    }

    table.arm_user_child_row_table tr.arm_child_user_row td {
        border-left: none !important;
        border-right: none !important;
        border-top: none !important
    }

    td.arm_child_user_row div:not(.arm_child_row_div) {
        padding: 2px 45px
    }

    .arm_member_grid_arrow {
        padding: 14px !important;
        position: absolute;
        border: 2px solid var(--arm-gt-gray-200);
        border-top: 0;
        border-right: 0;
        margin-left: -29px;
        margin-top: -5px;
        height: 6px;
        border-color: var(--arm-gt-gray-200);
        border-style: solid
    }

    span.arm_user_plan_circle {
        width: 32px !important;
        min-width: 32px;
        max-width: 32px;
        margin: 0 7px 7px 0;
        display: inline-block;
        color: var(--arm-cl-white);
        text-align: center;
        border-radius: 19px;
        height: 32px;
        line-height: 32px
    }

    .arm_user_plan_circle.arm_user_plan_1 {
        background-color: #341ad4
    }

    .arm_user_plan_circle.arm_user_plan_2 {
        background-color: #b727fb
    }

    .arm_user_plan_circle.arm_user_plan_3 {
        background-color: #fd7d21
    }

    .arm_user_plan_circle.arm_user_plan_4 {
        background-color: #ffa400
    }

    .arm_user_plan_circle.arm_user_plan_5 {
        background-color: #ad476e
    }

    .arm_user_plan_circle.arm_user_plan_6 {
        background-color: #4c0070
    }

    .arm_user_plan_circle.arm_user_plan_7 {
        background-color: #42d754
    }

    .arm_user_plan_circle.arm_user_plan_8 {
        background-color: #e8a592
    }

    .arm_user_plan_circle.arm_user_plan_9 {
        background-color: #a45d5d
    }

    .arm_user_plan_circle.arm_user_plan_10 {
        background-color: #934081
    }

    .arm_member_manage_plan_detail_popup_text table,
    .arm_member_manage_post_detail_popup_text table {
        width: 95%;
        border-left: 1px solid #eaeaea;
        margin: 10px;
        border-right: 1px solid #eaeaea
    }

    .arm_member_manage_plan_detail_popup_text .arm_add_plan .arm_position_relative {
        clear: both
    }

    .arm_member_manage_plan_detail_popup_text .arm_add_plan .arm_selectbox dt {
        max-width: 500px;
        width: 500px
    }

    .arm_edit_plan_expire_date {
        width: 170px;
        min-width: 170
    }

    .arm_edit_plan_action_button {
        margin-left: 5px;
        cursor: pointer
    }

    .arm_edit_user_plan_popup_wrapper table td,
    .arm_edit_user_plan_popup_wrapper table th {
        color: #32323a;
        font-size: 14px;
        border-bottom: 1px solid #eaeaea;
        padding: 15px 20px
    }

    .arm_user_plan_row .arm_edit_plan_name {
        width: 250px;
        min-width: 100px;
        color: #0073aa
    }

    .arm_user_plan_row .arm_edit_plan_start {
        width: 100px;
        min-width: 100px
    }

    .arm_user_plan_row .arm_edit_plan_expire {
        width: 165px;
        min-width: 100px
    }

    .arm_user_plan_row .arm_edit_plan_cycle_date {
        width: 100px;
        min-width: 100px
    }

    .arm_user_plan_row .arm_edit_plan_type {
        width: 200px;
        min-width: 100px
    }

    .arm_user_plan_row .arm_edit_plan_expiry {
        width: 140px;
        min-width: 130px;
        position: relative
    }

    .arm_user_plan_row .arm_edit_plan_action {
        min-width: 10px;
        width: 10px
    }

    .arm_add_plan span.arm_edit_plan_lbl {
        display: inline-block;
        float: left;
        text-align: right;
        width: 28%;
        height: 50px;
        line-height: 50px
    }

    .arm_edit_field {
        float: left;
        margin: 7px 20px
    }

    .arm_edit_field input {
        float: left
    }

    .arm_add_new_plan {
        margin: 10px 10px 10px 0
    }

    .arm_user_edit_plan_table th:last-child {
        border-right: none
    }

    .arm_user_edit_plan_table th {
        border-right: #f5f5f5 1px solid;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        font-weight: 700
    }

    .arm_user_edit_plan_table td:last-child {
        border-right: none
    }

    .arm_user_edit_plan_table td {
        border-right: #f5f5f5 1px solid
    }

    tr.arm_user_plan_row.odd {
        background-color: #fafafa !important
    }

    tr.arm_user_plan_row td {
        min-height: 36px;
        height: 36px
    }

    .arm_edit_plan_action .arm_confirm_box {
        margin-top: -10px
    }

    .popup_content_text.arm_add_plan {
        margin-bottom: 20px
    }

    .arm_user_plan_head th {
        color: #32323a !important;
        font-weight: 700 !important;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS"
    }

    .arm_bp_fields_map_wrapper {
        width: 90%
    }

    .arm_buddypress_settings_block,
    .arm_buddypress_settings_column {
        width: 50%;
        float: left
    }

    .arm_buddypress_settings_block {
        padding: 10px 0;
        line-height: 34px;
        width: 65%
    }

    .arm_buddypress_settings_column.arm_bp_tabel_th,
    .arm_buddypress_settings_column.arm_bp_th {
        font-weight: 700;
        font-size: 14px;
        color: #000
    }

    .arm_buddypress_settings_column .arm_bp_fields_heading,
    .arm_buddypress_settings_column .arm_bp_fields_label {
        padding: 0 10px;
        text-align: right
    }

    .arm_buddypress_settings_column .arm_bp_fields_input {
        padding: 0 10px
    }

    .arm_admin_form .arm_selectbox dt.arm_login_redirection_dt {
        width: 170px !important
    }

    .arm_login_conditional_redirection_ul .arm_login_redirection_action {
        vertical-align: top !important
    }

    .arm_login_conditional_redirection_ul .arm_login_redirection_and_lbl {
        vertical-align: top !important;
        padding-top: 52px !important
    }

    .arm_login_conditional_redirection_box_div {
        padding: 1px 10px 20px 10px !important
    }

    .arm_edit_profile_conditional_redirection_url,
    .arm_login_conditional_redirection_url,
    .arm_signup_conditional_redirection_url {
        max-width: 100% !important;
        width: 525px !important
    }

    .arm_edit_profile_conditional_redirection_box_div,
    .arm_login_conditional_redirection_box_div,
    .arm_setup_signup_conditional_redirection_box_div,
    .arm_signup_conditional_redirection_box_div {
        margin-bottom: 20px;
        padding: 5px 10px 5px 10px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        max-width: 780px
    }

    .arm_setup_signup_conditional_redirection_box_div table tr td {
        padding: 10px 8px !important
    }

    .arm_login_conditional_redirection_row dl.arm_selectbox.column_level_dd {
        margin-top: 5px !important
    }

    .arm_remove_setup_signup_link {
        float: left;
        width: 100%
    }

    .arm_remove_setup_signup_link a {
        float: right;
        text-decoration: none;
        font-size: 20px
    }

    .arm_redirection_expiration_days {
        float: right;
        width: 105px
    }

    .arm_edit_profile_conditional_redirection_ul td dl,
    .arm_login_conditional_redirection_ul td dl,
    .arm_signup_conditional_redirection_ul td dl {
        margin: 0 !important
    }

    .arm_edit_profile_conditional_redirection_ul span.arm_rsc_error,
    .arm_login_conditional_redirection_ul span.arm_rsc_error,
    .arm_setup_signup_conditional_redirection_ul span.arm_rsc_error,
    .arm_signup_conditional_redirection_ul span.arm_rsc_error {
        display: none;
        float: left;
        padding: 5px;
        color: red
    }

    .arm_login_conditional_redirection_row td:first-child {
        padding-top: 42px !important
    }

    @media only screen and (min-device-width: 1300px) and (max-device-width:1520px) {
        .arm_admin_form .arm_selectbox dt.arm_login_redirection_dt {
            width: 140px !important
        }

        .arm_selectbox dt.arm_edit_profile_redirection_dt,
        .arm_setup_signup_conditional_redirection_ul td .arm_selectbox dt.arm_signup_redirection_dt {
            width: 400px !important
        }

        .arm_setup_signup_conditional_redirection_ul td .arm_selectbox dt {
            width: 400px !important
        }

        .arm_edit_profile_conditional_redirection_ul td .arm_selectbox dt.arm_edit_profile_redirection_dt,
        .arm_signup_conditional_redirection_ul td .arm_selectbox dt.arm_signup_redirection_dt {
            width: 400px !important
        }

        .arm_edit_profile_conditional_redirection_ul td .arm_selectbox dt,
        .arm_signup_conditional_redirection_ul td .arm_selectbox dt {
            width: 400px !important
        }
    }

    .arm_conditionally_block_urls_content span.arm_invalid {
        display: none;
        float: left;
        padding: 5px;
        color: red
    }

    .arm_login_conditional_redirection_row td {
        padding: 20px 5px 0 5px !important
    }

    .arm_default_redirection_lbl {
        display: inline-block;
        vertical-align: top;
        padding: 5px 10px 5px 0
    }

    .arm_default_redirection_txt {
        display: inline
    }

    .arm_default_redirection_full {
        width: 100%
    }

    .arm_default_redirection_txt input.arm_member_form_input.arm_edit_profile_redirection_conditional_redirection,
    .arm_default_redirection_txt input.arm_member_form_input.arm_login_redirection_conditional_redirection,
    .arm_default_redirection_txt input.arm_member_form_input.arm_signup_redirection_conditional_redirection {
        min-width: 100%
    }

    .arm_plan_payment_cycle_label {
        float: left;
        width: 220px
    }

    .arm_plan_payment_cycle_amount {
        float: left;
        margin-left: 14px;
        width: 86px
    }

    .arm_plan_payment_cycle_amount input {
        max-width: 71% !important
    }

    .arm_plan_payment_cycle_billing_cycle {
        float: left;
        margin-left: 14px;
        width: 200px
    }

    .arm_plan_payment_cycle_recurring_time {
        float: left;
        margin-left: 14px;
        width: 115px
    }

    .arm_plan_payment_cycle_action_buttons {
        float: left;
        margin-top: 35px;
        width: 87px
    }

    .arm_plan_payment_cycle_action_buttons i {
        margin-left: 5px
    }

    .arm_plan_payment_cycle_li label {
        line-height: 30px
    }

    .arm_user_plan_text_th.arm_user_plan_no {
        width: 10px
    }

    .arm_user_plan_text_th.arm_user_plan_name,
    .arm_user_plan_text_th.arm_user_plan_type {
        width: 235px
    }

    .arm_user_plan_text_th.arm_user_plan_cycle_date,
    .arm_user_plan_text_th.arm_user_plan_start {
        width: 100px
    }

    .arm_user_plan_text_th.arm_user_plan_end {
        width: 155px
    }

    .arm_user_plan_text_th.arm_user_plan_action {
        width: 235px
    }

    .arm_user_plan_table {
        border: 1.5px solid var(--arm-gt-gray-50);
        border-radius: 3px;
        border-spacing: 0;
        box-sizing: border
    }

    .arm_user_plan_table_tr td {
        padding: 14px 10px 10px 10px !important;
        vertical-align: top !important;
        min-height: 40px;
        height: 40px
    }

    .arm_user_plan_table th {
        padding: 14px 10px 10px 10px !important;
        vertical-align: top
    }

    .arm_user_plan_table tr.odd {
        background-color: #f6f8f8
    }

    .arm_user_plan_table tr.even {
        background-color: var(--arm-cl-white)
    }

    .arm_invoice_settings .arm_email_content_area_left {
        width: 71%
    }

    .arm_invoice_settings .arm_email_content_area_right {
        width: 25%
    }

    .arm_invoice_settings .arm_shortcode_wrapper {
        height: 595px
    }

    .arm_add_member_plans_div {
        margin-left: 0
    }

    .arm_add_member_plans_div .arm_user_plan_table {
        width: 100%
    }

    .arm_user_plan_expire_text,
    .arm_user_plan_type.arm_plan_cycle,
    .arm_user_plan_type.arm_user_installments,
    .arm_user_plan_type_text {
        display: block;
        width: 100%
    }

    .arm_user_plan_type_text {
        font-weight: 700
    }

    .arm_user_plan_expire_text span {
        display: block;
        width: 100%
    }

    .arm_rewrite_button_div {
        width: 100%;
        text-align: center;
        margin: 0 auto
    }

    #arm_rename_wp_admin_popup_div_notice .popup_footer {
        background-color: #f5f5f5
    }

    .arm_hide_wp_admin_notice.arm_admin_notices_container {
        font-size: 15px;
        background-color: #ff0
    }

    .arm_drip_show_old_post_switch {
        float: left;
        width: 60%
    }

    .arm_drip_show_old_post_text {
        float: left;
        width: 40%
    }

    .arm_setup_option_field.enable_two_steps {
        display: none
    }

    .arm_rename_wpadmin_wrapper ol li {
        margin-bottom: 15px
    }

    .arm_rename_wpadmin_wrapper .arm_shortcode_text span {
        font-size: 14px
    }

    .arm_rename_wpadmin_wrapper .arm_shortcode_text {
        padding: 5px 10px 1px 9px
    }

    .arm_members_grid_container .arm_grid_action_btn_container .arm_change_status_box {
        right: 70px
    }

    .arm_transactions_grid_container #transactions_list_form .arm_datatable_filters .arm_datatable_filter_item {
        margin-left: 6px
    }

    .arm_end_of_term_action_note {
        float: left;
        width: auto;
        position: relative;
        top: 5px;
        left: 5px;
        clear: both;
        display: inline-block;
        width: 100%
    }

    .arm_eopa_select,
    .arm_trial_select {
        float: left
    }

    .arm_eopa_type_main,
    .arm_plan_recurring_type_main {
        margin-left: 5px;
        float: left
    }

    .arm_add_edit_plan_form .arm_pg_important_note {
        float: left;
        margin-top: 20px
    }

    .arm_confirm_box_extend_renewal_date {
        width: 280px;
        top: 25px;
        left: 10px
    }

    .arm_profile_editor_left_div {
        border-radius: 3px;
        float: left;
        width: 71%;
        border: 1px #eaedf1 solid;
        margin-left: 0;
        background-color: transparent
    }

    .arm_profile_editor_right_div {
        border: 1.5px solid var(--arm-gt-gray-50);
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        -moz-border-radius: 3px;
        float: right;
        margin: 0 40px 0 0;
        width: 290px
    }

    .arm_social_profile_fields_wrap {
        width: 100%;
        height: 180px
    }

    .arm_profile_user_meta_tbl_selected .arm_profile_detail_tbl {
        box-shadow: 1px 1px 1px 1px #999
    }

    .arm_profile_defail_container.arm_profile_tabs_container {
        width: 100%;
        float: left
    }

    .arm_preofile_user_meta_custom_icons {
        margin-top: 10px;
        position: absolute;
        right: 40px;
        display: none;
        z-index: 3
    }

    .arm_profile_user_meta_container:hover .arm_preofile_user_meta_custom_icons,
    .arm_profile_user_meta_tbl_selected .arm_preofile_user_meta_custom_icons {
        display: block
    }

    .arm_profile_tabs_container .arm_profile_tab_detail .arm_profile_field_settings_menu_wrapper {
        width: 430px;
        position: absolute;
        right: 0;
        margin-top: 43px;
        margin-bottom: 15px;
        z-index: 9999
    }

    #arm_profile_user_meta_setting_box {
        display: none
    }

    .arm_profile_tabs_container .arm_profile_tab_detail .arm_profile_field_settings_menu_wrapper .arm_profile_tabs_container .arm_profile_tab_detail.arm_profile_field_settings_menu_wrapper {
        display: inline-block;
        width: 100%;
        font-size: 13px;
        cursor: auto !important
    }

    .arm_profile_belt {
        background: #eaedf1;
        height: 60px
    }

    .arm_profile_belt_icon:last-child {
        border: none
    }

    .arm_profile_belt_icon {
        border-right: 1px solid #dbdbdb;
        box-sizing: border-box;
        float: left;
        height: 60px;
        padding: 13px 20px
    }

    .arm_profile_belt_right_icon_last {
        border-bottom: 1px solid #f2f2f2;
        box-sizing: border-box;
        float: right;
        height: 60px;
        padding: 12px 10px;
        background-color: var(--arm-cl-white);
        font-size: 14px;
        color: #32323a
    }

    .arm_profile_belt_right_icon {
        border-bottom: 1px solid #f2f2f2;
        border-right: 1px solid #f2f2f2;
        box-sizing: border-box;
        float: right;
        height: 60px;
        width: 60px;
        padding: 17px 10px;
        background-color: var(--arm-pt-theme-blue)
    }

    .arm_profile_belt_right_icon .arm_profile_template_belt_icon {
        float: left;
        width: 100%;
        height: 100%;
        position: relative
    }

    .arm_profile_template_belt_icon.custom_css {
        background: url('../images/custom_css.png') no-repeat center center
    }

    .arm_profile_template_belt_icon.select_template {
        background: url('../images/select_template.png') no-repeat center center
    }

    .arm_profile_template_belt_icon.font_setting {
        background: url('../images/font-setting.png') no-repeat center center
    }

    .arm_profile_template_belt_icon.color_settings {
        background: url('../images/topbar_color_pallet_icon.png') no-repeat center center
    }

    .arm_profile_belt_right_icon:hover {
        background: var(--arm-cl-white)
    }

    .arm_profile_belt_right_icon:hover .arm_profile_template_belt_icon.custom_css {
        background: url('../images/custom_css_hover.png') no-repeat center center
    }

    .arm_profile_belt_right_icon:hover .arm_profile_template_belt_icon.select_template {
        background: url('../images/select_template_hover.png') no-repeat center center
    }

    .arm_profile_belt_right_icon:hover .arm_profile_template_belt_icon.font_setting {
        background: url('../images/font-setting_hover.png') no-repeat center center
    }

    .arm_profile_belt_right_icon:hover .arm_profile_template_belt_icon.color_settings {
        background: url('../images/topbar_color_pallet_icon_hover.png') no-repeat center center
    }

    .arm_profile_width_type {
        float: left
    }

    .arm_profile_belt_right_icon_last input {
        height: 34px;
        border-right: medium none;
        margin: 1px;
        width: 55px;
        float: left;
        text-align: center
    }

    .arm_profile_width dt {
        background: var(--arm-cl-white) none repeat scroll 0 0;
        border: 1px solid #d2d2d2;
        border-radius: 0;
        color: #000;
        display: block;
        font-size: 13px;
        float: left;
        line-height: 0x;
        height: 34px;
        min-width: 30px;
        text-align: left;
        width: 30px
    }

    .arm_profile_belt_right_icon_last .arm_profile_width_label {
        float: left;
        font-size: 14px;
        padding: 6px
    }

    .arm_profile_width_input {
        float: left;
        margin-right: -5px
    }

    .arm_profile_editor_right_div #arm_accordion {
        margin: 0 !important
    }

    .arm_profile_editor_right_div .arm_accordion {
        padding: 10px 4px 4px 15px
    }

    .arm_profile_editor_right_div .arm_accordion .arm_social_profile_field_item {
        margin-bottom: 12px
    }

    .arm_profile_editor_right_div #arm_accordion ul li .arm_accordion_header {
        background-color: #f1f6ff
    }

    .arm_profile_editor_right_div #arm_accordion ul li.arm_active_section .arm_accordion_header {
        background-color: #e0ecff
    }

    .arm_admin_profile_container {
        margin: 0 auto;
        width: 96%;
        max-width: 96%;
        padding-top: 20px
    }

    .arm_profile_settings_popup {
        background: #fff none repeat scroll 0 0;
        box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        margin-left: -10px;
        margin-top: 10px;
        position: absolute;
        width: 400px;
        z-index: 999999;
        display: none;
        top: 85%
    }

    .arm_profile_setting_switch_div {
        color: #3c3e4f;
        font-size: 15px;
        margin-bottom: 5px;
        padding: 10px 0 10px 0
    }

    .arm_profile_membership_plan {
        padding: 20px
    }

    .arm_profile_clor_scheme_div {
        padding: 20px
    }

    .arm_profile_editor_left_div .arm_belt_box.bottom_div {
        margin: 0;
        border-radius: 0;
        text-align: right;
        display: block
    }

    .arm_profile_belt_icon.desktop {
        background-image: url(../images/desktop_icon.png);
        background-repeat: no-repeat;
        background-position: center center;
        width: 75px
    }

    .arm_profile_belt_icon.desktop.selected,
    .arm_profile_belt_icon.desktop:hover {
        background-color: var(--arm-pt-theme-blue);
        background-image: url(../images/desktop_hover_icon.png);
        background-repeat: no-repeat;
        background-position: center center;
        width: 75px;
        cursor: pointer
    }

    .arm_profile_belt_icon.tab {
        background-image: url(../images/tablet_icon.png);
        background-repeat: no-repeat;
        background-position: center center;
        width: 75px
    }

    .arm_profile_belt_icon.tab.selected,
    .arm_profile_belt_icon.tab:hover {
        background-color: var(--arm-pt-theme-blue);
        background-image: url(../images/tablet_icon_hover.png);
        background-repeat: no-repeat;
        background-position: center center;
        width: 75px;
        cursor: pointer
    }

    .arm_profile_belt_icon.mobile {
        background-image: url(../images/mobile_icon.png);
        background-repeat: no-repeat;
        background-position: center center;
        width: 75px;
        border-right: none
    }

    .arm_profile_belt_icon.mobile.selected,
    .arm_profile_belt_icon.mobile:hover {
        background-color: var(--arm-pt-theme-blue);
        background-image: url(../images/mobile_icon_hover.png);
        background-repeat: no-repeat;
        background-position: center center;
        width: 75px;
        cursor: pointer
    }

    .arm_profiles_main_wrapper * {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_profiles_main_wrapper {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        float: left;
        max-width: 100%;
        width: 100%
    }

    .arm_profile_belt_right_icon {
        cursor: pointer;
        position: relative
    }

    #arm_profile_font_settings_popup_div,
    #arm_profile_settings_popup_div {
        cursor: default;
        padding: 20px;
        display: inline-block;
        width: 350px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        background: var(--arm-cl-white);
        z-index: 9999;
        position: absolute;
        box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        -webkit-box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        -o-box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        -moz-box-shadow: 0 0 4px 0 rgba(50, 50, 50, .3);
        left: 0;
        top: 100%;
        margin: 0
    }

    #arm_profile_font_settings_popup_div {
        width: 500px
    }

    .arm_profile_color_scheme_title,
    .arm_profile_font_settings_popup_title,
    .arm_profile_settings_popup_div_title {
        float: left;
        width: 100%;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        font-size: 18px;
        color: #5c5c60;
        margin-bottom: 5px
    }

    .arm_profile_font_settings_popup_inner_div {
        float: left;
        width: 100%
    }

    .arm_accordion .chosen-container {
        min-width: 100% !important
    }

    .arm_accordion .arm_profile_membership_plan {
        padding: 0 15px 0 5px
    }

    .arm_accordion_inner_title {
        width: 100%;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        font-size: 15px;
        color: #5c5c60;
        margin-bottom: 5px;
        font-weight: 700
    }

    .arm_accordion_separator {
        display: block;
        width: 100%;
        margin: 10px 0
    }

    .arm_profile_upload_buttons_div {
        padding-left: 10px
    }

    span.arm_profile_upload_buttons_label {
        display: inline-block;
        width: 60%
    }

    .arm_card_icon_wrapper,
    .arm_default_cover_photo_wrapper,
    .arm_default_profile_photo_wrapper,
    .arm_stripe_icon_wrapper,
    .arm_stripe_popup_icon_wrapper {
        display: inline-block;
        width: 100px;
        clear: both;
        background: var(--arm-pt-theme-blue);
        text-align: center;
        border: 1px solid var(--arm-pt-theme-blue);
        height: 30px;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        -moz-border-radius: 3px;
        line-height: 30px;
        color: var(--arm-cl-white);
        font-size: 16px;
        cursor: pointer;
        position: relative
    }

    .arm_stripe_icon_wrapper,
    .arm_stripe_popup_icon_wrapper {
        display: block
    }

    .arm_card_icon_wrapper input[type=file],
    .arm_default_cover_photo_wrapper input[type=file],
    .arm_default_profile_photo_wrapper input[type=file],
    .arm_stripe_icon_wrapper input[type=file],
    .arm_stripe_popup_icon_wrapper input[type=file] {
        opacity: 0;
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        cursor: pointer
    }

    div#arm_profile_upload_buttons_div {
        margin-bottom: -20px
    }

    .arm_belt_block .page_sub_title {
        margin-bottom: 0
    }

    .colpick {
        z-index: 999999 !important
    }

    .arm_profile_settings_popup .arm_temp_form_label {
        width: 75%
    }

    #arm_profile_font_settings_popup dt,
    #arm_profile_settings_popup_div dt {
        height: auto !important
    }

    .arm_profile_template_image {
        float: right;
        margin-right: 10px
    }

    .arm_profile_detail_wrapper .arm_profile_picture_block.armCoverPhoto:hover .arm_cover_upload_container,
    .arm_profile_detail_wrapper .arm_user_avatar:hover .arm_cover_upload_container {
        display: none !important
    }

    .arm_accordion[data-id=arm_profile_fields_wrapper] dl dt {
        height: auto !important
    }

    .arm_add_profile_shortcode_row .arm_profile_field_input,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_member_fields_label .display_member_field_input,
    .arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper .arm_display_member_fields_label .display_member_field_input,
    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper .arm_display_member_fields_label .display_member_add_field_input {
        background: rgba(0, 0, 0, 0);
        border: none;
        transition: all 0s !important;
        -webkit-transition: all 0s !important;
        -o-transition: all 0s !important;
        -moz-transition: all 0s !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -o-box-shadow: none !important;
        -moz-box-shadow: none !important
    }

    .arm_add_profile_shortcode_row .arm_confirm_box:not(.arm_confirm_box_plan_change) {
        top: 27px;
        right: 15px
    }

    .arm_profile_field_input:focus {
        border: 1px solid #ddd;
        background: var(--arm-cl-white);
        color: #000 !important;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        -moz-border-radius: 3px
    }

    .arm_custom_css_popup_wrapper {
        position: fixed;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .7);
        top: 0;
        left: 0;
        z-index: 99999;
        display: none
    }

    .arm_custom_css_popup_wrapper.armactive {
        display: block
    }

    .arm_custom_css_popup_inner_wrapper {
        float: left;
        width: 50%;
        background: var(--arm-cl-white);
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -o-border-radius: 5px;
        -moz-border-radius: 5px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%)
    }

    .arm_custom_css_popup_title {
        float: left;
        width: 100%;
        height: 40px;
        line-height: 40px;
        padding: 0 10px;
        border-bottom: 1px solid #ddd;
        font-size: 18px;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS"
    }

    .arm_custom_css_popup_container {
        float: left;
        width: 100%;
        height: 78%
    }

    .arm_custom_css_popup_container .CodeMirror.cm-s-default {
        border: 1px solid #ddd;
        overflow: hidden
    }

    .arm_custom_css_popup_footer {
        float: left;
        width: 100%;
        text-align: right;
        height: 55px
    }

    .arm_profile_font_settings_popup_footer,
    .arm_profile_template_settings_popup_footer,
    .arm_temp_color_option_footer {
        text-align: right;
        float: left;
        width: 100%;
        height: 40px;
        line-height: 60px
    }

    .arm_profile_color_scheme_title {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        color: #3c3e4f
    }

    #arm_profile_settings_color_popup_div {
        width: 360px
    }

    .arm_temp_color_scheme_block.arm_temp_color_scheme_block_custom {
        background: url(../images/custom_color.png) no-repeat
    }

    .arm_temp_color_options .arm_pdtemp_color_opts {
        padding: 0;
        margin-bottom: 10px
    }

    #arm_profile_settings_color_popup_div .arm_temp_color_options {
        background: #f2fafd;
        padding: 20px 20px 20px 20px;
        margin: 0 0 0 -20px;
        box-sizing: content-box;
        -webkit-box-sizing: content-box;
        -o-box-sizing: content-box;
        -moz-box-sizing: content-box
    }

    .arm_temp_color_options .arm_pdtemp_color_opts .arm_temp_form_label {
        float: left;
        width: 100%
    }

    .arm_custom_colorpicker_label {
        border-radius: 3px 0 0 3px !important;
        -webkit-border-radius: 3px 0 0 3px !important;
        -o-border-radius: 3px 0 0 3px !important;
        -moz-border-radius: 3px 0 0 3px !important
    }

    .arm_custom_colorpicker_label .arm_colorpicker {
        border: 1px solid #d2d2d2 !important;
        border-radius: 0 3px 3px 0 !important;
        -webkit-border-radius: 0 3px 3px 0 !important;
        -o-border-radius: 0 3px 3px 0 !important;
        -moz-border-radius: 0 3px 3px 0 !important
    }

    .arm_add_profile_field_icons .arm_profile_field_icon,
    .arm_display_member_field_icons .arm_display_member_field_icon {
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 4px;
        cursor: pointer;
        border-bottom: none !important
    }

    .arm_add_profile_field_icons .arm_profile_field_icon.edit_field,
    .arm_display_member_field_icons .arm_display_member_field_icon.edit_field {
        background: url(../images/edit_field_icon.png) no-repeat center center
    }

    .arm_add_profile_field_icons .arm_profile_field_icon.edit_field:hover,
    .arm_display_member_field_icons .arm_display_member_field_icon.edit_field:hover {
        background: url(../images/edit_field_icon_hover.png) no-repeat center center
    }

    .arm_add_profile_field_icons .arm_profile_field_icon.delete_field {
        background: url(../images/delete_field_icon.png) no-repeat center center
    }

    .arm_add_profile_field_icons .arm_profile_field_icon.delete_field:hover {
        background: url(../images/delete_field_icon_hover.png) no-repeat center center
    }

    .arm_add_profile_field_icons .arm_profile_field_icon.sort_field {
        background: url(../images/drag_field_icon.png) no-repeat center center;
        cursor: move
    }

    .arm_add_profile_field_icons .arm_profile_field_icon.sort_field:hover {
        background: url(../images/drag_field_icon_hover.png) no-repeat center center
    }

    .arm_user_custom_meta.arm_add_profile_shortcode_row {
        border: 1px solid #eaedf1;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        -moz-border-radius: 3px
    }

    .arm_user_custom_meta.arm_add_profile_shortcode_row input.arm_profile_field_input {
        border: 1px solid transparent;
        padding: 7px 12px 6px 12px;
        width: 70%
    }

    .arm_membership_card_template_edit_form .arm_display_member_fields_label input[type=text]:focus,
    .arm_page .arm_display_member_fields_label input[type=text]:focus,
    .arm_template_edit_form .arm_display_member_fields_label input[type=text]:focus,
    .arm_user_custom_meta.arm_add_profile_shortcode_row input.arm_profile_field_input:focus {
        border: 1px solid var(--arm-pt-theme-blue)
    }

    #arm_profile_fields_inner_container {
        position: relative
    }

    #arm_profile_fields_inner_container .arm_profile_fields_li_place_holder {
        margin-bottom: 10px;
        min-height: 40px;
        border: 1px dotted #a6a6a6;
        width: 97%
    }

    .arm_social_prof_div.hidden_section {
        display: none !important
    }

    .arm_profile_field_after_content_wrapper,
    .arm_profile_field_before_content_wrapper {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        padding: 15px 30px 15px 68px;
        text-align: left;
        height: auto;
        word-break: break-word
    }

    .arm_remove_default_cover_photo_wrapper {
        display: inline-block;
        width: 100px;
        clear: both;
        background: #d04540;
        text-align: center;
        border: 1px solid #d04540;
        height: 30px;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        -moz-border-radius: 3px;
        line-height: 30px;
        color: var(--arm-cl-white);
        font-size: 16px;
        cursor: pointer;
        position: relative
    }

    .arm_card_icon_remove,
    .arm_stripe_icon_remove,
    .arm_stripe_popup_icon_remove {
        display: block;
        float: left
    }

    .arm_profile_editor_left_div .arm_profile_detail_wrapper {
        border: 1px solid #eceff3 !important
    }

    .arm_profile_settings_popup_close_button {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 20px;
        height: 20px;
        cursor: pointer;
        background: url(../images/close_profile_field_popup.png) no-repeat center center
    }

    .arm_profile_editor_left_div .arm_profile_detail_tbl tr {
        width: 100% !important
    }

    .arm_current_membership_trial_active {
        color: green
    }

    .arm_custom_css_popup_container .CodeMirror-scroll {
        max-width: 100% !important;
        overflow: hidden !important
    }

    .arm_invoice_settings:parent {
        padding: 0
    }

    .arm_page table.display thead th:first-child div.DataTables_sort_wrapper span {
        display: none
    }

    .arm_page table.arm_on_display thead th:first-child div.DataTables_sort_wrapper span {
        display: block
    }

    tr.arm_plan_cycle td {
        min-height: 15px;
        height: 15px
    }

    .arm_profile_fields_dropdown dl dt {
        background-color: var(--arm-pt-theme-blue)
    }

    .arm_profile_fields_dropdown dl dt i {
        display: none
    }

    .arm_profile_fields_dropdown .arm_multiple_selectbox dt span,
    .arm_profile_fields_dropdown .arm_selectbox dt span {
        width: 100%;
        text-align: center;
        color: var(--arm-cl-white) !important
    }

    .arm_profile_fields_dropdown .arm_selectbox .arm_autocomplete,
    .arm_profile_fields_dropdown .arm_selectbox input.arm_autocomplete {
        color: var(--arm-cl-white) !important;
        text-align: center;
        max-width: 100% !important;
        margin-left: 0 !important
    }

    .arm_profile_fields_dropdown .arm_deactive {
        display: none !important
    }

    .arm_profile_template_associalated_plan {
        float: left;
        width: 100%;
        text-align: center;
        margin-top: 10px;
        padding: 0 10px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -o-box-sizing: border-box;
        -moz-box-sizing: border-box
    }

    .arm_manage_preset_fields {
        width: 100%;
        float: left
    }

    .arm_manage_preset_fields_btn {
        min-width: 27%;
        float: left
    }

    .arm_manage_preset_fields_text {
        width: 73%;
        float: left
    }

    .arm_manage_preset_fields_text .arm_info_text {
        margin: 0
    }

    input.arm_preset_form_field {
        width: 290px !important
    }

    textarea.arm_preset_form_field {
        width: 290px !important;
        padding: 5px 10px !important;
        min-height: 70px
    }

    .arm_preset_field_table td,
    .arm_preset_field_table th {
        border: 1px solid #d2d2d2;
        padding: 10px;
        vertical-align: top
    }

    .arm_preset_field_table tr:not(:last-child) td,
    .arm_preset_field_table tr:not(:last-child) th {
        border-bottom: 0
    }

    .arm_preset_field_table tr td:not(:last-child),
    .arm_preset_field_table tr th:not(:last-child) {
        border-right: 0
    }

    .arm_preset_field_table .description {
        margin: 0
    }

    .arm_preset_field_updated_msg {
        width: 70%;
        float: left;
        margin: 20px 0
    }

    .arm_preset_field_updated_msg .arm_error_msg,
    .arm_preset_field_updated_msg .arm_success_msg {
        display: none
    }

    .arm_preset_field_table th {
        background-color: #f6f8f8
    }

    .arm_edit_form_fields_popup_text {
        overflow: auto;
        height: 450px
    }

    #arm_date_filter,
    #arm_filter_gpend_date,
    #arm_filter_gpstart_date,
    #arm_filter_pend_date,
    #arm_filter_ppend_date,
    #arm_filter_ppstart_date,
    #arm_filter_pstart_date {
        background: url(../images/date_icon.jpg) no-repeat right !important;
        background-position: 96% center !important;
        background-color: var(--arm-cl-white) !important;
        margin: 15px 0 !important;
        padding: 7px 16px 6px 16px
    }

    #arm_date_filter {
        width: 150px !important;
        margin: 0 !important
    }

    .arm_coupon_date_expire {
        color: var(--arm-sc-error) !important
    }

    #arm_coupon_wrapper td:nth-child(5),
    #arm_coupon_wrapper td:nth-child(6) {
        width: 12% !important
    }

    .arm_datatable_filters .arm_payment_history_filter_submit {
        width: auto;
        margin-left: 0;
        text-align: left
    }

    .arm_access_rules_grid_wrapper .arm_access_rules_empty {
        text-align: center;
        padding: 20px !important;
        border: #e4e4e4 1px solid;
        color: #3c3e4f;
        background-color: #f5f5f5;
        font-size: 14px
    }

    .arm_opt_ins_cl_wrapper {
        margin: 15px 0;
        padding: 10px 18px 15px 15px
    }

    .arm_opt_ins_cl_wrapper .arm_opt_ins_cl_form_fields_wrapper dl dt {
        min-width: 123px;
        width: 123px
    }

    .arm_opt_ins_cl_wrapper .arm_opt_ins_cl_form_fields_wrapper dl.arm_opt_ins_cl_optin_operators dt {
        min-width: 60px;
        width: 60px
    }

    .arm_opt_ins_cl_val_txt {
        min-height: 34px;
        display: inline;
        font-weight: 400;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        vertical-align: middle;
        width: 55px
    }

    .arm_member_status_div,
    .arm_send_email_to_user_div {
        display: inline-block !important;
        vertical-align: middle !important;
        margin: 0 10px 0 0 !important
    }

    .arm_common_tax_td,
    .arm_country_tax_td {
        padding-left: 45px !important;
        padding-top: 0 !important
    }

    .arm_common_tax_td #tax_amount,
    .arm_country_tax_td #arm_country_tax_amount {
        max-width: 100px
    }

    .arm_common_tax_td .arm_info_text,
    .arm_country_tax_td .arm_info_text,
    .arm_setup_two_step_note {
        margin: 10px 0 0;
        display: block
    }

    .arm_tax_country_list_wrapper {
        position: relative
    }

    .arm_tax_country_list_wrapper span.arm_country_val_error {
        position: absolute;
        left: 0;
        margin-left: 190px;
        top: 36px
    }

    .arm_country_tax_action_buttons {
        display: inline-block;
        overflow: hidden;
        vertical-align: text-bottom
    }

    .arm_country_tax_plus_icon {
        background: rgba(0, 0, 0, 0) url("../images/add_plan.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    .arm_country_tax_plus_icon:hover {
        background: rgba(0, 0, 0, 0) url("../images/add_plan_hover.png") no-repeat scroll center center
    }

    .arm_country_tax_minus_icon {
        background: rgba(0, 0, 0, 0) url("../images/remove_plan.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    .arm_country_tax_minus_icon:hover {
        background: rgba(0, 0, 0, 0) url("../images/remove_plan_hover.png") no-repeat scroll center center
    }

    .arm_enable_country_tax #arm_country_tax_loader {
        width: 24px !important;
        height: 24px !important;
        position: relative !important;
        top: 7px !important;
        left: 6px
    }

    .arm_element_border_on_error {
        border-color: red !important
    }

    .arm_drip_rules_grid_container .arm_datatable_filter_item span.arm_manage_filter_label,
    .arm_members_grid_container .arm_datatable_filter_item span.arm_manage_filter_label {
        padding-left: 6px
    }

    .arm_drip_rules_grid_container .arm_datatable_filter_item span.arm_manage_filter_label {
        display: block
    }

    .arm_membership_card_temp_edit_popup_wrapper {
        width: 750px
    }

    .arm_edit_membership_card_templates {
        background-color: var(--arm-cl-white)
    }

    .arm_edit_membership_card_templates table {
        width: 100%
    }

    .arm_edit_membership_card_templates .arm_template_option_block {
        padding: 0
    }

    .arm_add_membership_card_templates .arm_template_option_block .arm_opt_label {
        color: #191818 !important;
        min-width: 180px !important;
        max-width: 180px !important;
        vertical-align: top !important;
        margin-top: 5px !important;
        display: inline-block !important
    }

    .arm_admin_form .arm_membership_card_height_label input[type=text],
    .arm_admin_form .arm_membership_card_width_label input[type=text] {
        margin-right: 8px
    }

    .arm_membership_card_template_wrapper .arm_grid_avatar {
        height: auto
    }

    .arm_temp_opt_box_with_lbl {
        margin-bottom: 5px !important
    }

    .arm_temp_opt_box_lbl {
        margin-top: -10px !important
    }

    .arm_membership_card_user_id_label {
        margin-bottom: 30px !important
    }

    .arm_card_background_remove,
    .arm_card_logo_remove {
        vertical-align: top !important
    }

    .arm_clogo_cnt_wrapper {
        line-height: 0
    }

    .arm_card_background_wrapper,
    .arm_card_logo_wrapper {
        vertical-align: top !important
    }

    .arm_card_bg_selected_img,
    .arm_card_selecred_img,
    .arm_stripe_icon_selected_img,
    .arm_stripe_popup_icon_selected_img {
        display: inline-block;
        width: 50px;
        height: 50px;
        margin-left: 20px;
        position: relative;
        top: -10px
    }

    .arm_card_icon_selected_img:not(.arm_default_image_card) {
        display: inline-block;
        width: 150px;
        height: auto;
        margin-left: 20px;
        position: relative
    }

    .arm_card_icon_selected_img.arm_default_image_card {
        max-width: 200px;
        height: auto;
        position: absolute;
        top: 10px;
        margin-left: 115px;
        display: inline-block
    }

    .arm_card_icon_selected_img img.arm_default_image_card {
        content: url(../images/arm_default_card_image_url.png);
        width: 100%;
        height: max-content
    }

    .arm_card_icon_selected_img img {
        width: 100%;
        height: auto
    }

    .arm_stripe_icon_selected_img,
    .arm_stripe_popup_icon_selected_img {
        top: 0
    }

    .arm_card_bg_selected_img img,
    .arm_card_selecred_img img,
    .arm_stripe_icon_selected_img img,
    .arm_stripe_popup_icon_selected_img img {
        width: 100%;
        height: 100%
    }

    .arm_stripe_icon_error {
        color: red
    }

    .arm_clog_lbl {
        line-height: 20px
    }

    .arm_clogo_opt {
        font-size: 12px
    }

    .arm_add_mcard_template_box_content,
    .arm_add_membership_card {
        min-height: 252px !important
    }

    .arm_clogo_recom_lbl {
        display: block;
        font-size: 12px
    }

    .arm_enable_country_tax .arm_helptip_icon_dtax {
        margin-left: 10px !important
    }

    .arm_feature_list.mycred_enable .arm_feature_icon {
        background-image: url(../images/mycred_feature_icon.png)
    }

    ::-webkit-file-upload-button {
        cursor: pointer
    }

    .arm_achievement_plus_icon {
        background: rgba(0, 0, 0, 0) url("../images/add_plan.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    .arm_achievement_plus_icon:hover {
        background: rgba(0, 0, 0, 0) url("../images/add_plan_hover.png") no-repeat scroll center center
    }

    .arm_achievement_minus_icon {
        background: rgba(0, 0, 0, 0) url("../images/remove_plan.png") no-repeat scroll center center;
        cursor: pointer;
        float: left;
        height: 24px;
        margin-left: 5px;
        width: 24px
    }

    .arm_achievement_minus_icon:hover {
        background: rgba(0, 0, 0, 0) url("../images/remove_plan_hover.png") no-repeat scroll center center
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dd ul li img.arm_badge_icon,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dd ul li img.arm_badge_icon {
        display: inline-block;
        margin: 0 10px 0 0
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dd ul li span.arm_badge_title,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dd ul li span.arm_badge_title {
        padding-top: 7px;
        display: inline-table;
        width: 80%;
        vertical-align: middle;
        line-height: 15px
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dt span img.arm_badge_icon,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dt span img.arm_badge_icon {
        float: left;
        margin: 0;
        padding: 0 10px 0 0
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dt span span.arm_badge_title,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dt span span.arm_badge_title {
        display: inline-block;
        width: 75%;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_helptip_icon,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_helptip_icon {
        display: inline-block;
        vertical-align: middle
    }

    .arm_achievements_list_grid img.arm_grid_badges_icon {
        padding: 0 5px
    }

    .arm_achievement_has_complete .arm_achievement_has_complete_tultip {
        font-size: 12px
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_helptip,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_helptip {
        width: 100%;
        display: inline-block;
        margin: 1% 0
    }

    .arm_achievement_badge_select dd ul li img.arm_badge_icon,
    .arm_achievement_badge_select dt span img.arm_badge_icon {
        width: 24px !important;
        height: 24px !important
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete span#arm_add_achieve-error,
    .arm_add_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete span#arm_require_achive_badges_id-error,
    .arm_add_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete span#arm_require_badges_tootip-error,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete span#arm_edit_achieve_num-error,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete span#arm_require_achive_badges_id-error,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete span#arm_require_badges_tootip-error {
        display: none !important
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td input.arm_badges_tooltip {
        width: 310px
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete input.arm_achivement_badges_tootip,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete input.arm_achivement_badges_tootip {
        min-width: 130px;
        width: 130px
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete .arm_achievement_badge_select,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td .arm_achievement_has_complete .arm_achievement_badge_select {
        margin: 0 10px 3px 10px !important
    }

    .arm_add_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dt span span.arm_badge_title img.arm_badge_icon,
    .arm_edit_achievements_wrapper .arm_table_label_on_top tr td dl.arm_badge_select dt span span.arm_badge_title img.arm_badge_icon {
        padding: 0 10px 0 0
    }

    .arm_confirm_box_plan_change .arm_add_plan_filter_label {
        font-size: 14px
    }

    .arm_add_plan_filter_label.arm_choose_payment_cycle_label {
        margin-top: 10px;
        display: inline-block
    }

    .arm_admin_form .form-table th.arm_email_settings_content_label:not(.arm_user_plan_text_th) {
        min-width: 130px
    }

    .arm_feature_list .arm_feature_vesrion_compatiblity {
        display: inline-block;
        width: 76%;
        color: #bdbd17;
        margin-top: 0;
        padding-left: 15px;
        min-height: auto !important
    }

    .arm_all_loginhistory_filter_wrapper {
        margin: 10px 0 30px
    }

    .arm_all_loginhistory_filter_inner {
        width: auto;
        float: left
    }

    .arm_all_loginhistory_filter_wrapper .arm_log_history_search_lbl_user {
        float: left
    }

    .arm_all_loginhistory_filter_wrapper input#arm_log_history_search_user {
        width: 200px !important
    }

    .arm_all_loginhistory_filter_wrapper button.arm_login_history_page_search_btn,
    .arm_all_loginhistory_filter_wrapper button.arm_login_history_search_btn {
        min-width: 60px
    }

    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .display_member_field_edit form input,
    .arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper .display_member_field_edit form input,
    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper .display_member_field_edit form input {
        max-width: 80% !important;
        min-height: 25px;
        max-height: 25px;
        height: 25px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border: 1px solid var(--arm-pt-theme-blue) !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        -o-border-radius: 3px;
        background: var(--arm-cl-white) !important;
        color: #5c5c60 !important;
        margin: 0;
        vertical-align: top;
        z-index: 9999;
        float: left;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        font-size: 14px;
        text-decoration: none !important;
        font-weight: 400 !important;
        font-style: normal !important
    }

    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_member_fields_label,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_members_fields_label,
    .arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper .arm_display_member_fields_label,
    .arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper .arm_display_members_fields_label,
    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper .arm_display_member_fields_label,
    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper .arm_display_members_fields_label {
        width: 30%
    }

    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_member_fields_label .display_member_field_input,
    .arm_pdtemp_edit_popup_wrapper .arm_display_members_fields_selection_wrapper .arm_display_member_fields_label .display_member_field_input,
    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper .arm_display_member_fields_label .display_member_add_field_input {
        height: 25px;
        max-width: 90%;
        min-width: 80%;
        width: 300px;
        padding: 10px 5px
    }

    .profile_display_member_fields .arm_profile_display_member_fields_list_wrapper .arm_display_member_fields_label .display_member_add_field_input {
        min-width: 140px;
        width: 140px
    }

    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_member_fields_label,
    .arm_opt_content_wrapper .arm_membership_card_display_members_fields_selection_wrapper .arm_display_members_fields_label {
        width: 50%
    }

    @media only screen and (max-width: 960px) {
        .arm_sticky_top_belt {
            padding: 0 0 0 40px
        }
    }

    @media screen and (max-width: 782px) {
        .arm_sticky_top_belt {
            padding: 0
        }

        .arm_sticky_top_belt .arm_belt_box {
            margin-top: 48px
        }
    }

    @media screen and (max-width: 600px) {
        .arm_sticky_top_belt {
            top: -100%
        }
    }

    @media screen and (max-width: 1000px) and (min-width:768px) {
        .arm_feature_list {
            width: 48%;
            max-width: 305px
        }

        .arm_feature_list.active {
            width: 48%;
            max-width: 305px
        }

        .arm_profile_editor_right_div {
            width: 164px
        }
    }

    @media screen and (max-width: 1299px) and (min-width:768px) {
        .arm_profile_editor_left_div {
            width: 65.9%
        }
    }

    @media screen and (max-width: 1599px) and (min-width:1300px) {
        .arm_profile_editor_left_div {
            width: 68%
        }

        .arm_profile_editor_right_div {
            width: 320px
        }
    }

    @media screen and (min-width: 1600px) and (max-width:1920px) {
        .arm_profile_editor_left_div {
            width: 75%
        }
    }

    @media screen and (min-width: 1900px) {
        .arm_profile_editor_left_div {
            width: 76%
        }

        .arm_profile_editor_right_div {
            width: 300px
        }
    }

    svg.arm_card_print_btn {
        position: absolute;
        top: 10px;
        right: 20px;
        cursor: pointer;
        display: none
    }

    .membershipcard1:hover .arm_card_print_btn,
    .membershipcard2:hover .arm_card_print_btn,
    .membershipcard3:hover .arm_card_print_btn {
        display: block
    }

    .arm_addon_loader {
        position: absolute;
        width: 30px;
        height: 30px;
        left: 50%;
        top: 58%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        z-index: -1
    }

    .arm_addon_loader.active {
        z-index: 999
    }

    .arm_circular {
        -webkit-animation: rotate 2s linear infinite;
        animation: rotate 2s linear infinite;
        height: 100%;
        -webkit-transform-origin: 43% 37%;
        transform-origin: 43% 37%;
        width: 100%;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        display: none
    }

    .arm_addon_loader.active .arm_circular {
        display: block
    }

    circle.path {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
        stroke-linecap: round;
        -webkit-animation: dash 1.5s ease-in-out infinite, color_blue 6s ease-in-out infinite;
        animation: dash 1.5s ease-in-out infinite, color_blue 6s ease-in-out infinite
    }

    .arm_default_access_restrictions_row .chosen-container {
        width: 500px !important;
        max-width: 100%
    }

    @keyframes rotate {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    @keyframes dash {
        0% {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0
        }

        50% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -35px
        }

        100% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -124px
        }
    }

    @keyframes color_blue {

        0%,
        100% {
            stroke: #005aee
        }

        40% {
            stroke: #005aee
        }

        66% {
            stroke: #005aee
        }

        80%,
        90% {
            stroke: #005aee
        }
    }

    .arm_report_analytics_content {
        padding-bottom: 50px;
        display: inline-block
    }

    .wrap .arm_report_analytics_content .lbltitle {
        color: #4e5462;
        padding: 5px 0 0 0;
        font-family: Asap-Regular;
        letter-spacing: normal;
        font-size: 14px;
        text-shadow: none;
        cursor: auto
    }

    .wrap .arm_report_analytics_content label {
        display: inline;
        margin-bottom: 0
    }

    .wrap .arm_report_analytics_content .lbltitle {
        font-weight: 700;
        color: #0384ae;
        font-size: 14px
    }

    .wrap .arm_report_analytics_content .lbltitle_main {
        font-weight: 700;
        color: #0384ae;
        font-size: 18px;
        margin-left: 27px
    }

    .wrap .arm_report_analytics_content .armtalbespacing {
        border-collapse: collapse !important;
        border-collapse: collapse !important;
        margin: 30px 0 45px 0 !important;
        width: 100%
    }

    .arm_report_analytics_content table.armtalbespacing tbody tr:not(.arm_cal_header):not(.arm_cal_month) {
        background-color: #f2f4f9
    }

    .arm_report_analytics_content table.table-condensed tbody.arm_cal_body tr {
        background-color: var(--arm-cl-white) !important
    }

    .arm_report_analytics_content table.armtalbespacing tbody tr:first-child td:first-child {
        padding-left: 15px
    }

    .arm_report_analytics_content table.armtalbespacing tbody tr:first-child td:last-child {
        padding-left: 0
    }

    .arm_report_analytics_content table.armtalbespacing tbody tr td {
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
        padding-right: 10px;
        width: 100%
    }

    .arm_report_analytics_main_wrapper .arm_datatable_searchbox tbody tr:nth-child(odd) {
        background-color: #f2f4f9 !important
    }

    .arm_report_analytics_main_wrapper .arm_member_last_subscriptions_table tbody tr:nth-child(2n) {
        background-color: var(--arm-cl-white)
    }

    .arm_report_analytics_main_wrapper .arm_member_last_subscriptions_table tbody tr:nth-child(odd) {
        background-color: var(--arm-cl-white)
    }

    .btn_chart_type {
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -o-box-shadow: none !important;
        -moz-box-shadow: none !important;
        text-decoration: none;
        color: #91949b !important;
        cursor: pointer;
        font-family: inherit;
        font-size: 14px;
        outline: medium none;
        border: 0 none;
        height: 36px;
        cursor: pointer;
        background: 0 0 !important;
        border-bottom: 1px solid transparent;
        width: 98px;
        padding: 5px
    }

    .wrap .arm_report_analytics_content .btn_chart_type.active {
        color: var(--arm-pt-theme-blue) !important;
        border-bottom: 1px solid var(--arm-pt-theme-blue);
        pointer-events: none
    }

    .armgraphtype.selected,
    .wrap .arm_report_analytics_content .armgraphtype:hover {
        background: var(--arm-pt-theme-blue);
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        -moz-border-radius: 3px
    }

    .wrap .arm_report_analytics_content .armgraphtype {
        width: 48px;
        height: 35px;
        float: left;
        margin: 0 5px;
        position: relative;
        cursor: pointer
    }

    .wrap .arm_report_analytics_content .armgraphtype input[type=radio] {
        opacity: 0;
        display: none
    }

    .wrap .arm_report_analytics_content .armgraphtype_span {
        position: absolute;
        width: auto;
        height: 28px;
        cursor: pointer;
        left: 0;
        top: 4px
    }

    .wrap .arm_report_analytics_content .armgraphtype_span path {
        fill: #b2c7f5
    }

    .wrap .arm_report_analytics_content .armgraphtype.selected path,
    .wrap .arm_report_analytics_content .armgraphtype:hover path {
        fill: var(--arm-cl-white)
    }

    .wrap .arm_report_analytics_content .armchart_display_title {
        color: #32323a;
        background-repeat: no-repeat;
        background-position: left bottom;
        min-height: 40px;
        width: auto;
        text-align: left;
        margin-top: -38px;
        position: absolute;
        font-weight: 600;
        margin-left: 35px
    }

    .wrap .arm_report_analytics_content .wrap .armcharttitle {
        font-size: 16px;
        color: #4e5462
    }

    .arm_disabled_class_next rect,
    .arm_disabled_class_next.highcharts-button-hover rect,
    .arm_disabled_class_next.highcharts-button-normal rect,
    .arm_disabled_class_prev rect,
    .arm_disabled_class_prev.highcharts-button-hover rect,
    .arm_disabled_class_prev.highcharts-button-normal rect {
        fill: rgb(234, 234, 234) !important;
        stroke: #eaeaea
    }

    .arm_disabled_class_next svg path,
    .arm_disabled_class_next.highcharts-button-hover svg path,
    .arm_disabled_class_next.highcharts-button-normal svg path,
    .arm_disabled_class_prev svg path,
    .arm_disabled_class_prev.highcharts-button-hover svg path,
    .arm_disabled_class_prev.highcharts-button-normal svg path {
        fill: var(--arm-cl-white) !important
    }

    .wrap .arm_report_analytics_content .arm_disabled_class_next rect,
    .wrap .arm_report_analytics_content .arm_disabled_class_next.highcharts-button-hover rect,
    .wrap .arm_report_analytics_content .arm_disabled_class_next.highcharts-button-normal rect,
    .wrap .arm_report_analytics_content .arm_disabled_class_prev rect,
    .wrap .arm_report_analytics_content .arm_disabled_class_prev.highcharts-button-hover rect,
    .wrap .arm_report_analytics_content .arm_disabled_class_prev.highcharts-button-normal rect {
        fill: rgb(234, 234, 234) !important;
        stroke: #eaeaea
    }

    .wrap .arm_report_analytics_content .arm_disabled_class_next svg path,
    .wrap .arm_report_analytics_content .arm_disabled_class_next.highcharts-button-hover svg path,
    .wrap .arm_report_analytics_content .arm_disabled_class_next.highcharts-button-normal svg path,
    .wrap .arm_report_analytics_content .arm_disabled_class_prev svg path,
    .wrap .arm_report_analytics_content .arm_disabled_class_prev.highcharts-button-hover svg path,
    .wrap .arm_report_analytics_content .arm_disabled_class_prev.highcharts-button-normal svg path {
        fill: var(--arm-cl-white) !important
    }

    .wrap .arm_report_analytics_content #arm_next_button:not(.arm_disabled_class_next),
    .wrap .arm_report_analytics_content #arm_prev_button:not(.arm_disabled_class_prev) {
        cursor: pointer
    }

    .arm_report_analytics_content .arm_add_new_item_box .armemailaddbtn {
        border-radius: 30px;
        -webkit-border-radius: 30px;
        -moz-border-radius: 30px;
        -o-border-radius: 30px;
        padding: 5px 10px
    }

    .arm_report_analytics_content .arm_datatable_searchbox .armemailaddbtn {
        margin-left: 10px !important
    }

    .arm_report_analytics_content .armemailaddbtn img {
        margin-right: 5px
    }

    .arm_member_payment_history_chart .arm_report_table_title,
    .arm_members_chart .arm_report_table_title {
        font-size: 20px
    }

    .arm_report_analytics_main_wrapper .arm_member_last_subscriptions_table {
        margin-top: 20px
    }

    .arm_report_analytics_main_wrapper .arm_member_last_subscriptions_table thead td {
        font-weight: 700
    }

    .arm_report_analytics_main_wrapper .arm_member_last_subscriptions_table.arm_member_login_history_filter_table {
        margin-top: 0
    }

    th.arm_report_grid_no_data {
        text-align: center
    }

    .highcharts-container .highcharts-root {
        font-family: inherit !important
    }

    .arm_member_payment_history_chart .sltstandard {
        margin-right: 0
    }

    .arm_transfer_mode_main_container {
        display: none;
        margin-left: 30px
    }

    .arm_transfer_mode_main_container input.arm_bank_transfer_mode_option_label {
        width: 55%
    }

    .arm_transfer_mode_main_container label {
        width: 5%;
        float: left
    }

    .arm_transfer_mode_main_container .arm_transfer_mode_list_container {
        margin-bottom: 5px;
        display: flex;
        align-items: baseline
    }

    .arm_recaptchav3_msg {
        color: var(--arm-sc-error)
    }

    .arm_chart_container {
        padding: 15px;
        display: none
    }

    .arm_chart_container_inner {
        width: 100%;
        height: 300px;
        margin-top: 30px;
        margin-left: 6px
    }

    .arm_report_member_summary {
        display: inline-block;
        margin: 0 20px;
        text-align: center;
        vertical-align: middle;
        width: 100%
    }

    .arm_report_member_summary a {
        color: var(--arm-cl-white) !important;
        display: block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_report_member_summary a:focus,
    .arm_report_member_summary a:focus .media-icon img {
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none
    }

    .arm_report_member_summary .arm_member_summary {
        float: left;
        width: 20%;
        min-height: 65px;
        padding: 1%;
        margin-bottom: 8px;
        text-align: center;
        background-color: #f9f9f9;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -o-border-radius: 6px
    }

    .arm_report_analytics_main_wrapper .arm_report_member_summary .arm_member_summary {
        padding: 25px 1%;
        margin-bottom: 20px
    }

    .arm_report_analytics_main_wrapper .arm_report_member_summary .arm_member_summary_label {
        font-size: 16px
    }

    .arm_report_member_summary .arm_member_summary_count {
        display: inline-block;
        font-size: 26px;
        line-height: 26px;
        margin-bottom: 10px
    }

    .arm_report_member_summary .arm_member_summary_label {
        font-size: 14px
    }

    .arm_report_member_summary .arm_total_members {
        background: #2c2d42
    }

    .arm_report_analytics_main_wrapper .arm_report_member_summary .arm_member_summary {
        margin-right: 2%
    }

    .arm_report_member_summary .arm_active_members {
        background: #4caf50
    }

    .arm_report_member_summary .arm_inactive_members {
        background: #ff3b3b
    }

    .arm_report_member_summary .arm_membership_plans {
        background: #005aee
    }

    .arm_setup_summary_text_container {
        width: 95%;
        margin-bottom: 10px
    }

    .arm_currency_prefix_suffix_display {
        display: flex;
        margin-top: .5rem
    }

    .arm_custom_currency_edit {
        margin-left: .5rem
    }

    .armember_page_arm_general_settings #arm_form_shortcode_options_popup_wrapper .arm_selectbox dt,
    .armember_page_arm_manage_pay_per_post #arm_form_shortcode_options_popup_wrapper .arm_selectbox dt {
        width: 280px
    }

    #arm_add_edit_paid_post_form #arm_paid_post_items_input {
        width: 520px !important
    }

    .arm_paid_post_url_param {
        vertical-align: baseline !important;
        text-align: right;
        line-height: 2.3 !important
    }

    .arm_pay_per_post_default_content {
        width: 96%
    }

    .arm_report_graph_buttons_td div {
        float: right !important
    }

    .arm_report_filters_td {
        width: 86% !important
    }

    .arm_report_filters_td .sltstandard div a {
        vertical-align: sub
    }

    .arm_report_filters_td .sltstandard .arm_filter_div {
        padding: 0 5px
    }

    .arm_report_filters_td .sltstandard .filter_div input[type=button] {
        margin-top: 5px
    }

    .dataTables_scrollBody {
        position: unset !important
    }

    .DTFC_LeftBodyWrapper table.dataTable tbody tr td:last-child {
        text-align: center !important
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding-left: 0 !important;
        padding-right: .5em !important
    }

    .arm_smtp_debug_title {
        width: 100%;
        color: var(--arm-sc-error);
        margin-bottom: 25px;
        font-size: 16px;
        display: block
    }

    #arm_smtp_debug_notices .popup_content_text {
        height: 500px;
        overflow: auto
    }

    #arm_error_test_mail .arm_error_full_log_container {
        position: relative;
        float: right;
        margin: 10px 0 0;
        min-width: 300px;
        text-align: right;
        cursor: default
    }

    .arm_pg_error_msg {
        color: var(--arm-sc-error);
        display: list-item
    }

    .arm_login_link_options .arm_info_text {
        line-height: normal;
        font-size: 12px;
        color: #949494
    }

    .arm_profile_template_name_div {
        margin-bottom: 30px
    }

    .arm_card_template_name_div {
        margin-bottom: 15px
    }

    .arm_profile_template_name_div input {
        width: 40%
    }

    .arm_debug_log_action_container .arm_confirm_box {
        right: unset !important
    }

    .arm_view_debug_general_logs.popup_wrapper,
    .arm_view_debug_payment_logs.popup_wrapper {
        width: 90% !important;
        min-height: 500px !important;
        position: absolute !important;
        z-index: 9999 !important;
        opacity: 1 !important;
        left: 5% !important
    }

    .arm_debug_log_raw_data {
        width: 55%;
        line-break: anywhere
    }

    .arm_download_confirm_box .arm_confirm_box_arrow {
        float: unset !important;
        left: 20% !important
    }

    .arm_download_confirm_box .arm_confirm_box_body {
        max-width: 450px
    }

    .arm_download_confirm_box .arm_download_custom_duration_div {
        display: flex;
        display: none
    }

    .arm_download_confirm_box .arm_download_custom_duration_div #arm_filter_pend_date,
    .arm_download_confirm_box .arm_download_custom_duration_div #arm_filter_pstart_date {
        width: 160px !important
    }

    .arm_download_confirm_box .arm_download_debug_log_btn {
        margin-top: 20px !important
    }

    .arm_download_confirm_box .arm_download_duration_selection {
        display: flex;
        margin-top: 5px
    }

    .arm_download_confirm_box .arm_download_duration_selection .arm_select_duration_label {
        text-align: left !important;
        font-size: 14px;
        padding-right: 10px;
        line-height: 32px !important
    }

    .arm_general_debug_download_confirm_box .arm_confirm_box_arrow {
        float: unset !important;
        left: 20% !important
    }

    .arm_general_debug_download_confirm_box .arm_confirm_box_body {
        max-width: 450px
    }

    .arm_general_debug_download_confirm_box .arm_download_custom_duration_div {
        display: flex;
        display: none
    }

    .arm_general_debug_download_confirm_box .arm_download_custom_duration_div #arm_filter_pend_date,
    .arm_general_debug_download_confirm_box .arm_download_custom_duration_div #arm_filter_pstart_date {
        width: 160px !important
    }

    .arm_general_debug_download_confirm_box .arm_download_general_debug_log_btn {
        margin-top: 20px !important
    }

    .arm_general_debug_download_confirm_box .arm_download_duration_selection {
        display: flex;
        margin-top: 5px
    }

    .arm_general_debug_download_confirm_box .arm_download_duration_selection .arm_select_duration_label {
        text-align: left !important;
        font-size: 14px;
        padding-right: 10px;
        line-height: 32px !important
    }

    .arm_form_shortcode_box span.arm_api_security_key {
        overflow: unset
    }

    .arm_page .arm_api_security_key_form .arm_form_shortcode_box {
        max-width: 558px;
        line-height: 24px;
        display: block;
        margin-top: 8px
    }

    .arm_page .arm_api_security_key_form .arm_api_field_label,
    .arm_page .arm_api_security_key_form .arm_api_field_name {
        width: 130px;
        display: inline-block;
        padding: 5px 2px
    }

    .arm_api_fields {
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center
    }

    .arm_page .arm_api_security_key_form .arm_api_field_optional {
        width: 70px;
        display: inline-block;
        padding: 5px 2px
    }

    .arm_page .arm_api_security_key_form .arm_api_field_default {
        width: 320px;
        display: inline-block;
        padding: 5px 2px
    }

    .armchart_plan_item_desc .arm_chart_total_amount {
        padding-left: 10px
    }

    .arm_bulk_coupon_form_fields_popup_text #arm_subscription_coupons_chosen {
        width: 73% !important
    }

    .arm_coupon_blank_field_warning {
        color: #666;
        width: 100%;
        display: inline-block;
        font-size: 12px
    }

    .coupon_type_membership_plan .chosen-container,
    .coupon_type_paid_post .ui-autocomplete-input {
        margin-bottom: 5px !important
    }

    .arm_access_rules_grid_wrapper .armswitch {
        margin: 0 auto;
        width: 35px
    }

    .arm_display_block {
        display: block
    }

    .arm_number_input_field {
        width: 60px !important;
        display: inline-block
    }

    .arm_enable_confirm_email_field,
    .arm_enable_confirm_password_field,
    .arm_strength_meter_field {
        padding-top: 0;
        margin-top: -3px
    }

    .arm_checkbox_field_label {
        margin-left: -4px
    }

    .arm_info_text_style {
        margin: 10px 0;
        display: block
    }

    .arm_submit_btn_loader {
        position: relative;
        top: 8px
    }

    .arm_members_chart_container {
        min-width: 255px
    }

    .arm_access_rules_container .arm_info_text {
        margin: 0 40px 15px;
        width: calc(100% - 80px)
    }

    .arm_access_rules_grid_wrapper {
        min-height: 400px;
        position: relative;
        top: 16px
    }

    .arm_max_login_retries_error,
    .arm_permanent_lockdown_duration_error,
    .arm_permanent_login_retries_error,
    .arm_temporary_lockdown_duration_error {
        margin: 0 5px
    }

    .arm_debug_log_action_container {
        margin-top: 10px
    }

    .arm_download_duration_selection .arm_selectbox dt {
        width: 120px
    }

    .add_new_badges_wrapper.popup_wrapper,
    .add_new_user_badges_wrapper.popup_wrapper,
    .arm_failed_login_attempts_history_popup.popup_wrapper,
    .popup_wrapper.arm_social_profile_fields_popup_wrapper {
        width: 650px;
        margin-top: 40px
    }

    .arm_add_new_drip_rule_wrapper.popup_wrapper,
    .arm_edit_drip_rule_wrapper.popup_wrapper {
        width: 800px;
        margin-top: 40px
    }

    .add_new_message_wrapper.popup_wrapper,
    .edit_email_template_wrapper.popup_wrapper {
        width: 860px;
        margin-top: 40px
    }

    .arm_bulk_coupon_form_fields_popup_div.popup_wrapper,
    .arm_edit_form_fields_popup_div.popup_wrapper,
    .arm_member_manage_plan_detail_popup.popup_wrapper,
    .arm_member_paid_post_popup.popup_wrapper {
        width: 1000px;
        min-height: 200px
    }

    .arm_save_social_network_wrapper.popup_wrapper {
        width: 800px;
        margin-top: 40px
    }

    .arm_custom_css_detail_popup.popup_wrapper,
    .arm_import_user_list_detail_popup.popup_wrapper {
        width: 900px
    }

    .arm_section_custom_css_detail_popup.popup_wrapper,
    .arm_smtp_debug_detail_popup.popup_wrapper {
        width: 700px
    }

    .arm_members_list_detail_popup.arm_members_list_detail_popup_wrapper {
        width: 810px;
        min-height: 250px
    }

    .arm_member_plan_failed_payment_popup.popup_wrapper {
        width: 800px;
        min-height: 200px
    }

    .arm_add_new_paid_post_wrapper.popup_wrapper,
    .arm_edit_paid_post_wrapper.popup_wrapper {
        width: 1200px;
        margin-top: 40px
    }

    .arm_add_achievements_wrapper.popup_wrapper,
    .arm_edit_achievements_wrapper.popup_wrapper {
        width: 720px;
        margin-top: 40px
    }

    .add_new_form_wrapper.popup_wrapper,
    .arm_add_new_other_forms_wrapper.popup_wrapper,
    .arm_preview_badge_details_popup_wrapper.popup_wrapper {
        width: 650px
    }

    #arm_rename_wp_admin_popup_div.popup_wrapper,
    .arm_invoice_detail_popup.popup_wrapper,
    .arm_preview_failed_log_detail_popup.popup_wrapper,
    .arm_preview_log_detail_popup.popup_wrapper {
        width: 800px
    }

    .arm_template_preview_popup.popup_wrapper {
        width: 1090px;
        max-width: 100%
    }

    .add_new_profile_form_wrapper.popup_wrapper,
    .arm_edit_membership_card_templates.popup_wrapper,
    .arm_pdtemp_edit_popup_wrapper.popup_wrapper,
    .arm_ptemp_add_popup_wrapper.popup_wrapper {
        width: 750px
    }

    .arm_plan_cycle_detail_popup.popup_wrapper {
        width: 850px;
        min-height: 200px
    }

    .arm_woocommerce_feature_version_required_notice {
        font-size: 15px;
        font-weight: 700;
        color: var(--arm-gt-gray-500);
        min-height: 0
    }

    .arm_form_settings_style_block .arm_form_width {
        width: 152px
    }

    .arm_form_opacity_opts {
        width: 60px !important;
        min-width: 50px !important
    }

    .arm_form_editor_field_label {
        vertical-align: top;
        padding-top: 7px
    }

    .arm_invoice_reset_btn_div .arm_submit_btn_loader {
        top: 15px;
        margin-right: 20px;
        float: right
    }

    .arm_currency_seperator_text_style {
        width: 220px;
        text-align: center;
        display: inline-block;
        font-weight: 700;
        font-size: 16px;
        margin: 15px 0 1px
    }

    .arm_badge_size_field_label {
        display: inline-block;
        min-width: 60px
    }

    .arm_success_test_mail_label {
        font-size: 14px !important;
        float: left;
        width: 100%;
        font-family: open_sanssemibold, Arial, Helvetica, Verdana, sans-serif;
        color: #4c9738 !important
    }

    .arm_error_test_mail_label {
        font-size: 14px !important;
        float: left;
        width: 100%;
        font-family: open_sanssemibold, Arial, Helvetica, Verdana, sans-serif;
        color: red !important
    }

    #arm_clear_form_fields_frm .arm_submit_btn_loader,
    #arm_edit_preset_fields_form .arm_submit_btn_loader {
        top: 15px
    }

    .arm_main_wrapper_seperator {
        position: relative;
        top: 10px
    }

    .arm_bulk_coupon_field_opts {
        width: 100px !important;
        min-width: 100px !important
    }

    .arm_color_red {
        color: red !important
    }

    .arm_recstricted_page_post_redirection_input {
        vertical-align: top !important;
        padding-top: 15px !important
    }

    .arm_social_info_text {
        margin: 10px 0 0;
        display: block
    }

    .arm_position_relative {
        position: relative
    }

    .arm_position_absolute {
        position: absolute
    }

    .arm_temp_switch_style {
        width: auto;
        margin: 5px 0
    }

    .arm_card_template_opt_style {
        width: auto;
        float: left;
        margin: 5px 0
    }

    :root {
        --arm-pt-theme-blue: #005AEE;
        --arm-pt-theme-blue-darker: #0D54C9;
        --arm-pt-pink: #F547AF;
        --arm-sc-warning: #F2D229;
        --arm-sc-warning-dark: #e0c01c;
        --arm-sc-warning-alpha-08: rgba(242, 210, 41, 0.08);
        --arm-sc-warning-alpha-12: rgba(242, 210, 41, 0.12);
        --arm-sc-success: #0EC9AE;
        --arm-sc-success-alpha-08: rgba(14, 201, 174, 0.08);
        --arm-sc-error: #FF3B3B;
        --arm-sc-error-darker: #d82a2a;
        --arm-sc-error-alpha-08: rgba(255, 59, 59, 0.08);
        --arm-dt-black-500: #1A2538;
        --arm-dt-black-400: #2C2D42;
        --arm-dt-black-300: #2F405C;
        --arm-dt-black-200: #3E4857;
        --arm-dt-black-100: #555F70;
        --arm-gt-gray-500: #6C6F95;
        --arm-gt-gray-400: #637799;
        --arm-gt-gray-300: #8D8EAF;
        --arm-gt-gray-200: #C6C9DF;
        --arm-gt-gray-100: #CED4DE;
        --arm-gt-gray-50: #DCE6F5;
        --arm-gt-gray-50-a: #DFE4EB;
        --arm-gt-gray-10: #F7FAFF;
        --arm-gt-gray-10-a: #F6F9FF;
        --arm-cl-white: #ffffff;
        --arm-radius-12px: 12px;
        --arm-radius-8px: 8px;
        --arm-radius-6px: 6px;
        --arm-radius-4px: 4px;
        --arm-radius-circle: 50%;
        --arm-primary-font: 'Poppins', sans-serif;
        --arm-pt-orange: #F5B11D;
        --arm-pt-orange-darker: #DB9B12
    }

    @font-face {
        font-family: Poppins;
        src: url('../fonts/poppins/Poppins-Regular.woff2') format('woff2'), url('../fonts/poppins/Poppins-Regular.woff') format('woff');
        font-weight: 400;
        font-style: normal;
        font-display: swap
    }

    @font-face {
        font-family: Poppins;
        src: url('../fonts/poppins/Poppins-Medium.woff2') format('woff2'), url('../fonts/poppins/Poppins-Medium.woff') format('woff');
        font-weight: 500;
        font-style: normal;
        font-display: swap
    }

    @font-face {
        font-family: Poppins;
        src: url('../fonts/poppins/Poppins-SemiBold.woff2') format('woff2'), url('../fonts/poppins/Poppins-SemiBold.woff') format('woff');
        font-weight: 600;
        font-style: normal;
        font-display: swap
    }

    @font-face {
        font-family: Poppins;
        src: url('../fonts/poppins/Poppins-Bold.woff2') format('woff2'), url('../fonts/poppins/Poppins-Bold.woff') format('woff');
        font-weight: 700;
        font-style: normal;
        font-display: swap
    }

    #wpcontent .notice-error,
    #wpcontent .notice-info,
    #wpcontent .notice-success,
    #wpcontent .notice-warning,
    #wpcontent .notice.is-dismissible:not(.arm_admin_notices_container),
    #wpcontent .update-php,
    #wpcontent div.notice.error,
    #wpcontent div.notice.updated,
    #wpcontent div.updated:not(.updated_notices) {
        display: none
    }

    #wpcontent {
        height: 100%;
        background-color: var(--arm-gt-gray-10);
        padding: 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    #wpbody-content {
        padding-bottom: 0
    }

    .wp-admin select[multiple] {
        padding: 0
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0
    }

    a {
        color: var(--arm-pt-theme-blue);
        text-decoration: none
    }

    a:focus,
    a:hover {
        outline: 0 !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        box-shadow: none !important;
        color: var(--arm-dt-black-300)
    }

    .armclear {
        clear: both
    }

    .armclear:after,
    .armclear:before {
        display: table;
        content: "";
        line-height: 0
    }

    .arm_solid_divider {
        width: 100%;
        border-bottom: 1px solid var(--arm-gt-gray-100);
        display: block;
        margin: 32px 0
    }

    .wrap.arm_page:not(.arm_manage_form_main_wrapper) {
        padding: 40px 40px 105px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        background-color: var(--arm-gt-gray-10);
        margin: 0;
        font-size: 15px;
        line-height: 24px;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        color: var(--arm-dt-black-200);
        font-weight: 400;
        font-style: normal;
        font-variant: normal
    }

    .wrap.arm_page.arm_manage_form_main_wrapper {
        margin: 0
    }

    .arm_badges_settings_content,
    .arm_page .content_wrapper {
        background-color: var(--arm-cl-white);
        border-radius: var(--arm-radius-8px);
        border: 2px solid var(--arm-gt-gray-50);
        position: relative;
        min-height: 700px
    }

    .page_title {
        padding: 24px 40px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        font-size: 24px;
        font-weight: 600;
        color: var(--arm-dt-black-500);
        line-height: 2
    }

    .page_sub_title {
        font-size: 18px;
        font-weight: 500;
        color: var(--arm-dt-black-300);
        margin-bottom: 12px
    }

    .arm_add_new_item_box {
        position: relative;
        float: right
    }

    .wrap label {
        display: inline-block;
        margin-bottom: 0;
        color: var(--arm-dt-black-200);
        font-size: 15px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .wrap .greensavebtn {
        -webkit-box-sizing: border-box !important;
        -moz-box-sizing: border-box !important;
        -o-box-sizing: border-box !important;
        box-sizing: border-box !important;
        -webkit-border-radius: var(--arm-radius-8px) !important;
        -moz-border-radius: var(--arm-radius-8px) !important;
        -o-border-radius: var(--arm-radius-8px) !important;
        border-radius: var(--arm-radius-8px) !important;
        display: inline-block !important;
        font-size: 15px !important;
        background-color: var(--arm-pt-theme-blue) !important;
        padding: 10px 24px !important;
        color: var(--arm-cl-white) !important;
        text-decoration: none !important;
        transition: color .1s ease 0s, background-color .1s ease 0s !important;
        -webkit-transition: color .1s ease 0s, background-color .1s ease 0s !important;
        -moz-transition: color .1s ease 0s, background-color .1s ease 0s !important;
        -ms-transition: color .1s ease 0s, background-color .1s ease 0s !important;
        -o-transition: color .1s ease 0s, background-color .1s ease 0s !important;
        border: none !important
    }

    .armemailaddbtn:focus,
    .armemailaddbtn:hover,
    .wrap .greensavebtn:focus,
    .wrap .greensavebtn:hover,
    input.armemailaddbtn:focus,
    input.armemailaddbtn:hover {
        background-color: var(--arm-pt-theme-blue-darker) !important;
        color: var(--arm-cl-white) !important
    }

    .armemailaddbtn:focus,
    .wrap .greensavebtn:focus,
    input.armemailaddbtn:focus {
        -webkit-box-shadow: 2px 4px 12px rgba(0, 90, 238, .28) !important;
        -moz-box-shadow: 2px 4px 12px rgba(0, 90, 238, .28) !important;
        -o-box-shadow: 2px 4px 12px rgba(0, 90, 238, .28) !important;
        box-shadow: 2px 4px 12px rgba(0, 90, 238, .28) !important
    }

    .wrap .greensavebtn img,
    .wrap .greensavebtn span {
        vertical-align: middle !important;
        display: inline-block !important;
        margin: 0 !important
    }

    .wrap .greensavebtn img {
        margin-right: 8px !important;
        width: 20px;
        height: 20px
    }

    .armemailaddbtn {
        box-sizing: border-box !important;
        -webkit-box-sizing: border-box !important;
        -moz-box-sizing: border-box !important;
        -o-box-sizing: border-box !important;
        border: 1.5px solid transparent !important;
        display: inline-block !important;
        border-radius: var(--arm-radius-6px) !important;
        -webkit-border-radius: var(--arm-radius-6px) !important;
        -moz-border-radius: var(--arm-radius-6px) !important;
        -o-border-radius: var(--arm-radius-6px) !important;
        line-height: 18px !important;
        font-size: 14px !important;
        color: var(--arm-cl-white) !important;
        background-color: var(--arm-pt-theme-blue) !important;
        text-decoration: none !important;
        padding: 10px 28px !important;
        text-align: center !important;
        cursor: pointer !important
    }

    #armember_datatable_1_wrapper .ColVis_Button,
    #armember_datatable_2_wrapper .ColVis_Button,
    #example_1_wrapper .ColVis_Button,
    .wrap #armember_datatable_1_wrapper .ColVis_Button,
    .wrap #armember_datatable_2_wrapper .ColVis_Button,
    .wrap #armember_datatable_wrapper .ColVis_Button,
    .wrap #example_1_wrapper .ColVis_Button,
    .wrap #example_wrapper .ColVis_Button {
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        color: var(--arm-dt-black-100);
        border: 1px solid var(--arm-gt-gray-100);
        border-radius: var(--arm-radius-6px);
        background-color: var(--arm-cl-white);
        background: var(--arm-cl-white);
        padding: 10px 28px;
        line-height: 1;
        position: relative;
        float: left;
        cursor: pointer
    }

    .armcommonbtn {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        display: inline-block;
        border: 1px solid var(--arm-pt-theme-blue);
        border-radius: var(--arm-radius-6px);
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        line-height: normal;
        font-size: 14px;
        color: var(--arm-cl-white);
        background-color: var(--arm-pt-theme-blue);
        text-decoration: none;
        padding: 7px 24px;
        text-align: center;
        cursor: pointer
    }

    .armcommonbtn:focus,
    .armcommonbtn:hover,
    input.armcommonbtn:focus,
    input.armcommonbtn:hover {
        background-color: var(--arm-pt-theme-blue-darker)
    }

    .arm_cancel_btn,
    .arm_dd_generate_shortcode,
    .arm_save_btn,
    .arm_submit_btn {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border-radius: var(--arm-radius-6px) !important;
        -webkit-border-radius: var(--arm-radius-6px) !important;
        -o-border-radius: var(--arm-radius-6px) !important;
        -moz-border-radius: var(--arm-radius-6px) !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        line-height: 18px !important;
        text-decoration: none;
        padding: 10px 24px !important;
        cursor: pointer;
        display: inline-block !important;
        border: 1.5px solid transparent !important;
        margin: 0 !important;
        min-width: unset !important;
        margin-right: 10px !important
    }

    .arm_dd_generate_shortcode {
        padding: 10px 16px !important
    }

    .arm_form_reset_btn,
    .arm_form_reset_btn.arm_cancel_btn {
        min-width: 40px !important;
        width: 42px;
        height: 38px;
        padding: 9px 10px 8px !important
    }

    .arm_form_reset_btn.arm_reset_radio_field {
        margin-left: 7px !important
    }

    .arm_save_btn {
        color: var(--arm-cl-white) !important;
        background-color: var(--arm-pt-theme-blue) !important;
        border-color: var(--arm-pt-theme-blue) !important
    }

    .arm_submit_btn {
        color: var(--arm-cl-white);
        background-color: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue)
    }

    .arm_add_profile_template_reset,
    .arm_cancel_btn,
    .arm_dd_generate_shortcode {
        color: var(--arm-dt-black-100) !important;
        border-color: #dfe4eb !important;
        background-color: var(--arm-cl-white) !important
    }

    .arm_save_btn:not(:disabled):focus,
    .arm_save_btn:not(:disabled):hover,
    .arm_submit_btn:not(:disabled):active,
    .arm_submit_btn:not(:disabled):focus,
    .arm_submit_btn:not(:disabled):hover,
    a.arm_save_btn:not(:disabled):focus,
    a.arm_save_btn:not(:disabled):hover,
    input.arm_save_btn:not(:disabled):focus {
        background-color: var(--arm-pt-theme-blue-darker) !important;
        color: var(--arm-cl-white) !important
    }

    .arm_add_profile_template_reset:not(:disabled):focus,
    .arm_add_profile_template_reset:not(:disabled):hover,
    .arm_cancel_btn:not(:disabled):focus,
    .arm_cancel_btn:not(:disabled):hover,
    a.arm_cancel_btn:not(:disabled):focus,
    a.arm_cancel_btn:not(:disabled):hover {
        background-color: var(--arm-gt-gray-10-a) !important;
        color: var(--arm-dt-black-100) !important
    }

    .arm_page input,
    .arm_page select,
    .arm_page textarea {
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none
    }

    .arm_admin_form input[type=email],
    .arm_admin_form input[type=number],
    .arm_admin_form input[type=password],
    .arm_admin_form input[type=search],
    .arm_admin_form input[type=tel],
    .arm_admin_form input[type=text],
    .arm_admin_form select,
    .arm_admin_form textarea,
    .arm_datatable_searchbox input:not([type=checkbox]),
    .arm_page input[type=email],
    .arm_page input[type=number],
    .arm_page input[type=password],
    .arm_page input[type=search],
    .arm_page input[type=tel],
    .arm_page input[type=text],
    .arm_page input[type=textbox],
    .arm_page input[type=url],
    .arm_page select,
    .arm_page textarea {
        color: var(--arm-dt-black-200);
        border: 1px solid var(--arm-gt-gray-100);
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        border-radius: var(--arm-radius-6px);
        padding: 7px 16px 6px 16px;
        margin: 0;
        outline: 0;
        line-height: normal;
        font-size: 14px;
        height: auto;
        font-family: var(--arm-primary-font)
    }

    .arm_datatable_searchbox input:not([type=checkbox], [type=button]) {
        background: url('../images/search_icon.png') 16px center no-repeat;
        padding: 7px 0 6px 48px;
        background-color: var(--arm-cl-white)
    }

    .arm_admin_form input[type=email],
    .arm_admin_form input[type=number],
    .arm_admin_form input[type=password],
    .arm_admin_form input[type=tel],
    .arm_admin_form input[type=text],
    .arm_admin_form input[type=url],
    .arm_admin_form select,
    .arm_admin_form textarea,
    .arm_page input[type=search] {
        max-width: 96%
    }

    .arm_page input[type=button]:focus,
    .arm_page input[type=checkbox]:focus,
    .arm_page input[type=color]:focus,
    .arm_page input[type=date]:focus,
    .arm_page input[type=datetime-local]:focus,
    .arm_page input[type=datetime]:focus,
    .arm_page input[type=email]:focus,
    .arm_page input[type=month]:focus,
    .arm_page input[type=number]:focus,
    .arm_page input[type=password]:focus,
    .arm_page input[type=radio]:focus,
    .arm_page input[type=search]:focus,
    .arm_page input[type=submit]:focus,
    .arm_page input[type=tel]:focus,
    .arm_page input[type=text]:focus,
    .arm_page input[type=time]:focus,
    .arm_page input[type=url]:focus,
    .arm_page input[type=week]:focus,
    .arm_page select:focus,
    .arm_page textarea:focus,
    .popup_wrapper input[type=text]:focus,
    .popup_wrapper textarea:focus {
        box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -webkit-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -moz-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -o-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        border: 1px var(--arm-gt-gray-200) solid;
        outline: 0 !important
    }

    .arm_datatable_searchbox input:not([type=checkbox])::placeholder {
        color: var(--arm-gt-gray-400) !important
    }

    input[type=checkbox],
    input[type=radio] {
        height: 20px !important;
        max-width: 20px !important;
        min-width: 20px !important;
        border-color: #d9dfeb;
        border-width: 2px;
        background-color: #d9dfeb;
        border-radius: var(--arm-radius-4px);
        -webkit-border-radius: var(--arm-radius-4px);
        -moz-border-radius: var(--arm-radius-4px);
        -o-border-radius: var(--arm-radius-4px);
        padding: 0 !important;
        margin: 0;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        box-shadow: none !important;
        outline: 0 !important;
        transition: none !important;
        -webkit-transition: none !important;
        -moz-transition: none !important;
        -o-transition: none !important
    }

    .form-table input[type=radio] {
        margin-top: 0;
        margin-right: 0
    }

    input[type=checkbox]:focus,
    input[type=radio]:focus {
        border-color: var(--arm-gt-gray-200);
        -webkit-box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important;
        -moz-box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important;
        -o-box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important;
        box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important
    }

    input[type=checkbox]:checked:focus,
    input[type=radio]:checked:focus {
        border-color: #0d45a3;
        -webkit-box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important;
        -moz-box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important;
        -o-box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important;
        box-shadow: 0 4px 12px rgba(136, 150, 200, .4) !important
    }

    input[type=checkbox]:checked,
    input[type=radio]:checked {
        background-color: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue)
    }

    input[type=checkbox]:checked:before {
        content: '\f147' !important;
        margin: 0;
        color: var(--arm-cl-white);
        font: normal 18px/1 dashicons;
        top: calc(50% - 9px);
        position: relative;
        left: calc(50% - 10px);
        width: auto;
        height: auto
    }

    input[type=radio]:checked::before {
        content: '\f111';
        font: normal 12px FontAwesome;
        color: var(--arm-cl-white);
        margin: 0;
        top: calc(50% - 6px);
        position: relative;
        left: calc(50% - 5px);
        width: auto;
        height: auto;
        background-color: transparent
    }

    input[type=checkbox]+.arm_checkbox_label,
    input[type=checkbox]+.arm_temp_form_label,
    input[type=checkbox]+label,
    input[type=checkbox]+span,
    input[type=radio]+.arm_radio_label,
    input[type=radio]+.arm_temp_form_label,
    input[type=radio]+label,
    input[type=radio]+span {
        font-size: 14px;
        font-weight: 400;
        color: var(--arm-dt-black-200);
        margin: 0 16px 0 8px;
        display: inline
    }

    .arm_multiple_selectbox,
    .arm_selectbox {
        cursor: pointer;
        margin: 0 !important;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS" !important;
        text-align: left
    }

    .arm_multiple_selectbox.disabled:before,
    .arm_multiple_selectbox[disabled]:before,
    .arm_selectbox.disabled:before,
    .arm_selectbox[disabled]:before {
        content: "";
        position: absolute;
        top: 0;
        height: 100%;
        width: 100%;
        z-index: 99;
        cursor: not-allowed
    }

    .arm_multiple_selectbox dd,
    .arm_multiple_selectbox dt,
    .arm_multiple_selectbox ul,
    .arm_selectbox dd,
    .arm_selectbox dt,
    .arm_selectbox ul {
        margin: 0;
        padding: 0
    }

    .arm_multiple_selectbox dd,
    .arm_selectbox dd {
        position: relative
    }

    .arm_multiple_selectbox dt,
    .arm_selectbox dt {
        background: 0 0;
        border: 1px solid var(--arm-gt-gray-100) !important;
        -webkit-border-radius: var(--arm-radius-6px) !important;
        -moz-border-radius: var(--arm-radius-6px) !important;
        -o-border-radius: var(--arm-radius-6px) !important;
        border-radius: var(--arm-radius-6px) !important;
        display: block;
        font-size: 14px !important;
        line-height: 36px !important;
        overflow: hidden;
        padding: 0 16px !important;
        height: 36px !important;
        box-sizing: border-box;
        background-color: var(--arm-cl-white);
        min-width: 50px
    }

    .arm_multiple_selectbox dt:focus,
    .arm_selectbox dt:focus {
        box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -webkit-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -moz-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -o-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        border-color: var(--arm-gt-gray-300)
    }

    .arm_multiple_selectbox dt span,
    .arm_selectbox dt span {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        float: left;
        width: 90%;
        height: 100%;
        color: var(--arm-dt-black-200) !important;
        letter-spacing: normal;
        font-size: 14px !important
    }

    .arm_admin_form .arm_selectbox dt input[type=text],
    .arm_multiple_selectbox dt input,
    .arm_page .arm_selectbox dt input[type=text],
    .arm_selectbox dt input {
        padding: 0 !important
    }

    .arm_multiple_selectbox dt i,
    .arm_selectbox dt i {
        position: absolute;
        right: 16px;
        z-index: 98;
        margin: 0;
        font-size: 16px;
        color: var(--arm-gt-gray-300);
        line-height: 36px !important
    }

    .arm_multiple_selectbox dd ul,
    .arm_page .arm_multiple_selectbox dd ul,
    .arm_page .arm_selectbox dd ul,
    .arm_selectbox dd ul {
        background: var(--arm-cl-white) !important;
        border: 1px solid var(--arm-gt-gray-100) !important;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        border-top: none;
        border-radius: 0 0 var(--arm-radius-4px) var(--arm-radius-4px) !important;
        -webkit-border-radius: 0 0 var(--arm-radius-4px) var(--arm-radius-4px) !important;
        -moz-border-radius: 0 0 var(--arm-radius-4px) var(--arm-radius-4px) !important;
        -o-border-radius: 0 0 var(--arm-radius-4px) var(--arm-radius-4px) !important;
        font-size: 14px !important;
        color: var(--arm-dt-black-200) !important;
        overflow-x: hidden;
        overflow-y: auto;
        max-height: 200px;
        width: 100%;
        margin: -3px 0 0 !important;
        position: absolute;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        z-index: 100;
        display: none
    }

    .arm_multiple_selectbox dd ul ol,
    .arm_selectbox dd ul ol {
        font-weight: 500;
        width: 100%;
        color: var(--arm-dt-black-400) !important;
        margin: 0;
        padding: 4px 16px !important;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_multiple_selectbox dd ul li,
    .arm_selectbox dd ul li {
        display: inline-block;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        min-height: 22px;
        height: auto;
        line-height: 20px !important;
        padding: 6px 16px !important;
        width: 100%;
        z-index: 100;
        margin-bottom: 0;
        cursor: pointer;
        position: relative
    }

    .arm_multiple_selectbox dd ul li:hover,
    .arm_multiple_selectbox dd ul li:hover label,
    .arm_selectbox dd ul li:hover {
        background: var(--arm-pt-theme-blue) !important;
        color: var(--arm-cl-white) !important
    }

    .arm_multiple_selectbox dd ul li:hover input[type=checkbox]:checked,
    .arm_selectbox dd ul li:hover input[type=checkbox]:checked {
        background-color: var(--arm-cl-white);
        border-color: var(--arm-cl-white)
    }

    .arm_multiple_selectbox dd ul li:hover input[type=checkbox]:checked::before,
    .arm_selectbox dd ul li:hover input[type=checkbox]:checked::before {
        color: var(--arm-pt-theme-blue)
    }

    .arm_country_tax_field_list dt {
        width: 200px !important;
        max-width: 200px !important
    }

    .arm_tax_country_list_dl dt {
        width: 150px !important;
        max-width: 150px !important
    }

    .arm_tax_country_unit_dl dt,
    .tax_amount_unit_dl dt {
        width: 100px !important;
        max-width: 100px !important
    }

    .arm_add_edit_paid_post_form dt.arm_width_80 {
        width: 125px !important
    }

    .arm_admin_form .arm_multiple_selectbox .arm_autocomplete:focus,
    .arm_admin_form .arm_selectbox .arm_autocomplete:focus,
    .arm_multiple_selectbox arm_autocomplete,
    .arm_multiple_selectbox input.arm_autocomplete,
    .arm_multiple_selectbox input.arm_autocomplete:focus,
    .arm_selectbox .arm_autocomplete,
    .arm_selectbox input.arm_autocomplete,
    .arm_selectbox input.arm_autocomplete:focus {
        width: 100%;
        max-width: 90% !important;
        min-width: auto !important;
        margin-top: 0;
        font-size: 14px !important;
        border: 0 !important;
        background: 0 0 !important;
        outline: 0 !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -o-box-shadow: none !important;
        z-index: 97
    }

    a.arm_form_additional_btn {
        text-decoration: none;
        padding: 10px 28px;
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        border-radius: var(--arm-radius-6px);
        border: 1.5px solid #dfe4eb;
        color: var(--arm-dt-black-100);
        font-size: 14px;
        font-weight: 500;
        display: inline-block
    }

    a.arm_form_additional_btn:focus,
    a.arm_form_additional_btn:hover {
        color: var(--arm-pt-theme-blue)
    }

    a.arm_form_additional_btn i {
        margin-right: 8px;
        background-image: url("../images/plus_additional_icon.png");
        background-repeat: no-repeat;
        background-position: center center;
        width: 20px;
        height: 20px;
        display: inline-block;
        vertical-align: middle;
        padding: 0;
        margin-top: -2px
    }

    a.arm_form_additional_btn.active {
        background-color: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white)
    }

    a.arm_form_additional_btn.active i {
        background-image: url("../images/minus_additional_icon.png")
    }

    .arm_page .chosen-container,
    .chosen-container {
        border: 1px solid var(--arm-gt-gray-100);
        border-radius: var(--arm-radius-6px);
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        max-width: 95%;
        min-width: 95%
    }

    .arm_page .chosen-container:not(#arm_temp_plans_chosen, #arm_membersip_card_plans_chosen),
    .chosen-container:not(#arm_temp_plans_chosen, #arm_membersip_card_plans_chosen, #arm_drip_rule_plans_chosen, #arm_edit_drip_rule_plans_chosen) {
        width: 95% !important
    }

    .arm_page .chosen-container-multi .chosen-choices,
    .chosen-container.chosen-container-multi .chosen-choices {
        padding: 7px 0 6px 16px;
        border-radius: 0;
        background: 0 0;
        border: 0
    }

    .chosen-container.chosen-container-active .chosen-choices {
        box-shadow: none
    }

    .chosen-container.chosen-container-multi .chosen-choices li.search-field input[type=text] {
        min-height: unset;
        height: auto;
        padding: 0;
        font-size: 14px;
        font-family: inherit;
        color: var(--arm-dt-black-200)
    }

    .arm_page .chosen-container-multi .chosen-choices li.search-choice,
    .chosen-container-multi ul.chosen-choices li.search-choice {
        position: relative;
        margin: 0;
        padding: 4px 20px 3px 5px;
        border: 1px solid transparent;
        max-width: 100%;
        background: 0 0;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none;
        color: var(--arm-pt-theme-blue);
        cursor: default;
        font-size: 14px;
        font-weight: 500;
        font-family: var(--arm-primary-font)
    }

    .arm_page .chosen-container .chosen-results li,
    .chosen-container .chosen-results li,
    .chosen-container.chosen-container-multi .chosen-results li {
        line-height: normal
    }

    .chosen-container-multi .chosen-choices li.search-choice .search-choice-close {
        background: url(../images/chosen-sprite.png) -42px 2px no-repeat !important;
        transition: background-position .4s ease
    }

    .chosen-container-multi .chosen-choices li.search-choice .search-choice-close:hover {
        background-position: -42px -9px !important
    }

    .chosen-container-active {
        box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -webkit-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -moz-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        -o-box-shadow: 0 0 0 3px rgba(184, 193, 211, .24);
        border-color: var(--arm-gt-gray-300);
        outline: 0 !important
    }

    .arm_admin_form .chosen-container .chosen-drop {
        left: 0;
        display: none;
        border-color: var(--arm-gt-gray-100)
    }

    .arm_admin_form .chosen-container.chosen-with-drop .chosen-drop {
        left: 0;
        display: block
    }

    .arm_admin_form .chosen-container .chosen-results li {
        padding: 6px 6px 6px 16px;
        color: var(--arm-dt-black-300)
    }

    .arm_admin_form .chosen-container .chosen-results li.result-selected {
        color: var(--arm-gt-gray-300)
    }

    .arm_admin_form .chosen-container .chosen-results li.highlighted {
        background-color: var(--arm-pt-theme-blue);
        background-image: none;
        color: var(--arm-cl-white)
    }

    .arm_communication_message_wrapper_frm .arm_shortcode_row {
        padding: 0
    }

    .arm_communication_message_wrapper_frm .arm_table_label_on_top .chosen-container:not(#arm_temp_plans_chosen, #arm_membersip_card_plans_chosen),
    .arm_communication_message_wrapper_frm td>input {
        width: 510px !important
    }

    .armswitch {
        position: relative !important;
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
        width: auto !important
    }

    .armswitch .armswitch_input {
        display: none !important
    }

    .armswitch .armswitch_label {
        display: block !important;
        overflow: hidden !important;
        cursor: pointer !important;
        min-width: auto !important;
        width: 42px;
        height: 24px !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 14px !important;
        border: none !important;
        border-radius: 40px !important;
        -webkit-border-radius: 40px !important;
        -moz-border-radius: 40px !important;
        -o-border-radius: 40px !important;
        position: relative;
        background-color: var(--arm-gt-gray-100) !important
    }

    .armswitch .armswitch_label:before {
        content: "";
        display: block;
        width: 18px !important;
        height: 18px !important;
        background: var(--arm-cl-white) !important;
        position: absolute !important;
        top: 3px !important;
        left: 3px !important;
        right: auto !important;
        margin: 0 !important;
        bottom: auto !important;
        border-radius: 30px !important;
        -webkit-border-radius: 30px !important;
        -moz-border-radius: 30px !important;
        -o-border-radius: 30px !important
    }

    .armswitch .armswitch_input:checked+.armswitch_label {
        background-color: var(--arm-pt-theme-blue) !important
    }

    .armswitch .armswitch_input:checked+.armswitch_label:before {
        left: auto !important;
        right: 3px !important
    }

    .armswitch label.armswitch_label {
        margin: auto !important
    }

    .arm_page .arm_shortcode_text,
    .arm_shortcode_text,
    span.arm_shortcode_text {
        color: var(--arm-dt-black-200);
        background-color: var(--arm-sc-success-alpha-08);
        border: 1px solid var(--arm-sc-success);
        border-radius: var(--arm-radius-4px);
        -webkit-border-radius: var(--arm-radius-4px);
        -moz-border-radius: var(--arm-radius-4px);
        -o-border-radius: var(--arm-radius-4px);
        padding: 6px 10px;
        font-size: 14px !important;
        text-align: center;
        vertical-align: middle;
        display: inline-block;
        position: relative;
        line-height: normal;
        overflow: hidden
    }

    .arm_click_to_copy_text,
    .arm_copied_text,
    .arm_form_shortcode_box .arm_click_to_copy_text,
    .arm_form_shortcode_box .arm_copied_text {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--arm-sc-success);
        color: var(--arm-cl-white);
        z-index: 9;
        padding: 6px 0;
        cursor: pointer;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_shortcode_box:hover .arm_click_to_copy_text {
        display: block;
        background: var(--arm-sc-success);
        color: var(--arm-cl-white)
    }

    .arm_confirm_box:not(.arm_confirm_box_plan_change),
    .arm_confirm_box_add_user_achievements,
    .arm_confirm_box_custom_currency {
        display: none;
        position: absolute;
        right: 0;
        margin-top: 6px;
        font-size: 16px;
        font-weight: 400;
        z-index: 9992
    }

    .arm_confirm_box.arm_confirm_box_arm_drip_sync {
        right: auto
    }

    .arm_confirm_box.arm_confirm_box_arm_drip_sync .arm_confirm_box_arrow {
        float: left
    }

    .arm_form_content_box .arm_form_action_btns .arm_confirm_box {
        right: 65px
    }

    .arm_form_action_btns.arm_profile_form_action_btns .arm_confirm_box,
    .arm_form_content_box .arm_reg_form_action_btns .arm_confirm_box {
        right: 100px
    }

    .arm_confirm_box_body {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        min-width: 275px;
        max-width: 280px;
        width: auto;
        background: var(--arm-cl-white);
        border-radius: var(--arm-radius-6px);
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        -webkit-box-shadow: 0 0 20px 0 rgba(136, 150, 200, .32);
        -moz-box-shadow: 0 0 20px 0 rgba(136, 150, 200, .32);
        -o-box-shadow: 0 0 20px 0 rgba(136, 150, 200, .32);
        box-shadow: 0 0 20px 0 rgba(136, 150, 200, .32);
        padding: 12px 20px;
        margin-top: 14px;
        border-collapse: separate
    }

    .arm_confirm_box_arrow {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border-bottom: 16px solid var(--arm-cl-white);
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        float: right;
        height: 0;
        margin: -22px 0 0 0;
        width: 0;
        position: relative
    }

    .arm_confirm_box_arrow:after,
    .arm_confirm_box_arrow:before {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        z-index: -1;
        position: absolute;
        content: "";
        background: 0 0;
        top: 6px;
        right: -8px;
        width: 15px;
        height: 15px
    }

    .arm_confirm_box_text {
        font-size: 14px;
        line-height: 22px;
        color: var(--arm-dt-black-400)
    }

    .arm_confirm_box_btn_container,
    .arm_confirm_box_text {
        display: block;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_confirm_box_btn {
        padding: 8px 20px;
        vertical-align: middle;
        color: var(--arm-cl-white);
        text-align: center;
        border: 1.5px solid #dfe4eb;
        font-size: 14px;
        font-weight: 500;
        border-radius: var(--arm-radius-6px);
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        cursor: pointer
    }

    .arm_confirm_box_btn.armok {
        background-color: var(--arm-sc-error);
        border-color: var(--arm-sc-error);
        color: var(--arm-cl-white);
        margin: 0 10px 0 0
    }

    .arm_confirm_box_btn.armok:hover {
        background-color: var(--arm-sc-error-darker)
    }

    .arm_confirm_box_btn.armcancel {
        border-color: #dfe4eb;
        color: var(--arm-dt-black-100);
        background-color: var(--arm-cl-white)
    }

    .arm_confirm_box_btn.armcancel:hover {
        background-color: var(--arm-gt-gray-10-a)
    }

    .arm_datatable_filters {
        border-bottom: 2px solid var(--arm-gt-gray-50);
        display: inline-block;
        width: 100%;
        padding: 0 40px 24px 40px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_datatable_filters .arm_dt_filter_block {
        display: inline-block
    }

    .arm_datatable_filters .arm_datatable_filter_item {
        margin-left: 24px;
        display: inline-block
    }

    .arm_datatable_filters .arm_dt_filter_submit {
        margin-left: 24px
    }

    #arm_report_analytics_form,
    .arm_add_profile_temp_form,
    .arm_feature_settings_wrapper,
    .wrap .dataTables_wrapper {
        margin: 0 40px
    }

    .arm_feature_settings_wrapper .arm_feature_settings_container.arm_margin_top_30 .page_title {
        padding-top: 0;
        padding-left: 0
    }

    .wrap #armember_datatable_1_wrapper>div:first-child,
    .wrap #armember_datatable_2_wrapper>div:first-child,
    .wrap #armember_datatable_wrapper>div:first-child {
        padding: 24px 0;
        display: inline-block;
        width: 100%
    }

    .arm_feature_settings_wrapper .page_title {
        padding-left: 0;
        padding-bottom: 0
    }

    #armember_datatable_1_wrapper .dt-buttons,
    #armember_datatable_2_wrapper .dt-buttons,
    #armember_datatable_wrapper .dt-buttons {
        float: right !important;
        position: relative
    }

    .dataTables_scroll {
        overflow-x: auto;
        overflow-y: hidden
    }

    .wrap .dataTable {
        border: 0;
        overflow: hidden;
        border-collapse: separate
    }

    .wrap table.dataTable thead tr,
    table.dataTable thead tr {
        background-color: var(--arm-gt-gray-10-a)
    }

    #armember_datatable_1_wrapper tr.odd,
    #armember_datatable_2_wrapper tr.odd,
    #example_1_wrapper tr.odd,
    .wrap #armember_datatable_1_wrapper tr.odd,
    .wrap #armember_datatable_2_wrapper tr.odd,
    .wrap #armember_datatable_wrapper tr.odd,
    .wrap #example_1_wrapper tr.odd,
    .wrap #example_wrapper tr.odd {
        background-color: var(--arm-cl-white)
    }

    #armember_datatable_1_wrapper tr.even,
    #armember_datatable_2_wrapper tr.even,
    #example_1_wrapper tr.even,
    .wrap #armember_datatable_1_wrapper tr.even,
    .wrap #armember_datatable_2_wrapper tr.even,
    .wrap #armember_datatable_wrapper tr.even,
    .wrap #example_1_wrapper tr.even,
    .wrap #example_wrapper tr.even {
        background-color: var(--arm-cl-white)
    }

    table.dataTable thead tr th {
        font-weight: 600;
        color: var(--arm-dt-black-200);
        padding: 20px 12px;
        text-align: left;
        border: none;
        font-size: 14px
    }

    table.dataTable thead tr td {
        color: var(--arm-dt-black-500);
        padding: 20px 12px;
        font-size: 14px;
        border: none;
        line-height: 18px
    }

    .wrap table.dataTable thead tr th.sorting,
    .wrap table.dataTable thead tr th.sorting_asc,
    .wrap table.dataTable thead tr th.sorting_desc {
        background-position: right 45%
    }

    #armember_datatable_1_wrapper tr.even td,
    #armember_datatable_1_wrapper tr.odd td,
    #armember_datatable_2_wrapper tr.even td,
    #armember_datatable_2_wrapper tr.odd td,
    #example_1_wrapper tr.even td,
    #example_1_wrapper tr.odd td,
    .wrap #armember_datatable_1_wrapper tr.even td,
    .wrap #armember_datatable_1_wrapper tr.odd td,
    .wrap #armember_datatable_2_wrapper tr.even td,
    .wrap #armember_datatable_2_wrapper tr.odd td,
    .wrap #armember_datatable_wrapper tr.even td,
    .wrap #armember_datatable_wrapper tr.odd td,
    .wrap #example_1_wrapper tr.even td,
    .wrap #example_1_wrapper tr.odd td,
    .wrap #example_wrapper tr.even td,
    .wrap #example_wrapper tr.odd td {
        color: var(--arm-dt-black-400);
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-bottom: 1px solid #e0eafe;
        padding: 20px 12px;
        height: auto
    }

    #armember_datatable_1_wrapper tr.even td,
    #armember_datatable_1_wrapper tr.odd td,
    #armember_datatable_2_wrapper tr.even td,
    #armember_datatable_2_wrapper tr.odd td,
    #example_1_wrapper tr.even td,
    #example_1_wrapper tr.odd td,
    .wrap #armember_datatable_1_wrapper tr.even td,
    .wrap #armember_datatable_1_wrapper tr.odd td,
    .wrap #armember_datatable_2_wrapper tr.even td,
    .wrap #armember_datatable_2_wrapper tr.odd td,
    .wrap #armember_datatable_wrapper tr.even td,
    .wrap #example_1_wrapper tr.even td,
    .wrap #example_1_wrapper tr.odd td,
    .wrap #example_wrapper tr.even td,
    .wrap.arm_manage_members_main_wrapper #armember_datatable_wrapper tr.odd td,
    .wrap.arm_manage_members_main_wrapper #example_wrapper tr.odd td {
        color: var(--arm-dt-black-400);
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-bottom: 1px solid #e0eafe;
        padding: 20px 12px;
        height: auto
    }

    .wrap.arm_manage_members_main_wrapper #armember_datatable_wrapper tr td.arm_child_user_row {
        padding: 4px 12px
    }

    #armember_datatable_1_wrapper tr.even td,
    #armember_datatable_1_wrapper tr.odd td,
    #armember_datatable_2_wrapper tr.even td,
    #armember_datatable_2_wrapper tr.odd td,
    #example_1_wrapper tr.even td,
    #example_1_wrapper tr.odd td,
    .wrap #armember_datatable_1_wrapper tr.even td,
    .wrap #armember_datatable_1_wrapper tr.odd td,
    .wrap #armember_datatable_2_wrapper tr.even td,
    .wrap #armember_datatable_2_wrapper tr.odd td,
    .wrap #armember_datatable_wrapper tr.even td,
    .wrap #example_1_wrapper tr.even td,
    .wrap #example_1_wrapper tr.odd td,
    .wrap #example_wrapper tr.even td,
    .wrap.arm_transactions_main_wrapper #armember_datatable_wrapper tr.odd td,
    .wrap.arm_transactions_main_wrapper #example_wrapper tr.odd td {
        color: var(--arm-dt-black-400);
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-bottom: 1px solid #e0eafe;
        padding: 20px 12px;
        height: auto
    }

    #armember_datatable_1_wrapper tr:not(.arm_child_user_row).armopen td,
    #armember_datatable_1_wrapper tr:not(.arm_child_user_row):hover td,
    #armember_datatable_2_wrapper tr:not(.arm_child_user_row).armopen td,
    #armember_datatable_2_wrapper tr:not(.arm_child_user_row):hover td,
    #example_1_wrapper tr:not(.arm_child_user_row).armopen td,
    #example_1_wrapper tr:not(.arm_child_user_row):hover td,
    .wrap #armember_datatable_1_wrapper tr:not(.arm_child_user_row).armopen td,
    .wrap #armember_datatable_1_wrapper tr:not(.arm_child_user_row):hover td,
    .wrap #armember_datatable_2_wrapper tr:not(.arm_child_user_row).armopen td,
    .wrap #armember_datatable_2_wrapper tr:not(.arm_child_user_row):hover td,
    .wrap #armember_datatable_wrapper tr:not(.arm_child_user_row).armopen td,
    .wrap #armember_datatable_wrapper tr:not(.arm_child_user_row):hover td,
    .wrap #example_1_wrapper tr:not(.arm_child_user_row).armopen td,
    .wrap #example_1_wrapper tr:not(.arm_child_user_row):hover td,
    .wrap #example_wrapper tr:not(.arm_child_user_row).armopen td,
    .wrap #example_wrapper tr:not(.arm_child_user_row):hover td {
        background-color: #f1f4fa !important;
        border-bottom-color: #f1f4fa;
        box-shadow: 20px 1px 20px 0 rgba(230, 237, 250, .4);
        -webkit-box-shadow: 20px 1px 20px 0 rgba(230, 237, 250, .4);
        -moz-box-shadow: 20px 1px 20px 0 rgba(230, 237, 250, .4);
        position: relative
    }

    #armember_datatable_1_wrapper a,
    #armember_datatable_2_wrapper a,
    #example_1_wrapper a,
    .wrap #armember_datatable_1_wrapper a,
    .wrap #armember_datatable_2_wrapper a,
    .wrap #armember_datatable_wrapper a,
    .wrap #example_1_wrapper a,
    .wrap #example_wrapper a {
        text-decoration: none;
        cursor: pointer;
        font-weight: 500;
        color: var(--arm-dt-black-500);
        font-size: 14px;
        text-decoration: underline
    }

    #armember_datatable_1_wrapper a:hover,
    #armember_datatable_2_wrapper a:hover,
    #example_1_wrapper a:hover,
    .wrap #armember_datatable_1_wrapper a:hover,
    .wrap #armember_datatable_2_wrapper a:hover,
    .wrap #armember_datatable_wrapper a:hover,
    .wrap #example_1_wrapper a:hover,
    .wrap #example_wrapper a:hover {
        color: var(--arm-pt-theme-blue)
    }

    .arm_grid_avatar {
        width: 36px;
        height: 36px;
        vertical-align: middle;
        -webkit-border-radius: var(--arm-radius-circle);
        -moz-border-radius: var(--arm-radius-circle);
        -o-border-radius: var(--arm-radius-circle);
        border-radius: var(--arm-radius-circle)
    }

    .dataTables_wrapper .arm_item_status_text,
    .dataTables_wrapper .arm_item_status_text_transaction {
        display: inline-block;
        background-color: var(--arm-sc-success-alpha-08);
        border: 1px solid var(--arm-sc-success);
        border-radius: var(--arm-radius-4px);
        padding: 4px 8px;
        text-align: left;
        line-height: normal
    }

    .dataTables_wrapper .arm_item_status_text span,
    .dataTables_wrapper .arm_item_status_text_transaction span {
        display: inline-block;
        font-size: 13px;
        font-weight: 500;
        color: var(--arm-dt-black-200)
    }

    .dataTables_wrapper .arm_item_status_text_transaction.pending {
        background-color: var(--arm-sc-warning-alpha-08);
        border: 1px solid var(--arm-sc-warning)
    }

    .dataTables_wrapper .arm_item_status_text_transaction.canceled,
    .dataTables_wrapper .arm_item_status_text_transaction.expired,
    .dataTables_wrapper .arm_item_status_text_transaction.failed {
        background-color: var(--arm-sc-error-alpha-08);
        border: 1px solid var(--arm-sc-error)
    }

    .dataTables_wrapper .arm_item_status_text.inactive {
        color: var(--arm-dt-black-200)
    }

    .dataTables_wrapper .arm_item_status_text.inactive.banned,
    .dataTables_wrapper .arm_item_status_text.inactive.cancelled,
    .dataTables_wrapper .arm_item_status_text.inactive.expired,
    .dataTables_wrapper .arm_item_status_text.inactive.failed {
        background-color: var(--arm-sc-error-alpha-08);
        border: 1px solid var(--arm-sc-error)
    }

    .dataTables_wrapper .arm_item_status_text.pending {
        background-color: var(--arm-sc-warning-alpha-08);
        border: 1px solid var(--arm-sc-warning)
    }

    #armember_datatable_1_wrapper tr td.armGridActionTD,
    #armember_datatable_1_wrapper tr th.armGridActionTD,
    #armember_datatable_1_wrapper tr:hover td.armGridActionTD,
    #armember_datatable_2_wrapper tr td.armGridActionTD,
    #armember_datatable_2_wrapper tr th.armGridActionTD,
    #armember_datatable_2_wrapper tr:hover td.armGridActionTD,
    #example_1_wrapper tr td.armGridActionTD,
    #example_1_wrapper tr th.armGridActionTD,
    #example_1_wrapper tr:hover td.armGridActionTD,
    .wrap #armember_datatable_1_wrapper tr td.armGridActionTD,
    .wrap #armember_datatable_1_wrapper tr th.armGridActionTD,
    .wrap #armember_datatable_1_wrapper tr:hover td.armGridActionTD,
    .wrap #armember_datatable_2_wrapper tr td.armGridActionTD,
    .wrap #armember_datatable_2_wrapper tr th.armGridActionTD,
    .wrap #armember_datatable_2_wrapper tr:hover td.armGridActionTD,
    .wrap #armember_datatable_wrapper tr td.armGridActionTD,
    .wrap #armember_datatable_wrapper tr th.armGridActionTD,
    .wrap #armember_datatable_wrapper tr:hover td.armGridActionTD,
    .wrap #example_1_wrapper tr td.armGridActionTD,
    .wrap #example_1_wrapper tr th.armGridActionTD,
    .wrap #example_1_wrapper tr:hover td.armGridActionTD,
    .wrap #example_wrapper tr td.armGridActionTD,
    .wrap #example_wrapper tr th.armGridActionTD,
    .wrap #example_wrapper tr:hover td.armGridActionTD {
        visibility: hidden;
        position: absolute !important;
        right: 0;
        background: 0 0 !important;
        border: 0 !important;
        height: auto !important;
        box-shadow: none !important;
        vertical-align: middle;
        padding: 4px 0 !important
    }

    #armember_datatable_1_wrapper td.armGridActionTD.armopen,
    #armember_datatable_1_wrapper tr:hover td.armGridActionTD,
    #armember_datatable_2_wrapper td.armGridActionTD.armopen,
    #armember_datatable_2_wrapper tr:hover td.armGridActionTD,
    #example_1_wrapper td.armGridActionTD.armopen,
    #example_1_wrapper tr:hover td.armGridActionTD,
    .wrap #armember_datatable_1_wrapper td.armGridActionTD.armopen,
    .wrap #armember_datatable_1_wrapper tr:hover td.armGridActionTD,
    .wrap #armember_datatable_2_wrapper td.armGridActionTD.armopen,
    .wrap #armember_datatable_2_wrapper tr:hover td.armGridActionTD,
    .wrap #armember_datatable_wrapper td.armGridActionTD.armopen,
    .wrap #armember_datatable_wrapper tr:hover td.armGridActionTD,
    .wrap #example_1_wrapper td.armGridActionTD.armopen,
    .wrap #example_1_wrapper tr:hover td.armGridActionTD,
    .wrap #example_wrapper td.armGridActionTD.armopen,
    .wrap #example_wrapper tr:hover td.armGridActionTD {
        visibility: visible
    }

    .arm_grid_action_wrapper {
        display: inline-block;
        width: 100%
    }

    .arm_grid_action_btn_container {
        display: block;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        float: right;
        width: auto;
        min-height: unset;
        height: auto;
        padding: 8px 14px;
        background-color: var(--arm-pt-theme-blue);
        -webkit-border-radius: var(--arm-radius-12px) 0 0 var(--arm-radius-12px);
        -moz-border-radius: var(--arm-radius-12px) 0 0 var(--arm-radius-12px);
        -o-border-radius: var(--arm-radius-12px) 0 0 var(--arm-radius-12px);
        border-radius: var(--arm-radius-12px) 0 0 var(--arm-radius-12px)
    }

    .arm_grid_action_btn_container a {
        display: inline-block;
        width: 34px;
        height: 34px;
        vertical-align: middle;
        text-align: center;
        margin: 0 0 0 4px
    }

    .arm_grid_action_btn_container a:first-child {
        margin: 0 0 0 4px
    }

    .arm_grid_action_btn_container a img {
        vertical-align: middle;
        width: 100%
    }

    #example_1_wrapper .ui-widget-header,
    #example_1_wrapper div.footer,
    .dataTables_wrapper>div.footer,
    .wrap #armember_datatable_1_wrapper .ui-widget-header,
    .wrap #armember_datatable_1_wrapper div.footer,
    .wrap #armember_datatable_2_wrapper .ui-widget-header,
    .wrap #armember_datatable_2_wrapper div.footer,
    .wrap #example_1_wrapper .ui-widget-header,
    .wrap #example_1_wrapper div.footer,
    .wrap #example_wrapper .ui-widget-header,
    .wrap #example_wrapper div.footer {
        background: var(--arm-cl-white);
        padding: 16px 0;
        border: none;
        float: left;
        width: 100%;
        line-height: 2
    }

    table.dataTable.no-footer {
        border-bottom: none !important
    }

    .dataTables_wrapper>div.footer {
        border-radius: 0 0 var(--arm-radius-8px) var(--arm-radius-8px)
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 0 !important;
        color: var(--arm-dt-black-300) !important
    }

    .dataTables_paginate span,
    .wrap .dataTables_paginate span {
        font-size: 15px;
        text-decoration: none;
        border: 1px solid var(--arm-gt-gray-100);
        background-color: var(--arm-cl-white);
        text-align: center;
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        border-radius: var(--arm-radius-6px);
        width: 22px;
        height: 22px;
        line-height: 1.5;
        padding: 4px;
        margin: 0 12px 0 0;
        display: inline-block;
        cursor: pointer;
        vertical-align: middle
    }

    .dataTables_paginate span:last-child,
    .wrap .dataTables_paginate span:last-child {
        margin-right: 0
    }

    .dataTables_paginate .dataTables_length select {
        margin: 0 8px
    }

    .dataTables_paginate .paginate_page,
    .wrap .dataTables_paginate .paginate_page {
        background: 0 0 !important;
        border: 0 !important;
        width: auto
    }

    .dataTables_paginate .nof,
    .wrap .dataTables_paginate .nof {
        background: 0 0 !important;
        border: 0 !important;
        width: auto;
        text-align: center;
        display: inline-block;
        vertical-align: middle;
        line-height: 24px
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: var(--arm-dt-black-300);
        font-size: 15px
    }

    .dataTables_paginate .nof:hover,
    .dataTables_paginate span:hover,
    .wrap .dataTables_paginate .nof:hover,
    .wrap .dataTables_paginate span:hover {
        border-color: var(--arm-pt-theme-blue);
        background-color: var(--arm-pt-theme-blue)
    }

    .dataTables_paginate .paginate_disabled_last:hover,
    .dataTables_paginate .paginate_enabled_last:hover,
    .wrap .dataTables_paginate .paginate_disabled_last:hover,
    .wrap .dataTables_paginate .paginate_enabled_last:hover {
        background-image: url("../images/last_normal-icon_hover.png") !important
    }

    .dataTables_paginate .paginate_disabled_next:hover,
    .dataTables_paginate .paginate_enabled_next:hover,
    .wrap .dataTables_paginate .paginate_disabled_next:hover,
    .wrap .dataTables_paginate .paginate_enabled_next:hover {
        background-image: url("../images/next_normal-icon_hover.png") !important
    }

    .dataTables_paginate .paginate_disabled_first:hover,
    .dataTables_paginate .paginate_enabled_first:hover,
    .wrap .dataTables_paginate .paginate_disabled_first:hover,
    .wrap .dataTables_paginate .paginate_enabled_first:hover {
        background-image: url("../images/first_normal-icon_hover.png") !important
    }

    .dataTables_paginate .paginate_disabled_previous:hover,
    .dataTables_paginate .paginate_enabled_previous:hover,
    .wrap .dataTables_paginate .paginate_disabled_previous:hover,
    .wrap .dataTables_paginate .paginate_enabled_previous:hover {
        background-image: url("../images/previous_normal-icon_hover.png") !important
    }

    .dataTables_paginate input,
    .wrap .dataTables_paginate input {
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        width: 40px;
        min-width: 35px !important;
        min-height: 30px;
        padding: 5px;
        margin: 0 12px 0 0;
        text-align: center;
        font-weight: 700;
        display: inline-block;
        vertical-align: middle;
        outline: 0;
        box-shadow: none
    }

    #armember_datatable_1_wrapper #armember_datatable_1_length select,
    #armember_datatable_2_wrapper #armember_datatable_2_length select,
    #example_1_wrapper #example_1_length select,
    .wrap #armember_datatable_1_wrapper #armember_datatable_1_length select,
    .wrap #armember_datatable_2_wrapper #armember_datatable_2_length select,
    .wrap #armember_datatable_wrapper #armember_datatable_length select,
    .wrap #example_1_wrapper #example_1_length select,
    .wrap #example_wrapper #example_length select {
        border-radius: var(--arm-radius-6px);
        -webkit-border-radius: var(--arm-radius-6px);
        -moz-border-radius: var(--arm-radius-6px);
        -o-border-radius: var(--arm-radius-6px);
        border: 1px solid var(--arm-gt-gray-100);
        height: auto;
        cursor: pointer;
        outline: 0;
        box-shadow: none;
        min-width: 58px;
        min-height: unset;
        max-height: unset;
        margin: 0 8px;
        padding: 5px 0 5px 8px
    }

    .dataTables_wrapper div.dt-button-background {
        opacity: 0
    }

    div.ColVis_collection,
    div.ColVis_collection button.ColVis_Button {
        font-family: var(--arm-primary-font), sans-serif, "Trebuchet MS";
        min-width: 170px
    }

    .dataTables_wrapper div.dt-button-collection {
        left: 0 !important;
        width: auto;
        background-color: var(--arm-cl-white);
        border: 1.5px solid #dcdff5
    }

    #armember_datatable_1_wrapper div.dt-button-collection,
    #armember_datatable_2_wrapper div.dt-button-collection,
    #armember_datatable_wrapper div.dt-button-collection {
        left: 0 !important;
        width: auto;
        max-width: 100%;
        max-height: 360px;
        overflow-y: scroll;
        -webkit-border-radius: var(--arm-radius-8px);
        -moz-border-radius: var(--arm-radius-8px);
        -o-border-radius: var(--arm-radius-8px);
        border-radius: var(--arm-radius-8px);
        padding: 12px 16px;
        margin-top: 20px;
        box-shadow: none !important
    }

    div.ColVis_collection button.ColVis_Button {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis
    }

    #armember_datatable_1_wrapper div.dt-button-collection button.ColVis_Button,
    #armember_datatable_2_wrapper div.dt-button-collection button.ColVis_Button,
    #armember_datatable_wrapper div.dt-button-collection button.ColVis_Button {
        background-color: transparent;
        background: 0 0;
        width: 100%;
        float: none;
        padding: 8px 0;
        border: none;
        margin: 0;
        font-weight: 400;
        color: var(--arm-gt-gray-500);
        height: auto;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -o-box-shadow: none
    }

    .ColVis_Button .colvis_checkbox {
        position: relative;
        display: inline-block;
        width: 16px;
        height: 16px;
        background-color: #d9dfeb;
        border: none;
        vertical-align: middle;
        -webkit-border-radius: var(--arm-radius-4px);
        -moz-border-radius: var(--arm-radius-4px);
        -o-border-radius: var(--arm-radius-4px);
        border-radius: var(--arm-radius-4px)
    }

    .ColVis_Button.active .colvis_checkbox {
        background-color: var(--arm-pt-theme-blue)
    }

    .ColVis_Button.active .colvis_checkbox::before {
        font: normal 16px/1 dashicons;
        color: var(--arm-cl-white);
        content: '\f147';
        margin: 0;
        position: absolute;
        top: 50%;
        left: 46%;
        transform: translate(-50%, -50%)
    }

    button.ColVis_Button span.ColVis_radio {
        margin-right: 8px
    }

    .arm_form_list_container {
        border: 1.5px solid var(--arm-gt-gray-50);
        background-color: var(--arm-cl-white);
        border-radius: var(--arm-radius-8px);
        -webkit-border-radius: var(--arm-radius-8px);
        -moz-border-radius: var(--arm-radius-8px);
        -o-border-radius: var(--arm-radius-8px);
        padding: 0;
        margin: 0 40px
    }

    .arm_form_list_container table {
        padding: 0;
        margin: 0;
        width: 100%
    }

    .arm_form_list_container table tr td {
        border-bottom: 1px solid #e0eafe;
        font-size: 14px;
        font-weight: 500;
        color: var(--arm-dt-black-400);
        padding: 20px 12px
    }

    .arm_form_list_container table tr td:first-child,
    .arm_form_list_container table tr td:last-child {
        padding: 0 !important;
        max-width: 30px;
        min-width: 30px;
        width: 30px
    }

    .arm_form_list_container table tr:first-child td:first-child {
        border-top-left-radius: var(--arm-radius-8px);
        -webkit-border-top-left-radius: var(--arm-radius-8px);
        -moz-border-top-left-radius: var(--arm-radius-8px);
        -o-border-top-left-radius: var(--arm-radius-8px)
    }

    .arm_form_list_container table tr:first-child td:last-child {
        border-top-right-radius: var(--arm-radius-8px);
        -webkit-border-top-right-radius: var(--arm-radius-8px);
        -moz-border-top-right-radius: var(--arm-radius-8px);
        -o-border-top-right-radius: var(--arm-radius-8px)
    }

    .arm_form_list_container table tr:last-child td:first-child {
        border-bottom-left-radius: var(--arm-radius-8px);
        -webkit-border-bottom-left-radius: var(--arm-radius-8px);
        -moz-border-bottom-left-radius: var(--arm-radius-8px);
        -o-border-bottom-left-radius: var(--arm-radius-8px)
    }

    .arm_form_list_container table tr:last-child td:last-child {
        border-bottom-right-radius: var(--arm-radius-8px);
        -webkit-border-bottom-right-radius: var(--arm-radius-8px);
        -moz-border-bottom-right-radius: var(--arm-radius-8px);
        -o-border-bottom-right-radius: var(--arm-radius-8px)
    }

    .arm_form_list_container table tr:last-child td {
        border: 0
    }

    .arm_form_list_container table tr:hover td {
        background: #f1f4fa
    }

    .arm_form_list_container table tr.arm_form_list_header td {
        font-weight: 700;
        color: var(--arm-dt-black-400);
        background: var(--arm-gt-gray-10-a)
    }

    .arm_form_content_box .arm_form_date_col {
        max-width: 150px;
        width: 16%
    }

    .arm_form_content_box .arm_form_title_col .arm_form_date_col {
        display: inline-block;
        width: 100%;
        max-width: 100%;
        margin-top: 5px
    }

    .arm_form_content_box .arm_form_action_col {
        max-width: 100px;
        width: 100px;
        min-width: 60px
    }

    .arm_form_content_box .arm_form_title_col {
        min-width: 160px;
        width: 15%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_content_box .arm_form_id_col {
        min-width: 100px;
        width: 9%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box
    }

    .arm_form_content_box .arm_form_title_col.setup_name {
        width: 200px
    }

    .arm_member_detail_box .arm_item_status_text {
        color: var(--arm-sc-success)
    }

    .arm_member_detail_box .arm_item_status_text.pending {
        color: var(--arm-sc-warning)
    }

    .arm_member_detail_box .arm_item_status_text.inactive {
        color: var(--arm-dt-black-200)
    }

    .arm_member_detail_box .arm_item_status_text.banned,
    .arm_member_detail_box .arm_item_status_text.cancelled,
    .arm_member_detail_box .arm_item_status_text.expired,
    .arm_member_detail_box .arm_item_status_text.failed {
        color: var(--arm-sc-error)
    }

    .arm_admin_form_content {
        padding: 0 40px 0 40px
    }

    .arm_user_plns_box .arm_subscription_start_date_wrapper span {
        margin-bottom: 5px;
        display: inline-block
    }

    .arm_admin_form_content ul#arm_user_plan_ul li,
    .arm_admin_form_content ul#arm_user_plan_ul2 li {
        width: 100%;
        display: inline-block
    }

    .arm_admin_form_content ul#arm_user_plan_ul .arm_user_plns_box .arm_member_form_dropdown.arm_selectbox,
    .arm_admin_form_content ul#arm_user_plan_ul .arm_user_plns_box input[type=text],
    .arm_admin_form_content ul#arm_user_plan_ul2 .arm_user_plns_box .arm_member_form_dropdown.arm_selectbox,
    .arm_admin_form_content ul#arm_user_plan_ul2 .arm_user_plns_box input[type=text] {
        margin-right: 0;
        width: 95%
    }

    .arm_admin_form .form-table {
        margin: 0
    }

    .arm_admin_form .form-table th:not(.arm_user_plan_text_th) {
        color: var(--arm-dt-black-300);
        font-size: 14px;
        font-weight: 500;
        vertical-align: top;
        min-width: 320px;
        width: 320px;
        padding: 15px 12px;
        display: table-cell
    }

    .arm_admin_form .form-table td {
        margin: 0;
        vertical-align: middle;
        display: table-cell;
        padding: 12px 12px
    }

    .arm_add_edit_coupon_wrapper_frm .arm_selectbox,
    .arm_add_edit_member_wrapper .arm_selectbox,
    .arm_add_edit_payment_history_content tr.form-field .arm_selectbox,
    .arm_confirm_box_body .arm_selectbox,
    .arm_membership_setup_content .arm_selectbox,
    .arm_selectbox_full_width,
    .arm_settings_container tr.form-field:not(.arm_enable_country_tax) .arm_selectbox,
    .arm_subscription_plan_content .arm_selectbox {
        width: 95%
    }

    .arm_settings_container tr.form-field:not(.arm_enable_country_tax) .arm_selectbox#arm_currency_decimal {
        width: 100px
    }

    .arm_settings_container tr.form-field:not(.arm_enable_country_tax) span.arm_decimal_currency_text {
        font-weight: 600;
        margin-right: 15px
    }

    .arm_settings_container #arm_redirection_settings tr .arm_selectbox,
    .arm_settings_container #arm_redirection_settings tr input[type=text] {
        width: 80%
    }

    .arm_add_edit_coupon_wrapper_frm .arm_selectbox dt,
    .arm_add_edit_member_wrapper .arm_selectbox dt,
    .arm_confirm_box_body .arm_selectbox dt,
    .arm_membership_setup_content .arm_selectbox dt,
    .arm_selectbox_full_width dt,
    .arm_settings_container tr.form-field:not(.arm_enable_country_tax) .arm_selectbox dt,
    .arm_subscription_plan_content .arm_selectbox dt {
        width: 100%
    }

    .arm-note-message {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        background: url('../images/warning-icon.png') 12px center no-repeat;
        padding: 10px 12px 10px 36px;
        width: 100%
    }

    .arm-note-message p {
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
        color: var(--arm-dt-black-200)
    }

    .arm-note-message span {
        display: inline-block;
        font-weight: 400
    }

    .arm-note-message.--warning {
        background-color: var(--arm-sc-warning-alpha-12)
    }

    .arm_submit_btn_container {
        padding: 24px 0;
        margin: 50px auto 30px;
        text-align: right;
        border-top: 1px solid var(--arm-gt-gray-100)
    }

    .arm_submit_btn_container button:first-child {
        margin-right: 16px
    }

    .arm_submit_btn_container.arm_drip_rule_sync_btn_div {
        padding: 0;
        margin: 20px auto 30px;
        border: none
    }

    .arm_member_view_detail_popup.popup_wrapper {
        width: calc(100% - 80px);
        left: 40px !important;
        margin-top: 60px
    }

    .arm_member_view_detail_popup.popup_wrapper iframe {
        height: calc(100vh - 185px);
        width: 100%
    }

    .wrap.arm_page.arm_view_member_popup {
        background-color: var(--arm-cl-white);
        padding: 32px 40px 40px 40px
    }

    .wrap.arm_page.arm_view_member_popup .content_wrapper {
        border: none;
        border-radius: 0
    }

    .arm_belt_box {
        display: table;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding: 24px 40px;
        background: #f2f5fa;
        -o-border-radius: var(--arm-radius-8px);
        -moz-border-radius: var(--arm-radius-8px);
        -webkit-border-radius: var(--arm-radius-8px);
        border-radius: var(--arm-radius-8px);
        margin-bottom: 44px
    }

    .arm_view_member_left_box {
        float: left;
        width: 60%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        padding-left: 100px
    }

    .arm_admin_form .arm_view_member_left_box .form-table tr td,
    .arm_admin_form .arm_view_member_left_box .form-table tr th {
        padding-bottom: 15px
    }

    .arm_view_member_right_box {
        float: left;
        width: auto;
        min-width: 352px;
        max-width: 352px;
        text-align: center;
        padding: 0 24px 28px 24px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        border: 2px solid #dcdff5;
        -webkit-border-radius: var(--arm-radius-8px);
        -moz-border-radius: var(--arm-radius-8px);
        -o-border-radius: var(--arm-radius-8px);
        border-radius: var(--arm-radius-8px)
    }

    .arm_member_detail_avtar img {
        border-radius: var(--arm-radius-circle);
        -webkit-border-radius: var(--arm-radius-circle);
        -moz-border-radius: var(--arm-radius-circle);
        -o-border-radius: var(--arm-radius-circle);
        border: 22px solid var(--arm-cl-white);
        display: block;
        height: 120px;
        width: 120px;
        margin: -104px auto 0
    }

    .arm_member_detail_badges {
        margin: 0 auto 16px
    }

    .arm_member_detail_badges .arm-user-badge {
        display: inline-block;
        margin-right: 4px
    }

    .arm_view_member_right_box .armemailaddbtn {
        display: block
    }

    .arm_edit_member_link,
    .arm_view_member_right_box .arm_view_membership_card_btn {
        margin-top: 12px !important;
        width: 100%
    }

    .arm_setup_module_box input[type=text] {
        width: 95%
    }

    .arm_membership_setup_content .arm_setup_option_input_font_style {
        margin-right: 10px !important;
        width: 45% !important
    }

    .arm_setup_gateway_options_list .arm_setup_gateway_opt_wrapper label,
    .arm_setup_plan_options_list .arm_setup_plan_opt_wrapper label {
        margin-left: 5px
    }

    .arm_bulk_coupon_form_fields_popup_text .arm_admin_form_content {
        padding: 0 30px
    }

    .arm_add_edit_coupon_wrapper_frm.arm_admin_form .arm_coupon_code_input_field {
        width: 47%;
        margin-right: 10px
    }

    .arm_add_edit_coupon_wrapper_frm.arm_admin_form .arm_coupon_discount_input,
    .arm_add_edit_coupon_wrapper_frm.arm_admin_form .arm_coupon_discount_select {
        width: 47%
    }

    .arm_bulk_coupon_form_fields_popup_div .arm_bulk_coupon_form_fields_popup_text .arm_coupon_discount_input,
    .arm_bulk_coupon_form_fields_popup_div .arm_bulk_coupon_form_fields_popup_text .arm_selectbox.arm_coupon_discount_select {
        width: 230px
    }

    .arm_add_edit_coupon_wrapper_frm .arm_paid_post_items_list_container ul,
    .arm_paid_post_items_list_container .ui-menu {
        max-width: none
    }

    .wrap.arm_manage_coupon_main_wrapper #armember_datatable_wrapper tr.even td,
    .wrap.arm_manage_coupon_main_wrapper #armember_datatable_wrapper tr.odd td {
        padding-left: 13px
    }

    .arm_profile_popup_inner_content_wrapper .arm_profile_form_existing_options label,
    .arm_registration_popup_inner_content_wrapper .arm_form_existing_options label {
        margin: 10px 0
    }

    .arm_edit_field .arm_width_500_manage_plan_detail {
        width: 500px !important
    }

    a.arm_configure_submission_redirection_link {
        padding: 11px 24px !important
    }

    .arm_page .arm_form_settings_style_block.arm_tbl_label_left_input_right input[type=text] {
        padding: 7px 8px 6px 8px
    }

    .arm_settings_container a {
        color: var(--arm-pt-theme-blue)
    }

    .arm_admin_form .arm_bulk_coupon_form_fields_popup_text .arm_selectbox,
    .arm_admin_form .arm_bulk_coupon_form_fields_popup_text input[type=text] {
        max-width: 93% !important
    }

    .arm_dismiss_update_db_notice .armemailaddbtn,
    .arm_dismiss_updated_data_notice .armemailaddbtn {
        background-color: var(--arm-pt-orange) !important
    }

    .arm_dismiss_update_db_notice .armemailaddbtn:hover,
    .arm_dismiss_updated_data_notice .armemailaddbtn:hover {
        background-color: var(--arm-pt-orange-darker) !important
    }

    .arm_buddypress_sync_btn_div {
        margin-top: 20px !important
    }

    .arm_font_size_12 {
        font-size: 12px !important
    }

    .arm_font_size_13 {
        font-size: 13px !important
    }

    .arm_font_size_15 {
        font-size: 15px !important
    }

    .arm_font_size_16 {
        font-size: 16px !important
    }

    .arm_font_size_18 {
        font-size: 18px !important
    }

    .arm_font_size_20 {
        font-size: 20px !important
    }

    .arm_width_auto {
        width: auto !important
    }

    .arm_width_0 {
        width: 0% !important
    }

    .arm_width_30 {
        width: 30px !important
    }

    .arm_width_35 {
        width: 35px !important
    }

    .arm_width_40 {
        width: 40px !important
    }

    .arm_width_45 {
        width: 45px !important
    }

    .arm_width_50 {
        width: 50px !important
    }

    .arm_width_60 {
        width: 60px !important
    }

    .arm_width_70 {
        width: 70px !important
    }

    .arm_width_75 {
        width: 75px !important
    }

    .arm_width_80 {
        width: 80px !important
    }

    .arm_width_83 {
        width: 83px !important
    }

    .arm_width_90 {
        width: 90px
    }

    .arm_width_100 {
        width: 100px !important
    }

    .arm_width_110 {
        width: 110px !important
    }

    .arm_width_120 {
        width: 120px !important
    }

    .arm_width_130 {
        width: 130px !important
    }

    .arm_width_140 {
        width: 140px !important
    }

    .arm_width_150 {
        width: 150px !important
    }

    .arm_width_152 {
        width: 152px !important
    }

    .arm_width_155 {
        width: 155px !important
    }

    .arm_width_157 {
        width: 157px !important
    }

    .arm_width_160 {
        width: 160px !important
    }

    .arm_width_165 {
        width: 165px !important
    }

    .arm_width_170 {
        width: 170px !important
    }

    .arm_width_180 {
        width: 180px !important
    }

    .arm_width_190 {
        width: 190px !important
    }

    .arm_selectbox .arm_width_200,
    .arm_width_200 {
        width: 200px !important
    }

    .arm_width_210 {
        width: 210px !important
    }

    .arm_width_220 {
        width: 220px !important
    }

    .arm_width_230 {
        width: 230px !important
    }

    .arm_width_232 {
        width: 232px !important
    }

    .arm_width_235 {
        width: 235px !important
    }

    .arm_width_250 {
        width: 250px !important
    }

    .arm_width_280 {
        width: 280px !important
    }

    .arm_width_290 {
        width: 290px !important
    }

    .arm_width_300 {
        width: 300px !important
    }

    .arm_width_320 {
        width: 320px !important
    }

    .arm_width_352 {
        width: 352px !important
    }

    .arm_width_362 {
        width: 362px !important
    }

    .arm_width_370 {
        width: 370px !important
    }

    .arm_width_390 {
        width: 390px !important
    }

    .arm_width_400 {
        width: 400px !important
    }

    .arm_width_422 {
        width: 422px !important
    }

    .arm_width_450 {
        width: 450px !important
    }

    .arm_width_480 {
        width: 480px !important
    }

    .arm_width_500 {
        width: 500px !important
    }

    .arm_width_510 {
        width: 510px !important
    }

    .arm_width_512 {
        width: 512px !important
    }

    .arm_width_573 {
        width: 573px !important
    }

    .arm_width_960 {
        width: 960px !important
    }

    .arm_width_1125 {
        width: 1125px !important
    }

    .arm_width_70_pct {
        width: 70% !important
    }

    .arm_width_90_pct {
        width: 90% !important
    }

    .arm_width_92_pct {
        width: 92% !important
    }

    .arm_width_95_pct {
        width: 95% !important
    }

    .arm_width_100_pct {
        width: 100% !important
    }

    .arm_min_width_30 {
        min-width: 30px !important
    }

    .arm_min_width_35 {
        min-width: 35px !important
    }

    .arm_min_width_45 {
        min-width: 45px !important
    }

    .arm_min_width_40 {
        min-width: 40px !important
    }

    .arm_min_width_50 {
        min-width: 50px !important
    }

    .arm_min_width_60 {
        min-width: 60px !important
    }

    .arm_min_width_70 {
        min-width: 70px !important
    }

    .arm_min_width_75 {
        min-width: 75px !important
    }

    .arm_min_width_80 {
        min-width: 80px !important
    }

    .arm_min_width_100 {
        min-width: 100px !important
    }

    .arm_min_width_120 {
        min-width: 120px !important
    }

    .arm_min_width_140 {
        min-width: 140px !important
    }

    .arm_min_width_150 {
        min-width: 150px !important
    }

    .arm_min_width_200 {
        min-width: 200px !important
    }

    .arm_min_width_232 {
        min-width: 232px !important
    }

    .arm_min_width_250 {
        min-width: 250px !important
    }

    .arm_min_width_397 {
        min-width: 397px !important
    }

    .arm_min_width_500 {
        min-width: 500px !important
    }

    .arm_min_width_550 {
        min-width: 550px !important
    }

    .arm_min_width_802 {
        min-width: 802px !important
    }

    .arm_min_width_auto {
        min-width: auto !important
    }

    .arm_max_width_40 {
        max-width: 40px !important
    }

    .arm_max_width_60 {
        max-width: 60px !important
    }

    .arm_max_width_100 {
        max-width: 100px !important
    }

    .arm_max_width_140 {
        max-width: 140px !important
    }

    .arm_max_width_500 {
        max-width: 500px !important
    }

    .arm_max_width_785 {
        max-width: 785px !important
    }

    .arm_max_width_100_pct {
        max-width: 100% !important
    }

    .arm_max_width_80_pct {
        max-width: 80% !important
    }

    .arm_max_width_85_pct {
        max-width: 85% !important
    }

    .arm_max_width_90_pct {
        max-width: 90% !important
    }

    .arm_max_width_93_pct {
        max-width: 93% !important
    }

    .arm_min_width_100_pct {
        min-width: 100% !important
    }

    .arm_min_height_500 {
        min-height: 500px !important
    }

    .arm_height_1 {
        height: 1px !important
    }

    .arm_height_665 {
        height: 665px !important
    }

    .arm_max_height_100_pct {
        max-height: 100% !important
    }

    .arm_margin_0 {
        margin: 0 !important
    }

    .arm_margin_left_0 {
        margin-left: 0 !important
    }

    .arm_margin_left_5 {
        margin-left: 5px !important
    }

    .arm_margin_left_10 {
        margin-left: 10px !important
    }

    .arm_margin_left_30 {
        margin-left: 30px !important
    }

    .arm_margin_left_40 {
        margin-left: 40px !important
    }

    .arm_margin_right_0 {
        margin-right: 0 !important
    }

    .arm_margin_right_5,
    .arm_selectbox.arm_margin_right_5 {
        margin-right: 5px !important
    }

    .arm_margin_right_10,
    .arm_selectbox.arm_margin_right_10 {
        margin-right: 10px !important
    }

    .arm_margin_right_20 {
        margin-right: 20px !important
    }

    .arm_margin_right_40 {
        margin-right: 40px !important
    }

    .arm_margin_top_5 {
        margin-top: 5px !important
    }

    .arm_margin_top_10 {
        margin-top: 10px !important
    }

    .arm_margin_top_20 {
        margin-top: 20px !important
    }

    .arm_margin_top_30 {
        margin-top: 30px !important
    }

    .arm_margin_bottom_5 {
        margin-bottom: 5px !important
    }

    .arm_margin_bottom_10 {
        margin-bottom: 10px !important
    }

    .arm_margin_bottom_15 {
        margin-bottom: 15px !important
    }

    .arm_margin_bottom_20 {
        margin-bottom: 20px !important
    }

    .arm_margin_bottom_25 {
        margin-bottom: 25px !important
    }

    .arm_padding_0 {
        padding: 0 !important
    }

    .arm_padding_10 {
        padding: 10px !important
    }

    .arm_padding_15 {
        padding: 15px !important
    }

    .arm_padding_left_0 {
        padding-left: 0 !important
    }

    .arm_padding_left_5 {
        padding-left: 5px !important
    }

    .arm_padding_left_10 {
        padding-left: 10px !important
    }

    .arm_padding_left_17 {
        padding-left: 17px !important
    }

    .arm_padding_left_20 {
        padding-left: 20px !important
    }

    .arm_padding_left_35 {
        padding-left: 35px !important
    }

    .arm_padding_left_45 {
        padding-left: 45px !important
    }

    .arm_padding_top_5 {
        padding-top: 5px !important
    }

    .arm_padding_top_10 {
        padding-top: 10px !important
    }

    .arm_padding_top_14 {
        padding-top: 14px !important
    }

    .arm_padding_top_15 {
        padding-top: 15px !important
    }

    .arm_padding_bottom_15 {
        padding-bottom: 15px !important
    }

    .arm_padding_bottom_35 {
        padding-bottom: 35px !important
    }

    .arm_vertical_align_middle {
        vertical-align: middle !important
    }

    .arm_vertical_align_top {
        vertical-align: top !important
    }

    .arm_text_align_center {
        text-align: center !important
    }

    .arm_text_align_left {
        text-align: left !important
    }

    .arm_float_left {
        float: left !important
    }

    .arm_float_right {
        float: right !important
    }

    .arm_login_link_type_option.arm_login_link_type_option_page {
        margin-top: 5px
    }

    .arm_login_link_type_option.arm_login_link_type_option_page .arm_selectbox {
        width: 250px
    }

    .arm_admin_form #new_wp_admin_path {
        width: 100%;
        margin-bottom: 10px
    }

    .arm_admin_form #new_wp_admin_path~em,
    .arm_admin_form table tr td .arm_warning_text .arm_form_shortcode_box {
        margin-top: 10px
    }

    .arm_hide_datatable {
        visibility: hidden
    }

    .arm_need_help_wrapper {
        position: fixed;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background-color: var(--arm-dt-black-300);
        bottom: 40px;
        right: 40px;
        -webkit-box-shadow: 0 0 12px 2px #cfd6e4;
        -moz-box-shadow: 0 0 12px 2px #cfd6e4;
        -o-box-shadow: 0 0 12px 2px #cfd6e4;
        box-shadow: 0 0 12px 2px #cfd6e4;
        z-index: 9 !important;
        cursor: pointer
    }

    .arm_need_help_icon {
        background-image: url('../images/question-fill.png');
        background-repeat: no-repeat;
        background-position: center;
        width: 24px;
        height: 24px;
        cursor: pointer;
        position: relative;
        top: calc(50% - 12px);
        left: calc(50% - 12px);
        display: block
    }

    .arm_need_help_wrapper:hover {
        background-color: var(--arm-pt-theme-blue)
    }

    .arm_sidebar_drawer_main_wrapper {
        display: none;
        transition: opacity 2s linear
    }

    .arm_sidebar_drawer_main_wrapper {
        display: none;
        position: relative;
        overflow: hidden;
        margin: 0;
        transition: all .4s ease
    }

    .arm_sidebar_drawer_main_wrapper::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9998;
        background-color: transparent;
        opacity: 0;
        visibility: hidden;
        float: inherit
    }

    .arm_sidebar_drawer_main_wrapper.active {
        display: block
    }

    .arm_sidebar_drawer_main_wrapper.active::before {
        opacity: 1;
        visibility: visible;
        background-color: rgba(108, 111, 149, .44)
    }

    .arm_sidebar_drawer_inner_wrapper {
        position: relative;
        left: 0;
        right: 0;
        width: 100%;
        bottom: 0;
        height: 100%
    }

    .arm_sidebar_drawer_content {
        width: 30%;
        top: 30px;
        right: 0;
        bottom: 0;
        height: 100%;
        animation: rtl-drawer-in .3s 1ms;
        background-color: var(--arm-cl-white);
        position: fixed;
        box-sizing: border-box;
        overflow: visible;
        display: flex;
        z-index: 9999;
        transform: translateX(100%);
        -webkit-transform: translateX(100%)
    }

    .arm_sidebar_drawer_body {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        overflow: auto
    }

    .arm_sidebar_drawer_close_container {
        padding: 0;
        position: absolute;
        left: -28px;
        margin: 0;
        top: 40px
    }

    .arm_sidebar_drawer_close_btn {
        width: 28px;
        height: 28px;
        text-align: center;
        border-radius: 4px 0 0 4px;
        background-color: #2c33ae;
        color: var(--arm-cl-white);
        font-weight: 700;
        cursor: pointer;
        background-image: url(../images/help-sidebar-cancel-icon.png);
        background-repeat: no-repeat;
        background-position: center
    }

    .arm_sidebar_content_wrapper {
        flex-direction: column;
        padding: 40px;
        box-sizing: border-box;
        display: flex;
        flex: 1;
        flex-basis: auto
    }

    .arm_sidebar_content_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px
    }

    .arm_sidebar_content_heading {
        font-size: 20px;
        line-height: 28px;
        text-transform: capitalize;
        margin: 0;
        padding: 0;
        color: #202c45
    }

    .arm_sidebar_content_footer {
        float: right
    }

    .arm_single_doc h3 {
        font-size: 16px;
        font-weight: 500;
        color: var(--arm-dt-black-500);
        line-height: 24px;
        margin: 0 0 16px 0;
        padding-left: 10px;
        border-left: 3px solid var(--arm-pt-theme-blue)
    }

    .arm_single_doc ul li {
        font-size: 14px;
        color: var(--arm-dt-black-300)
    }

    .arm_readmore_link {
        color: var(--arm-dt-black-200);
        padding: 8px 16px;
        font-weight: 500;
        font-size: 14px;
        line-height: 16px;
        display: inline-block;
        text-align: center;
        border-radius: var(--arm-radius-4px);
        border: 1px solid #dfe4eb;
        width: 80px;
        margin-top: 12px
    }

    .arm_readmore_link:hover {
        background-color: var(--arm-pt-theme-blue);
        border-color: var(--arm-pt-theme-blue);
        color: var(--arm-cl-white)
    }

    .arm_sidebar_content_body img {
        width: auto;
        max-width: 100%;
        height: auto;
        border: 1px solid var(--arm-gt-gray-50)
    }

    .arm-slide-in {
        animation: arm-slide-in .5s forwards;
        -webkit-animation: arm-slide-in .5s forwards
    }

    .arm-slide-out {
        animation: arm-slide-out .5s forwards;
        -webkit-animation: arm-slide-out .5s forwards
    }

    @keyframes arm-slide-in {
        100% {
            transform: translateX(0)
        }
    }

    @-webkit-keyframes arm-slide-in {
        100% {
            -webkit-transform: translateX(0)
        }
    }

    @keyframes arm-slide-out {
        0% {
            transform: translateX(0)
        }

        100% {
            transform: translateX(100%)
        }
    }

    @-webkit-keyframes arm-slide-out {
        0% {
            -webkit-transform: translateX(0)
        }

        100% {
            -webkit-transform: translateX(100%)
        }
    }

    .arm_form_layout_writer .arm-df__form-field-wrap:not(.arm-df__form-field-wrap_roles) .arm-df__dropdown-control .arm__dc--head .arm__dc--head__title,
    .arm_form_layout_writer_border .arm-df__form-field-wrap:not(.arm-df__form-field-wrap_roles) .arm-df__dropdown-control .arm__dc--head .arm__dc--head__title {
        display: none
    }

    @media(max-width: 1366px) {
        .arm_report_filters_td .sltstandard .arm_filter_div input[type=button] {
            margin-top: 5px
        }

        .arm_member_coupon_report_chart .arm_report_filters_td .sltstandard .arm_filter_div input[type=button],
        .arm_member_pay_per_post_report_chart .arm_report_filters_td .sltstandard .arm_filter_div input[type=button],
        .arm_member_payment_history_chart .arm_report_filters_td .sltstandard .arm_filter_div input[type=button],
        .arm_members_chart .arm_report_filters_td .sltstandard .arm_filter_div input[type=button] {
            margin-top: 0
        }
    }

    @media screen and (max-width: 1356px) {
        .arm_members_grid_container #arm_member_list_form .arm_datatable_searchbox input:not([type=checkbox]) {
            width: 180px
        }

        .arm_transactions_grid_container #transactions_list_form .arm_datatable_searchbox .arm_filter_ptype_label {
            width: 115px
        }

        .arm_transactions_grid_container #transactions_list_form .arm_datatable_searchbox .arm_filter_gateway_label,
        .arm_transactions_grid_container #transactions_list_form .arm_datatable_searchbox .arm_filter_pmode_label,
        .arm_transactions_grid_container #transactions_list_form .arm_datatable_searchbox .arm_filter_pstatus_label {
            width: min-content
        }
    }

    @media screen and (max-width: 1280px) {

        .arm_subscription_types_container .icheckbox_minimal-red,
        .arm_subscription_types_container .iradio_minimal-red {
            margin: 0
        }

        .arm_admin_form input[type=email],
        .arm_admin_form input[type=number],
        .arm_admin_form input[type=password],
        .arm_admin_form input[type=tel],
        .arm_admin_form input[type=text],
        .arm_admin_form input[type=url],
        .arm_admin_form select,
        .arm_admin_form textarea,
        .arm_page .chosen-container,
        .chosen-container {
            width: 420px
        }

        .arm_drip_post_type_opts input[type=text] {
            width: 500px !important
        }

        .arm_admin_form .form-table th:not(.arm_user_plan_text_th) {
            color: #191818;
            text-align: right;
            font-weight: 400;
            vertical-align: top;
            min-width: 100px;
            padding: 15px 10px;
            display: table-cell
        }

        .arm_admin_form .arm_multiple_selectbox dt,
        .arm_admin_form .arm_selectbox dt {
            width: 398px
        }

        .arm_add_edit_coupon_wrapper_frm .arm_selectbox,
        .arm_add_edit_member_wrapper .arm_selectbox,
        .arm_confirm_box_body .arm_selectbox,
        .arm_membership_setup_content .arm_selectbox,
        .arm_selectbox_full_width,
        .arm_settings_container tr.form-field:not(.arm_enable_country_tax) .arm_selectbox,
        .arm_subscription_plan_content .arm_selectbox {
            width: 420px
        }

        .arm_add_achievements_wrapper_frm .arm_subscription_plan_form_dropdown.arm_multiple_selectbox dt,
        .arm_add_achievements_wrapper_frm .arm_subscription_plan_form_dropdown.arm_selectbox dt {
            width: 420px
        }

        .arm_add_edit_member_wrapper .arm_admin_form .arm_multiple_selectbox dt,
        .arm_add_edit_member_wrapper .arm_admin_form .arm_selectbox dt {
            width: 420px
        }

        .arm_add_edit_coupon_wrapper_frm .arm_selectbox {
            width: 425px !important
        }

        .arm_add_edit_coupon_wrapper_frm .arm_selectbox dt {
            width: 390px
        }

        .arm_membership_setup_content .arm_selectbox dt {
            width: 520px
        }

        .arm_bulk_coupon_form_fields_popup_div .arm_add_edit_coupon_wrapper_frm .arm_selectbox dt {
            width: 385px !important
        }

        .arm_bulk_coupon_form_fields_popup_div .arm_add_edit_coupon_wrapper_frm .arm_selectbox {
            width: 415px !important
        }

        .arm_plan_payment_cycle_label {
            float: left;
            width: 200px
        }

        .arm_plan_payment_cycle_billing_cycle {
            float: left;
            margin-left: 10px;
            width: 180px
        }

        .arm_plan_payment_cycle_action_buttons {
            float: left;
            margin-top: 35px;
            width: 87px;
            margin-left: 0
        }

        .arm_plan_payment_cycle_billing_input dt {
            width: 50px !important
        }

        .arm_admin_form .icheckbox_minimal-red+label,
        .arm_admin_form .iradio_minimal-red+label {
            margin-left: 0;
            margin-right: 10px;
            min-width: 70px
        }

        .arm_add_member_plans_div {
            margin-left: 0
        }

        .arm_selectbox.arm_setup_option_input_font_style dt {
            width: 160px !important
        }

        .arm_add_edit_coupon_wrapper_frm.arm_admin_form .arm_coupon_code_input_field {
            width: 285px !important;
            margin-right: 10px
        }

        .arm_add_edit_coupon_wrapper_frm.arm_admin_form .arm_coupon_discount_input,
        .arm_add_edit_coupon_wrapper_frm.arm_admin_form .arm_coupon_discount_select.arm_selectbox dt {
            width: 166px !important
        }

        .arm_add_edit_coupon_wrapper_frm .arm_coupon_discount_select.arm_selectbox {
            width: 200px !important
        }

        .arm_bulk_coupon_form_fields_popup_div .arm_bulk_coupon_form_fields_popup_text .arm_coupon_discount_input,
        .arm_bulk_coupon_form_fields_popup_div .arm_bulk_coupon_form_fields_popup_text .arm_selectbox.arm_coupon_discount_select {
            width: 200px !important
        }

        .arm_add_edit_coupon_wrapper_frm .arm_paid_post_items_list_container ul,
        .arm_paid_post_items_list_container .ui-menu {
            max-width: 419px !important
        }

        .arm_bulk_coupon_form_fields_popup_div .arm_add_edit_coupon_wrapper_frm .arm_paid_post_items_list_container .ui-menu,
        .arm_bulk_coupon_form_fields_popup_div .arm_add_edit_coupon_wrapper_frm .arm_paid_post_items_list_container ul {
            max-width: 419px !important
        }
    }

    @media (max-width: 1100px) {
        .arm_member_view_detail_popup.popup_wrapper {
            width: 95%;
            left: 2.5% !important
        }
    }

    @media(max-width: 767px) {
        .dataTables_length {
            float: none !important;
            text-align: center !important;
            margin-bottom: 1rem !important;
            margin-top: .5em !important
        }
    }
</style>

</body>

</html>