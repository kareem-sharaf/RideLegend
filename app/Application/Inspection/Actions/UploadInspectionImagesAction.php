<?php

namespace App\Application\Inspection\Actions;

use App\Domain\Inspection\Models\Inspection;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;
use App\Domain\Shared\Exceptions\BusinessRuleViolationException;
use App\Infrastructure\Services\InspectionImage\InspectionImageServiceInterface;
use Illuminate\Http\UploadedFile;

class UploadInspectionImagesAction
{
    public function __construct(
        private InspectionRepositoryInterface $inspectionRepository,
        private InspectionImageServiceInterface $imageService
    ) {}

    public function execute(int $inspectionId, array $files): Inspection
    {
        $inspection = $this->inspectionRepository->findById($inspectionId);

        if ($inspection === null) {
            throw new BusinessRuleViolationException(
                'Inspection not found',
                'INSPECTION_NOT_FOUND'
            );
        }

        $images = $inspection->getImages();

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $path = $this->imageService->store($file, $inspectionId);
            $images->push($path);
        }

        $inspection->setImages($images);

        return $this->inspectionRepository->save($inspection);
    }
}

