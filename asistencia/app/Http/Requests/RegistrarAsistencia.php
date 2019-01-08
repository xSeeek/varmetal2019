<?php

namespace Asistencia\Http\Requests;
use ValidateRequests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarAsistencia extends FormRequest
{
    /public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rut'=>'required|cl_rut',
            'file' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'rut.required' => 'Necesita ingresar su rut.',
            'rut.cl_rut' => 'El rut ingresado debe ser válido.',
            'file.required' => 'Debe registrar una imagen.',
        ];
    }
}
