<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Varmetal\Trabajador;
use Varmetal\Producto;
use Varmetal\User;
use Varmetal\Material;


class SoldaduraController extends Controller
{
    public function soldaduraControl($data)
    {
        $pieza = Producto::find($data);
        $gastoAla=0;
        $gastoGas=0;
        $cantidadProducida=0;
        $fechaTermino=NULL;
        $materiales_gastados = $pieza->materialWithAtributes;
        $soldadores = $pieza->trabajadorSoldadorWithAtributtes;
        foreach ($soldadores as $key => $trabajadorActual)
        {
          $cantidadProducida += $trabajadorActual->pivot->productosRealizados;
          foreach ($materiales_gastados as $key => $materiales)
          {
            if($materiales!=NULL)
            {
              $material = Material::find($materiales->pivot->material_id_material);
              if($material->tipo=='Soldador' && $material->nombre=='Gas')
              {
                if($materiales->pivot->trabajador_id_trabajador==$trabajadorActual->idTrabajador)
                {
                    $gastoGas+=$materiales->pivot->gastado;
                }
              }
              if($material->tipo=='Soldador' && $material->nombre=='Alambre')
              {
                if($materiales->pivot->trabajador_id_trabajador==$trabajadorActual->idTrabajador)
                {
                    $gastoAla+=$materiales->pivot->gastado;
                }
              }
              if($fechaTermino==NULL)
              {
                $fechaTermino=$materiales->pivot->fechaTermino;
              }else{
                if($materiales->pivot->fechaTermino!=NULL && $fechaTermino<$materiales->pivot->fechaTermino);
                  $fechaTermino=$materiales->pivot->fechaTermino;
              }
            }
          }
        }
        return view('admin.soldadura.soldadura_control')
                ->with('producto', $pieza)
                ->with('gas', $gastoGas)
                ->with('alambre',$gastoAla)
                ->with('soldadores',$soldadores)
                ->with('fechaTermino',$fechaTermino)
                ->with('cantidadProducida',$cantidadProducida);
    }
}
