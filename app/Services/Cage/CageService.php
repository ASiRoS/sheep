<?php

declare(strict_types=1);

namespace App\Services\Cage;

use App\Models\Cage;
use App\Models\Counter;
use App\Models\Event;
use App\Models\Sheep;
use DomainException;
use Illuminate\Database\Eloquent\Collection;

class CageService
{
    /**
     * @param Collection|Cage[] $cages
     * @param int $count sheep's to be slaughter count.
     * @throws DomainException
     */
    public function slaughter(Collection $cages, int $count): void
    {
        $eachCageSheepCount = [];

        foreach($cages as $cage) {
            $eachCageSheepCount[$cage->id] = $cage->sheep()->count();
        }

        $allSheepCountInCages = array_sum($eachCageSheepCount);
        $sheepCountCanBeSlaughtered = $allSheepCountInCages - count($cages);

        if($count > $sheepCountCanBeSlaughtered) {
            throw new DomainException('Too many sheep\'s to be slaughtered.');
        }

        foreach($cages as $cage) {
            if($count <= 0) {
                break;
            }

            $sheepCountInCage = $eachCageSheepCount[$cage->id];
            $slaughterCount = $this->calculateSlaughterCount($count, $sheepCountInCage);

            if($slaughterCount > 0) {
                $cage->removeLastSheep($slaughterCount);
                $count -= $slaughterCount;
            }
        }
    }

    private function calculateSlaughterCount(int $general, int $sheepInCage): int
    {
        if($sheepInCage > $general) {
            return $general;
        }

        $count = $sheepInCage - 1;

        return $count > -1 ? $count : 0;
    }

    /**
     * @param Collection|Cage[] $cages
     * @param int $count
     */
    public function born(Collection $cages, int $count = 1): void
    {
        foreach($cages as $cage) {
            if($cage->isNotPaired()) {
                continue;
            }

            for($i = 0; $i < $count; $i++) {
                $sheep = $cage->addSheep('Овечка');

                Event::new("Sheep #{$sheep->id} was added to cage #{$cage->id}");
            }
        }
    }

    /**
     * @param Collection|Cage[] $cages
     */
    public function fillAloneCages(Collection $cages): void
    {
        $lonelyCages = $this->getLonelyCages($cages);

        foreach($lonelyCages as $lonelyCage) {
            $biggestCage = $this->getBiggestCage($cages);

            if($biggestCage->sheepCount() > 1) {
                $sheep = $biggestCage->getLastSheep();
                $sheep->move($lonelyCage);

                Event::new( "Sheep #{$sheep->id} has moved from cage #{$lonelyCage->id} to cage #{$biggestCage->id}");
            }
        }
    }

    /**
     * @param Collection|Cage[] $cages
     *
     * @return Cage[]
     */
    private function getLonelyCages(Collection $cages): array
    {
        $lonelyCages = [];

        foreach($cages as $cage) {
            if(count($cage->sheep) === 1) {
                $lonelyCages[] = $cage;
            }
        }

        return $lonelyCages;
    }

    /**
     * @param Collection|Cage[] $cages
     *
     * @return Cage $cage
     */
    private function getBiggestCage(Collection $cages)
    {
        $biggestCountCage = null;

        foreach($cages as $key => $cage) {
            $count = is_null($biggestCountCage) ? 0 : count($biggestCountCage->sheep);
            $sheepCount = count($cage->sheep);

            if($sheepCount > $count) {
                $biggestCountCage = $cage;
            }
        }

        return $biggestCountCage;
    }

    public function killAllSheep()
    {
        Sheep::truncate();
    }
}