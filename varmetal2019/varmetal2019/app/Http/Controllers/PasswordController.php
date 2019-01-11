<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PasswordController extends Controller
{
    public function resetPassword()
    {
      return view('auth.passwords.reset');
    }
}
