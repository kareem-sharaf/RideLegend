<?php

namespace App\Application\Certification\Actions;

use App\Application\Certification\DTOs\GenerateCertificationDTO;
use App\Domain\Certification\Events\CertificationGenerated;
use App\Domain\Certification\Models\Certification;
use App\Domain\Certification\Repositories\CertificationRepositoryInterface;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;
use App\Domain\Inspection\ValueObjects\OverallGrade;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Infrastructure\Services\InspectionReport\InspectionReportPdfServiceInterface;
use Illuminate\Contracts\Events\Dispatcher;

class GenerateCertificationAction
{
    public function __construct(
        private CertificationRepositoryInterface $certificationRepository,
        private InspectionRepositoryInterface $inspectionRepository,
        private ProductRepositoryInterface $productRepository,
        private InspectionReportPdfServiceInterface $pdfService,
        private Dispatcher $eventDispatcher
    ) {}

    public function execute(GenerateCertificationDTO $dto): Certification
    {
        $inspection = $this->inspectionRepository->findById($dto->inspectionId);

        if ($inspection === null) {
            throw new BusinessRuleViolationException(
                'Inspection not found',
                'INSPECTION_NOT_FOUND'
            );
        }

        if (!$inspection->isCompleted()) {
            throw new BusinessRuleViolationException(
                'Inspection must be completed before generating certification',
                'INSPECTION_NOT_COMPLETED'
            );
        }

        $product = $this->productRepository->findById($dto->productId);

        if ($product === null) {
            throw new BusinessRuleViolationException(
                'Product not found',
                'PRODUCT_NOT_FOUND'
            );
        }

        // Generate PDF report
        $reportUrl = $this->pdfService->generate($inspection, $product);

        $overallGrade = OverallGrade::fromString($dto->grade);

        $certification = Certification::create(
            productId: $dto->productId,
            inspectionId: $dto->inspectionId,
            workshopId: $dto->workshopId,
            grade: $overallGrade,
            reportUrl: $reportUrl
        );

        $certification = $this->certificationRepository->save($certification);

        // Attach certification to product
        $product->assignCertification($certification->getId());
        $this->productRepository->save($product);

        // Dispatch domain events
        $certification->getDomainEvents()->each(function ($event) {
            $this->eventDispatcher->dispatch($event);
        });
        $certification->clearDomainEvents();

        return $certification;
    }
}

