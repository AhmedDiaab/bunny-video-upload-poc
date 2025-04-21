<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Library\CreateLibraryRequest;
use App\Http\Requests\Library\UpdateLibraryRequest;
use App\Models\Library;
use App\Services\Bunny\BunnyVideoLibrary\BunnyLibraryManager;

class LibraryController extends BaseController
{

    public function __construct(private BunnyLibraryManager $libraryManager)
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
            $name = $validated['name'];
            $library = $this->libraryManager->CreateVideoLibrary($name);
            $reference = $library['Id'];
            $validated['api_key'] = $library['ApiKey'];
            $validated['reference_id'] = $reference;
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
        $validated = $request->validated();
        try {
            $payload = [
                'Name' => $validated['name']
            ];
            $this->libraryManager->UpdateVideoLibrary($library['reference_id'], $payload);
            $library->update($validated);
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json($library, 200);
    }

    public function destroy(Library $library)
    {
        try {
            $this->libraryManager->DeleteVideoLibrary($library['reference_id']);
            $library->delete();
        } catch (\Exception $e) {
            throw $e;
        }
        return response()->json(null, 204);
    }
}
