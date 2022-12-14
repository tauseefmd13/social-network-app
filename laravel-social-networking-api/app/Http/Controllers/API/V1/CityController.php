<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = City::query();

        $query->when($request->state_id, function ($q) use ($request) {
            return $q->where('state_id', $request->state_id);
        });

        $query->with('state');
        $cities = $query->get();

        return CityResource::collection($cities);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        $city->load('state');

        return new CityResource($city);
    }
}
