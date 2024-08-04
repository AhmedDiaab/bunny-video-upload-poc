<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\BunnyUploader;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UpdateVideoRequest;
use App\Models\Video;

class VideoController extends BaseController
{

    public function __construct(private BunnyUploader $uploader)
    {
    }

    public function index()
    {
        return Video::all();
    }

    public function store(CreateVideoRequest $request)
    {
        $validated = $request->validated();
        $record = null;
        try {
            $validated['reference_id'] = '1234';
            $validated['url'] = 'N/A';
            $record = Video::create($validated);
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($record, 201);
    }

    public function show(Video $video)
    {
        $video->load(['library', 'collection']);
        return $video;
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        try {
            $validated = $request->validated();
            $video->update($validated);
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($video, 200);
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return response()->json(null, 204);
    }
}
