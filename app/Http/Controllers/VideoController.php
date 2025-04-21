<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bunny\Video\UpdateVideo;
use App\Http\Requests\Bunny\Video\CreateVideo;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Video\CreateVideoRequest;
use App\Http\Requests\Video\UpdateVideoRequest;
use App\Models\Collection;
use App\Models\Library;
use App\Models\Video;
use App\Services\Bunny\BunnyVideo\BunnyVideoManager;

class VideoController extends BaseController
{

    public function __construct(private BunnyVideoManager $videoManager)
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
            $name = $validated['name'];
            $library = Library::where('id', $validated['library_id'])->first();
            $library_api_key = $library['api_key'];
            $library_reference = (int) $library['reference_id'];
            $collection = Collection::where('id', $validated['collection_id'])->first();
            $collection_reference = $collection['reference_id'];
            $videoPayload = new CreateVideo();
            $videoPayload->setTitle($name);
            $videoPayload->setCollection($collection_reference);
            $video = $this->videoManager->CreateVideo($library_reference, $library_api_key, $videoPayload);
            $validated['reference_id'] = $video['guid'];
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

    public function update(UpdateVideoRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $record = Video::where('id', $id)->first();
            $name = $validated['name'];
            $library = Library::where('id', $validated['library_id'])->first();
            $library_api_key = $library['api_key'];
            $library_reference = (int) $library['reference_id'];
            $collection = Collection::where('id', $validated['collection_id'])->first();
            $collection_reference = $collection['reference_id'];
            $videoPayload = new UpdateVideo();
            $videoPayload->setTitle($name);
            $videoPayload->setCollection($collection_reference);
            $video = $this->videoManager->UpdateVideo($library_reference, $library_api_key, $record['reference_id'], $videoPayload);
            $record->update($validated);
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($record, 200);
    }

    public function destroy(int $id)
    {
        try {
            $video = Video::where('id', $id)->first();
            $library = Library::where('id', $video['library_id'])->first();
            $this->videoManager->DeleteVideo($library['reference_id'], $library['api_key'], $video['reference_id']);
            $video->delete();
        } catch (\Exception $e) {
            throw $e;
        }


        return response()->json(null, 204);
    }
}
