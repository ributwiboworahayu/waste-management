<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrxRequest extends FormRequest
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
            'liquid_waste_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'code_name' => 'required|string',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'shipper_name' => 'required|string',
            'input_by' => 'required|string',
            'input_at' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'liquid_waste_id.required' => 'Kolom limbah cair wajib diisi',
            'liquid_waste_id.integer' => 'Kolom limbah cair harus berupa angka',
            'unit_id.required' => 'Kolom satuan wajib diisi',
            'unit_id.integer' => 'Kolom satuan harus berupa angka',
            'code_name.required' => 'Kolom kode wajib diisi',
            'code_name.string' => 'Kolom kode harus berupa teks',
            'type.required' => 'Kolom tipe wajib diisi',
            'type.in' => 'Kolom tipe harus berupa in atau out',
            'quantity.required' => 'Kolom kuantitas wajib diisi',
            'quantity.numeric' => 'Kolom kuantitas harus berupa angka',
            'quantity.min' => 'Kolom kuantitas minimal 0',
            'photo.required' => 'Kolom foto wajib diisi',
            'photo.image' => 'Kolom foto harus berupa gambar',
            'document.required' => 'Kolom dokumen wajib diisi',
            'document.image' => 'Kolom dokumen harus berupa gambar',
            'shipper_name.required' => 'Kolom nama pengirim wajib diisi',
            'shipper_name.string' => 'Kolom nama pengirim harus berupa teks',
            'status.required' => 'Kolom status wajib diisi',
            'status.in' => 'Kolom status harus berupa pending, approved, atau rejected',
            'description.string' => 'Kolom deskripsi harus berupa teks',
            'input_by.required' => 'Kolom input oleh wajib diisi',
            'input_by.string' => 'Kolom input oleh harus berupa teks',
            'input_at.required' => 'Kolom input pada wajib diisi',
            'input_at.date' => 'Kolom input pada harus berupa tanggal',
        ];
    }
}
