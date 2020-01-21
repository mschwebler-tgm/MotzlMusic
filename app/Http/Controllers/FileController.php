<?php

namespace App\Http\Controllers;

use App\Service\GenericDaos\TrackDao;
use App\Components\Upload\SingleUploadRequest;
use App\Components\Upload\UploadService;
use App\User;
use Auth;
use File;

class FileController extends Controller
{
    const PATH_TRACK_FILE = 'trackFiles';

    public function uploadTrack(SingleUploadRequest $request, UploadService $uploadService)
    {
        $uploadService->storeFromRequest($request, $this->getUser());

        return response(null, 200);
    }

    public function getTrackFile(TrackDao $trackDao, $id)
    {
        $user = $this->getUser();
        $track = $trackDao->getForUser($id, $user);

        return File::get(storage_path('app/' . $track->local_path));
    }

    private function getUser(): User
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Not authorized');
        }

        return $user;
    }
}
