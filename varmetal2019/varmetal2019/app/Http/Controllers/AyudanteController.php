<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;

class AyudanteController extends Controller
{
  public function addAyudante(Request $request)
  {
      $response = json_decode($request->DATA);

      $trabajador = Trabajador::find($response[1]);
      $ayudante = Ayudante::find($response[0]);

      $trabajador->ayudante()->attach($ayudante->idAyudante);
      $ayudante->save();
      return 1;
  }
}
