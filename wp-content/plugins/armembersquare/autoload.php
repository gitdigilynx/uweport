<?php
if (is_ssl()) {
    define('ARM_SQUARE_URL', str_replace('http://', 'https://', WP_PLUGIN_URL . '/' . ARM_SQUARE_DIR_NAME));
    define('ARM_SQUARE_HOME_URL', home_url('','https'));
} else {
    define('ARM_SQUARE_URL', WP_PLUGIN_URL . '/' . ARM_SQUARE_DIR_NAME);
    define('ARM_SQUARE_HOME_URL', home_url());
}

define('ARM_SQUARE_DOC_URL', ARM_SQUARE_URL . '/documentation/index.html#content');

global $arm_square_version;
$arm_square_version = '1.6';

global $armnew_square_version;


global $armsquare_api_url, $armsquare_plugin_slug, $wp_version;

class ARM_Square{
    
    function __construct() {
        global $arm_payment_gateways, $arm_transaction;
        $arm_payment_gateways->currency['square'] = $this->arm_square_currency_symbol();

        add_action('init', array(&$this, 'arm_square_db_check'));

        register_activation_hook(__FILE__, array('ARM_Square', 'install'));

        register_activation_hook(__FILE__, array('ARM_Square', 'arm_square_check_network_activation'));

        register_uninstall_hook(__FILE__, array('ARM_Square', 'uninstall'));

        add_filter('arm_get_payment_gateways', array(&$this, 'arm_add_square_payment_gateways'));
        
        add_filter('arm_get_payment_gateways_in_filters', array(&$this, 'arm_add_square_payment_gateways'));
        
        add_action('admin_notices', array(&$this, 'arm_square_admin_notices'));
        
        add_filter('arm_change_payment_gateway_tooltip', array(&$this, 'arm_change_payment_gateway_tooltip_func'), 10, 3);
        
        add_filter('arm_gateway_callback_info', array(&$this, 'arm_gateway_callback_info_func'), 10, 3);
        
        add_filter('arm_filter_gateway_names', array(&$this, 'arm_filter_gateway_names_func'), 10);
        
        add_filter('arm_set_gateway_warning_in_plan_with_recurring', array(&$this, 'arm_square_recurring_trial'), 10);

        add_filter('arm_not_display_payment_mode_setup', array(&$this, 'arm_not_display_payment_mode_setup_func'), 10, 1);
        
        add_filter('arm_allowed_payment_gateways', array(&$this, 'arm_payment_allowed_gateways'), 10, 3);
        
        add_action('arm_payment_related_common_message', array(&$this, 'arm_payment_related_common_message'), 10);

        add_filter('arm_currency_support', array(&$this, 'arm_square_currency_support'), 10, 2);

        add_action('arm_after_payment_gateway_listing_section', array(&$this, 'arm_after_payment_gateway_listing_section_func'), 10, 2);

        add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_script'), 10);
        
        add_action('plugins_loaded', array(&$this, 'arm_square_load_textdomain'));
        
        add_action('admin_init', array(&$this, 'upgrade_data_square'));
        
        add_filter('arm_change_pending_gateway_outside',array(&$this,'arm2_change_pending_gateway_outside'),100,3);
        
        add_filter('arm_default_plan_array_filter', array(&$this, 'arm2_default_plan_array_filter_func'), 10, 1);
        
        add_filter('arm_need_to_cancel_old_subscription_gateways', array(&$this, 'arm2_need_to_cancel_old_subscription_gateways'), 10, 1);
        
        add_action('arm_payment_gateway_validation_from_setup', array(&$this, 'arm2_payment_gateway_form_submit_action'), 10, 4);
        
        add_action('wp', array(&$this, 'arm2_square_webhook'), 5);
        
        add_action('arm_cancel_subscription_gateway_action', array(&$this, 'arm2_square_cancel_subscription'), 10, 2);

        //For disable update card button at front end side.
        add_filter( 'arm_display_update_card_button_from_outside', array( $this, 'arm_display_update_card_button'), 10, 3 );

        add_filter( 'arm_render_update_card_button_from_outside', array( $this, 'arm_render_update_card_button'), 10, 6 );

        add_action('wp_head', array(&$this, 'arm_square_set_front_js'), 10);
    }

    function arm_square_set_front_js() {
        if($this->is_version_compatible()){
            global $ARMember, $arm_square_version;
            $gateway_options = get_option('arm_payment_gateway_settings');
            $pgoptions = maybe_unserialize($gateway_options);
            if(!empty($pgoptions['square']['status']))
            {
                wp_register_script('arm_square_js', ARM_SQUARE_URL . '/js/arm_square.js', array('jquery'), $arm_square_version);
                wp_enqueue_script('arm_square_js');

                $arm_square_load_js_url = (!empty($pgoptions['square']) && $pgoptions['square']['square_payment_mode'] == "sandbox") ? 'https://sandbox.web.squarecdn.com/v1/square.js' : 'https://web.squarecdn.com/v1/square.js';

                wp_register_script( 'arm-payment-square-js', $arm_square_load_js_url, array(), $arm_square_version );
                wp_enqueue_script( 'arm-payment-square-js' );
            }
        }
    }
    
    function arm_display_update_card_button( $display, $pg, $planData ){
        if( 'square' == $pg ){
            $display = true;
        }
        return $display;
    }
    
    
    function arm_render_update_card_button(  $content, $pg, $planData, $user_plan, $arm_disable_button, $update_card_text ){
        if( 'square' == $pg ){
            $content .= '';
        }
        return $content;
    }
    

    function arm2_need_to_cancel_old_subscription_gateways( $payment_gateway_array ) {
        array_push($payment_gateway_array, 'square');
        return $payment_gateway_array;
    }
    
    function arm2_default_plan_array_filter_func( $default_plan_array ) {
        global $ARMember;
        $default_plan_array['arm_square'] = '';
        return $default_plan_array;
    }
    
    function arm_square_load_textdomain() {
        load_plugin_textdomain('ARM_SQUARE', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    public static function arm_square_db_check() {
        global $arm_square;
        $arm_square_version = get_option('arm_square_version');

        if (!isset($arm_square_version) || $arm_square_version == '')
            $arm_square->install();
    }

    function armsquare_getapiurl() {
        $api_url = 'https://www.arpluginshop.com/';
        return $api_url;
    }
        
    function upgrade_data_square() {
        global $armnew_square_version;

        if (!isset($armnew_square_version) || $armnew_square_version == "")
            $armnew_square_version = get_option('arm_square_version');

        if (version_compare($armnew_square_version, '1.6', '<')) {
            $path = ARM_SQUARE_DIR . '/upgrade_latest_data_square.php';
            include($path);
        }
    }
    
    function armsquare_get_remote_post_params($plugin_info = "") {
        global $wpdb;

        $action = "";
        $action = $plugin_info;

        if (!function_exists('get_plugins')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_list = get_plugins();
        $site_url = ARM_SQUARE_HOME_URL;
        $plugins = array();

        $active_plugins = get_option('active_plugins');

        foreach ($plugin_list as $key => $plugin) {
            $is_active = in_array($key, $active_plugins);

            //filter for only armember ones, may get some others if using our naming convention
            if (strpos(strtolower($plugin["Title"]), "square") !== false) {
                $name = substr($key, 0, strpos($key, "/"));
                $plugins[] = array("name" => $name, "version" => $plugin["Version"], "is_active" => $is_active);
            }
        }
        $plugins = json_encode($plugins);

        //get theme info
        $theme = wp_get_theme();
        $theme_name = $theme->get("Name");
        $theme_uri = $theme->get("ThemeURI");
        $theme_version = $theme->get("Version");
        $theme_author = $theme->get("Author");
        $theme_author_uri = $theme->get("AuthorURI");

        $im = is_multisite();
        $sortorder = get_option("armSortOrder");

        $post = array("wp" => get_bloginfo("version"), "php" => phpversion(), "mysql" => $wpdb->db_version(), "plugins" => $plugins, "tn" => $theme_name, "tu" => $theme_uri, "tv" => $theme_version, "ta" => $theme_author, "tau" => $theme_author_uri, "im" => $im, "sortorder" => $sortorder);

        return $post;
    }
            
    public static function install() {
        global $arm_square;
        $arm_square_version = get_option('arm_square_version');

        if (!isset($arm_square_version) || $arm_square_version == '') {
            global $wpdb, $arm_square_version;
            update_option('arm_square_version', $arm_square_version);
        }
    }

    
    /*
     * Restrict Network Activation
     */
    public static function arm_square_check_network_activation($network_wide) {
        if (!$network_wide)
            return;

        deactivate_plugins(plugin_basename(__FILE__), TRUE, TRUE);

        header('Location: ' . network_admin_url('plugins.php?deactivate=true'));
        exit;
    }

    public static function uninstall() {
        delete_option('arm_square_version');
    }

    function arm_square_currency_symbol() {
        global $arm_payment_gateways, $arm_global_settings;
        $gateway_options = get_option('arm_payment_gateway_settings');
        $pgoptions = maybe_unserialize($gateway_options);
        $is_sandbox_mode  = isset($pgoptions['square']['square_payment_mode']) ? $pgoptions['square']['square_payment_mode'] : 'sandbox';
        
        if($is_sandbox_mode == 'sandbox')
        {
            $currency_symbol = array(
                'AUD' => '$',
                'BRL' => 'R$',
                'CAD' => '$',
                'CZK' => '&#75;&#269;',
                'DKK' => '&nbsp;&#107;&#114;',
                'EUR' => '&#128;',
                'HKD' => '&#20803;',
                'HUF' => '&#70;&#116;',
                'ILS' => '&#8362;',
                'JPY' => '&#165;',
                'MYR' => '&#82;&#77;',
                'MXN' => '&#36;',
                'TWD' => '&#36;',
                'NZD' => '&#36;',
                'NOK' => '&nbsp;&#107;&#114;',
                'PHP' => '&#8369;',
                'PLN' => '&#122;&#322;',
                'GBP' => '&#163;',
                'RUB' => '&#1088;&#1091;',
                'SGD' => '&#36;',
                'SEK' => '&nbsp;&#107;&#114;',
                'CHF' => '&#67;&#72;&#70;',
                'THB' => '&#3647;',
                'USD' => '$',
                'TRY' => '&#89;&#84;&#76;',
                'INR' => '&#8377;',
            );
        }
        else
        {
            $currency_symbol = array(
                'AUD' => '$',
                'BRL' => 'R$',
                'CAD' => '$',
                'CZK' => '&#75;&#269;',
                'DKK' => '&nbsp;&#107;&#114;',
                'EUR' => '&#128;',
                'HKD' => '&#20803;',
                'HUF' => '&#70;&#116;',
                'ILS' => '&#8362;',
                'JPY' => '&#165;',
                'MYR' => '&#82;&#77;',
                'MXN' => '&#36;',
                'TWD' => '&#36;',
                'NZD' => '&#36;',
                'NOK' => '&nbsp;&#107;&#114;',
                'PHP' => '&#8369;',
                'PLN' => '&#122;&#322;',
                'GBP' => '&#163;',
                'RUB' => '&#1088;&#1091;',
                'SGD' => '&#36;',
                'SEK' => '&nbsp;&#107;&#114;',
                'CHF' => '&#67;&#72;&#70;',
                'THB' => '&#3647;',
                'USD' => '$',
                'TRY' => '&#89;&#84;&#76;',
                'INR' => '&#8377;',
            );
        }
        return $currency_symbol;
    }

    function arm_add_square_payment_gateways($default_payment_gateways) {
        if ($this->is_version_compatible()) {
            global $arm_payment_gateways;
            $default_payment_gateways['square']['gateway_name'] = __('Square', 'ARM_SQUARE');
            return $default_payment_gateways;
        } else {
            return $default_payment_gateways;
        }
    }

    function arm_square_admin_notices() {
        global $pagenow, $arm_slugs;    
        if($pagenow == 'plugins.php' || (isset($_REQUEST['page']) && in_array($_REQUEST['page'], (array) $arm_slugs))){
            if (!$this->is_armember_support())
                echo "<div class='updated updated_notices'><p>" . __('Square For ARMember plugin requires ARMember Plugin installed and active.', 'ARM_SQUARE') . "</p></div>";

            else if (!$this->is_version_compatible())
                echo "<div class='updated updated_notices'><p>" . __('Square For ARMember plugin requires ARMember plugin installed with version 4.4 or higher.', 'ARM_SQUARE') . "</p></div>";
        }
    }

    function is_armember_support() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        return is_plugin_active('armember/armember.php');
    }

    function get_armember_version() {
        $arm_db_version = get_option('arm_version');

        return (isset($arm_db_version)) ? $arm_db_version : 0;
    }

    function is_version_compatible() {
        if (!version_compare($this->get_armember_version(), '4.4', '>=') || !$this->is_armember_support()) :
            return false;
        else :
            return true;
        endif;
    }

    function arm_change_payment_gateway_tooltip_func($titleTooltip, $gateway_name, $gateway_options) {
        if ($gateway_name == 'square') {
            return __("You can find Application ID and Access Token in your Square account. To get more details, Please refer this", 'ARM_SQUARE')." <a href='https://developer.squareup.com/apps' target='_blank'>".__("document", 'ARM_SQUARE')."</a>.";
        }
        return $titleTooltip;
    }
    
    function arm_gateway_callback_info_func($apiCallbackUrlInfo, $gateway_name, $gateway_options) {
        if ($gateway_name == 'square') {           
            global $arm_global_settings;
            $apiCallbackUrl = $arm_global_settings->add_query_arg("arm-listener", "arm_square_api", get_home_url() . "/");
            $apiCallbackUrlInfo = __('Please make sure you have set following callback URL in your square account.', 'ARM_SQUARE');
            $callbackTooltip = __('To get more information about how to set callback URL in your square account, please refer this', 'ARM_SQUARE').' <a href="'. ARM_SQUARE_DOC_URL .'" target="_blank">'.__('document', 'ARM_SQUARE').'</a>';
            //$apiCallbackUrlInfo = '<a href="'. ARM_SQUARE_DOC_URL .'" target="_blank">'.__('ARMember Square Documentation', 'ARM_SQUARE').'</a>';
            

            $apiCallbackUrlInfo .= '<i class="arm_helptip_icon armfa armfa-question-circle" title="'.htmlentities($callbackTooltip).'"></i>';
            $apiCallbackUrlInfo .= '<br/><b>' . $apiCallbackUrl . '</b>';
        }
        return $apiCallbackUrlInfo;
    }

    function arm_filter_gateway_names_func($pgname) {
        $pgname['square'] = __('Square', 'ARM_SQUARE');
        return $pgname;
    }

    function arm2_change_pending_gateway_outside($user_pending_pgway,$plan_ID,$user_id){
        global $is_free_manual,$ARMember;
        if( $is_free_manual ){
            $key = array_search('square',$user_pending_pgway);
            unset($user_pending_pgway[$key]);
        }
        return $user_pending_pgway;
    }
    
    function admin_enqueue_script(){
        global $arm_square_version, $arm_slugs;

        if(!empty($arm_slugs->general_settings)) {
            $arm_square_page_array = array($arm_slugs->general_settings);
            $arm_square_action_array = array('payment_options');
            
            if( isset($_REQUEST['page']) && isset($_REQUEST['action']) && (in_array($_REQUEST['page'], $arm_square_page_array) && in_array($_REQUEST['action'], $arm_square_action_array)) ||  (isset($_REQUEST['page']) && $_REQUEST['page']==$arm_slugs->membership_setup)) {
                wp_register_script( 'arm-admin-square', ARM_SQUARE_URL . '/js/arm_admin_square.js', array(), $arm_square_version);
                wp_enqueue_script( 'arm-admin-square' );
                wp_register_style('arm-admin-square-css', ARM_SQUARE_URL . '/css/arm_admin_square.css', array(), $arm_square_version);
                wp_enqueue_style('arm-admin-square-css');

            }    
        }
    }
    
    function arm_square_recurring_trial($notice) {
        // if need to display any notice related subscription in Add / Edit plan page
        if ($this->is_version_compatible()){
            $notice .= "<span style='margin-bottom:10px;'><b>". __('Square (if Square payment gateway is enabled)','ARM_SQUARE')."</b><br/>";
            $notice .= "<ol style='margin-left:30px;'>";
            $notice .= "<li>".__('Square Payment Gateway does not support auto debit payment method.','ARM_SQUARE')."</li>";
            $notice .= "</ol>";
            $notice .= "</span>";
        } 
        return $notice;
    }

    function arm_payment_allowed_gateways($allowed_gateways, $plan_obj, $plan_options) {
        
        $allowed_gateways['square'] = "1";
        return $allowed_gateways;
    }

    function arm_payment_related_common_message($common_messages) {
        if ($this->is_version_compatible()) {
            ?>
            <tr class="form-field">
                <th class="arm-form-table-label"><label for="arm_payment_fail_square"><?php _e('Payment Fail (Square)', 'ARM_SQUARE'); ?></th>
                <td class="arm-form-table-content">
                    <input type="text" name="arm_common_message_settings[arm_payment_fail_square]" id="arm_payment_fail_square" value="<?php echo (!empty($common_messages['arm_payment_fail_square']) ) ? $common_messages['arm_payment_fail_square'] : 'Sorry something went wrong while processing payment with Square.'; ?>" />
                </td>
            </tr>
            <?php
        }
    }

    function arm_payment_gateway_has_ccfields_func($pgHasCcFields, $gateway_name, $gateway_options) {
        if ($gateway_name == 'square') {
            return true;
        } else {
            return $pgHasCcFields;
        }
    }

    function arm_square_currency_support($notAllow, $currency) {
        global $arm_payment_gateways;
        $square_currency = $this->arm_square_currency_symbol();
        if (!array_key_exists($currency, $square_currency)) {
            $notAllow[] = 'square';
        }
        return $notAllow;
    }

    function arm_not_display_payment_mode_setup_func($gateway_name_arr) {
        //for remove auto debit payment and manual payment option from front side page and admin site. Its allow only manual payment.
        $gateway_name_arr[] = 'square';
        return $gateway_name_arr;
    }

    function arm_after_payment_gateway_listing_section_func($gateway_name, $gateway_options) {
        // set paymetn geteway setting field in general settgin > payment gateway
        global $arm_global_settings;
        if ($gateway_name == 'square') {
            $gateway_options['square_payment_mode'] = (!empty($gateway_options['square_payment_mode']) ) ? $gateway_options['square_payment_mode'] : 'sandbox';
            $gateway_options['status'] = isset($gateway_options['status']) ? $gateway_options['status'] : 0;
            $disabled_field_attr = ($gateway_options['status'] == '1') ? '' : 'disabled="disabled"';
            $readonly_field_attr = ($gateway_options['status'] == '1') ? '' : 'readonly="readonly"';

            ?>
            <tr class="form-field">
                <th class="arm-form-table-label"><label><?php _e('Payment Mode', 'ARM_SQUARE'); ?> *</label></th>
                <td class="arm-form-table-content">
                    <input id="arm_square_payment_gateway_mode_sand" class="arm_general_input arm_square_mode_radio arm_iradio arm_active_payment_<?php echo strtolower($gateway_name); ?>" type="radio" value="sandbox" name="payment_gateway_settings[square][square_payment_mode]" <?php checked($gateway_options['square_payment_mode'], 'sandbox'); ?> <?php echo $disabled_field_attr; ?>>
                    <label for="arm_square_payment_gateway_mode_sand"><?php _e('Sandbox', 'ARM_SQUARE'); ?></label>
                    <input id="arm_square_payment_gateway_mode_pro" class="arm_general_input arm_square_mode_radio arm_iradio arm_active_payment_<?php echo strtolower($gateway_name); ?>" type="radio" value="production" name="payment_gateway_settings[square][square_payment_mode]" <?php checked($gateway_options['square_payment_mode'], 'production'); ?> <?php echo $disabled_field_attr; ?>>
                    <label for="arm_square_payment_gateway_mode_pro"><?php _e('Production', 'ARM_SQUARE'); ?></label>
                </td>
            </tr>
            <!-- ***** Begining of Sandbox Input for square ***** -->
            <?php
            $square_hidden = "hidden_section";
            if (isset($gateway_options['square_payment_mode']) && $gateway_options['square_payment_mode'] == 'sandbox') {
                $square_hidden = "";
            } else if (!isset($gateway_options['square_payment_mode'])) {
                $square_hidden = "";
            }
            ?>
            <tr class="form-field arm_square_sandbox_fields <?php echo $square_hidden; ?> ">
                <th class="arm-form-table-label"><?php _e('Test Application ID', 'ARM_SQUARE'); ?> *</th>
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_test_application_id" name="payment_gateway_settings[square][square_test_application_id]" value="<?php echo (!empty($gateway_options['square_test_application_id'])) ? $gateway_options['square_test_application_id'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                </td>
            </tr>
            <tr class="form-field arm_square_sandbox_fields <?php echo $square_hidden; ?> ">
                <th class="arm-form-table-label"><?php _e('Test Access Token', 'ARM_SQUARE'); ?> *</th> 
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_test_access_token" name="payment_gateway_settings[square][square_test_access_token]" value="<?php echo (!empty($gateway_options['square_test_access_token'])) ? $gateway_options['square_test_access_token'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                </td>
            </tr>
            <tr class="form-field arm_square_sandbox_fields <?php echo $square_hidden; ?> ">
                <th class="arm-form-table-label"><?php _e('Test Location ID', 'ARM_SQUARE'); ?> *</th> 
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_test_square_location" name="payment_gateway_settings[square][square_test_square_location]" value="<?php echo (!empty($gateway_options['square_test_square_location'])) ? $gateway_options['square_test_square_location'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                </td>
            </tr>
            
            
            <!-- ***** Ending of Sandbox Input for square ***** -->

            <!-- ***** Begining of Live Input for square ***** -->
            <?php
            $square_live_fields = "hidden_section";
            if (isset($gateway_options['square_payment_mode']) && $gateway_options['square_payment_mode'] == "production") {
                $square_live_fields = "";
            }
            ?>
            <tr class="form-field arm_square_fields <?php echo $square_live_fields; ?> ">
                <th class="arm-form-table-label"><?php _e('Live Application ID', 'ARM_SQUARE'); ?> *</th>
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_live_application_id" name="payment_gateway_settings[square][square_live_application_id]" value="<?php echo (!empty($gateway_options['square_live_application_id'])) ? $gateway_options['square_live_application_id'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                </td>
            </tr>
            <tr class="form-field arm_square_fields <?php echo $square_live_fields; ?> ">
                <th class="arm-form-table-label"><?php _e('Live Access Token', 'ARM_SQUARE'); ?> *</th>
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_live_access_token" name="payment_gateway_settings[square][square_live_access_token]" value="<?php echo (!empty($gateway_options['square_live_access_token'])) ? $gateway_options['square_live_access_token'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                </td>
            </tr>
            <tr class="form-field arm_square_fields <?php echo $square_live_fields; ?> ">
                <th class="arm-form-table-label"><?php _e('Live Location ID', 'ARM_SQUARE'); ?> *</th>
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_live_square_location" name="payment_gateway_settings[square][square_live_square_location]" value="<?php echo (!empty($gateway_options['square_live_square_location'])) ? $gateway_options['square_live_square_location'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                </td>
            </tr>
            
            <!-- ***** Ending of Live Input for square ***** -->

            <tr class="form-field">
                <th class="arm-form-table-label"><?php _e('Popup Title', 'ARM_SQUARE'); ?> *</th>
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_payment_button_title" name="payment_gateway_settings[square][square_popup_title]" value="<?php echo (!empty($gateway_options['square_popup_title'])) ? $gateway_options['square_popup_title'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                    <i class="arm_helptip_icon armfa armfa-question-circle" title="{arm_selected_plan_title} : <?php _e("This shortcode will be replaced with the user selected plan name.", 'ARM_SQUARE');?>"></i>
                </td>
            </tr>

            <tr class="form-field">
                <th class="arm-form-table-label"><?php _e('Popup Button Title', 'ARM_SQUARE'); ?> *</th>
                <td class="arm-form-table-content">
                    <input type="text" class="arm_active_payment_<?php echo strtolower($gateway_name); ?>" id="arm_square_payment_button_title" name="payment_gateway_settings[square][square_payment_button_title]" value="<?php echo (!empty($gateway_options['square_payment_button_title'])) ? $gateway_options['square_payment_button_title'] : ''; ?>" <?php echo $readonly_field_attr; ?> />
                </td>
            </tr>


            <?php
        }
    }

    function arm2_payment_gateway_form_submit_action($payment_gateway, $payment_gateway_options, $posted_data, $entry_id = 0){
        global $wpdb, $ARMember, $arm_global_settings, $arm_membership_setup, $arm_subscription_plans, $arm_member_forms, $arm_manage_coupons, $payment_done, $arm_payment_gateways, $arm_transaction, $paid_trial_square_payment_done, $is_free_manual, $arm_debug_payment_log_id;

        $all_payment_gateways = $arm_payment_gateways->arm_get_active_payment_gateways();
        if ($payment_gateway == 'square' && isset($all_payment_gateways['square']) && !empty($all_payment_gateways['square'])) 
        {
            $arm_return_data = array();
            $arm_return_data = apply_filters('arm_calculate_payment_gateway_submit_data', $arm_return_data, $payment_gateway, $payment_gateway_options, $posted_data, $entry_id);

            if(!empty($arm_return_data))
            {
                $currency = $arm_payment_gateways->arm_get_global_currency();
                $entry_data = !empty($arm_return_data) ? $arm_return_data['arm_entry_data'] : '';
                if(!empty($entry_data))
                {
                    $gateway_options = get_option('arm_payment_gateway_settings');
                    $pgoptions = maybe_unserialize($gateway_options);
                    $recurring_payment_mode = !empty($arm_return_data['arm_payment_mode']) ? $arm_return_data['arm_payment_mode'] : 'manual_subscription';
                    $form_id = $entry_data['arm_form_id'];
                    $user_id = $entry_data['arm_user_id'];

                    $arm_form_random_key = !empty($posted_data['form_random_key']) ? $posted_data['form_random_key'] : '';
                    $arm_form_id = "arm_setup_form".$arm_form_random_key;

                    $entry_values = $entry_data['arm_entry_value'];
                    $payment_cycle = $entry_values['arm_selected_payment_cycle']; 
                    $arm_tax_data = !empty($arm_return_data['arm_tax_data']) ? $arm_return_data['arm_tax_data'] : array();
                    $tax_percentage = !empty($arm_tax_data['tax_percentage']) ? $arm_tax_data['tax_percentage'] : 0;
                    $user_email_add = $arm_return_data['arm_user_email'];
                    if (is_user_logged_in()) {
                        $user_obj = get_user_by( 'ID', $user_id);
                        $user_name = $user_obj->first_name." ".$user_obj->last_name;
                        $user_email_add = $user_obj->user_email;
                    }else { 
                        $user_name = $entry_data['arm_entry_value']['first_name']." ".$entry_data['arm_entry_value']['last_name'];
                    }

                    $plan_id = $arm_return_data['arm_plan_id'];
                    $plan = $arm_return_data['arm_plan_obj'];
                    $plan_action = $arm_return_data['arm_plan_action'];
                    $plan_payment_type = $plan->payment_type;
                    $is_recurring = $plan->is_recurring();

                    $plan_name = !empty($plan->name) ? $plan->name : "Plan Name";
                    $recurring_data = !empty($arm_return_data['arm_recurring_data']) ? $arm_return_data['arm_recurring_data'] : array();
                    if($is_recurring){
                        $amount = $recurring_data['amount'];
                    }else{
                        $amount = !empty($plan->amount) ? $plan->amount : 0;
                    }
                    $amount = str_replace(",", "", $amount);
                    $amount = number_format((float)$amount, 2, '.','');

                    $iscouponfeature = false;
                    $arm_is_trial = '0';
                    $extraParam = array();
                    if ($plan_action == 'new_subscription') {
                        $is_trial = false;
                        $allow_trial = true;
                        if (is_user_logged_in()) {
                            $user_id = get_current_user_id();
                            $user_plan = get_user_meta($user_id, 'arm_user_plan_ids', true);
                            $user_plan_id = $user_plan;
                            if (!empty($user_plan)) {
                                $allow_trial = false;
                            }
                        }

                        if ($plan->has_trial_period() && $allow_trial && $payment_mode == 'auto_debit_subscription') {
                            $square_err_msg = '<div class="arm_error_msg"><ul><li>'.__('Square does not support Free trial/plan amount.', 'ARM_SQUARE').'</li></ul></div>';
                            $return = array('status' => 'error', 'type' => 'message', 'message' => $square_err_msg);
                            echo json_encode($return);
                            exit;
                        }
                    }

                    $arm_coupon_discount_type = $arm_coupon_code = '';
                    $arm_coupon_discount = $arm_coupon_on_each_subscriptions = 0;
                    $discount_amt = $amount;
                    $extraParam = array('plan_amount' => $amount, 'paid_amount' => $amount);
                    if ($arm_manage_coupons->isCouponFeature && !empty($arm_return_data['arm_coupon_data'])) {
                        $arm_coupon_data = $arm_return_data['arm_coupon_data'];
                        $arm_coupon_code = $arm_return_data['arm_coupon_code'];
                        $coupon_amount = !empty($arm_coupon_data['coupon_amt']) ? $arm_coupon_data['coupon_amt'] : 0;
                        $arm_coupon_discount = (!empty($arm_coupon_data['discount']) && !empty($arm_coupon_data['discount'])) ? $arm_coupon_data['discount'] : 0;
                        $arm_coupon_discount_type = ($arm_coupon_data['discount_type'] != 'percentage') ? $currency : "%";
                        $arm_coupon_on_each_subscriptions = isset($arm_coupon_data['arm_coupon_on_each_subscriptions']) ? $arm_coupon_data['arm_coupon_on_each_subscriptions'] : '0';

                        $extraParam['coupon'] = array(
                            'coupon_code' => $arm_coupon_code,
                            'amount' => $coupon_amount,
                            'arm_coupon_on_each_subscriptions' => $arm_coupon_on_each_subscriptions
                        );

                        if($arm_coupon_on_each_subscriptions){
                            $arm_coupon_on_each_subscription_amount = !empty($arm_return_data['arm_coupon_amount_on_each_subs']) ? $arm_return_data['arm_coupon_amount_on_each_subs'] : 0;
                            $discount_amt = $arm_coupon_on_each_subscription_amount;
                        }else{
                            $discount_amt = $arm_coupon_data['total_amt'];
                        }

                    } else {
                        $posted_data['arm_coupon_code'] = '';
                    }
                    $discount_amt = str_replace(",", "", $discount_amt);
                    $arm_square_plan_amount = str_replace(",", "", $plan->amount);

                    if($arm_coupon_on_each_subscriptions){
                        $arm_coupon_on_each_subscription_amount = !empty($arm_return_data['arm_coupon_amount_on_each_subs']) ? $arm_return_data['arm_coupon_amount_on_each_subs'] : 0;
                        $arm_square_plan_amount = $arm_coupon_on_each_subscription_amount;
                    }else{
                        $arm_square_plan_amount = $discount_amt;
                    }

                    if($tax_percentage > 0){
                        $tax_amount = $tax_discount_amt = $arm_tax_data['tax_amount'];
                        $amount = $discount_amt = $arm_tax_data['tax_final_amount'];
                    }

                    $amount = number_format((float)$amount, 2, '.','');
                    $discount_amt = number_format((float)$discount_amt, 2, '.','');


                    $arm_redirecturl = $entry_values['setup_redirect'];
                    if (empty($arm_redirecturl)) {
                        $arm_redirecturl = ARM_HOME_URL;
                    }

                    if ((($discount_amt <= 0 || $discount_amt == '0.00') && $recurring_payment_mode == 'manual_subscription' && $is_recurring) || (!$is_recurring && ($discount_amt <= 0 || $discount_amt == '0.00'))) 
                    {
                        global $payment_done;
                        $square_response = array();
                        $current_user_id = 0;
                        if (is_user_logged_in()) {
                            $square_response['arm_user_id'] = get_current_user_id();
                        }
                        $arm_first_name = (isset($posted_data['first_name'])) ? $posted_data['first_name'] : '';
                        $arm_last_name = (isset($posted_data['last_name'])) ? $posted_data['last_name'] : '';
                        if($user_id){
                            if(empty($arm_first_name)){
                                $user_detail_first_name = get_user_meta($user_id, 'first_name', true);
                                $arm_first_name = $user_detail_first_name;
                            }
                            if(empty($arm_last_name)){
                                $user_detail_last_name = get_user_meta($user_id, 'last_name', true);
                                $arm_last_name = $user_detail_last_name;
                            }    
                        }
                        $square_response['arm_plan_id'] = $plan->ID;
                        $square_response['arm_first_name'] = $arm_first_name;
                        $square_response['arm_last_name'] = $arm_last_name;
                        $square_response['arm_payment_gateway'] = 'square';
                        $square_response['arm_payment_type'] = $plan->payment_type;
                        $square_response['arm_token'] = '-';
                        $square_response['arm_payer_email'] = $user_email_add;
                        $square_response['arm_receiver_email'] = '';
                        $square_response['arm_transaction_id'] = '-';
                        $square_response['arm_transaction_payment_type'] = $plan->payment_type;
                        $square_response['arm_transaction_status'] = 'completed';
                        $square_response['arm_payment_mode'] = 'manual_subscription';
                        $square_response['arm_payment_date'] = date('Y-m-d H:i:s');
                        $square_response['arm_amount'] = $amount;
                        $square_response['arm_currency'] = $currency;
                        $square_response['arm_coupon_code'] = $arm_coupon_code;
                        $square_response['arm_extra_vars'] = '';
                        $square_response['arm_is_trial'] = $arm_is_trial;
                        $square_response['arm_created_date'] = current_time('mysql');
                        $square_response['arm_coupon_discount'] = $arm_coupon_discount;
                        $square_response['arm_coupon_discount_type'] = $arm_coupon_discount_type;
                        $square_response['arm_coupon_on_each_subscriptions'] = $arm_coupon_on_each_subscriptions;

                        $payment_log_id = $arm_payment_gateways->arm_save_payment_log($square_response);
                        $return = array('status' => TRUE, 'log_id' => $payment_log_id, 'entry_id' => $entry_id);
                        $payment_done = $return;
                        $is_free_manual = true;

                        if($arm_manage_coupons->isCouponFeature && !empty($arm_coupon_code) && !empty($arm_coupon_on_each_subscriptions)) {
                                $payment_done["coupon_on_each"] = TRUE;
                                $payment_done["trans_log_id"] = $payment_log_id;
                        }

                        do_action('arm_after_square_free_payment',$plan,$payment_log_id,$arm_is_trial,$posted_data['arm_coupon_code'],$extraParam);

                        return $return;
                    }
                    else
                    {
                        $extraVars['paid_amount'] = $amount;
                        $data_array['arm_square_entry_id'] = $entry_id;
                        $data_array['currency'] = $currency;
                        $data_array['arm_plan_id'] = $plan_id;
                        $data_array['arm_plan_name'] = $plan_name;
                        $data_array['arm_plan_amount'] = $discount_amt;
                        $data_array['reference'] = 'ref-' . $entry_id.'-'.time();
                        $data_array['redirect_url'] = $arm_square_redirecturl;
                        $data_array['arm_coupon_code'] = $posted_data['arm_coupon_code'];

                        if($pgoptions['square']['square_payment_mode'] == 'sandbox')
                        {
                            $data_array['arm_square_application_id'] = $pgoptions['square']['square_test_application_id'];
                            $data_array['arm_square_access_token'] = $pgoptions['square']['square_test_access_token'];
                            $data_array['arm_square_location_id'] = $pgoptions['square']['square_test_square_location'];
                        }
                        else
                        {
                            $data_array['arm_square_application_id'] = $pgoptions['square']['square_live_application_id'];
                            $data_array['arm_square_access_token'] = $pgoptions['square']['square_live_access_token'];
                            $data_array['arm_square_location_id'] = $pgoptions['square']['square_live_square_location'];
                        }
                    
                        $data_array['first_name'] = $entry_data['arm_entry_value']['first_name'];
                        $data_array['last_name'] = $entry_data['arm_entry_value']['last_name'];
                        $data_array['user_email'] = $user_email_add;

                        if($recurring_payment_mode == 'auto_debit_subscription' )
                        {
                            $square_err_msg = '<div class="arm_error_msg"><ul><li>'.__('Square does not support subscription payment.', 'ARM_SQUARE').'</li></ul></div>';
                            $return = array('status' => 'error', 'type' => 'message', 'message' => $square_err_msg);
                            echo json_encode($return);
                            exit;
                        }
                    }

                    $extraVars['paid_amount'] = $discount_amt;
                    $data_array['currency'] = $currency;
                    $data_array['arm_plan_id'] = $plan_id;
                    $data_array['arm_plan_name'] = $plan_name;
                    $data_array['arm_plan_amount'] = $discount_amt;
                    $data_array['reference'] = 'ref-' . $entry_id;
                    $data_array['redirect_url'] = $arm_redirecturl;

                    if($pgoptions['square']['square_payment_mode']=='sandbox'){
                        $data_array['arm_square_application_id'] = $pgoptions['square']['square_test_application_id'];
                        $data_array['arm_square_access_token'] = $pgoptions['square']['square_test_access_token'];
                        $data_array['arm_square_location_id'] = $pgoptions['square']['square_test_square_location'];
                    }else{
                        $data_array['arm_square_application_id'] = $pgoptions['square']['square_live_application_id'];
                        $data_array['arm_square_access_token'] = $pgoptions['square']['square_live_access_token'];
                        $data_array['arm_square_location_id'] = $pgoptions['square']['square_live_square_location'];
                    }

                    $data_array['first_name'] = $entry_data['arm_entry_value']['first_name'];
                    $data_array['last_name'] = $entry_data['arm_entry_value']['last_name'];
                    $data_array['user_email'] = $user_email_add;
                    $data_array['arm_coupon_on_each_subscriptions'] = $arm_coupon_on_each_subscriptions;
                    $data_array['arm_coupon_discount_type'] = $arm_coupon_discount_type;
                    $square_response['arm_coupon_discount'] = $arm_coupon_discount;

                    $arm_check_square_currency = $this->arm2_square_check_zero_decimal_currency($currency);
                    if($arm_check_square_currency){
                        $discount_amt = $discount_amt * 100;
                    }

                    $arm_checkout_form_data = array();
                    $arm_checkout_form_data['idempotency_key'] = md5(uniqid());
                    $arm_checkout_form_data['amount_money'] = implode('*', [
                        'amount'   => $discount_amt,
                        'currency' => $currency
                    ]);
                    $arm_checkout_form_data['buyer_email_address'] = $user_email_add;
                    $arm_checkout_form_data['note'] = $plan_name;
                    $arm_checkout_form_data['reference_id'] = $data_array['reference'];
                    $arm_checkout_form_data['order_id'] = $entry_id.'_'.time();

                    do_action('arm_payment_log_entry', 'square', 'Checkout submitted form data', 'payment_gateway', $arm_checkout_form_data, $arm_debug_payment_log_id);

                    $arm_checkout_form_data = implode('|',$arm_checkout_form_data);

                    $arm_square_payment_button_title = $pgoptions['square']['square_payment_button_title'];
                    $arm_square_payment_modal_title = get_bloginfo('name');

                    $pgoptions_square_square_popup_title = !empty($pgoptions['square']['square_popup_title']) ? $pgoptions['square']['square_popup_title'] : '';
                    if(!empty($pgoptions_square_square_popup_title))
                    {
                        $arm_square_payment_modal_title = str_replace("{arm_selected_plan_title}", $plan_name, $pgoptions_square_square_popup_title);
                    }

                    $arm_checkout_form .= "<style class='arm_square_css'>";
                    $arm_checkout_form .= ".arm_setup_form_container iframe{ width: unset !important;border: unset !important;position: unset !important;left: unset !important;height: 4rem !important; }";


                    $arm_checkout_form .= ".square_element_wrapper{position:fixed;top:0;left:0;width:100%;height:100%;text-align:center;background:rgba(0,0,0,0.6);z-index:999999;}.square_element_wrapper .form-inner-row{ float: left; width: 300px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #F5F5F7;text-align:left;border-radius:5px;overflow:hidden;padding: 15px;}.square_element_wrapper #sq-creditcard,#update-card-button{ background:linear-gradient(#43B0E9,#3299DE); padding:0 !important; font-weight:normal; border:none; color: #fff; display: inline-block; margin-top: 25px; margin-bottom:15px; height: 40px; line-height: normal; float: left; border-radius:4px;width:100%;font-size:20px;}.square_element_wrapper .form-row{ float:left; width: 70%;}.square_element_wrapper iframe{position:relative;left:0;width:100% !important;height: 100% !important;}.StripeElement {box-sizing: border-box;height: 40px;padding: 10px 12px;border: 1px solid transparent;border-radius: 4px;background-color: white;box-shadow: 0 1px 3px 0 #e6ebf1;-webkit-transition: box-shadow 150ms ease;transition: box-shadow 150ms ease;}.card-errors{font-size: 14px;color: #ff0000;}.site_info_row {float: left;width: 100%;height: 95px;background: #E8E9EB;border-bottom: 1px solid #DBDBDD;box-sizing: border-box;text-align: center;padding: 25px 10px;}.field_wrapper{float:left;padding:30px;width:100%;box-sizing:border-box;}.form-inner-row .field_wrapper .arm_square_field_row{float:left;width:100%;margin-bottom:10px;}.site_title,.site_tag{float:left;width:100%;text-align:center;font-size:16px;} .site_title{font-weight:bold;}.site_info_row .close_icon{position: absolute;width: 20px;height: 20px;background: #cecccc;right: 10px;top: 10px;border-radius: 20px;cursor:pointer;}.site_info_row .close_icon::before{content: '';width: 12px;height: 2px;background: #fff;display: block;top: 50%;left: 50%;transform: translate(-50%,-50%) rotate(45deg);position: absolute;}.site_info_row .close_icon::after{content: '';width: 12px;height: 2px;background: #fff;display: block;top: 50%;left: 50%;transform: translate(-50%,-50%) rotate(-45deg);position: absolute;}.StripeElement--focus { box-shadow: 0 1px 3px 0 #cfd7df; }.StripeElement--invalid {border-color: #fa755a;}.StripeElement--webkit-autofill {background-color: #fefde5 !important;}.arm_square_loader{float:none;display:inline-block;width:15px;height:15px;border:3px solid #fff;border-radius:15px;border-top:3px solid transparent;margin-right:5px;position:relative;top:3px;display:none;animation:spin infinite 1.5s}@keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg)}} #sq-creditcard[disabled],#update-card-button[disabled]{opacity:0.7;} #sq-creditcard[disabled] .arm_square_loader,#update-card-button[disabled] .arm_square_loader{display:inline-block;} #arm_square_error_msg{ color: #f00;font-size: 1.8rem; } .square_element_wrapper .form-inner-row,.site_info_row,.sq-card-wrapper{background-color: #FFFFFF !important;}";

                    $arm_checkout_form .= "</style>";
                    
                    $arm_checkout_form .= "<div class='square_element_wrapper'>";
                        $arm_checkout_form .= "<div class='form-inner-row' data-locale-reversible>";
                            $arm_checkout_form .= "<div class='site_info_row'>";

                                $arm_checkout_form .= "<div class='site_info'>";
                                    $arm_checkout_form .= "<div class='site_title'>".$arm_square_payment_modal_title."</div>";
                                        $arm_checkout_form .= "<div class='close_icon' id='square_wrapper_close_icon' onclick='armSquarePaymentModal()'></div>";
                                    $arm_checkout_form .= "</div>";
                                $arm_checkout_form .= "</div>";

                                $arm_checkout_form .= "<form id='payment-form' method='POST'>";

                                    $arm_checkout_form .= " <div id='card-container'></div>";

                                    $arm_checkout_form .= "<button id='sq-creditcard' class='button-credit-card'><span class='arm_square_loader'></span>".$arm_square_payment_button_title."</button>";

                                $arm_checkout_form .= "</form>";

                            $arm_checkout_form .= "</div>";
                        $arm_checkout_form .= "</div>";
                    $arm_checkout_form .= "</div>";

                    $arm_checkout_form .= "<form id='arm_final_payment_form' method='POST' action=''>";

                    $arm_checkout_form .= "<input type='hidden' name='arm_square_payment_data' value='".$arm_checkout_form_data."'>";
                                    $arm_checkout_form .= "<input type='hidden' name='arm-listener' value='arm_square_api'>";
                                    $arm_checkout_form .= "<input type='hidden' name='arm_payment_nonce' id='arm_payment_nonce' value=''>";
                    
                    $arm_checkout_form .= "</form>";
                    
                    
                    $arm_main_checkout_form = '<script type="text/javascript" class="arm_square_payment_form_script">';
                    $arm_main_checkout_form .= 'jQuery("#'.$arm_form_id.' .arm_setup_form_inner_container").after("'.$arm_checkout_form.'");';

                    $arm_main_checkout_form .= '';
		    
		    $arm_main_checkout_form .= 'function armSquarePaymentModal(){';
                    $arm_main_checkout_form .= 'jQuery(".square_element_wrapper").remove();';
                    $arm_main_checkout_form .= 'jQuery(".arm_square_css").remove();';
                    $arm_main_checkout_form .= 'jQuery("#arm_final_payment_form").remove();';
                    
                    $arm_main_checkout_form .= 'Square.payments("'.$data_array['arm_square_application_id'].'", "'.$data_array['arm_square_location_id'].'").destroy();';
                    $arm_main_checkout_form .= '}';

                        $arm_main_checkout_form .= 'async function main() 
                        {
                            const payments = Square.payments("'.$data_array['arm_square_application_id'].'", "'.$data_array['arm_square_location_id'].'");  
                            const card = await payments.card();
                            await card.attach("#card-container");
                            let tokenResult;
                            const cardButton = document.getElementById("sq-creditcard");
                            cardButton.addEventListener("click", async function (event) {
                                cardButton.setAttribute("disabled","disabled");
                                cardButton.style.cursor = "not-allowed";
                                await handlePaymentMethodSubmission(event, card);
                            });
                            async function handlePaymentMethodSubmission(event, paymentMethod) {
                                event.preventDefault();
                                try {
                                    const result = await card.tokenize();
                                    if (result.status === "OK") {
                                        document.querySelector("#arm_payment_nonce").value = `${result.token}`;
                                        setTimeout(function(){ document.getElementById("arm_final_payment_form").submit(); }, 1000);
                                    }
                                } catch (e) {
                                    cardButton.removeAttribute("disabled");
                                    cardButton.style.cursor = "";
                                    console.error(e);
                                }
                            }
                        }
                        main();';
                
                    $arm_main_checkout_form .= '</script>';

                    echo json_encode( array('type' => 'script', 'isHide' => false, 'message' => $arm_main_checkout_form));
                    exit();
                }
            }
        }
    }

    function arm2_square_check_zero_decimal_currency($currency){
        $arm_allowed_currency = array('BIF', 'DJF','JPY', 'KRW','PYG', 'VND', 'XAF', 'XPF', 'CLP', 'GNF', 'KMF', 'MGA', 'RWF', 'VUV', 'XOF', 'HUF');
        $currency = strtoupper($currency);
        if(!in_array($currency, $arm_allowed_currency)){
            return 1;
        }

        return 0;
    }

    function arm2_square_webhook($transaction_id = 0, $arm_listener = '', $tran_id = '') {
        global $wpdb, $ARMember, $arm_payment_gateways, $arm_subscription_plans, $arm_members_class, $arm_manage_communication, $wp_version, $arm_global_settings, $arm_debug_payment_log_id, $arm_transaction;
        if(isset($_REQUEST['arm-listener']) && in_array($_REQUEST['arm-listener'], array('arm_square_api'))) 
        {   
            do_action('arm_payment_log_entry', 'square', 'Square webhook data', 'payment_gateway', $_REQUEST, $arm_debug_payment_log_id);

            $arm_square_payment_data = explode('|', $_REQUEST['arm_square_payment_data']);
            $arm_square_amount_arr = explode('*', $arm_square_payment_data[1]);

            $arm_square_webhook_amt = !empty($arm_square_amount_arr[0]) ? (int)$arm_square_amount_arr[0] : 0;
            $arm_square_webhook_currency = !empty($arm_square_amount_arr[1]) ? $arm_square_amount_arr[1] : '';
            
            $arm_checkout_form_data = array();
            $arm_checkout_form_data['source_id'] = $_REQUEST['arm_payment_nonce'];
            $arm_checkout_form_data['idempotency_key'] = $arm_square_payment_data[0];
            $arm_checkout_form_data['amount_money'] = [
                'amount'   => $arm_square_webhook_amt,
                'currency' => $arm_square_webhook_currency
            ];
            $arm_checkout_form_data['buyer_email_address'] = $arm_square_payment_data[2];
            $arm_checkout_form_data['note'] = $arm_square_payment_data[3];
            $arm_checkout_form_data['reference_id'] = $arm_square_payment_data[4];

            $arm_get_payment_log = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$ARMember->tbl_arm_payment_log` WHERE arm_token = %s", $arm_checkout_form_data['idempotency_key']), ARRAY_A);

            do_action('arm_payment_log_entry', 'square', 'Square webhook check transaction exist or not response', 'payment_gateway', $arm_get_payment_log, $arm_debug_payment_log_id);
                
            $arm_log_id = (!empty($arm_get_payment_log['arm_log_id'])) ? $arm_get_payment_log['arm_log_id'] : '';
            $arm_square_user_id = (!empty($arm_get_payment_log['arm_user_id'])) ? $arm_get_payment_log['arm_user_id'] : '';
            $arm_square_plan_id = (!empty($arm_get_payment_log['arm_plan_id'])) ? $arm_get_payment_log['arm_plan_id'] : '';

            //Explode entry from order id from request
            $arm_square_entry_id = (!empty($arm_square_payment_data[5])) ? explode('_', $arm_square_payment_data[5]) : '';
            $arm_square_entry_id = $arm_square_entry_id[0];


            if($arm_log_id == '') 
            {
                $gateway_options = get_option('arm_payment_gateway_settings');
                $pgoptions = maybe_unserialize($gateway_options);
                $arm_square_payment_access_token = ($pgoptions['square']['square_payment_mode'] == 'sandbox') ? $pgoptions['square']['square_test_access_token'] :  $pgoptions['square']['square_live_access_token'];

                $arm_square_payment_url = ($pgoptions['square']['square_payment_mode'] == 'sandbox') ? 'https://connect.squareupsandbox.com/v2/payments' : 'https://connect.squareup.com/v2/payments';

                $arm_square_payment_body = array(
                    'method'  => 'POST',
                    'body'    => wp_json_encode($arm_checkout_form_data),
                    'headers' => [
                        'Authorization'  => 'Bearer '.$arm_square_payment_access_token,
                        'Square-Version' => '2022-10-19',
                        'Content-Type'   => 'application/json'
                    ],
                    'sslverify'   => false
                );

                do_action('arm_payment_log_entry', 'square', 'Square webhook transaction verification params', 'payment_gateway', $arm_square_payment_body, $arm_debug_payment_log_id);

                $arm_square_payment_request = wp_remote_post($arm_square_payment_url, $arm_square_payment_body);

                $arm_square_payment_response = json_decode(wp_remote_retrieve_body($arm_square_payment_request));
                do_action('arm_payment_log_entry', 'square', 'Square webhook transaction verification response', 'payment_gateway', $arm_square_payment_response, $arm_debug_payment_log_id);

                if(isset($arm_square_payment_response->payment) && ($arm_square_payment_response->payment->status == "COMPLETED"))
                {
                    $arm_token = $arm_checkout_form_data['idempotency_key'];
                    $arm_transaction_id = $arm_checkout_form_data['reference_id'];

                    $arm_subscription_field_name = '';
                    $arm_token_field_name = 'idempotency_key';
                    $arm_transaction_id_field_name = 'reference_id';

                    $arm_square_payment_response = (array)$arm_square_payment_response->payment;

                    do_action('arm_payment_log_entry', 'square', 'Square webhook submitted payment response', 'payment_gateway', $arm_square_payment_response, $arm_debug_payment_log_id);

                    $arm_card_number = !empty($arm_square_payment_response['card_details']->card->last_4) ? $arm_square_payment_response['card_details']->card->last_4 : '';
                    if(!empty($arm_card_number)){
                        $arm_card_number = $arm_transaction->arm_mask_credit_card_number($arm_card_number);
                        $arm_square_payment_response['arm_payment_card_number'] = $arm_card_number;
                    }

                    $arm_webhook_save_membership_data = array();
                    $arm_webhook_save_membership_data = apply_filters('arm_modify_payment_webhook_data', $arm_webhook_save_membership_data, $arm_square_payment_response, 'square', $arm_token, $arm_transaction_id, $arm_square_entry_id, $arm_token, $arm_subscription_field_name, $arm_token_field_name, $arm_transaction_id_field_name);

                    $entry_data = $arm_payment_gateways->arm_get_entry_data_by_id($arm_square_entry_id);
                    $entry_values = $entry_data['arm_entry_value'];
                    $arm_redirecturl = $entry_values['setup_redirect'];
                    
                    if (empty($arm_redirecturl)) {
                        $arm_redirecturl = ARM_HOME_URL;
                    }
                    
                    header('Location: '.$arm_redirecturl);
                }
                else
                {
                    $square_err_msg = '<div class="arm_error_msg"><ul><li style="text-color: #f00 !important;">'.__('Your payment is failed. Please try again.', 'ARM_SQUARE').'</li></ul></div>';

                    $globalSettings = $arm_global_settings->global_settings;
                    $cp_page_id = isset($globalSettings['cancel_payment_page_id']) ? $globalSettings['cancel_payment_page_id'] : 0;
                    
                    $default_cancel_url = $arm_global_settings->arm_get_permalink('', $cp_page_id);
                    
                    $cancel_url = (!empty($paypal_options['cancel_url'])) ? $paypal_options['cancel_url'] : $default_cancel_url;
                    if ($cancel_url == '' || empty($cancel_url)) {
                        $cancel_url = ARM_HOME_URL;
                    }
                    header('Location: '.$cancel_url);
                }
                exit();
            }
        }
    }
    
    function arm2_square_cancel_subscription($user_id, $plan_id){
        global $wpdb, $ARMember, $arm_global_settings, $arm_subscription_plans, $arm_member_forms, $arm_payment_gateways, $arm_manage_communication, $arm_debug_payment_log_id;
        if (isset($user_id) && $user_id != 0 && isset($plan_id) && $plan_id != 0) {
            $arm_cancel_subscription_data = array();
            $arm_cancel_subscription_data = apply_filters('arm_gateway_cancel_subscription_data', $arm_cancel_subscription_data, $user_id, $plan_id, 'square', '', '', '');
            $arm_plan_data = $arm_cancel_subscription_data['arm_plan_data'];
            $user_payment_gateway = isset($arm_plan_data['arm_user_gateway']) ? $arm_plan_data['arm_user_gateway'] : '';
            if($user_payment_gateway == "square" && !empty($arm_cancel_subscription_data))
            {
                do_action('arm_payment_log_entry', 'square', 'Square webhook submitted payment response', 'payment_gateway', $arm_cancel_subscription_data, $arm_debug_payment_log_id);

                $arm_cancel_amount = $arm_cancel_subscription_data['arm_cancel_amount'];
                $payment_gateway_options = $arm_cancel_subscription_data['payment_gateway_options'];
                $arm_payment_mode = $arm_cancel_subscription_data['arm_payment_mode'];
                $arm_subscr_id = $arm_cancel_subscription_data['arm_subscr_id'];
                $arm_customer_id = $arm_cancel_subscription_data['arm_customer_id'];
                $arm_transaction_id = $arm_cancel_subscription_data['arm_transaction_id'];
                $transaction = $arm_cancel_subscription_data['arm_payment_log_data'];

                if(!empty($transaction))
                {
                    $extra_var = maybe_unserialize($transaction->arm_extra_vars);
                    $payment_type = $extra_var['payment_type'];
                    if ($payment_type == 'square') {
                        $payer_email = !empty($transaction->arm_payer_email) ? $transaction->arm_payer_email : '';
                        do_action('arm_cancel_subscription_payment_log_entry', $user_id, $plan_id, 'square', $arm_subscr_id, $arm_transaction_id, $arm_customer_id, $arm_payment_mode, $arm_cancel_amount, $payer_email);
                    }
                }
            }
        }
    }
}

global $arm_square;
$arm_square = new ARM_Square();


global $armsquare_api_url, $armsquare_plugin_slug;

$armsquare_api_url = $arm_square->armsquare_getapiurl();
$armsquare_plugin_slug = basename(dirname(__FILE__));

add_filter('pre_set_site_transient_update_plugins', 'armsquare_check_for_plugin_update');

function armsquare_check_for_plugin_update($checked_data) {
    global $armsquare_api_url, $armsquare_plugin_slug, $wp_version, $arm_square_version,$arm_square;

    //Comment out these two lines during testing.
    if (empty($checked_data->checked))
        return $checked_data;

    $args = array(
        'slug' => $armsquare_plugin_slug,
        'version' => $arm_square_version,
        'other_variables' => $arm_square->armsquare_get_remote_post_params(),
    );

    $request_string = array(
        'body' => array(
            'action' => 'basic_check',
            'request' => serialize($args),
            'api-key' => md5(ARM_SQUARE_HOME_URL)
        ),
        'user-agent' => 'ARMSQUARE-WordPress/' . $wp_version . '; ' . ARM_SQUARE_HOME_URL
    );

    // Start checking for an update
    $raw_response = wp_remote_post($armsquare_api_url, $request_string);

    if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
        $response = @unserialize($raw_response['body']);

    if (isset($response) && !empty($response) && isset($response->token) && $response->token != "")
        update_option('armsquare_update_token', $response->token);

    if (isset($response) && is_object($response) && is_object($checked_data) && !empty($response)) // Feed the update data into WP updater
        $checked_data->response[$armsquare_plugin_slug . '/' . $armsquare_plugin_slug . '.php'] = $response;

    return $checked_data;
}

add_filter('plugins_api', 'armsquare_plugin_api_call', 10, 3);

function armsquare_plugin_api_call($def, $action, $args) {
    global $armsquare_plugin_slug, $armsquare_api_url, $wp_version;

    if (!isset($args->slug) || ($args->slug != $armsquare_plugin_slug))
        return false;

    // Get the current version
    $plugin_info = get_site_transient('update_plugins');
    $current_version = $plugin_info->checked[$armsquare_plugin_slug . '/' . $armsquare_plugin_slug . '.php'];
    $args->version = $current_version;

    $request_string = array(
        'body' => array(
            'action' => $action,
            'update_token' => get_site_option('armsquare_update_token'),
            'request' => serialize($args),
            'api-key' => md5(ARM_SQUARE_HOME_URL)
        ),
        'user-agent' => 'ARMSQUARE-WordPress/' . $wp_version . '; ' . ARM_SQUARE_HOME_URL
    );

    $request = wp_remote_post($armsquare_api_url, $request_string);

    if (is_wp_error($request)) {
        $res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', 'ARM_SQUARE'), $request->get_error_message());
    } else {
        $res = unserialize($request['body']);

        if ($res === false)
            $res = new WP_Error('plugins_api_failed', __('An unknown error occurred', 'ARM_SQUARE'), $request['body']);
    }

    return $res;
}
?>