<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Cage
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property Sheep[] $sheep
 */
class Cage extends Model
{
    public function sheep(): HasMany
    {
        return $this->hasMany(Sheep::class);
    }

    public function sheepCount()
    {
        return $this->sheep()->count();
    }

    public function isNotPaired(): bool
    {
        return $this->sheepCount() < 1;
    }

    public function removeLastSheep(int $count)
    {
        if($count > 0) {
            $this->sheep()->latest()->take($count)->delete();
        }
    }
    
    public function getLastSheep(): Sheep
    {
        return $this->sheep()->latest()->first();
    }

    public function addSheep(string $name): Sheep
    {
        $sheep = new Sheep();
        $sheep->name = $name;

        return $this->sheep()->save($sheep);
    }
}