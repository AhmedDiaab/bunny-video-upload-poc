<?php

namespace App\Services\Bunny;

use Illuminate\Http\Client\Response;

class BunnyUploader
{

    protected $BaseURL;
    protected $BunnyCDN;
    protected $ApiKey;
    protected $VideoLibraryId;
    protected $headers;
    public function __construct()
    {
        $this->BaseURL = env("BUNNY_BASE_URL");
        $this->BunnyCDN = env("BUNNY_CDN_URL");
        $this->ApiKey = env('BUNNY_VIDEO_API_KEY');
        $this->VideoLibraryId = env("BUNNY_DEFAULT_VIDEO_LIBRARY_ID");
        $this->headers = [
            'AccessKey' => "{$this->ApiKey}",
            'Accept' => 'application/json'
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
     * Returns response body if successful
     * or throws BadRequest if fails
     */
    protected function __handleResponse(Response $response)
    {
        // Check if the response was successful
        if ($response->successful()) return $response->json();

        // Handle the error case
        return [
            'success' => false,
            'message' => 'Failed to create resource',
            'status' => $response->status(),
            'error' => $response->json(),
        ];
    }
}
