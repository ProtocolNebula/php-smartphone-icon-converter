<?php
include APP_DIR . 'lib/thumbs.php';
include APP_DIR . 'lib/pclzip.lib.php';

function downloadZip($file, $nameToShow, $delete = true) {

    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename=$nameToShow");
    header("Content-length: " . filesize($file));
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile($file);
    unlink($file);
    die();
}

/**
 * Function executed on index.php when POST petition is received
 */
function convertImages() {
    // Temporal ID for this session
    //$tmp_session = session_id() . time();
    $tmp_session = session_id();

    define('TMP_SESSION_DIR', TMP_DIR . $tmp_session . '/');
    if (!is_dir(TMP_SESSION_DIR)) {
        mkdir(TMP_SESSION_DIR, 0777, true);
    }
    if (!is_dir(OUT_DIR)){
        mkdir(OUT_DIR, 0777, true);
    }

    $tmpIcon = TMP_SESSION_DIR . 'original.png';
    if (is_file($tmpIcon)) {
        unlink($tmpIcon);
    }
    
    // TODO: Make a thumb base if image is too large
    move_uploaded_file($_FILES['icon']['tmp_name'], $tmpIcon);

    try {
        $thumbs = new Thumbs($tmpIcon);
    } catch (Exception $ex) {
        return 'Check image file type, dimensions and size';
    }
    
    foreach ($GLOBALS['sizes'] as $os => $size) {
        $path = TMP_SESSION_DIR . $os . '/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        
        if ($os == 'ANDROID') {
            foreach ($size as $name => $data) {
                $subPath = $path . $name . '/';
                if (!is_dir($subPath))
                    mkdir($subPath, 0777, true);

                $bg = isset($data['bg']) ? $data['bg'] : '';
                $thumbs->doResize($subPath . $data['fileName'], $data['width'], $data['height'], $bg);
            }
        } else {
            foreach ($size as $name => $data) {
                $bg = isset($data['bg']) ? $data['bg'] : '';
                $thumbs->doResize($path . $name, $data['width'], $data['height'], $bg);
            }
        }
    }
    
    unset($thumbs);

    // Make ZIP
    $fileDownload = OUT_DIR . $tmp_session . '.zip';
    $archive = new PclZip($fileDownload);
    $v_list = $archive->create(TMP_SESSION_DIR, PCLZIP_OPT_REMOVE_PATH, TMP_SESSION_DIR);

    // Delete temp directory for this user
    DirectoryManager::delete(TMP_SESSION_DIR, true, true, true, 0);
    
    // Download the file
    downloadZip($fileDownload, 'Mobile-Icons', true);
}
