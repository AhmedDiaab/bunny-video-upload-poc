<?php

namespace App\Services\Bunny\BunnyVideo;

use App\Http\Requests\Bunny\BaseResponse;
use App\Http\Requests\Bunny\VideoCaption;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class BunnyVideoMetadataManager extends BunnyVideoManager
{
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
}
