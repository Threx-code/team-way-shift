<?php

namespace App\Http\Requests\Manager;

use App\Helpers\ShiftTypes;
use App\Validators\ValidatorResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkerRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'before:end_date'],
            'user_id' => ['required', 'integer'],
            'manager_id' => ['required', 'integer'],
            'shift' => ['required',  Rule::in(ShiftTypes::SHIFTS)],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        ValidatorResponse::validationErrors($validator->errors(), 422);
    }
}
