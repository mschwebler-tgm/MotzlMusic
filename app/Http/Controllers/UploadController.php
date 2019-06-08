<?php

namespace App\Http\Controllers;

use App\Components\Upload\SingleUploadRequest;
use App\Components\Upload\UploadService;

class UploadController extends Controller
{
    public function uploadTrack(SingleUploadRequest $request, UploadService $uploadService)
    {
        $uploadService->storeFromRequest($request);
//        $a = $mp3File->store(apiUser()->mp3StoragePath());
        return response(null, 200);
    }
}
