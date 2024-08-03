<?php

namespace App\Http\Requests\Collection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CreateCollectionRequest extends FormRequest
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
            'library' => 'required|int|min:1|exists:App\Models\Library,id'
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
            'library.required' => 'The library field is required.',
            'library.int' => 'The library field must be an integer.',
            'library.min' => 'The library field must be at least :min.',
            'library.exists' => 'The selected library does not exist in our records.',
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
