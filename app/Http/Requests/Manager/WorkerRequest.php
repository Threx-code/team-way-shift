<?php

namespace App\Http\Requests\Manager;

use App\Helpers\ShiftTypes;
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
            'shift_date' => ['required'],
            'user_id' => ['required', 'integer'],
            'manager_id' => ['required', 'integer'],
            'shift_id' => ['required',  Rule::exists('shifts', 'id')],
        ];
    }
}
