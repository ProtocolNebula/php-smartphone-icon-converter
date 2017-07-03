<?php
// APP Settings:
define('MAX_FILE_SIZE', '5242880'); // In Bytes (default 5 MB - 5242880 bytes) - 0 disable this (server limit)

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // AVOID DDOS: minimum time between conversions
    define('SECONDS_BETWEEN_CONVERSIONS', '0');
} else {
    define('SECONDS_BETWEEN_CONVERSIONS', '10'); // In seconds (0 = disable this)
}