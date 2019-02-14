<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Trabajador;
use Varmetal\User;
use Varmetal\Producto;
use Varmetal\Material;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function materialesGastados(Request $request)
    {
      $response = json_decode($request->DATA);

      $gastoAlambre = $response[0];
      $gastoGas = $response[1];
      $idUser = $response[2];
      $idAlambre = $response[4];
      $idGas = $response[3];

      $contGas=0;
      $contAla=0;

      $user = User::find($idUser);
      $gas = Material::find($idGas);

      if($gas==NULL)
      {
        return 'No existe el tipo de gas';
      }

      $alambre = Material::find($idAlambre);

      if($alambre==NULL)
      {
        return 'No existe el tipo de alambre';
      }

      $trabajador = $user->trabajador;
      if($trabajador==NULL)
      {
        return 'No existe el trabajador';
      }
      $productos = $trabajador->producto;
      if($productos==NULL)
      {
        return 'No posees productos terminados';
      }
      foreach ($productos as $key => $producto)
      {
        if($producto->trabajadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first()!=NULL)
        {
          $dataProducto = $producto->trabajadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
          if($dataProducto->pivot->productosRealizados < $producto->cantProducto)
          {
            echo 'Faltan ';
            echo $producto->cantProducto-$dataProducto->pivot->productosRealizados;
            echo ' por hacer de la pieza: ';
            echo $producto->codigo;
          }
            //return var_dump($gas->productoWithAttributes()->where('producto_id_producto','=',$producto->idProducto)->where('trabajador_id_trabajador','=',$trabajador->idTrabajador)->where('material_id_material','=',$gas->idMaterial)->orderBy('producto_id_producto','desc')->first());
            if($gas->productoWithAttributes()->where('producto_id_producto','=',$producto->idProducto)->where('trabajador_id_trabajador','=',$trabajador->idTrabajador)->where('material_id_material','=',$gas->idMaterial)->orderBy('producto_id_producto','desc')->get()->first()==NULL)
            {
              $gas->producto()->attach($producto->idProducto);
            }
            if($alambre->productoWithAttributes()->where('producto_id_producto','=',$producto->idProducto)->where('trabajador_id_trabajador','=',$trabajador->idTrabajador)->where('material_id_material','=',$gas->idMaterial)->orderBy('producto_id_producto','desc')->get()->first()==NULL)
            {
              $alambre->producto()->attach($producto->idProducto);
            }
            $gases = $gas->productoWithAttributes;
            $alambres = $alambre->productoWithAttributes;
            foreach ($gases as $key => $mg)
            {
              if($mg->pivot->fechaTermino==NULL)
              {
                $mg->pivot->trabajador_id_trabajador = $trabajador->idTrabajador;
                $mg->pivot->save();
                $mg->save();
                $mg->pivot->gastado = $gastoGas;
                $mg->pivot->fechaTermino = now();
                $mg->pivot->save();
                $mg->save();
                break;
              }
            }
            foreach ($alambres as $key => $ag)
            {
                if($ag->pivot->fechaTermino==NULL)
                {
                  $ag->pivot->trabajador_id_trabajador = $trabajador->idTrabajador;
                  $ag->pivot->save();
                  $ag->save();
                  $ag->pivot->gastado = $gastoAlambre;
                  $ag->pivot->fechaTermino = now();
                  $ag->pivot->save();
                  $ag->save();
                  break;
                }
            }
          }
      }
      return "Piezas Registradas";
    }

    public function productoTerminado(Request $request)
    {
      $response = json_decode($request->DATA);

      $cantidad = 0;
      $codigo = $response[0];
      $cantidad += $response[1];
      $idUser = $response[2];
      $cont=0;

      $productosRealizados = 0;

      $user = User::find($idUser);
      $trabajador = $user->trabajador;
      $productos = Producto::get();

      if($trabajador==NULL)
        return 'No existe el trabajador';

      if($productos==NULL)
        return 'No existe el producto';

      if($trabajador->producto!=NULL)
      {
        foreach ($trabajador->producto as $key => $producto)
        {
          if($producto->nombre == $codigo)
          {
            $cont=1;
            $dataProducto = $producto->trabajadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
            $trabajadores = $producto->trabajadorWithAtributtes;

            foreach($trabajadores as $worker)
                if($worker->tipo=="Soldador")
                  $productosRealizados += $worker->pivot->productosRealizados;

            if($producto->cantProducto <= $productosRealizados)
            return 'La pieza ya fue finalizada';

            if(($productosRealizados + $cantidad) > ($producto->cantProducto))
            {
              echo 'La cantidad ingresada supera a la cantidad requerida actual: ';
              echo $dataProducto->pivot->productosRealizados;
              echo ' de: ';
              echo $producto->cantProducto;
              return;
            }
                $dataProducto->pivot->productosRealizados = ($dataProducto->pivot->productosRealizados) + $cantidad;
                $dataProducto->pivot->kilosTrabajados = ($dataProducto->pivot->productosRealizados) * $producto->pesoKg;
                $dataProducto->pivot->fechaComienzo = now();


                $dataProducto->pivot->save();
                $dataProducto->save();
                return 1;
          }
        }
      }
      if($cont==0)
      {
        foreach ($productos as $key => $producto)
        {
          if($producto !=NULL)
          {
            if($producto->nombre == $codigo)
            {
              $cont=1;
              $trabajador->producto()->attach($producto->idProducto);
              $dataProducto = $producto->trabajadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
              $trabajadores = $producto->trabajadorWithAtributtes;

              foreach($trabajadores as $worker)
                  if($worker->user->type=="Soldador")
                    $productosRealizados += $worker->pivot->productosRealizados;

              if($producto->cantProducto <= $productosRealizados)
              return 'La pieza ya fue finalizada';

              if(($productosRealizados + $cantidad) > ($producto->cantProducto))
              {
                echo 'La cantidad ingresada supera a la cantidad requerida actual: ';
                echo $dataProducto->pivot->productosRealizados;
                echo ' de: ';
                echo $producto->cantProducto;
                return;
              }
                  $dataProducto->pivot->productosRealizados = ($dataProducto->pivot->productosRealizados) + $cantidad;
                  $dataProducto->pivot->kilosTrabajados = ($dataProducto->pivot->productosRealizados) * $producto->pesoKg;

                  $dataProducto->pivot->save();
                  $dataProducto->save();
                  return 1;
            }
          }
        }
      }
      return 'No se encontró el producto';
    }
}
