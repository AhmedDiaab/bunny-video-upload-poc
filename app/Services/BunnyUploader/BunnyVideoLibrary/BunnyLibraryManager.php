<?php

namespace App\Services\BunnyUploader\BunnyVideoLibrary;

use App\Services\BunnyUploader\BunnyUploader;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Bunny\VideoLibraryResponse;

class BunnyLibraryManager extends BunnyUploader
{


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
}
