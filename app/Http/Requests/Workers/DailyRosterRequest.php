<?php

namespace App\Http\Requests\Workers;

use App\Validators\ValidatorResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DailyRosterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        ValidatorResponse::validationErrors($validator->errors());
    }
}
