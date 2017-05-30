<?php
define('APP_DIR', __DIR__ . '/');
define('TMP_DIR', APP_DIR . 'tmp/');
define('OUT_DIR', APP_DIR . 'out/');

if (!is_dir(TMP_DIR)) mkdir(TMP_DIR, 0777, true);
if (!is_dir(OUT_DIR)) mkdir(OUT_DIR, 0777, true);

if ($_POST) {
	include APP_DIR . 'config.php';
	include APP_DIR . 'lib/thumbs.php';
	
	$tmpIcon = TMP_DIR . 'icon.png';
	if (is_file($tmpIcon)) unlink($tmpIcon);
	move_uploaded_file($_FILES['icon']['tmp_name'], $tmpIcon);
	
	foreach ($sizes as $os=>$size) {
		$path = OUT_DIR . $os . '/';
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
	
	echo 'Imagenes generadas.<hr />';
}
?>

<form method="post" enctype="multipart/form-data">
	<b>Icono <u>.png</u> (recomendado 1024x1024): </b> <input type="file" name="icon" /><br />
	<input type="submit" value="Convertir" name="submit"/>
</form>