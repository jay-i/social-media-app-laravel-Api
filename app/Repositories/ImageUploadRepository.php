<?php

namespace App\Repositories;

use App\Repositories\Contracts\ImageUploadRepositoryContract;
use App\Models\UserFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ImageUploadRepository implements ImageUploadRepositoryContract 
{
    public function saveUpload($file)
    {
        try {
            $newFile = new UserFile();
            $newFile->file_name = url(Storage::url($file));
            $newFile->user_id = auth()->user()->id;
            $newFile->save();

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}