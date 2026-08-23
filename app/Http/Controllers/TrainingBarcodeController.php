<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Services\TrainingBarcodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TrainingBarcodeController extends Controller
{
    public function __construct(
        private readonly TrainingBarcodeService $barcodeService
    ) {
    }

    private function authorizeRole(): void
    {
        abort_unless(
            auth()->check()
            && in_array(
                auth()->user()->role,
                [
                    'guru',
                    'pelatih',
                ],
                true
            ),
            403
        );
    }

    public function show(
        TrainingSession $trainingSession
    ): View {
        $this->authorizeRole();

        $trainingSession->load([
            'creator',
        ]);

        return view(
            'training.barcode',
            compact('trainingSession')
        );
    }

    public function current(
        TrainingSession $trainingSession
    ): JsonResponse {
        $this->authorizeRole();

        $data = $this->barcodeService
            ->getCurrent($trainingSession);

        return response()->json($data);
    }
}