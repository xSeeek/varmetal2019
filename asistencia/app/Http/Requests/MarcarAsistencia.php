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
      'image'=>'required|image|mimes:jpeg,bmp,png|max:100000'
    ];
  }

  public function attributes()
  {
      return [
          'rut' => 'Rut del usuario',
          'image' => 'Imagen del archivo'
      ];
  }

  public function messages()
  {
    return [
        'rut.required' => 'Se requiere el rut del usuario.',
        'rut.cl_rut' => 'El rut ingresado no es válido.',
        'image.size' => 'El tamaño maximo fue exedido',
      ];
  }
}
