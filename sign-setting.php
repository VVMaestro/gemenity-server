<?php

require_once 'data.php';
require_once 'functions.php';

$connect = connect_to_db($database);

$sign_settings_request = 'SELECT * FROM settings';
$sign_settings = get_db_data($connect, $sign_settings_request);

$setting_to_value = [];
foreach ($sign_settings as $sign) {
    $setting_to_value[$sign['setting']] = (float) $sign['value'];
}

$json_setting_to_value = json_encode($setting_to_value);

print($json_setting_to_value);