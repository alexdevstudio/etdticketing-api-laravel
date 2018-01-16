<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Mail;
//use App\User;

class RegisterController extends Controller
{

    protected function create(RegisterRequest $request)
    {
      $activation_code = sha1(mt_rand(10000,99999).time().$request['user_email']);
        User::create([
          'user_first_name' => $request['user_first_name'],
          'user_last_name' => $request['user_last_name'],
          'user_geo_location' => $request['user_geo_location'],
          'user_office' => $request['user_office'],
          'user_floor' => $request['user_floor'],
          'user_telephone' => $request['user_telephone'],
          'user_email' => $request['user_email'],
          'user_password' => Hash::make($request['user_password']),
          'user_activation_code' => $activation_code
        ]);
        
        $fname = $request['user_first_name'];
        $email = $request['user_email'];

        $data = [
            'fname' => $fname,
            'email' => $email,
            'activation_code' => $activation_code
          ];

        Mail::send('emails.activation', $data, function ($message) use ($data) {
          $message->to($data['email']);
          $message->from('esupport@bluecdf.gr');
          $message->subject('Activate Your Account');
       });

        return response()->json([
          'success' => true,
          'message' => 'Register success'
        ]);
    }


}
