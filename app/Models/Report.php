<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Report
 * @package App\Models
 *
 * @property int $general_sheep_count
 * @property int $killed_sheep_count
 * @property int $alive_sheep_count
 * @property Cage $biggest_cage
 */
class Report extends Model
{
    public function biggestCage()
    {
        return $this->belongsTo(Cage::class);
    }
}