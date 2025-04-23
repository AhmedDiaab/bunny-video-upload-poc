<?php

namespace App\Http\Requests\Bunny;

class VideoNotificationWebHookRequest
{
    public int $VideoLibraryId;
    public string $VideoGuid;
    public int $Status;

    public function __construct(array $data)
    {
        $this->VideoLibraryId = $data['VideoLibraryId'];
        $this->VideoGuid = $data['VideoGuid'];
        $this->Status = $data['Status'];
    }


    public function MapStatusToText()
    {
        $map = [
            0  => 'Queued',
            1  => 'Processing',
            2  => 'Encoding',
            3  => 'Finished',
            4  => 'Resolution finished',
            5  => 'Failed',
            6  => 'PresignedUploadStarted',
            7  => 'PresignedUploadFinished',
            8  => 'PresignedUploadFailed',
            9  => 'CaptionsGenerated',
            10 => 'TitleOrDescriptionGenerated',
        ];

        return $map[$this->Status] ?? 'Unknown status';
    }
}
