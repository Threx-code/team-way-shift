<?php

namespace App\Validators;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidatorResponse
{
    /**
     * @param $error
     * @param $code
     * @return void
     */
    public static function validationErrors($error, $code): void
    {
        $errorResponse = response()->json(['message' => $error->first()], $code);
        RepositoryValidator::throw($errorResponse);
    }
}
