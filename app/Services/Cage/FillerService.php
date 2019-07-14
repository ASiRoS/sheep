<?php

declare(strict_types=1);

namespace App\Services\Cage;

use App\Models\Cage;

class FillerService
{
    private $cages, $livingCages;

    /**
     * Run the database seeds.
     *
     * @param int $sheepCount
     *
     * @return void
     */
    public function fill(int $sheepCount): void
    {
        $this->refresh();

        if(count($this->cages) > $sheepCount) {
            throw new \DomainException('Sheep count must be more than cages count.');
        }

        for($i = 0; $i < $sheepCount; $i++) {
            $cage = $this->getCage();
            $cage->addSheep("Овечка #$i");
        }
    }

    private function getCage(): Cage
    {
        $cageIndex = $this->getIndex();

        $this->fillCage($cageIndex);

        return $this->cages[$cageIndex];
    }

    private function getIndex(): int
    {
        $cageCount = count($this->cages);
        $lastCageIndex = $cageCount - 1;

        $livingCages = $this->livingCages;
        $livingCagesCount = count($livingCages);

        if(empty($livingCages)) {
            $cageIndex = 0;
        } elseif(!empty($livingCages) && $cageCount > $livingCagesCount) {
            $cageIndex = $livingCagesCount;
        } else {
            $cageIndex = mt_rand(0, $lastCageIndex);
        }

        return $cageIndex;
    }

    private function fillCage(int $index): void
    {
        $this->livingCages[] = $index;
    }

    private function refresh(): void
    {
        $this->cages = Cage::all();
        $this->livingCages = [];
    }
}