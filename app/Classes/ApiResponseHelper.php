<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiResponseHelper
{
    public static function rollBack(Throwable $exception, string $message = 'Failure in the process')
    {
        DB::rollBack();
        return self::throw($exception, $message);
    }

    public static function throw(Throwable $exception, string $message = 'Failure in the process')
    {
        Log::info($exception->getMessage());
        throw new HttpResponseException(response()->json([
            'message' => $message,
        ], 500));
    }

    public static function sendResponse($result, string $message = 'Success', int $statusCode = 200)
    {
        if ($statusCode == 204) return response()->noContent();

        $response = [
            'success' => true,
            'data' => $result,
        ];

        if (!empty($message)) $response['message'] = $message;

        return response()->json($response, $statusCode);
    }
}
