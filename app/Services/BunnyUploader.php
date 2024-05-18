<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\Bunny\VideoLibraryResponse;
use App\Http\Requests\Bunny\VideoCollectionResponse;



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
     * @return VideoLibraryResponse
     */
    public function CreateVideoLibrary(string $name)
    {
        $url = "{$this->BaseURL}/videolibrary";
        $this->headers['content-type'] = "application/json";
        return Http::post($url, [
            'body' => `{"Name": $name}`,
            'headers' => $this->headers
        ]);
    }

    /**
     * List video libraries
     * @return VideoLibraryResponse[]
     */
    public function ListVideoLibraries()
    {
        $url = "{$this->BaseURL}/videolibrary";
        return Http::get($url, [
            'headers' => $this->headers
        ]);
    }

    /**
     * Get video library
     * @return VideoLibraryResponse
     */
    public function GetVideoLibrary(int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$id}";
        return Http::get($url, [
            'headers' => $this->headers
        ]);
    }

    /**
     * Update video library
     * @return VideoLibraryResponse
     */
    public function UpdateVideoLibrary(int $id, VideoLibraryResponse $payload)
    {
        $url = "{$this->BaseURL}/videolibrary/{$id}";
        $this->headers['content-type'] = "application/json";
        return Http::post($url, [
            'body' => $payload,
            'headers' => $this->headers
        ]);
    }

    /**
     * Delete video library
     * @return VideoLibraryResponse
     */
    public function DeleteVideoLibrary(int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$id}";
        return Http::delete($url, [
            'headers' => $this->headers
        ]);
    }

    /*----------------------------------------------------------------------------*/


    /**
     * Video Collection
     */

    /**
     * Create video collection
     * @return VideoCollectionResponse
     */
    public function CreateVideoCollection(int $libraryId, string $name)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections";
        $this->headers['content-type'] = "application/json";
        return Http::post($url, [
            'body' => `{"name": $name}`,
            'headers' => $this->headers
        ]);
    }

    /**
     * List video collection
     * @return VideoCollectionResponse[]
     */
    public function ListVideoCollections(int $libraryId)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections";
        return Http::get($url, [
            'headers' => $this->headers
        ]);
    }

    /**
     * Get video collection
     * @return VideoCollectionResponse
     */
    public function GetVideoCollection(int $libraryId, int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections/{$id}";
        return Http::get($url, [
            'headers' => $this->headers
        ]);
    }

    /**
     * Update video collection
     * @return VideoCollectionResponse
     */
    public function UpdateVideoCollection(int $libraryId, int $id, string $name)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections/{$id}";
        $this->headers['content-type'] = "application/json";
        return Http::post($url, [
            'body' => `{"name": $name}`,
            'headers' => $this->headers
        ]);
    }

    /**
     * Delete video collection
     * @return VideoCollectionResponse
     */
    public function DeleteVideoCollection(int $libraryId, int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections/{$id}";
        return Http::delete($url, [
            'headers' => $this->headers
        ]);
    }


    /*----------------------------------------------------------------------------*/



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
