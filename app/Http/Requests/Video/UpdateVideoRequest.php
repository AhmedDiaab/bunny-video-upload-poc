<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * validationData
     * Before validation decode json object come from formdata
     * sometimes not decoded nested object
     *  */
    public function validationData()
    {
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:32',
            'library_id' => 'required|int|min:1|exists:App\Models\Library,id',
            'collection_id' => 'required|int|min:1|exists:App\Models\Collection,id',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.min' => 'The name field must be at least 3 characters long.',
            'name.max' => 'The name field may not be greater than 32 characters.',
            'library_id.required' => 'The library_id field is required.',
            'library_id.int' => 'The library_id field must be an integer.',
            'library_id.min' => 'The library_id field must be at least :min.',
            'library_id.exists' => 'The selected library_id does not exist in our records.',
            'collection_id.required' => 'The collection_id field is required.',
            'collection_id.int' => 'The collection_id field must be an integer.',
            'collection_id.min' => 'The collection_id field must be at least :min.',
            'collection_id.exists' => 'The selected collection_id does not exist in our records.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation failed.',
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
