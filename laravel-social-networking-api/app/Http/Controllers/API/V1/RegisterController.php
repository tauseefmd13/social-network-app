<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'device_name' => $request->device_name,
            'device_token' => $request->device_token,
        ]);

        // event(new Registered($user));
        // Auth::login($user);

        $data = [
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken,
        ];

        return $this->successResponse('Successfully registered!', $data, 201);
    }
}
