<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bunny\Video\CreateVideo;
use App\Http\Requests\GetUploadUrlRequest;
use App\Models\Video;
use Illuminate\Routing\Controller as BaseController;
use App\Services\BunnyUploader;

class VideoUploadController extends BaseController
{

    public function __construct(private BunnyUploader $uploader)
    {
    }

    public function GetUploadUrl(Video $video, GetUploadUrlRequest $request)
    {
        try {
            // validate request
            $validated = $request->validated();

            $payload   = new CreateVideo();
            $payload->title = $validated['name'];
            $video = $this->uploader->CreateVideo($payload);
            $uuid = $video['guid'];
            $libraryId = $video['videoLibraryId'];
            $expiration = 1000 * 60 * 60; // 1 hour
            return $this->uploader->GeneratePresignedUrl($libraryId, $expiration, $uuid);
        } catch (\Throwable | \Exception $e) {
            return $e;
        }
    }
}
