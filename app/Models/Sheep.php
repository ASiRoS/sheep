<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Sheep
 * @package App\Models
 *
 * @property int $cage_id
 * @property Cage $cage
 * @property string $name
 */
class Sheep extends Model
{
    public function cage(): BelongsTo
    {
        return $this->belongsTo(Cage::class);
    }

    public function move(Cage $cage)
    {
        $this->cage_id = $cage->id;
        $this->save();
    }
}