<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Post login resource in storage.
     *
     * @param  \Illuminate\Http\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email','password'),$request->filled('remember'))) {
            return $this->errorResponse('The provided credentials do not match our records!', null, 401);
        }

        if(Auth::user()->status == User::STATUS_INACTIVE) {
            Auth::logout();
            
            return $this->errorResponse('Your account is suspended, please contact administrator!', null,  403);
        }

        Auth::user()->update([
            'device_name' => $request->device_name,
            'device_token' => $request->device_token,
        ]);

        $data = [
            'user' => Auth::user(),
            'token' => Auth::user()->createToken('API Token')->plainTextToken,
        ];

        return $this->successResponse('Successfully logged in!', $data);
    }

    /**
     * Logout resource in storage.
     *
     * @param  \Illuminate\Http\LogoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->successResponse('Successfully logged out!', null);
    }
}
