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

      $cont=0;

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
      $productos = $trabajador->productoSoldador;
      if(count($productos)==0)
      {
        return 'No posees productos terminados';
      }
      foreach ($productos as $key => $producto)
      {
        $foraneaGas=$gas->idMaterial*100+$producto->idProducto*10+$trabajador->idTrabajador;
        $foraneaAlambre=$alambre->idMaterial*100+$producto->idProducto*10+$trabajador->idTrabajador;
        if($producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first()!=NULL)
        {
          $dataProducto = $producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
          if($dataProducto->pivot->productosRealizados < $producto->cantProducto)
          {
            if($cont==0)
              echo 'Piezas Faltantes:';
            $cont++;
            echo ' | ';
            echo $producto->cantProducto-$dataProducto->pivot->productosRealizados;
            echo ' por hacer de la pieza: ';
            echo $producto->codigo;
          }else {
            if($gas->productoWithAttributes()->where('foranea', '=', $foraneaGas)->orderBy('producto_id_producto','desc')->get()->first()==NULL)
            {
                $gas->producto()->attach($producto->idProducto, ['trabajador_id_trabajador' => $trabajador->idTrabajador,'gastado' => $gastoGas, 'fechaTermino' => now(), 'foranea' => $foraneaGas]);
            }
            if($alambre->productoWithAttributes()->where('foranea', '=', $foraneaAlambre)->get()->first()==NULL)
            {
              if($alambre->producto()->attach($producto->idProducto, ['trabajador_id_trabajador' => $trabajador->idTrabajador,'gastado' => $gastoAlambre, 'fechaTermino' => now(), 'foranea' => $foraneaAlambre]))
                $alambre->producto()->attach($producto->idProducto, ['trabajador_id_trabajador' => $trabajador->idTrabajador,'gastado' => $gastoAlambre, 'fechaTermino' => now(), 'foranea' => $foraneaAlambre]);
            }
          }
        }
      }
      return 1;
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
            $dataProducto = $producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
            $trabajadores = $producto->trabajadorSoldadorWithAtributtes;

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
              $trabajador->productoSoldador()->attach($producto->idProducto, ['fechaComienzo' => now()]);
              $dataProducto = $producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
              $trabajadores = $producto->trabajadorSoldadorWithAtributtes;

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
