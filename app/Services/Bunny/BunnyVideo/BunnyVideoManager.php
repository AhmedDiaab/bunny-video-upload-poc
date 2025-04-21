<?php

namespace App\Services\Bunny\BunnyVideo;

use App\Http\Requests\Bunny\Video\CreateVideo;
use App\Http\Requests\Bunny\Video\UpdateVideo;
use App\Http\Requests\Bunny\VideoCollectionResponse;
use App\Http\Requests\Bunny\VideoResponse;
use App\Services\Bunny\BunnyUploader;
use Illuminate\Support\Facades\Http;

class BunnyVideoManager extends BunnyUploader
{
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
}
