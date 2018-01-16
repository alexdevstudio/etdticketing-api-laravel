<?php

namespace App\Http\Controllers;

use App\Office;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeRequest;


class OfficeController extends Controller
{
  protected function getAll(OfficeRequest $request)
  {
    $office_address_id = $request['office_address_id'];
    $offices = Office::where('office_address_id', $office_address_id)->get();

    if($offices){
      return response()->json([
        'success' => true,
        'offices' => $offices
      ]);
    }

    return response()->json([
      'error' => true,
      'message' => 'No Offices Were Found. Try Another Geo Location'
    ], 422);


  }
}
