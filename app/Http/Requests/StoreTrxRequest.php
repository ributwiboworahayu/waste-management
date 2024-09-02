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
            'list_waste_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'code_name' => 'required|string',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'shipper_name' => 'string',
            'input_by' => 'required|string',
            'input_at' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
            'description' => 'nullable|string',
        ];
    }

    // messages in indonesia
    public function messages(): array
    {
        return [
            'list_waste_id.required' => 'Jenis limbah harus diisi',
            'list_waste_id.integer' => 'Jenis limbah harus berupa angka',
            'unit_id.required' => 'Satuan harus diisi',
            'unit_id.integer' => 'Satuan harus berupa angka',
            'code_name.required' => 'Kode harus diisi',
            'code_name.string' => 'Kode harus berupa huruf',
            'type.required' => 'Tipe harus diisi',
            'type.in' => 'Tipe harus berupa in atau out',
            'quantity.required' => 'Jumlah harus diisi',
            'quantity.numeric' => 'Jumlah harus berupa angka',
            'quantity.min' => 'Jumlah tidak boleh kurang dari 0',
            'photo.required' => 'Foto harus diisi',
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Foto harus berupa gambar dengan format: jpeg, png, jpg, gif, svg',
            'photo.max' => 'Foto tidak boleh lebih dari 2MB',
            'document.required' => 'Dokumen harus diisi',
            'document.image' => 'Dokumen harus berupa gambar',
            'document.mimes' => 'Dokumen harus berupa gambar dengan format: jpeg, png, jpg, gif, svg',
            'document.max' => 'Dokumen tidak boleh lebih dari 2MB',
            'shipper_name.string' => 'Nama pengirim harus berupa huruf',
            'input_by.required' => 'Input oleh harus diisi',
            'input_by.string' => 'Input oleh harus berupa huruf',
            'input_at.required' => 'Tanggal input harus diisi',
            'input_at.date' => 'Tanggal input harus berupa tanggal',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus berupa pending, approved, atau rejected',
            'description.string' => 'Deskripsi harus berupa huruf',
        ];
    }
}
