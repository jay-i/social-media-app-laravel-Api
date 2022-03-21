<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserImageUploadRequest;

class UserImageController extends Controller
{
    public function store(UserImageUploadRequest $request)
    {
        dd('hi');
    }
}
