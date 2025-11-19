<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'bike_type' => ['sometimes', 'string', 'in:road,mountain,gravel,hybrid,electric,bmx,cruiser,folding,touring,cyclocross'],
            'frame_material' => ['sometimes', 'string', 'in:carbon,aluminum,steel,titanium,titanium_carbon'],
            'brake_type' => ['sometimes', 'string', 'in:rim_brake,disc_brake_mechanical,disc_brake_hydraulic,coaster_brake'],
            'wheel_size' => ['sometimes', 'string'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'weight_unit' => ['nullable', 'string', 'in:kg,lbs'],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
        ];
    }
}

