<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bunny\Video\CreateVideo;
use App\Models\Video;
use Illuminate\Routing\Controller as BaseController;
use App\Services\BunnyUploader\BunnyUploader;

class VideoUploadController extends BaseController
{

    public function __construct(private BunnyUploader $uploader)
    {
    }

    public function GetUploadUrl(int $id)
    {
        try {
            // validate request
            $video = Video::where('id', $id)->first();
            $video->load(['library', 'collection']);
            $expiration = 1000 * 60 * 60; // 1 hour
            $library_reference = $video['library']['reference_id'];
            $library_api_key = $video['library']['api_key'];
            return $this->uploader->GeneratePresignedUrl($library_reference, $library_api_key, $expiration, $video['reference_id']);
        } catch (\Throwable | \Exception $e) {
            return $e;
        }
    }
}
