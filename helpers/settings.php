<?php
/**
 * Settings Helper Proxy
 */
require_once dirname(__DIR__) . '/config/database.php';

if (!function_exists('sathi_site_setting')) {
    function sathi_site_setting($key, $default = '') {
        return site_setting($key, $default);
    }
}
