<?php

namespace App\Http\Requests\Inspection;

use Illuminate\Foundation\Http\FormRequest;

class SubmitInspectionReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('workshop');
    }

    public function rules(): array
    {
        return [
            'frame_grade' => ['required', 'string', 'in:excellent,very_good,good,fair,poor'],
            'frame_notes' => ['nullable', 'string'],
            'brake_grade' => ['required', 'string', 'in:excellent,very_good,good,fair,poor'],
            'brake_notes' => ['nullable', 'string'],
            'groupset_grade' => ['required', 'string', 'in:excellent,very_good,good,fair,poor'],
            'groupset_notes' => ['nullable', 'string'],
            'wheels_grade' => ['required', 'string', 'in:excellent,very_good,good,fair,poor'],
            'wheels_notes' => ['nullable', 'string'],
            'overall_grade' => ['required', 'string', 'in:A+,A,B,C'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

