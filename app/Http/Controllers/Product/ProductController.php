<?php

namespace App\Http\Controllers\Product;

use App\Application\Product\Actions\CreateProductAction;
use App\Application\Product\Actions\DeleteProductAction;
use App\Application\Product\Actions\FilterProductsAction;
use App\Application\Product\Actions\UpdateProductAction;
use App\Application\Product\DTOs\CreateProductDTO;
use App\Application\Product\DTOs\FilterProductsDTO;
use App\Application\Product\DTOs\UpdateProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private CreateProductAction $createProductAction,
        private UpdateProductAction $updateProductAction,
        private DeleteProductAction $deleteProductAction,
        private FilterProductsAction $filterProductsAction
    ) {}

    public function index(Request $request)
    {
        $dto = FilterProductsDTO::fromArray($request->all());
        $products = $this->filterProductsAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'products' => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ],
            ]);
        }

        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function show(int $id)
    {
        $product = app(\App\Domain\Product\Repositories\ProductRepositoryInterface::class)
            ->findById($id);

        if (!$product) {
            abort(404);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'product' => new ProductResource($product),
            ]);
        }

        return view('products.show', [
            'product' => $product,
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(CreateProductRequest $request)
    {
        $dto = CreateProductDTO::fromArray($request->validated());
        $dto = new CreateProductDTO(
            sellerId: auth()->user()->id,
            title: $dto->title,
            description: $dto->description,
            price: $dto->price,
            bikeType: $dto->bikeType,
            frameMaterial: $dto->frameMaterial,
            brakeType: $dto->brakeType,
            wheelSize: $dto->wheelSize,
            weight: $dto->weight,
            weightUnit: $dto->weightUnit,
            brand: $dto->brand,
            model: $dto->model,
            year: $dto->year,
            categoryId: $dto->categoryId,
        );

        $product = $this->createProductAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Product created successfully',
                'product' => new ProductResource($product),
            ], 201);
        }

        return redirect()->route('products.show', $product->getId())
            ->with('success', 'Product created successfully!');
    }

    public function edit(int $id)
    {
        $product = app(\App\Domain\Product\Repositories\ProductRepositoryInterface::class)
            ->findById($id);

        if (!$product || $product->getSellerId() !== auth()->user()->id) {
            abort(403);
        }

        return view('products.edit', [
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $dto = UpdateProductDTO::fromArray($id, $request->validated());
        $product = $this->updateProductAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Product updated successfully',
                'product' => new ProductResource($product),
            ]);
        }

        return redirect()->route('products.show', $product->getId())
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(int $id)
    {
        $this->deleteProductAction->execute($id, auth()->user()->id);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Product deleted successfully',
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}

