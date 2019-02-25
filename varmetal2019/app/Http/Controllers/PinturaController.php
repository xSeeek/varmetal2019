<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Varmetal\Trabajador;
use Varmetal\Pintado;
use Varmetal\Producto;
use Varmetal\User;

class PinturaController extends Controller
{
    public function homePintor()
    {
        $usuarioActual= Auth::user();

        return view('trabajador.menuPintor')
            ->with('user', $usuarioActual);
    }

    public function pintadoControl($data)
    {
        $pieza = Producto::find($data);
        $detallePintado = $pieza->pintado()->where('revisado', 'true')->get();

        return view('admin.pintado.pintado_control')
                ->with('producto', $pieza)
                ->with('pintado_revisado', $detallePintado);
    }

    public function detallePintadoControl($data)
    {
        $detallePintado = Pintado::find($data);
        $supervisor = $detallePintado->supervisor()->first();
        $pieza = $detallePintado->producto;
        $pintor = $detallePintado->pintor;

        $rendimiento = 0;
        $firstMult = ($detallePintado->areaPintada * $detallePintado->piezasPintadas)/$detallePintado->litrosGastados;
        $secondMult = 1/($detallePintado->espesor * 1000);
        $rendimiento = $firstMult * $secondMult;

        return view('admin.pintado.detalle_revision_pintado')
                ->with('supervisor', $supervisor)
                ->with('pintado', $detallePintado)
                ->with('pieza', $pieza)
                ->with('pintor', $pintor)
                ->with('rendimiento', $rendimiento);
    }

    public function pintarPieza(Request $request)
    {
        $response = json_decode($request->DATA);
        $userTrabajador = (User::find($response[2]))->trabajador;

        $pieza = Producto::where('codigo', $response[0])->first();
        if($pieza->zona != 2)
            return 'La pieza aún no está disponible para el pintado';

        $piezasPintadas = 0;
        $pintado = $pieza->pintado;
        foreach($pintado as $diaPintado)
            $piezasPintadas += $diaPintado->piezasPintadas;

        if($piezasPintadas == $pieza->cantProducto)
            return 'La pieza ya finalizó su proceso de pintado';

        if($response[1] <= 0 || ($piezasPintadas + $response[1]) > $pieza->cantProducto)
            return 'La cantidad ingresada no es válida';

        $pintado = new Pintado;
        $pintado->piezasPintadas = $response[1];
        $pintado->dia = now();
        $pintado->pintor_id_trabajador = $userTrabajador->idTrabajador;
        $pintado->producto_id_producto = $pieza->idProducto;
        $pintado->save();

        return 1;
    }

    public function piezasPendientes($data)
    {
        $pieza = Producto::find($data);
        $pendientes = $pieza->pintado()->where('revisado', 'false')->get();

        return view('admin.pintado.pendientes_pintado')
                ->with('producto', $pieza)
                ->with('pendientes', $pendientes);
    }

    public function detallePiezaPintada($data)
    {
        $detallePintado = Pintado::find($data);
        $pieza = $detallePintado->producto;

        return view('admin.pintado.revisar_pintado')
                ->with('producto', $pieza)
                ->with('idPintura', $data);
    }

    public function revisarPintado(Request $request)
    {
        $usuarioActual= Auth::user();

        $detallePintado = Pintado::find($request->idPintura);
        $pieza = $detallePintado->producto;

        if($request->pinturaGastada <= 0)
            return 'Litros de pintura utilizados no válido';
        if($request->espesorPintura <= 0)
            return 'Espesor de pintura ingresado no válido';

        $detallePintado->areaPintada = $pieza->area;
        $detallePintado->litrosGastados = $request->pinturaGastada;
        $detallePintado->espesor = $request->espesorPintura;
        $detallePintado->revisado = true;
        $detallePintado->supervisor = $usuarioActual->trabajador->idTrabajador;

        $pinturas = $pieza->pintado;
        $cantPintada = 0;
        foreach($pinturas as $pintura)
          $cantPintada += $pintura->piezasPintadas;

        if($cantPintada >= $pieza->cantProducto)
        {
            $pieza->zona = 3;
            $pieza->estado = 1;
            $pieza->save();
        }

        $detallePintado->save();
        return 1;
    }
}
