<?php
namespace App\Smart\Services\Image;

/**
 * Class ImageService
 * @package App\Smart\Services
 */
class ImageService
{
    use ValidatesResolution;

    /**
     * Default Image to show for non existing images
     *
     * @var string
     */
    protected $defaultImage;

    /**
     * @var ImageMaker
     */
    protected $imageMaker;

    /**
     * ImageService constructor.
     *
     * @param ImageMaker $imageMaker
     *
     * @internal param Image $image
     */
    public function __construct(ImageMaker $imageMaker)
    {
        $this->imageMaker   = $imageMaker;
        $this->defaultImage = public_path('images/no-image.png');
    }

    /**
     * Generate and save image.
     *
     * @param string $imagePath
     * @param string $resolution
     * @param string $imageName
     *
     * @return mixed|null
     */
    public function generate($imagePath, $resolution, $imageName)
    {
        // "photo.jpeg.webp" is a WebP rendition of "photo.jpeg".
        $format = null;
        if (!$this->exists($imagePath) && substr($imageName, -5) === '.webp') {
            $imagePath = substr($imagePath, 0, -5);
            $format = ImageFormat::Webp;
        }

        if (!$this->exists($imagePath) || !$this->isValidResolution($resolution)) {
            abort(404);
        }
        $thumbnailFolder = sprintf('%s/%s', $this->getParentDirectory($imagePath), $resolution);
        list($width, $height) = $this->extractDimensions($resolution);

        if ($format === ImageFormat::Webp) {
            return $this->imageMaker->load($imagePath)
                                    ->fit($width, $height)
                                    ->save($thumbnailFolder, $imageName, ImageMaker::WEBP_QUALITY)
                                    ->give($format);
        }

        return $this->imageMaker->load($imagePath)
                                ->thumbnail($width, $height)
                                ->save($thumbnailFolder, $imageName)
                                ->give();
    }

    /**
     * Check if the file exists
     *
     * @param string $file
     *
     * @return bool
     */
    protected function exists($file)
    {
        return file_exists($file);
    }

    /**
     * Get the parent directory of the given path
     *
     * @param string $path
     *
     * @return string
     */
    protected function getParentDirectory($path)
    {
        return dirname($path);
    }
}
