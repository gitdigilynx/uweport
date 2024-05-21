<?php

global $wpdb, $armnew_square_version;

$arm_square_version = get_option('arm_square_version');
if(version_compare($arm_square_version, '1.6', '<')) {
    update_option('arm_square_old_version', $arm_square_version);
    update_option('arm_square_version', '1.6');
    $armnew_square_version = '1.6';
}
