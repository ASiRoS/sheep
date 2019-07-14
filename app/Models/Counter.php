<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Counter
 * @package App\Models
 *
 * @property bool is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Counter extends Model
{
    public const
        DAY_IN_SECOND = 10,
        DAYS_TO_BE_SLAUGHTERED = 10;

    protected $casts = [
        'is_active' => 'bool',
    ];

    public static function last(): ?self
    {
        return self::latest()->first();
    }

    public static function start()
    {
        $counter = new self;
        $counter->save();

        return $counter;
    }

    public function getDaysPassed(): int
    {
        $now = Carbon::now();

        $diff = $now->diffInSeconds($this->created_at);

        $days = ceil($diff / self::DAY_IN_SECOND);

        return (int) $days;
    }

    public function getDaysToBeSlaughtered(): int
    {
        $days = ceil($this->getDaysPassed() / Counter::DAYS_TO_BE_SLAUGHTERED);

        return (int) $days;
    }
}