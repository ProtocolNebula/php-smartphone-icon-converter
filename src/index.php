<?php
session_start();

define('APP_DIR', __DIR__ . '/');
define('TMP_DIR', APP_DIR . 'tmp/');
define('OUT_DIR', TMP_DIR . 'out/');
//define('PUBLIC_DIR', APP_DIR . 'public/');
define('VIEW_DIR', APP_DIR . 'view/');
include APP_DIR . 'lib/DirectoryManager.php';

if ($_POST) {
	
	// Temporal ID for this session
	//$tmp_session = session_id() . time();
	$tmp_session = session_id();

	define('TMP_SESSION_DIR', TMP_DIR . $tmp_session . '/');
	if (!is_dir(TMP_SESSION_DIR)) mkdir(TMP_SESSION_DIR, 0777, true);
	if (!is_dir(OUT_DIR)) mkdir(OUT_DIR, 0777, true);

	include APP_DIR . 'config.php';
	include APP_DIR . 'lib/functions.php';
	
	$tmpIcon = TMP_SESSION_DIR . 'original.png';
	if (is_file($tmpIcon)) unlink($tmpIcon);
	move_uploaded_file($_FILES['icon']['tmp_name'], $tmpIcon);
	
	foreach ($sizes as $os=>$size) {
		$path = TMP_SESSION_DIR . $os . '/';
		if (!is_dir($path)) mkdir($path, 0777, true);
		
		if ($os == 'ANDROID') {
			foreach ($size as $name=>$data) {
				$subPath = $path . $name . '/';
				if (!is_dir($subPath)) mkdir($subPath, 0777, true);
				
				$bg = isset($data['bg']) ? $data['bg'] : '';
				doResize($tmpIcon, $subPath . $data['fileName'], $data['width'], $data['height'], $bg);
			}
		} else {
			foreach ($size as $name=>$data) {
				$bg = isset($data['bg']) ? $data['bg'] : '';
				doResize($tmpIcon, $path . $name, $data['width'], $data['height'], $bg);
			}
		}
	}
	
	// Make ZIP
	$fileDownload = OUT_DIR . $tmp_session . '.zip';
	$archive = new PclZip($fileDownload);
	$v_list = $archive->create(TMP_SESSION_DIR, PCLZIP_OPT_REMOVE_PATH, TMP_SESSION_DIR);
	
	// Delete temp directory for this user
	DirectoryManager::delete(TMP_SESSION_DIR, true, true, true, 0);
	
	// Download the file
	downloadZip($fileDownload, 'Mobile-Icons', true);
} else {
	// Cleaning directories olders than 60 seconds (if broked script)
	DirectoryManager::delete(TMP_DIR, false, true, true, 60);
}

include VIEW_DIR . 'header.php';
?>


<div class="jumbotron">
    <h1>Convert your icons!</h1>
    <p class="lead">
        Choose you icon (1024x1024 minimum recommended) in PNG format.
    </p>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="icon" /><br />
        <input type="submit" value="Convert" name="submit" class="btn btn-lg btn-success"/>
    </form>
</div>



<?php include VIEW_DIR . 'footer.php'; ?>