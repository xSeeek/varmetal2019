<?php

namespace Asistencia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarTrabajadorRequest extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  public function rules()
  {
    return
    [
      'nombre_completo'=>'required|min:3',
      'rut'=>'required|cl_rut',
      'cargo'=>'required'
    ];
  }

  public function attributes()
  {
      return [
          'nombre_completo' => 'Nombre',
          'rut' => 'Rut',
          'cargo'=>'Cargo del trabajador'
      ];
  }
}
