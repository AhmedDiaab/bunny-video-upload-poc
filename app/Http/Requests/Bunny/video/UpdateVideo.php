<?php

namespace App\Http\Requests\Bunny\Video;

class UpdateVideo
{
    public ?string $title = null;
    public ?string $collectionId = null;
    /** @var Chapter[]|null */
    public ?array $chapters = null;
    /** @var Moment[]|null */
    public ?array $moments = null;
    /** @var MetaTag[]|null */
    public ?array $metaTags = null;

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setCollection(string $collection)
    {
        $this->collectionId = $collection;
    }
}

class Chapter
{
    public string $title;
    public ?int $start;
    public ?int $end;
}

class Moment
{
    public string $label;
    public ?int $timestamp;
}

class MetaTag
{
    public ?string $property = null;
    public ?string $value = null;
}
