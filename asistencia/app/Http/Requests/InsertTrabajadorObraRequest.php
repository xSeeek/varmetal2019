<?php

namespace Asistencia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertTrabajadorRequest extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  public function rules()
  {
    return
    [
      'trabajador'=>'required',
    ];
  }

  public function attributes()
  {
      return [
          'trabajador' => 'Trabajador',
      ];
  }

  public function messages()
  {
    return [
        'trabajador.required' => 'Requiere seleccionar un trabajador.',
      ];
  }
}
