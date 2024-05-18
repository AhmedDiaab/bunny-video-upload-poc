<?php
namespace App\Http\Requests\Bunny;
class Caption {
    public $srclang;
    public $label;
}

class Chapter {
    public $title;
    public $start;
    public $end;
}

class Moment {
    public $label;
    public $timestamp;
}

class MetaTag {
    public $property;
    public $value;
}

class TranscodingMessage {
    public $timeStamp;
    public $level;
    public $issueCode;
    public $message;
    public $value;
}

class VideoResponse {
    public int $videoLibraryId;
    public string $guid;
    public string $title;
    public string $dateUploaded;
    public int $views;
    public bool $isPublic;
    public int $length;
    public int $status;
    public int $framerate;
    public int $rotation;
    public int $width;
    public int $height;
    public string $availableResolutions;
    public int $thumbnailCount;
    public int $encodeProgress;
    public int $storageSize;
    /** @var Caption[] */
    public array $captions = [];
    public bool $hasMP4Fallback;
    public string $collectionId;
    public string $thumbnailFileName;
    public int $averageWatchTime;
    public int $totalWatchTime;
    public string $category;
    /** @var Chapter[] */
    public array $chapters = [];
    /** @var Moment[] */
    public array $moments = [];
    /** @var MetaTag[] */
    public array $metaTags = [];
    /** @var TranscodingMessage[] */
    public array $transcodingMessages = [];
}