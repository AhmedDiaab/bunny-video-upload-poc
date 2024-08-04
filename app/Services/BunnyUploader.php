<?php

namespace App\Services;

use App\Http\Requests\Bunny\BaseResponse;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Bunny\VideoLibraryResponse;
use App\Http\Requests\Bunny\VideoCollectionResponse;
use App\Http\Requests\Bunny\Video\CreateVideo;
use App\Http\Requests\Bunny\UpdateVideo;
use App\Http\Requests\Bunny\VideoCaption;
use App\Http\Requests\Bunny\VideoResponse;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;

class BunnyUploader
{

    private $BaseURL = "https://api.bunny.net";
    private $ApiKey;
    private $VideoLibraryId;
    private $headers;
    public function __construct()
    {
        $this->ApiKey = env('BUNNY_VIDEO_API_KEY');
        $this->VideoLibraryId = env("BUNNY_VIDEO_LIBRARY_ID");
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
        $payload = [
            'Name' => $name
        ];
        $response = Http::withHeaders($this->headers)->post($url, $payload);
        return $this->__handleResponse($response);
    }

    /**
     * List video libraries
     * @return VideoLibraryResponse[]
     */
    public function ListVideoLibraries()
    {
        $url = "{$this->BaseURL}/videolibrary";
        $response = Http::withHeaders($this->headers)->get($url);
        return $this->__handleResponse($response);
    }

    /**
     * Get video library
     * @return VideoLibraryResponse
     */
    public function GetVideoLibrary(int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$id}";
        $response = Http::withHeaders($this->headers)->get($url);
        return $this->__handleResponse($response);
    }

    /**
     * Update video library 
     * accepts VideoLibraryResponse
     * @return VideoLibraryResponse
     */
    public function UpdateVideoLibrary(int $id, $payload)
    {
        $url = "{$this->BaseURL}/videolibrary/{$id}";
        $this->headers['content-type'] = "application/json";
        $response = Http::withHeaders($this->headers)->post($url, $payload);
        return $this->__handleResponse($response);
    }

    /**
     * Delete video library
     * @return VideoLibraryResponse
     */
    public function DeleteVideoLibrary(int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$id}";
        $response = Http::withHeaders($this->headers)->delete($url);
        return $this->__handleResponse($response);
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
        $payload = [
            'Name' => $name
        ];
        return Http::withHeaders($this->headers)->post($url, $payload);
    }

    /**
     * List video collection
     * @return VideoCollectionResponse[]
     */
    public function ListVideoCollections(int $libraryId)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections";
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Get video collection
     * @return VideoCollectionResponse
     */
    public function GetVideoCollection(int $libraryId, int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections/{$id}";
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Update video collection
     * @return VideoCollectionResponse
     */
    public function UpdateVideoCollection(int $libraryId, int $id, string $name)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections/{$id}";
        $this->headers['content-type'] = "application/json";
        $payload = [
            'Name' => $name
        ];
        return Http::withHeaders($this->headers)->post($url, $payload);
    }

    /**
     * Delete video collection
     * @return VideoCollectionResponse
     */
    public function DeleteVideoCollection(int $libraryId, int $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/collections/{$id}";
        return Http::withHeaders($this->headers)->delete($url);
    }


    /*----------------------------------------------------------------------------*/

    /**
     * Video
     */

    /**
     * Create video
     * return VideoResponse
     */
    public function CreateVideo(CreateVideo $payload, string $libraryId = null)
    {
        if (!$libraryId) $libraryId = $this->VideoLibraryId;
        $url = "{$this->BaseURL}/library/{$libraryId}/videos";
        $this->headers['Content-Type'] = "application/json";
        $response = Http::withHeaders($this->headers)->post($url, $payload);
        if ($response->successful()) return $response->json();
        return $response->json();
    }

    /**
     * List videos
     * @return VideoResponse[]
     */
    public function ListVideos(int $libraryId)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/videos";
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Get video
     * @return VideoResponse
     */
    public function GetVideo(int $libraryId, string $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/videos/{$id}";
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Update video
     * @return VideoResponse
     */
    public function UpdateVideo(int $libraryId, string $id, UpdateVideo $payload)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/videos/{$id}";
        $this->headers['content-type'] = "application/json";
        return Http::withHeaders($this->headers)->post($url, $payload);
    }

    /**
     * Delete video collection
     * @return VideoCollectionResponse
     */
    public function DeleteVideo(int $libraryId, string $id)
    {
        $url = "{$this->BaseURL}/videolibrary/{$libraryId}/videos/{$id}";
        return Http::withHeaders($this->headers)->delete($url);
    }

    /**
     * Set thumbnail to video
     * requires thumbnail url to be passed as a query parameter
     * @return BaseResponse
     */
    public function SetThumbnail(int $libraryId, string $id, string $thumbnailUrl)
    {
        $url = "{$this->BaseURL}/library/{$libraryId}/videos/{$id}/thumbnail?thumbnailUrl={$thumbnailUrl}";
        return Http::withHeaders($this->headers)->post($url);
    }

    /**
     * Add caption to video
     * requires payload and language
     * @return BaseResponse
     */
    public function AddCaption(int $libraryId, string $id, string $lang, VideoCaption $payload)
    {
        $url = "{$this->BaseURL}/library/{$libraryId}/videos/{$id}/captions/{$lang}";
        $this->headers['content-type'] = "application/json";
        return Http::withHeaders($this->headers)->post($url, $payload);
    }


    /**
     * Delete caption for video
     * requires language
     * @return BaseResponse
     */
    public function RemoveCaption(int $libraryId, string $id, string $lang)
    {
        $url = "{$this->BaseURL}/library/{$libraryId}/videos/{$id}/captions/{$lang}";
        return Http::delete($url, [
            'headers' => $this->headers
        ]);
    }


    /**
     * Generate url to be used for uploading file from client side
     */
    function GeneratePresignedUrl(int $libraryId, int $expiresInInMS, string $videoId)
    {
        // Endpoint for the Bunny.net Tus uploads
        $url = "https://video.bunnycdn.com/tusupload";

        // get timestamp for future time
        $timestamp = Carbon::now()->timestamp + $expiresInInMS;

        // generate authorization signature
        $signature = $this->__generatePresignedSignature($libraryId, $timestamp, $videoId);

        // Prepare headers
        $headers = [
            'AuthorizationSignature' => $signature,
            'AuthorizationExpire' => $timestamp,
            'VideoId' => $videoId,
            'LibraryId' => $libraryId
        ];


        return json_encode([
            'url' => $url,
            'headers' => $headers
        ]);
    }

    /**
     * Generates signature for presigned url 
     */
    private function __generatePresignedSignature(int $libraryId, int $expiresIn, string $videoId)
    {
        $phrase = $libraryId . $this->ApiKey . $expiresIn . $videoId;
        return hash('sha256', $phrase);
    }

    /*----------------------------------------------------------------------------*/

    /**
     * Utility functions
     * 
     */

    /**
     * Returns response body if successful
     * or throws BadRequest if fails
     */
    private function __handleResponse(Response $response)
    {
        // Check if the response was successful
        if ($response->successful()) return $response->json();

        // Handle the error case
        return [
            'success' => false,
            'message' => 'Failed to create video library',
            'status' => $response->status(),
            'error' => $response->json(),
        ];
    }
}
