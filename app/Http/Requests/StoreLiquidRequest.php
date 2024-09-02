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
    public function rules(): array
    {
        return [
            'lists.*.codeName' => 'required|string|max:255|unique:list_wastes,code',
            'lists.*.name' => 'required|string|max:255',
            'lists.*.unitName' => 'required|int',
            'lists.*.description' => 'nullable|string|max:1000',
        ];
    }

    // message
    public function messages(): array
    {
        return [
            'lists.*.codeName.required' => 'Kode tidak boleh kosong',
            'lists.*.codeName.unique' => 'Ada kode yang sama atau sudah digunakan',
            'lists.*.name.required' => 'Nama tidak boleh kosong',
            'lists.*.unitName.required' => 'Unit tidak boleh kosong',
        ];
    }
}
