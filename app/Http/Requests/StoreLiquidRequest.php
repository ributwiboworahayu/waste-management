<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLiquidRequest extends FormRequest
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
    public function rules()
    {
        return [
            'liquids.*.codeName' => 'required|string|max:255|unique:liquid_wastes,code',
            'liquids.*.name' => 'required|string|max:255',
            'liquids.*.unitName' => 'required|int',
            'liquids.*.description' => 'nullable|string|max:1000',
        ];
    }

    // message
    public function messages(): array
    {
        return [
            'liquids.*.codeName.required' => 'Kode tidak boleh kosong',
            'liquids.*.codeName.unique' => 'Ada kode yang sama atau sudah digunakan',
            'liquids.*.name.required' => 'Nama tidak boleh kosong',
            'liquids.*.unitName.required' => 'Unit tidak boleh kosong',
        ];
    }
}
