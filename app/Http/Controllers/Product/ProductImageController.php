<?php

namespace App\Http\Controllers\Product;

use App\Application\Product\Actions\UploadProductImagesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UploadProductImagesRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;

class ProductImageController extends Controller
{
    public function __construct(
        private UploadProductImagesAction $uploadProductImagesAction
    ) {}

    public function store(UploadProductImagesRequest $request, int $productId)
    {
        $files = $request->file('images');
        $primaryIndex = $request->input('primary_index');

        $product = $this->uploadProductImagesAction->execute(
            $productId,
            $files,
            $primaryIndex
        );

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Images uploaded successfully',
                'product' => new ProductResource($product),
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }
}

