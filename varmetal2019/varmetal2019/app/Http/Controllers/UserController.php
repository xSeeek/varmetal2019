<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

class UserController extends Controller
{
  public function getProfilePassword(Request $request) {
    return view('emails.cambiarContraseña', ['user' => Auth::user()]);
  }

  public function postProfilePassword(Request $request) {
      $user = Auth::user();

      $this->validate($request, [
       'old_password'   => 'required',
       'password'    => 'required',
       'password_confirmation' => 'required|same:password'
      ]);

      if(Hash::check($request->old_password,$user->password))
      {
        $user->password = bcrypt($request->password);
        $user->save();
      }
      echo 'Contraseña cambiada';
      return view('welcome');
    }
/*Email*/
    public function getProfileEmail(Request $request) {
      return view('emails.cambiarEmail', ['user' => Auth::user()]);
    }

    public function postProfileEmail(Request $request) {
        $user = Auth::user();

        $this->validate($request, [
         'actual_password'   => 'required',
         'email'    => 'required',
         'email_confirmation' => 'required|same:email'
        ]);

        if(Hash::check($request->actual_password,$user->password))
        {
          $user->email = $request->email;
          $user->save();
        }
        return view('welcome');
      }
}
