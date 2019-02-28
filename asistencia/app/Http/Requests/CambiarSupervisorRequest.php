<?php

namespace Asistencia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambiarSupervisorRequest extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  public function rules()
  {
    return
    [
      'encargado'=>'required',
    ];
  }

  public function attributes()
  {
      return [
          'encargado' => 'Encargado',
      ];
  }
}
