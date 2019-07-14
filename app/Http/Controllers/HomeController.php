<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Services\CounterService;

class HomeController
{
    public function index(CounterService $counter)
    {
        $counter->makeSheep();

        $cages = Cage::all();


        return view('home.index', compact('cages'));
    }
}