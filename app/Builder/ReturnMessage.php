<?php

namespace App\Builder;
use Illuminate\Http\JsonResponse as JsonResponse;

class ReturnMessage
{

    /**
	 * message
	 *
	 * @param  bool $error
	 * @param  string $message
	 * @param  string $developerMessage
	 * @param  mixed $exception
	 * @param  mixed $data
     * @param  int $status
	 * @return void
	 */
	public static function message(
        bool $error,
        ?string $message,
        ?string $developerMessage,
        ?\Exception $exception,
        $data,
        int $status
    ) : JsonResponse
	{
		return response()->json(
            [
                'error' => $error,
                'message' =>  $message,
                'developerMessage' => $developerMessage,
                'exception' => $exception,
                'data' => $data
            ],
            $status,
            [
                'Content-Type => application/json'
            ]
        );
	}
}
