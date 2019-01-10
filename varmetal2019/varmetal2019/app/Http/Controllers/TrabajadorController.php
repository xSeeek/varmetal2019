<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Trabajador;
use Varmetal\User;
use Varmetal\Producto;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Auth;

class TrabajadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminTrabajadores()
    {
        $trabajadores_registrados = Trabajador::get();
        return view('admin.administracion_trabajadores')->with('trabajadores_almacenados', $trabajadores_registrados);
    }

    public function trabajadorControl($data)
    {
        if($data == 'undefined')
            return redirect()->route('adminTrabajador');

        $datos_trabajador = Trabajador::find($data);
        $userTrabajador = $datos_trabajador->user;
        $productos = $datos_trabajador->productoIncompleto;

        return view('admin.trabajador.trabajador_control')
                                ->with('trabajador', $datos_trabajador)
                                ->with('usuario_trabajador', $userTrabajador)
                                ->with('productos_trabajador', $productos);
    }

    public function addTrabajador()
    {
        return view('admin.trabajador.addTrabajador');
    }

    public function createPassword()
    {
        $pass = User::createPassword(8);
        return $pass;
    }

    public function insertTrabajador(Request $data)
    {
        $newUserTrabajador = new User;
        $newUserTrabajador->email = $data->email;
        $newUserTrabajador->password = bcrypt($data->password);
        $newUserTrabajador->type = User::DEFAULT_TYPE;

        $verify = User::where('email', '=', $data->email)
                                ->get();

        if(count($verify))
            return "Correo ya registrado en el sistema, ingrese otro correo.";

        if($newUserTrabajador->validateData($data->email) == false)
            return "Tiene que ingresar un email para el usuario.";
        if($newUserTrabajador->validateData($data->password) == false)
            return "Tiene que ingresar o generar una contraseña para el usuario.";

        $newTrabajador = new Trabajador;
        $newTrabajador->nombre = $data->nameTrabajador;
        $newTrabajador->rut = $data->rutTrabajador;
        $newTrabajador->estado = true;

        if($newTrabajador->validateData($data->nameTrabajador) == false)
            return "Tiene que ingresar el nombre para el trabajador.";
        if($newTrabajador->validateData($data->rutTrabajador) == false)
            return "Tiene que ingresar el RUT del trabajador.";
        if((Rut::parse($data->rutTrabajador)->validate()) == false)
            return "RUT no válido.";

        $newUserTrabajador->save();
        $newUserTrabajador->trabajador()->save($newTrabajador);

        return 1;
    }

    public function deleteTrabajador(Request $request)
    {
        $trabajador = Trabajador::find($request->DATA);
        $trabajador->delete();
        $trabajador->user->delete();
        return 1;
    }

    public function productosTrabajador()
    {
        $usuarioActual = Auth::user();

        if($usuarioActual->trabajador == NULL)
            return redirect()->route('/home');

        $datos_trabajador = $usuarioActual->trabajador;
        $productos = $datos_trabajador->producto;

        return view('trabajador.productos_trabajador')
                ->with('productos', $productos);
    }

    public function asignarTrabajo($data)
    {
        $trabajador = Trabajador::find($data);
        $productos_almacenados = Producto::where('terminado', '=', 'false')->get();
        $productos = $trabajador->producto;

        $productos_disponibles = null;
        $i = 0;
        $cont = 0;

        foreach($productos_almacenados as $p_saved)
        {
            foreach($productos as $p_asig)
                if($p_saved->idProducto == $p_asig->idProducto)
                    $cont++;
            if($cont == 0)
            {
                $productos_disponibles[$i] = $p_saved;
                $i++;
            }
            $cont = 0;
        }

        return view('admin.trabajador.productos_disponibles')
                ->with('productos_almacenados', $productos_disponibles)
                ->with('idTrabajador', $data);
    }
}
