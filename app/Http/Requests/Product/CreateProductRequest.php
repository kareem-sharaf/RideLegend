<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('seller');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'bike_type' => ['required', 'string', 'in:road,mountain,gravel,hybrid,electric,bmx,cruiser,folding,touring,cyclocross'],
            'frame_material' => ['required', 'string', 'in:carbon,aluminum,steel,titanium,titanium_carbon'],
            'brake_type' => ['required', 'string', 'in:rim_brake,disc_brake_mechanical,disc_brake_hydraulic,coaster_brake'],
            'wheel_size' => ['required', 'string'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'weight_unit' => ['nullable', 'string', 'in:kg,lbs'],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
        ];
    }
}

