<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\Bunny\BunnyVideo\BunnyVideoMetadataManager;
use Illuminate\Routing\Controller as BaseController;


class VideoUploadController extends BaseController
{

    public function __construct(private BunnyVideoMetadataManager $videoMetadataManager)
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
            return $this->videoMetadataManager->GeneratePresignedUrl($library_reference, $library_api_key, $expiration, $video['reference_id']);
        } catch (\Throwable | \Exception $e) {
            return $e;
        }
    }
}
