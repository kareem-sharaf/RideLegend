<?php

namespace App\Application\Admin\Products\Actions;

use App\Application\Admin\Products\DTOs\ListProductsDTO;
use App\Infrastructure\Services\Export\ExportServiceInterface;

class ExportProductsAction
{
    public function __construct(
        private ExportServiceInterface $exportService,
    ) {}

    public function execute(ListProductsDTO $dto, string $format = 'csv'): string
    {
        // Get all products (no pagination for export)
        $dto = new ListProductsDTO(
            status: $dto->status,
            search: $dto->search,
            sellerId: $dto->sellerId,
            categoryId: $dto->categoryId,
            minPrice: $dto->minPrice,
            maxPrice: $dto->maxPrice,
            dateFrom: $dto->dateFrom,
            dateTo: $dto->dateTo,
            sortBy: $dto->sortBy,
            sortDirection: $dto->sortDirection,
            page: 1,
            perPage: 10000, // Large number to get all
        );

        $listAction = new \App\Application\Admin\Products\Actions\ListProductsAction();
        $products = $listAction->execute($dto);

        // Prepare data for export
        $data = [];
        foreach ($products->items() as $product) {
            $data[] = [
                'ID' => $product->id,
                'Title' => $product->title,
                'Brand' => $product->brand,
                'Model' => $product->model,
                'Price' => $product->price,
                'Status' => $product->status,
                'Seller' => $product->seller->email ?? 'N/A',
                'Created At' => $product->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $headers = ['ID', 'Title', 'Brand', 'Model', 'Price', 'Status', 'Seller', 'Created At'];

        if ($format === 'csv') {
            return $this->exportService->exportToCsv($data, $headers);
        } else {
            return $this->exportService->exportToPdf($data, 'admin.exports.products');
        }
    }
}

