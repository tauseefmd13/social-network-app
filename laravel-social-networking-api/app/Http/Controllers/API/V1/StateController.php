<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = State::query();

        $query->when($request->country_id, function ($q) use ($request) {
            return $q->where('country_id', $request->country_id);
        });

        $query->with('country');
        $states = $query->get();

        return StateResource::collection($states);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        $state->load('country');

        return new StateResource($state);
    }
}
