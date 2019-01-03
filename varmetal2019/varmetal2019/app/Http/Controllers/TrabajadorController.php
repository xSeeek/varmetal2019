<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabajador;
use App\User;
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
        $productos = $datos_trabajador->producto;

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
        if($data->statusUser == 0)
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
        }
        else
        {
            $newUserTrabajador = User::where('email', '=', $data->email)
                                ->first();
        }

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

        if($data->statusUser == 0)
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
}
