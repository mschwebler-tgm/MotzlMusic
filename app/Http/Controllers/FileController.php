<?php

namespace App\Http\Controllers;

use App\Components\Upload\SingleUploadRequest;
use App\Components\Upload\UploadService;

class FileController extends Controller
{
    public function uploadTrack(SingleUploadRequest $request, UploadService $uploadService)
    {
        $uploadService->storeFromRequest($request);
        return response(null, 200);
    }

    public function getTrackFile(SingleUploadRequest $request, UploadService $uploadService)
    {
        // TODO
    }
}
