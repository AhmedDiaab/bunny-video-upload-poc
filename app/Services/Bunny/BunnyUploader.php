<?php

namespace App\Services\Bunny;

use App\Http\Requests\Bunny\BaseResponse;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Bunny\VideoCollectionResponse;
use App\Http\Requests\Bunny\Video\CreateVideo;
use App\Http\Requests\Bunny\Video\UpdateVideo;
use App\Http\Requests\Bunny\VideoCaption;
use App\Http\Requests\Bunny\VideoResponse;
use Carbon\Carbon;
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

    

    /*----------------------------------------------------------------------------*/

    /**
     * Video
     */

    /**
     * Create video
     * @return VideoResponse
     */
    public function CreateVideo(int $libraryId, string $libraryApiKey, CreateVideo $payload)
    {
        if (!$libraryId) $libraryId = $this->VideoLibraryId;
        $url = "{$this->BunnyCDN}/library/{$libraryId}/videos";
        $this->headers['Content-Type'] = "application/json";
        $this->headers['AccessKey'] = $libraryApiKey;
        $response = Http::withHeaders($this->headers)->post($url, $payload);
        if ($response->successful()) return $response->json();
        return $response->json();
    }

    /**
     * List videos
     * @return VideoResponse[]
     */
    public function ListVideos(int $libraryId, string $libraryApiKey)
    {
        $this->headers['AccessKey'] = $libraryApiKey;
        $url = "{$this->BunnyCDN}/videolibrary/{$libraryId}/videos";
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Get video
     * @return VideoResponse
     */
    public function GetVideo(int $libraryId, string $libraryApiKey, string $id)
    {
        $this->headers['AccessKey'] = $libraryApiKey;
        $url = "{$this->BunnyCDN}/videolibrary/{$libraryId}/videos/{$id}";
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Update video
     * @return VideoResponse
     */
    public function UpdateVideo(int $libraryId, string $libraryApiKey, string $id, UpdateVideo $payload)
    {
        $this->headers['AccessKey'] = $libraryApiKey;
        $url = "{$this->BunnyCDN}/videolibrary/{$libraryId}/videos/{$id}";
        $this->headers['content-type'] = "application/json";
        return Http::withHeaders($this->headers)->post($url, $payload);
    }

    /**
     * Delete video collection
     * @return VideoCollectionResponse
     */
    public function DeleteVideo(int $libraryId, string $libraryApiKey, string $id)
    {
        $this->headers['AccessKey'] = $libraryApiKey;
        $url = "{$this->BunnyCDN}/videolibrary/{$libraryId}/videos/{$id}";
        return Http::withHeaders($this->headers)->delete($url);
    }

    /**
     * Set thumbnail to video
     * requires thumbnail url to be passed as a query parameter
     * @return BaseResponse
     */
    public function SetThumbnail(int $libraryId, string $libraryApiKey, string $id, string $thumbnailUrl)
    {
        $this->headers['AccessKey'] = $libraryApiKey;
        $url = "{$this->BunnyCDN}/library/{$libraryId}/videos/{$id}/thumbnail?thumbnailUrl={$thumbnailUrl}";
        return Http::withHeaders($this->headers)->post($url);
    }

    /**
     * Add caption to video
     * requires payload and language
     * @return BaseResponse
     */
    public function AddCaption(int $libraryId, string $libraryApiKey, string $id, string $lang, VideoCaption $payload)
    {
        $this->headers['AccessKey'] = $libraryApiKey;
        $url = "{$this->BunnyCDN}/library/{$libraryId}/videos/{$id}/captions/{$lang}";
        $this->headers['content-type'] = "application/json";
        return Http::withHeaders($this->headers)->post($url, $payload);
    }


    /**
     * Delete caption for video
     * requires language
     * @return BaseResponse
     */
    public function RemoveCaption(int $libraryId, string $libraryApiKey, string $id, string $lang)
    {
        $this->headers['AccessKey'] = $libraryApiKey;
        $url = "{$this->BunnyCDN}/library/{$libraryId}/videos/{$id}/captions/{$lang}";
        return Http::delete($url, [
            'headers' => $this->headers
        ]);
    }


    /**
     * Generate url to be used for uploading file from client side
     */
    function GeneratePresignedUrl(int $libraryId, string $libraryApiKey, int $expiresInInMS, string $videoId)
    {
        // Endpoint for the Bunny.net Tus uploads
        $url = "https://video.bunnycdn.com/tusupload";

        // get timestamp for future time
        $timestamp = Carbon::now()->timestamp + $expiresInInMS;

        // generate authorization signature
        $signature = $this->__generatePresignedSignature($libraryId, $libraryApiKey, $timestamp, $videoId);

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
    private function __generatePresignedSignature(int $libraryId, string $libraryApiKey, int $expiresIn, string $videoId)
    {
        $phrase = $libraryId . $libraryApiKey . $expiresIn . $videoId;
        return hash('sha256', $phrase);
    }

    /*----------------------------------------------------------------------------*/

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
