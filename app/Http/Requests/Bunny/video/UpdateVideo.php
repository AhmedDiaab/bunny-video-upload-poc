<?php
namespace App\Http\Requests\Bunny;

class UpdateVideo {
    public ?string $title = null;
    public ?string $collectionId = null;
    /** @var Chapter[]|null */
    public ?array $chapters = null;
    /** @var Moment[]|null */
    public ?array $moments = null;
    /** @var MetaTag[]|null */
    public ?array $metaTags = null;
}

class Chapter {
    public string $title;
    public? int $start;
    public? int $end;
}

class Moment {
    public string $label;
    public? int $timestamp;
}

class MetaTag {
    public ?string $property = null;
    public ?string $value = null;
}