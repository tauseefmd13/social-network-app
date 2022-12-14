<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Response Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponseTrait
{
	/**
     * Return a success JSON response.
     *
     * @param  string  $message
     * @param  array|string  $data
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
	protected function successResponse(string $message = null, $data, int $code = 200)
	{
		return response()->json([
			'success' => true,
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
	protected function errorResponse(string $message = null, $data = null, int $code = 200)
	{
		return response()->json([
			'success' => false,
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
	protected function validationErrorResponse(string $message = null, $data = null, int $code = 422)
	{
		return response()->json([
			'success' => false,
			'message' => $message,
			'errors' => $data
		], $code);
	}
}