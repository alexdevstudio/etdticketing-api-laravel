<?php

namespace App\Http\Controllers;

use App\Floor;
use App\Http\Controllers\Controller;
use App\Http\Requests\FloorRequest;


class FloorController extends Controller
{
  protected function getAll(FloorRequest $request)
  {
    $floor_address_id = $request['floor_address_id'];

    $floors = Floor::where('floor_address_id', $floor_address_id)->get();

    if($floors){
      return response()->json([
        'success' => true,
        'floors' => $floors
      ]);
    }

    return response()->json([
      'error' => true,
      'message' => 'No Floors Were Found. Try Another Geo Location'
    ], 422);


  }
}
