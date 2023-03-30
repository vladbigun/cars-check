<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'number' => 'required|min:3|max:10',
            'vin' => 'required|min:17|max:17',
            'color' => 'required|max:255',
            'brand' => 'safe|max:255',
            'model' => 'max:255',
            'year' => 'max:4'
        ];
    }
}
