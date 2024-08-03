<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\BunnyUploader;
use App\Http\Requests\Library\CreateLibraryRequest;
use App\Http\Requests\Library\UpdateLibraryRequest;
use App\Models\Library;

class LibraryController extends BaseController
{

    public function __construct(private BunnyUploader $uploader)
    {
    }

    public function index()
    {
        return Library::all();
    }

    public function store(CreateLibraryRequest $request)
    {
        $validated = $request->validated();
        $record = null;
        try {
            $validated['reference_id'] = '1234';
            $record = Library::create($validated);
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($record, 201);
    }

    public function show(Library $library)
    {
        return $library;
    }

    public function update(UpdateLibraryRequest $request, Library $library)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
        ]);

        $library->update($request->all());

        return response()->json($library, 200);
    }

    public function destroy(Library $library)
    {
        $library->delete();

        return response()->json(null, 204);
    }


}
