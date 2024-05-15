<?php
namespace App\Services;

class PublicFileService
{

    public function __construct(private BunnyUploader $BunnyUploader)
    {
    }

    /**
     * Send video file name and gets a url to upload video to
     */
    public function GetUploadUrl(string $name){
        return $this->BunnyUploader->UploadVideo($name);
    }
}
