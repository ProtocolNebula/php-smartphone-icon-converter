<?php
class Thumbs {

    private $imagePath;
    private $info_image;
    private $resource;
            
    function __construct($pathImage) {
        $this->setImage($pathImage);
    }
    
    function __destruct() {
        $this->destroyResource();
    }
    
    function destroyResource() {
        if ($this->resource) {
            imagedestroy($this->resource);
        }
    }

    /**
     * Change the current image to transform
     * @param type $path
     * @throws Exception
     */
    function setImage($path) {
        
        $this->destroyResource();
        
        if (!is_file($path)) { throw new Exception('The file ' . $path . ' no exist', 0); }
        $this->imagePath = $path;
        
        $this->info_image = getimagesize($path);
        if (!$this->info_image) { throw new Exception('The uploaded file is not an image', 1); }
        
        $this->resource = $this->createSrcFromImage();
        if (!$this->resource) { throw new Exception('The uploaded file is not an image', 2); }
        
    }

    /**
     * Redimensiona una imagen
     * @param string $dst Destination file
     * @param numeric $width New width
     * @param numeric $height New height
     * @param string $bgColor Background color (transparent, white)
     */
    function doResize($dst, $width, $height, $bgColor = 'transparent') {
        // Obtener los nuevos tamaños
        if (!$this->resource) {
            return false;
        } 
        
        list ($originalWidth, $originalHeight) = $this->info_image;
        
        $resource = $this->resizeToFit($this->resource, $originalWidth, $originalHeight, $width, $height);
        
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
    }

    
    function createSrcFromImage() {
        switch ($this->info_image['mime']) {
            case "image/jpeg":
                @$src = imagecreatefromjpeg($this->imagePath);
                if ($src) return $src;
                break;
            case "image/gif":
                @$src = imagecreatefromgif($this->imagePath);
                if ($src) return $src;
                break;
            case "image/png":
                @$src = imagecreatefrompng($this->imagePath);
                if ($src) return $src;
                break;
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
    function resizeToFit($src, &$originalWidth, &$originalHeight, $newWidth, $newHeight) {
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
            $currentWidth = ($newHeight / $currentHeight) * $currentWidth;
            $currentHeight = $newHeight;
        }

        // Preparamos la base de la imagen redimensionada
        $new = imagecreatetruecolor($currentWidth, $currentHeight);
        $bgColor = imagecolorallocatealpha($new, 0, 0, 0, 127);
        imagesavealpha($new, true);
        imagefill($new, 0, 0, $bgColor);
        imagealphablending($new, true);

        // Redimensionamos
        imagecopyresampled($new, $src, 0, 0, 0, 0, $currentWidth, $currentHeight, $originalWidth, $originalHeight);

        // Actualizamos los datos que tiene que recibir la funcion que lo ha llamado
        $originalWidth = round($currentWidth);
        $originalHeight = round($currentHeight);

        return $new;
    }

}
