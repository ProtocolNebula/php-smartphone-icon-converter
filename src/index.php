<?php
session_start();

define('APP_DIR', __DIR__ . '/');
define('TMP_DIR', APP_DIR . 'tmp/');
define('OUT_DIR', TMP_DIR . 'out/');
//define('PUBLIC_DIR', APP_DIR . 'public/');
define('VIEW_DIR', APP_DIR . 'view/');
include APP_DIR . 'config/app.php';
include APP_DIR . 'config/sizes.php';
include APP_DIR . 'lib/functions.php';
include APP_DIR . 'lib/DirectoryManager.php';


if ($_POST) {
    try {
        $res = convertImages();
    } catch (Exception $ex) {
        $res = $ex->getMessage();
    }
    
    if (!$res) {
        $res = 'An unknown error ocurred';
    }
    
} else {
    // Cleaning directories olders than 60 seconds (if broked script)
    DirectoryManager::delete(TMP_DIR, false, true, true, 60);
}

include VIEW_DIR . 'header.php';
if (isset($res) and $res !== true) {
    echo '<div class="alert alert-danger" role="alert">',
        '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ',
        '<span class="sr-only">Error:</span> ',
        $res,
    '</div>';
}
include VIEW_DIR . 'main.php';
include VIEW_DIR . 'footer.php'; ?>