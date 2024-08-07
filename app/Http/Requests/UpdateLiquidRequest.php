<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLiquidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'name' => 'required|string',
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'nullable|numeric',
            'description' => 'nullable|string',
        ];
    }
}
