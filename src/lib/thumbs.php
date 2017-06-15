<?php

class Thumbs {

    /**
     * Redimensiona una imagen
     * @param string|resource $src Ruta de origen|Resource generado de Thumbs::createSrcFromImage
     * @param string $dst Ruta de destino
     * @param numeric $width Nuevo ancho
     * @param numeric $height Nuevo alto
     * @param string $bgColor Color de fondo (transparent, white)
     */
    static function doResize($src, $dst, $width, $height, $bgColor = 'transparent') {
        // Obtener los nuevos tamaños
        

        // Cargamos los buffers para la conversion
        if (!$src) {
            return false;
        } else if (is_string($src)) {
            $resource = self::createSrcFromImage($src);
            list($originalWidth, $originalHeight) = getimagesize($src);
        } else {
            $resource = $src;
            print_r($resource);
            die();
            list ($originalWidth, $originalHeight) = $resource;
        }
        
        $resource = self::resizeToFit($resource, $originalWidth, $originalHeight, $width, $height);


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
        imagecopy($new, $resource, $widthCenter, $heightCenter, 0, 0, $originalWidth, $originalHeight);

        // Guardamos
        imagepng($new, $dst, 9);
        
        imagedestroy($new);
        if (is_string($src)) {
            imagedestroy($resource);
        }
    }

    
    static function createSrcFromImage($src) {

        if (@$info_image = getimagesize($src)) {
            switch ($info_image['mime']) {
                case "image/jpeg":
                    @$src = imagecreatefromjpeg($src);
                    if ($src) return $src;
                    break;
                case "image/gif":
                    @$src = imagecreatefromgif($src);
                    if ($src) return $src;
                    break;
                case "image/png":
                    @$src = imagecreatefrompng($src);
                    if ($src) return $src;
                    break;
            }
        }
        
        return false;
    }

    /**
     * Redimensiona a proporcion una imagen para que entre en otra imagen mas pequeña (ya sea solo de altura o anchura)
     * @param resource $src Fuente de la imagen original cargada en "doResize"
     * @param numeric $originaWidth Widht de la imagen original
     * @param numeric $originalHeight Height de la imagen original
     * @param numeric $newWidth Anchura maxima de la nueva imagen
     * @param numeric $newHeight Altura maxima de la nueva imagen
     */
    static function resizeToFit($src, &$originalWidth, &$originalHeight, $newWidth, $newHeight) {
        $currentWidth = $originalWidth;
        $currentHeight = $originalHeight;

        /* if ($currentWidth < $currentHeight) {
          $currentHeight = ($newWidth / $currentWidth) * $currentHeight;
          } elseif ($currentWidth > $currentHeight) {
          $currentWidth = ($newHeight / $currentHeight) * $currentWidth;
          } */

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

}
