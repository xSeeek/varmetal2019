<?php

namespace Asistencia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use ValidateRequests;

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
      'email'=>'max:255|unique:users,email',
      'nombre_completo'=>'required|max:255|min:3',
      'rut'=>'required|unique:trabajador,rut|cl_rut',
      'cargo'=>'required|min:2',
    ];
  }

  public function attributes()
  {
      return [
          'email' => 'Email',
          'nombre_completo' => 'Nombre completo',
          'rut' => 'Rut',
          'cargo' => 'Cargo'
      ];
  }
}
