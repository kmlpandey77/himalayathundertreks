<?php
namespace App\Smart\Services\Image;

/**
 * Class ValidatesResolution
 * @package App\Smart\Services\Image
 */
trait ValidatesResolution
{
    /**
     * @var array
     */
    protected $allowedDimensions = [
        [1600, 550],
        [400, 300],
        [300, 400],
        [540, 400],
        [540, 530],
        [100, 80],
        [300, 300],
        [255, 255],
        // Hero slides (config/image.php "slide" / "trip_slide") and their mobile sizes
        [1600, 650],
        [800, 325],
        [1600, 600],
        [800, 300],
    ];

    /**
     * Is valid image resolution.
     *
     * @param string $resolution
     *
     * @return bool
     */
    protected function isValidResolution($resolution)
    {
        if ($this->allowedDimensions == '*') {
            return true;
        }

        if (strpos($resolution, 'x') === false) {
            return false;
        }

        list($width, $height) = $this->extractDimensions($resolution);

        if (!is_numeric($width) || !is_numeric($height)) {
            return false;
        }

        return $this->isAllowedDimensions($width, $height);
    }

    /**
     * Check for valid image dimension.
     *
     * @param int $width
     * @param int $height
     *
     * @return array
     */
    protected function isAllowedDimensions($width, $height)
    {
        return in_array([$width, $height], $this->allowedDimensions);
    }

    /**
     * Get Image Size
     *
     * @param string $size
     *
     * @return array
     */
    protected function extractDimensions($size)
    {
        list($width, $height) = explode('x', $size);

        return [(int) $width, (int) $height];
    }
}
