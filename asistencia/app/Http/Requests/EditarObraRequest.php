<?php

namespace Asistencia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarObraRequest extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  public function rules()
  {
    return
    [
      'nombre'=>'required|min:3',
    ];
  }

  public function attributes()
  {
      return [
          'nombre' => 'Nombre de la obra',
      ];
  }

}
