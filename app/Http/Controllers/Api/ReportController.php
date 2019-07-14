<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Cage;
use App\Models\Counter;
use App\Models\Report;
use App\Services\Cage\CageService;

class ReportController
{
    public function generate(CageService $cageService)
    {
        $counter = Counter::last();
        $report = new Report();

        $allSheepCount = $cageService->getAllSheepCount();
        $killedSheepCount = $counter->getDaysToBeSlaughtered();

        $report->alive_sheep_count = $allSheepCount;
        $report->biggest_cage_id = $cageService->getBiggestCage(Cage::all())->id;
        $report->killed_sheep_count = $killedSheepCount;
        $report->general_sheep_count = $allSheepCount + $killedSheepCount;
        $report->save();

        return $report;
    }
}