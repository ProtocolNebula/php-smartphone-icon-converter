<?php
/**
 * Redimensiona una imagen
 * @param string $src Ruta de origen
 * @param string $dst Ruta de destino
 * @param numeric $width Nuevo ancho
 * @param numeric $height Nuevo alto
 * @param string $bgColor Color de fondo (transparent, white)
 */
function doResize($src, $dst, $width, $height, $bgColor = 'transparent') {
	// Obtener los nuevos tamaños
	list($originalWidth, $originalHeight) = getimagesize($src);
	
	// Cargamos los buffers para la conversion
	$src = imagecreatefrompng($src);
	$src = resizeToFit($src, $originalWidth, $originalHeight, $width, $height);
	
	
	$new = imagecreatetruecolor($width, $height);
	
	if ($bgColor == 'white') {
		$bgColor = imagecolorallocate($new, 255, 255, 255);
	} else {
		$bgColor = imagecolorallocatealpha($new, 0, 0, 0, 127);
		imagesavealpha($new, true);
	}
	
	imagefill($new, 0, 0, $bgColor);
	imagealphablending($new, true);
	
	// Redimensionamos
	//imagecopyresampled($new, $src, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
	$widthCenter = $width / 2 - ($originalWidth / 2);
	$heightCenter = $height / 2 - ($originalHeight / 2);
	imagecopy($new, $src, $widthCenter, $heightCenter, 0, 0, $originalWidth, $originalHeight);
	
	// Guardamos
	imagepng($new, $dst, 9);
}

/**
 * Redimensiona a proporcion una imagen para que entre en otra imagen mas pequeña (ya sea solo de altura o anchura)
 * @param resource $src Fuente de la imagen original cargada en "doResize"
 * @param numeric $originaWidth Widht de la imagen original
 * @param numeric $originalHeight Height de la imagen original
 * @param numeric $newWidth Anchura maxima de la nueva imagen
 * @param numeric $newHeight Altura maxima de la nueva imagen
 */
function resizeToFit($src, &$originalWidth, &$originalHeight, $newWidth, $newHeight) {
	$currentWidth = $originalWidth;
	$currentHeight = $originalHeight;
		
	/*if ($currentWidth < $currentHeight) {
		$currentHeight = ($newWidth / $currentWidth) * $currentHeight;
	} elseif ($currentWidth > $currentHeight) {
		$currentWidth = ($newHeight / $currentHeight) * $currentWidth;
	}*/
	
	if ($currentWidth > $newWidth) {
		//if the width is greather than supplied thumbnail size
		$currentWidth = $newWidth;
		$currentHeight = ($currentWidth / $originalWidth) * $currentHeight;
	}
	
	if ($currentHeight > $newHeight) {
		//if the height is greather than supplied thumbnail size
		$currentHeight = $newHeight;
		$currentWidth = ($currentHeight / $originalHeight) * $currentWidth;
	}
	
	// Preparamos la base de la imagen redimensionada
	$new = imagecreatetruecolor($currentWidth, $currentHeight);
	$bgColor = imagecolorallocatealpha($new, 0, 0, 0, 127);
	imagesavealpha($new, true);
	imagefill($new, 0, 0, $bgColor);
	imagealphablending($new, true);
	
	// Redimensionamos
	imagecopyresampled($new, $src, 0, 0, 0, 0, $currentWidth, $currentHeight, $originalWidth, $originalHeight);
	
	$originalWidth = $currentWidth;
	$originalHeight = $currentHeight;
	
	return $new;
}