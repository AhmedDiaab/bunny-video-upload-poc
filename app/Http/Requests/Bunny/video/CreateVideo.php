<?php
namespace App\Http\Requests\Bunny\Video;

class CreateVideo {
    public string $title;
    public? int $thumbnailTime = null;
    public? int $collectionId = null;

    public function toArray() {
        $payload = [];
        $payload['title'] = $this->title;
        if ($this->thumbnailTime) $payload['thumbnailTime'] = $this->thumbnailTime;
        if ($this->collectionId) $payload['collectionId'] = $this->collectionId;
        return $payload;
    }
}