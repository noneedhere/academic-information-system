<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isTeacher();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date'                    => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'attendances'             => ['required', 'array', 'min:1'],
            'attendances.*.student_id' => ['required', 'exists:users,id'],
            'attendances.*.status'    => ['required', 'in:present,sick,permission,absent'],
            'attendances.*.notes'     => ['nullable', 'string', 'max:500'],
        ];
    }
}
