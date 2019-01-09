<?php

namespace Asistencia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use ValidateRequests;

class MarcarAsistencia extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  public function rules()
  {
    return
    [
      'rut'=>'required|cl_rut|exists:trabajador,rut',
      'file'=>'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];
  }

  public function attributes()
  {
      return [
          'rut' => 'Rut del usuario',
          'file' => 'Imagen del archivo'
      ];
  }

  public function messages()
  {
    return [
        'rut.required' => 'Se requiere el rut de la empresa.',
        'rut.cl_rut' => 'El rut ingresado no es válido.',
      ];
  }
}
