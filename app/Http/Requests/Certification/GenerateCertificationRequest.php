<?php

namespace App\Http\Requests\Certification;

use Illuminate\Foundation\Http\FormRequest;

class GenerateCertificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('workshop');
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'inspection_id' => ['required', 'integer', 'exists:inspections,id'],
            'workshop_id' => ['required', 'integer', 'exists:users,id'],
            'grade' => ['required', 'string', 'in:A+,A,B,C'],
        ];
    }
}

