<?php
/**
 * Validation Helpers
 */
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_required($value)
{
    return is_string($value) && trim($value) !== '';
}

function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}$/', $mobile);
}
