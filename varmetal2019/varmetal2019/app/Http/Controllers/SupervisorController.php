<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function menuTrabajador()
    {
        return view('menu_trabajadores');
    }
}
