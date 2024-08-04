<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\BunnyUploader;
use App\Http\Requests\Collection\CreateCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;
use App\Models\Collection;
use App\Models\Library;

class CollectionController extends BaseController
{

    public function __construct(private BunnyUploader $uploader)
    {
    }

    public function index()
    {
        $records = Collection::all();
        foreach ($records as $record) {
            $record->load('library');
        }
        return $records;
    }

    public function store(CreateCollectionRequest $request)
    {
        $validated = $request->validated();
        $record = null;
        try {
            $name = $validated['name'];
            $library = Library::where('id', $validated['library_id'])->first();
            $library_reference = (int) $library->reference_id;
            $library_api_key = $library->api_key;
            $collection = $this->uploader->CreateVideoCollection($library_reference, $library_api_key, $name);
            $validated['reference_id'] = $collection['guid'];
            $record = Collection::create($validated);
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($record, 201);
    }

    public function show(Collection $collection)
    {
        $collection->load(['library']);
        return $collection;
    }

    public function update(UpdateCollectionRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $name = $validated['name'];
            $library = Library::where('id', $validated['library_id'])->first();
            $library_reference = (int) $library->reference_id;
            $library_api_key = $library->api_key;
            $collection = Collection::where('id', (int) $id)->first();
            $this->uploader->UpdateVideoCollection($library_reference, $library_api_key, $collection['reference_id'], $name);
            $collection->update($validated);
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($collection, 200);
    }

    public function destroy(int $id)
    {
        try {
            $collection = Collection::where('id', (int) $id)->first();
            $library = Library::where('id', $collection['library_id'])->first();
            $library_reference = (int) $library->reference_id;
            $library_api_key = $library->api_key;
            $this->uploader->DeleteVideoCollection((int) $library_reference, $library_api_key, $collection['reference_id']);
            $collection->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json(null, 204);
    }
}
