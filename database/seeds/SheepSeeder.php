<?php

use App\Services\Cage\FillerService;
use Illuminate\Database\Seeder;

class SheepSeeder extends Seeder
{
    /**
     * @var FillerService
     */
    private $filler;

    /**
     * SheepSeeder constructor.
     * @param FillerService $filler
     */
    public function __construct(FillerService $filler)
    {
        $this->filler = $filler;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->filler->fill(10);
    }
}
