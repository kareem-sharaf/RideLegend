<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Products\Actions\BulkDeleteProductsAction;
use App\Application\Admin\Products\Actions\BulkUpdateProductStatusAction;
use App\Application\Admin\Products\Actions\DeleteProductAction;
use App\Application\Admin\Products\Actions\ExportProductsAction;
use App\Application\Admin\Products\Actions\ListProductsAction;
use App\Application\Admin\Products\Actions\ShowProductAction;
use App\Application\Admin\Products\Actions\UpdateProductAction;
use App\Application\Admin\Common\DTOs\BulkActionDTO;
use App\Application\Admin\Products\DTOs\DeleteProductDTO;
use App\Application\Admin\Products\DTOs\ListProductsDTO;
use App\Application\Admin\Products\DTOs\ShowProductDTO;
use App\Application\Admin\Products\DTOs\UpdateProductDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
        private ListProductsAction $listProductsAction,
        private ShowProductAction $showProductAction,
        private UpdateProductAction $updateProductAction,
        private DeleteProductAction $deleteProductAction,
        private BulkDeleteProductsAction $bulkDeleteProductsAction,
        private BulkUpdateProductStatusAction $bulkUpdateProductStatusAction,
        private ExportProductsAction $exportProductsAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListProductsDTO(
            status: $request->input('status'),
            search: $request->input('search'),
            sellerId: $request->input('seller_id') ? (int)$request->input('seller_id') : null,
            categoryId: $request->input('category_id') ? (int)$request->input('category_id') : null,
            minPrice: $request->input('min_price') ? (float)$request->input('min_price') : null,
            maxPrice: $request->input('max_price') ? (float)$request->input('max_price') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $products = $this->listProductsAction->execute($dto);

        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        $dto = new ShowProductDTO(productId: (int)$id);
        $product = $this->showProductAction->execute($dto);

        // Get Eloquent model for view
        $eloquentProduct = \App\Models\Product::with(['seller', 'category', 'certification', 'images', 'inspection'])
            ->findOrFail($id);

        return view('admin.products.show', [
            'product' => $eloquentProduct,
            'domainProduct' => $product,
        ]);
    }

    public function approve($id)
    {
        $dto = new UpdateProductDTO(
            productId: (int)$id,
            status: 'active',
        );

        $this->updateProductAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Product approved successfully');
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $dto = new UpdateProductDTO(
            productId: (int)$id,
            status: 'rejected',
            rejectionReason: $validated['reason'] ?? null,
        );

        $this->updateProductAction->execute($dto);

        return redirect()->back()
            ->with('success', 'Product rejected successfully');
    }

    public function destroy($id)
    {
        $dto = new DeleteProductDTO(productId: (int)$id);
        $this->deleteProductAction->execute($dto);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|string|in:delete,approve,reject',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:products,id',
        ]);

        $dto = new BulkActionDTO(
            action: $validated['action'],
            ids: $validated['ids'],
            data: match($validated['action']) {
                'approve' => ['status' => 'active'],
                'reject' => ['status' => 'rejected'],
                default => null,
            },
        );

        $count = match($validated['action']) {
            'delete' => $this->bulkDeleteProductsAction->execute($dto),
            'approve', 'reject' => $this->bulkUpdateProductStatusAction->execute($dto),
        };

        return redirect()->back()
            ->with('success', "Bulk action completed. {$count} items affected.");
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'format' => 'required|string|in:csv,pdf',
        ]);

        $dto = new ListProductsDTO(
            status: $request->input('status'),
            search: $request->input('search'),
            sellerId: $request->input('seller_id') ? (int)$request->input('seller_id') : null,
            categoryId: $request->input('category_id') ? (int)$request->input('category_id') : null,
            minPrice: $request->input('min_price') ? (float)$request->input('min_price') : null,
            maxPrice: $request->input('max_price') ? (float)$request->input('max_price') : null,
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: 1,
            perPage: 15,
        );

        $filepath = $this->exportProductsAction->execute($dto, $validated['format']);

        return Storage::download(str_replace(storage_path('app/'), '', $filepath));
    }
}
