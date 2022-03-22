<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\ImageUploadRepositoryContract;

class ImageUploadService
{
    protected $imageUploadRepositoryContract;

    public function __construct(ImageUploadRepositoryContract $imageUploadRepositoryContract)
    {
        $this->imageUploadRepositoryContract = $imageUploadRepositoryContract;
    }

    public function saveUpload($file)
    {
        return $this->imageUploadRepositoryContract->saveUpload($file);
    }
}