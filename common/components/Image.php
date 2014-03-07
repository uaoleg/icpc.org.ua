<?php

namespace common\components;

class Image extends \CApplicationComponent
{

    /**
     * Initializes the application component
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Copy one image from another
     *
     * @param string $newPath
     * @param string $srcPath
     * @param type $newImg
     * @param int $newX
     * @param int $newY
     * @param int $srcX
     * @param int $srcY
     * @param int $newWidth
     * @param int $newHeight
     * @param int $srcWidth
     * @param int $srcHeight
     * @param int $quality
     * @return bool
     */
    public function copy($newPath, $srcPath, $newImg, $newX, $newY, $srcX, $srcY, $newWidth, $newHeight, $srcWidth, $srcHeight, $quality = null)
    {
        switch (mb_strtolower(mb_substr(mb_strrchr($newPath, '.'), 1))) {
            default:
            case 'jpg':
            case 'jpeg':
                $writeImage = 'imagejpeg';
                $imageQuality = $quality ? $quality : 75;
                break;
            case 'gif':
                $writeImage = 'imagegif';
                $imageQuality = null;
                break;
            case 'png':
                $writeImage = 'imagepng';
                $imageQuality = $quality ? $quality : 9;
                break;
        }

        switch (mb_strtolower(mb_substr(mb_strrchr($srcPath, '.'), 1))) {
            default:
            case 'jpg':
            case 'jpeg':
                $srcImg = imagecreatefromjpeg($srcPath);
                break;
            case 'gif':
                imagecolortransparent($newImg, imagecolorallocate($newImg, 0, 0, 0));
                $srcImg = imagecreatefromgif($srcPath);
                break;
            case 'png':
                imagecolortransparent($newImg, imagecolorallocate($newImg, 0, 0, 0));
                imagealphablending($newImg, false);
                imagesavealpha($newImg, true);
                $srcImg = imagecreatefrompng($srcPath);
                break;
        }

        $success = $srcImg && imagecopyresampled(
            $newImg,
            $srcImg,
            $newX,
            $newY,
            $srcX,
            $srcY,
            $newWidth,
            $newHeight,
            $srcWidth,
            $srcHeight
        ) && $writeImage($newImg, $newPath, $imageQuality);

        // Free up memory (imagedestroy does not delete files):
        imagedestroy($srcImg);
        imagedestroy($newImg);

        return $success;
    }

    /**
     * Scale image
     *
     * @param string $srcPath
     * @param string $newPath
     * @param array $options
     *  - max_width     required
     *  - max_height    required
     *  - min_width     optional, default = max_width
     *  - min_height    optional, default = min_width
     *  - scale_larger  optional, default = false
     * @return bool
     */
    public function scale($srcPath, $newPath, array $options = array())
    {
        // Set default options
        if (!isset($options['min_width'])) {
            $options['min_width'] = $options['max_width'];
        }
        if (!isset($options['min_height'])) {
            $options['min_height'] = $options['max_height'];
        }
        if (!isset($options['scale_larger'])) {
            $options['scale_larger'] = false;
        }

        // Get source sizes
        list($imgWidth, $imgHeight) = getimagesize($srcPath);
        if ((!$imgWidth) || (!$imgHeight)) {
            return false;
        }

        // Create new image
        $scaleMax = min(
            $options['max_width'] / $imgWidth,
            $options['max_height'] / $imgHeight
        );
        $scaleMin = max(
            $options['min_width'] / $imgWidth,
            $options['min_height'] / $imgHeight
        );
        if ($scaleMax < 1) {
            $newWidth = $imgWidth * $scaleMax;
            $newHeight = $imgHeight * $scaleMax;
        } elseif (($scaleMax >= 1) && ($scaleMin < 1)) {
            $newWidth = $imgWidth;
            $newHeight = $imgHeight;
        } else {
            $newWidth = $imgWidth * $scaleMin;
            $newHeight = $imgHeight * $scaleMin;
        }
        $newImg = imagecreatetruecolor($newWidth, $newHeight);
        $newImgBgColor = imagecolorallocate($newImg, 255, 255, 255);
        imagefill($newImg, 0, 0, $newImgBgColor);

        // New image is smaller
        if (($scaleMax < 1) || ($options['scale_larger'])) {
            return $this->copy($newPath, $srcPath, $newImg, 0, 0, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight);
        }

        // New image is larger: add white background and center the source image
        else {
            $newX = ($newWidth - $imgWidth) / 2;
            $newY = ($newHeight - $imgHeight) / 2;
            $this->copy($newPath, $srcPath, $newImg, $newX, $newY, 0, 0, $imgWidth, $imgHeight, $imgWidth, $imgHeight);
        }
    }

    /**
     * Scale image
     *
     * @param string $srcPath
     * @param string $newPath
     * @param array $options
     * @return bool
     */
    public function crop($srcPath, $newPath, array $options = array())
    {
        // Get source sizes
        list($imgWidth, $imgHeight) = getimagesize($srcPath);
        if ((!$imgWidth) || (!$imgHeight)) {
            return false;
        }

        // Set default params
        if ((!isset($options['width'])) || (!isset($options['height']))) {
            $minAngle = min($imgWidth, $imgHeight);
            $options['width'] = $minAngle;
            $options['height'] = $minAngle;
        }

        // Create new image
        $newWidth  = $options['width'];
        $newHeight = $options['height'];
        $newX      = isset($options['left']) ? $options['left'] : round(($imgWidth - $newWidth) / 2);
        $newY      = isset($options['top']) ? $options['top'] : round(($imgHeight - $newHeight) / 2);
        $newImg    = imagecreatetruecolor($newWidth, $newHeight);

        return $this->copy($newPath, $srcPath, $newImg, 0, 0, $newX, $newY, $newWidth, $newHeight, $newWidth, $newHeight);
    }

    /**
     * Create watermark image
     *
     * @param string $text
     * @param array  $options
     *  - font_size
     * @return resource
     */
    public function watermark($text, array $options = array())
    {
        // Set default options
        if (!isset($options['font_size'])) {
            $options['font_size'] = 15;
        }

        // Set font name, size and angle
        $fontName   = __DIR__ . '/fonts/arial.ttf';
        $fontSize   = $options['font_size'];
        $fontAngle  = 0;

        // Set width and height
        $bbox = imagettfbbox($fontSize, $fontAngle, $fontName, $text);
        $width = $bbox[2] - $bbox[0] + 5;
        $height = $bbox[1] - $bbox[7];

        // Create the image
        $watermark = imagecreatetruecolor($width, $height);
        imagesavealpha($watermark, true);

        // Make image transparent
        $colorBlack = imagecolorallocate($watermark, 0, 0, 0);
        imagefilledrectangle($watermark, 0, 0, 150, 25, $colorBlack);
        $transColor = imagecolorallocatealpha($watermark, 0, 0, 0, 127);
        imagefill($watermark, 0, 0, $transColor);

        // Set font colors
        $fontColor  = imagecolorallocate($watermark, 50, 50, 255);
        $fontShadow = imagecolorallocate($watermark, 0, 0, 0);

        // Add some shadow to the text
        imagettftext($watermark, $fontSize, $fontAngle, 1, $fontSize + 1, $fontShadow, $fontName, $text);

        // Add the text
        imagettftext($watermark, $fontSize, $fontAngle, 0, $fontSize, $fontColor, $fontName, $text);

        // Return watermark image
        return $watermark;
    }

    /**
     * Renders video viewer watermark
     *
     * @param string $customerName
     * @return resource
     */
    public function watermarkVideoViewer($customerName)
    {
        // Create logo
        $logo = imagecreatefrompng(__DIR__ . '/images/logo.png');

        // Create watermark
        $watermark = $this->watermark($customerName);

        // Create the image
        $width = imagesx($logo) > imagesx($watermark) ? imagesx($logo) : imagesx($watermark);
        $height = imagesy($logo) + imagesy($watermark) + 5;
        $image = imagecreatetruecolor($width, $height);
        imagesavealpha($image, true);

        // Make image transparent
        $colorBlack = imagecolorallocate($image, 0, 0, 0);
        imagefilledrectangle($image, 0, 0, 150, 25, $colorBlack);
        $transColor = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $transColor);

        // Copy logo on the image
        imagecopyresampled(
            $image,
            $logo,
            2,
            0,
            0,
            0,
            imagesx($logo),
            imagesy($logo),
            imagesx($logo),
            imagesy($logo)
        );

        // Copy customer name on the image
        imagecopyresampled(
            $image,
            $watermark,
            0,
            imagesy($logo) + 5,
            0,
            0,
            imagesx($watermark),
            imagesy($watermark),
            imagesx($watermark),
            imagesy($watermark)
        );

        // Return image
        return $image;
    }

    /**
     * Put watermark on image
     *
     * @param string $srcPath
     * @param resource $watermark
     * @param string $align "bottomleft", "centercenter", "topright"
     * @param int $margin
     */
    public function watermarkPutOnImage($srcPath, $watermark, $align, $margin = 0)
    {
        // Load the watermark and the image to apply the watermark to
        switch (mb_strtolower(mb_substr(mb_strrchr($srcPath, '.'), 1))) {
            default:
            case 'jpg':
            case 'jpeg':
                 $image = imagecreatefromjpeg($srcPath);
                break;
            case 'gif':
                 $image = imagecreatefromgif($srcPath);
                break;
            case 'png':
                 $image = imagecreatefrompng($srcPath);
                break;
        }

        // Define watermark size
        $width  = imagesx($watermark);
        $height = imagesy($watermark);
        switch ($align) {
            default:
            case 'bottomleft':
                $top    = imagesy($image) - $height - $margin;
                $left   = $margin;
                break;
            case 'centercenter':
                $top    = ((imagesy($image) - $height) / 2) - $margin;
                $left   = ((imagesx($image) - $width) / 2) - $margin;
                break;
            case 'topright':
                $top    = $margin;
                $left   = imagesx($image) - $width - $margin;
                break;
        }

        // Scale watermark
        $maxWidth = imagesx($image) - (2 * $margin);
        if ($width > $maxWidth) {
            $height *= ($maxWidth / $width);
            $width = $maxWidth;
        }

        // Copy the watermark image onto our image
        imagecopyresampled(
            $image,
            $watermark,
            $left,
            $top,
            0,
            0,
            $width,
            $height,
            imagesx($watermark),
            imagesy($watermark)
        );

        // Save and free memory
        imagepng($image, $srcPath);
        imagedestroy($watermark);
        imagedestroy($image);
    }

}