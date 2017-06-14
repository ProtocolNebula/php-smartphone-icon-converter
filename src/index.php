<?php
session_start();

define('APP_DIR', __DIR__ . '/');
define('TMP_DIR', APP_DIR . 'tmp/');
define('OUT_DIR', TMP_DIR . 'out/');
//define('PUBLIC_DIR', APP_DIR . 'public/');
define('VIEW_DIR', APP_DIR . 'view/');
include APP_DIR . 'lib/DirectoryManager.php';

if ($_POST) {
    convertImages();
} else {
    // Cleaning directories olders than 60 seconds (if broked script)
    DirectoryManager::delete(TMP_DIR, false, true, true, 60);
}

include VIEW_DIR . 'header.php';
include VIEW_DIR . 'main.php';
include VIEW_DIR . 'footer.php'; ?>