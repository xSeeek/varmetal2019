<?php

namespace Asistencia\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
      return redirect()->route('login');
    }
}
