<?php

namespace App\Http\Controllers\Certification;

use App\Application\Certification\Actions\GenerateCertificationAction;
use App\Application\Certification\DTOs\GenerateCertificationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Certification\GenerateCertificationRequest;
use App\Http\Resources\CertificationResource;
use Illuminate\Http\JsonResponse;

class CertificationController extends Controller
{
    public function __construct(
        private GenerateCertificationAction $generateCertificationAction
    ) {}

    public function generate(GenerateCertificationRequest $request)
    {
        $dto = GenerateCertificationDTO::fromArray($request->validated());
        $certification = $this->generateCertificationAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Certification generated successfully',
                'certification' => new CertificationResource($certification),
            ], 201);
        }

        return redirect()->back()->with('success', 'Certification generated successfully!');
    }

    public function show(int $id)
    {
        $certification = app(\App\Domain\Certification\Repositories\CertificationRepositoryInterface::class)
            ->findById($id);

        if (!$certification) {
            abort(404);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'certification' => new CertificationResource($certification),
            ]);
        }

        return view('certifications.show', [
            'certification' => $certification,
        ]);
    }
}

