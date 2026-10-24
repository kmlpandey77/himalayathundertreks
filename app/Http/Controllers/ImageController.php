<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Smart\Services\Image\ImageService;

/**
 * Class ImageController
 * @package App\Http\Controllers\Web\Image
 */
class ImageController extends Controller
{
    /**
     * @var ImageService
     */
    protected $image;

    /**
     * ImageController constructor.
     *
     * @param ImageService $image
     */
    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }

    /**
     * Return Image with given resolution
     *
     * @param string $type
     * @param string $resolution
     * @param string $imageName
     *
     * @return mixed
     */
    public function index($type, $resolution, $imageName)
    {
        $imagePath = sprintf('%s/%s/%s', public_path('uploads'), $type, $imageName);

        return $this->image->generate($imagePath, $resolution, $imageName);
    }
}

