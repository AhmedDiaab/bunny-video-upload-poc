<?php

namespace App\Services;

use App\Http\Requests\Bunny\Video\CreateVideo;

class PublicFileService
{

    public function __construct(private BunnyUploader $BunnyUploader)
    {
    }

    /**
     * Send video file name and gets a url to upload video to
     */
    public  function GetUploadUrl(string $name)
    {
        $payload   = new CreateVideo();
        $payload->title = $name;
        $video = $this->BunnyUploader->CreateVideo($payload);
        return 'success';
        // return $this->BunnyUploader->GeneratePresignedUrl(248503, 1000 * 60 * 60, $video->guid);
    }
}
