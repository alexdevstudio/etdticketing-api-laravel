<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivationRequest;


class ActivationController extends Controller
{
  protected function activate(ActivationRequest $request)
  {
    // $user = User::find(11);
    //
    // $user->user_first_name = 'Alex2';
    //
    // $user->save();

    $user = User::where('user_activation_code', $request['user_activation_code'])
          ->where('user_status', 0)
          ->update(['user_status' => 1]);

      if($user > 0){
        return response()->json([
          'success' => true,
          'message' =>   $user
        ]);
      }


      return response()->json([
        'message' => 'Ο κωδικός ενεργοποίησης δεν είναι έγκυρος. Επικοινωνήστε με το γραφείο Πληροφορικής για την επίλυση του ζητήματος '
      ], 401);


  }
}
