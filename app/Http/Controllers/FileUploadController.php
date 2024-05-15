<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\PublicFileCreateRequest;
use App\Services\PublicFileService;

class FileUploadController extends BaseController
{

    public function __construct(private PublicFileService $service)
    {
    }

    public function GetUploadUrl(PublicFileCreateRequest $request)
    {
        try {
            // validate request
            $validated = $request->validated();

            return $this->service->GetUploadUrl($validated['name']);
        } catch (\Throwable | \Exception $e) {
            error_log($e->getMessage());
        }
    }
}
