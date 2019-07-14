<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cage;
use App\Models\Counter;
use App\Services\Cage\CageService;
use App\Services\Cage\FillerService;

class CounterService
{
    private const FILL_SHEEP_COUNT = 10;

    /**
     * @var CageService
     */
    private $cage;

    /**
     * @var FillerService
     */
    private $filler;

    public function __construct(CageService $cage, FillerService $filler)
    {
        $this->cage = $cage;
        $this->filler = $filler;
    }

    public function start(): void
    {
        Counter::start();

        $this->emptyAndFillCages();
    }


    public function makeSheep(): void
    {
        $counter = Counter::last();

        if(!$counter) {
            return;
        }

        $cages = Cage::all();

        $this->emptyAndFillCages();

        /**
         * Sheep to be born, is the same to the count, to born.
         */
        $sheepToBeBorn = $counter->getDaysPassed();

        if($sheepToBeBorn > 0) {
            $this->cage->born($cages, $sheepToBeBorn);
        }

        /**
         * Sheep to be slaughtered is the same, to the days, to be slaughtered.
         */
        $sheepToBeSlaughtered = $counter->getDaysToBeSlaughtered();

        if($sheepToBeSlaughtered > 0) {
            $this->cage->slaughter($cages, $sheepToBeSlaughtered);
        }
    }

    private function emptyAndFillCages()
    {
        $this->cage->killAllSheep();
        $this->filler->fill(self::FILL_SHEEP_COUNT);
    }
}