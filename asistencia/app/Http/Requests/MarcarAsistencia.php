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
      'rut'=>'required|exists:trabajador,rut',
      'file'=>'required|image'
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
        'rut.required' => 'Se requiere el rut del usuario.',
        'rut.cl_rut' => 'El rut ingresado no es válido.',
      ];
  }
}