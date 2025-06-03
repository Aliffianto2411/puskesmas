<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoliRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_poli' => 'required|string|max:255',
            'kode_poli' => 'required|string|max:50|unique:poli,kode_poli,' . $this->route('poli'),
        ];
    }
}