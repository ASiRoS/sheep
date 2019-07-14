<?php

use App\Models\Cage;
use Illuminate\Database\Seeder;

class CageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 4; $i++) {
            $cage = new Cage();
            $cage->name = "Загон #$i";
            $cage->save();
        }
    }
}
