<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;

class AddressController extends Controller
{
  protected function getAll()
  {

    $addresses = Address::all();
    
      if($addresses){
        return response()->json([
          'success' => true,
          'addresses' =>   $addresses
        ]);
      }


      return response()->json([
        'message' => 'Unknown Error. Contact the support team'
      ], 401);


  }
}
