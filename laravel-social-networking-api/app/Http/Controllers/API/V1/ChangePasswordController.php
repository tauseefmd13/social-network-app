<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ChangePasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ChangePasswordRequest $request)
    {
        if(auth()->check()) {
            if(!Hash::check($request->old_password, auth()->user()->password)) {
                $errors = [
                    'old_password' => ['The provided old password does not match our records.'],
                ];
                return $this->validationErrorResponse('The given data was invalid.', $errors);
            }

            auth()->user()->update([
                'password' => Hash::make($request->password),
            ]);

            return $this->successResponse('Password updated successfully!', null);
        } else {
            return $this->errorResponse('User not found!', null, 404);
        }
    }
}
