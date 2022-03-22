<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\ImageUploadService;
use App\Http\Requests\UserImageUploadRequest;
use Illuminate\Support\Facades\Storage;

class UserImageController extends Controller
{
    protected $imageUploadService;
    protected $responseHelper;

    public function __construct(ImageUploadService $imageUploadService, ResponseHelper $responseHelper)
    {
        $this->imageUploadService = $imageUploadService;
        $this->responseHelper = $responseHelper;
    }

    public function store(UserImageUploadRequest $request)
    {
        $file = $request->file->storeAs(
            'public/images/' . auth()->user()->id, $request->file->getClientOriginalName()
        
        );

        $this->imageUploadService->saveUpload($file);
        
        return $this->responseHelper->successResponse(true, 'Image Uploaded', null);
    }
}
