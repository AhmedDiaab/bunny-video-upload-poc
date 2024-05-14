<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;


class BunnyUploader
{

    private $BaseURL = "https://video.bunnycdn.com";
    private $ApiKey = env('BUNNY_API_KEY');
    private $VideoLibraryId = env("BUNNY_VIDEO_LIBRARY_ID");
    public function __construct()
    {
    }

    public function UploadVideo(string $name) {
        $url = "{$this->BaseURL}/library/{$this->VideoLibraryId}/videos/{$name}";
        return Http::put($url, [
            'headers' => [
                'AccessKey' => $this->ApiKey,
                'accept' => 'application/json',
            ]
        ]);
    }
}
