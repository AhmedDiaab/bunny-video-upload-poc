<?php

namespace App\Services\Bunny\BunnyVideoCollection;

use App\Http\Requests\Bunny\VideoCollectionResponse;
use App\Services\Bunny\BunnyUploader;
use Illuminate\Support\Facades\Http;

class BunnyCollectionManager extends BunnyUploader
{

    /**
     * Video Collection
     */

    /**
     * Create video collection
     * @return VideoCollectionResponse
     */
    public function CreateVideoCollection(int $libraryId, string $libraryApiKey, string $name)
    {
        $url = "{$this->BunnyCDN}/library/{$libraryId}/collections";
        $this->headers['content-type'] = "application/json";
        $this->headers['AccessKey'] = $libraryApiKey;
        $payload = [
            'Name' => $name
        ];
        $response = Http::withHeaders($this->headers)->post($url, $payload);
        return $this->__handleResponse($response);
    }

    /**
     * List video collection
     * @return VideoCollectionResponse[]
     */
    public function ListVideoCollections(int $libraryId, string $libraryApiKey)
    {
        $url = "{$this->BunnyCDN}/library/{$libraryId}/collections";
        $this->headers['AccessKey'] = $libraryApiKey;
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Get video collection
     * @return VideoCollectionResponse
     */
    public function GetVideoCollection(int $libraryId, string $libraryApiKey, int $uuid)
    {
        $url = "{$this->BunnyCDN}/library/{$libraryId}/collections/{$uuid}";
        $this->headers['AccessKey'] = $libraryApiKey;
        return Http::withHeaders($this->headers)->get($url);
    }

    /**
     * Update video collection
     * @return VideoCollectionResponse
     */
    public function UpdateVideoCollection(int $libraryId, string $libraryApiKey, string $uuid, string $name)
    {
        $url = "{$this->BunnyCDN}/library/{$libraryId}/collections/{$uuid}";
        $this->headers['content-type'] = "application/json";
        $this->headers['AccessKey'] = $libraryApiKey;
        $payload = [
            'Name' => $name
        ];
        return Http::withHeaders($this->headers)->post($url, $payload);
    }

    /**
     * Delete video collection
     * @return VideoCollectionResponse
     */
    public function DeleteVideoCollection(int $libraryId, string $libraryApiKey, string $uuid)
    {
        $url = "{$this->BunnyCDN}/library/{$libraryId}/collections/{$uuid}";
        $this->headers['AccessKey'] = $libraryApiKey;
        return Http::withHeaders($this->headers)->delete($url);
    }
}
