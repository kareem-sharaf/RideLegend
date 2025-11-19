<?php

namespace App\Http\Controllers\Inspection;

use App\Application\Inspection\Actions\CreateInspectionRequestAction;
use App\Application\Inspection\Actions\SubmitInspectionReportAction;
use App\Application\Inspection\Actions\UploadInspectionImagesAction;
use App\Application\Inspection\DTOs\CreateInspectionRequestDTO;
use App\Application\Inspection\DTOs\SubmitInspectionReportDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inspection\CreateInspectionRequest;
use App\Http\Requests\Inspection\SubmitInspectionReportRequest;
use App\Http\Requests\Inspection\UploadInspectionImagesRequest;
use App\Http\Resources\InspectionResource;
use Illuminate\Http\JsonResponse;

class InspectionController extends Controller
{
    public function __construct(
        private CreateInspectionRequestAction $createInspectionRequestAction,
        private SubmitInspectionReportAction $submitInspectionReportAction,
        private UploadInspectionImagesAction $uploadInspectionImagesAction
    ) {}

    public function store(CreateInspectionRequest $request)
    {
        $dto = CreateInspectionRequestDTO::fromArray($request->validated());
        $dto = new CreateInspectionRequestDTO(
            productId: $dto->productId,
            sellerId: auth()->user()->id,
            workshopId: $dto->workshopId,
        );

        $inspection = $this->createInspectionRequestAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Inspection request created successfully',
                'inspection' => new InspectionResource($inspection),
            ], 201);
        }

        return redirect()->back()->with('success', 'Inspection request created!');
    }

    public function submitReport(SubmitInspectionReportRequest $request, int $id)
    {
        $dto = SubmitInspectionReportDTO::fromArray(array_merge($request->validated(), ['inspection_id' => $id]));
        $inspection = $this->submitInspectionReportAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Inspection report submitted successfully',
                'inspection' => new InspectionResource($inspection),
            ]);
        }

        return redirect()->back()->with('success', 'Inspection report submitted!');
    }

    public function uploadImages(UploadInspectionImagesRequest $request, int $id)
    {
        $files = $request->file('images');
        $inspection = $this->uploadInspectionImagesAction->execute($id, $files);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Images uploaded successfully',
                'inspection' => new InspectionResource($inspection),
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }
}

