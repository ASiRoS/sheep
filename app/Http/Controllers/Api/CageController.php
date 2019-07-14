<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Cage;
use App\Services\Cage\CageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CageController
{
    public function slaughter(Request $request, CageService $cageService)
    {
        $count = $request->request->getInt('count');

        try {
            $cageService->slaughter(Cage::all(), $count);

            return new JsonResponse([
                'message' => "$count sheep was slaughtered.",
            ]);
        } catch(\DomainException $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}