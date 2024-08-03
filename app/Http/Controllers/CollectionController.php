<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\BunnyUploader;
use App\Http\Requests\Collection\CreateCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;
use App\Models\Collection;

class CollectionController extends BaseController
{

    public function __construct(private BunnyUploader $uploader)
    {
    }

    public function index()
    {
        return Collection::all();
    }

    public function store(CreateCollectionRequest $request)
    {
        $validated = $request->validated();
        $record = null;
        try {
            $validated['reference_id'] = '1234';
            $record = Collection::create($validated);
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($record, 201);
    }

    public function show(Collection $Collection)
    {
        return $Collection;
    }

    public function update(UpdateCollectionRequest $request, Collection $Collection)
    {
        try {
            $validated = $request->validated();
            $Collection->update($validated);
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($Collection, 200);
    }

    public function destroy(Collection $Collection)
    {
        $Collection->delete();

        return response()->json(null, 204);
    }
}
