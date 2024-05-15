<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\Bunny\CreateCollectionResponse;


class BunnyUploader
{

    private $BaseURL = "https://video.bunnycdn.com";
    private $ApiKey;
    private $VideoLibraryId;
    private $headers;
    public function __construct()
    {
        $this->ApiKey = env('BUNNY_VIDEO_API_KEY');
        $this->VideoLibraryId = env("BUNNY_VIDEO_LIBRARY_ID");
        $this->headers = [
            'AccessKey' => "{$this->ApiKey}",
            'accept' => 'application/json'
        ];
    }

    /**
     * How to get upload links for bunny
     * 1. Create video library
     * 2. Create video collection
     * 3. Create video
     * 4. Add video thumbnail
     * 5. Add captions
     * 6. Generate presigned upload url for uploading video from end user side
     */

    /**
     * Video library
     */

    /**
     * Create video library
     * @return CreateCollectionResponse
     */
    public function CreateVideoLibrary(string $name)
    {
        $url = "{$this->BaseURL}/videolibrary";
        $this->headers['content-type'] = "application/json";
        return Http::post($url, [
            'body' => `{"Name": {$name}}`,
            'headers' => $this->headers
        ]);
    }

    public function ListVideoLibraries()
    {
    }

    public function UpdateVideoLibrary()
    {
    }

    public function DeleteVideoLibrary()
    {
    }

    public function UploadVideo(string $name)
    {
        $url = "{$this->BaseURL}/library/{$this->VideoLibraryId}/videos/{$name}";
        return Http::put($url, [
            'headers' => [
                'AccessKey' => "{$this->ApiKey}",
                'accept' => 'application/json',
            ]
        ]);
    }
}
