<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\CounterService;

class CounterController
{
    public function start(CounterService $counter)
    {
        $counter->start();
    }
}