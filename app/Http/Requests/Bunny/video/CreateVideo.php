<?php
namespace App\Http\Requests\Bunny;

class CreateVideo {
    public string $title;
    public? int $thumbnailTime;
    public? int $collectionId;
}