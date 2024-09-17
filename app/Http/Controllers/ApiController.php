<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{

    /**
     * Success response
     *
     * @param [type] $data
     * @param integer $httpStatusCode
     * @return void
     */
    protected function successResponse($data, string $message = "success", int $httpStatusCode = 200)
    {
        return response()->json([
            'status'    => 'success',
            'message'   => $message,
            'data'      => $data
        ], $httpStatusCode);
    }

    /**
     * Error response
     *
     * @param string|array $message
     * @param integer $httpStatusCode
     * @return void
     */
    protected function errorResponse(string|array $message, int $httpStatusCode = 400)
    {

        $message = is_string($message) ? array($message) : $message;

        return response()->json([
            'status'    => 'error',
            'message'   => $message,
        ], $httpStatusCode);
    }
}
