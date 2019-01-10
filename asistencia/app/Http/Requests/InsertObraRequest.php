<?php

namespace Asistencia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertObraRequest extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  public function rules()
  {
    return
    [
      'name'=>'required|min:3',
      'encargado'=>'required|exists:trabajador,rut'
    ];
  }

  public function attributes()
  {
      return [
          'name' => 'Nombre de la obra',
          'encargado' => 'Encargado de la obra'
      ];
  }

  public function messages()
  {
    return [
        'name.required' => 'Se requiere el nombre de la obra.',
        'encargado.required' => 'Se requiere seleccionar un encargado.',
      ];
  }
}
