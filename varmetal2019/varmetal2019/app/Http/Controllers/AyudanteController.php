<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Ayudante;
use Freshwork\ChileanBundle\Rut;
use Varmetal\Trabajador;

class AyudanteController extends Controller
{
    public function adminAyudantes()
    {
        $ayudantes_almacenados = Ayudante::get();

        return view('admin.administracion_ayudantes')
            ->with('ayudantes_almacenados', $ayudantes_almacenados);
    }

    public function addAyudante()
    {
        return view('admin.ayudante.addAyudante');
    }

    public function insertAyudante(Request $request)
    {
        if($request->nameAyudante == NULL)
            return 'Debe ingresar un nombre para el ayudante';
        if($request->rutAyudante == NULL)
            return 'Debe ingresar un RUT para el ayudante';
        if((Rut::parse($request->rutAyudante)->validate()) == false)
            return 'RUT no válido';

        $trabajador = Trabajador::where('rut', '=', $request->rutAyudante)->first();
        if($trabajador != NULL)
            return 'No puede registrar a un trabajador como ayudante';

        $ayudante = Ayudante::where('rut', '=', $request->rutAyudante)->first();
        if($ayudante != NULL)
            return 'Ya existe un ayudante con el RUT ingresado';

        $ayudante = new Ayudante;
        $ayudante->nombre = $request->nameAyudante;
        $ayudante->rut = $request->rutAyudante;
        $ayudante->save();

        return 1;
    }
    public function asignarAyudante(Request $request)
    {
        $response = json_decode($request->DATA);

        $trabajador = Trabajador::find($response[1]);
        $ayudante = Ayudante::find($response[0]);

        $trabajador->ayudante()->attach($ayudante->idAyudante);
        $ayudante->save();
        return 1;
    }
    public function detalleAyudante($data)
    {
        $detalles_ayudante = Ayudante::find($data);
        $trabajador = $detalles_ayudante->trabajador;

        return view('admin.ayudante.ayudante_control')
                ->with('detalles_ayudante', $detalles_ayudante)
                ->with('detalles_trabajador', $trabajador);
    }
}
