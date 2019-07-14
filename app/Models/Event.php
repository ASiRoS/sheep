<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * @package App\Models
 * @property string $description
 */
class Event extends Model
{
    public static function new(string $description): self
    {
        $event = new self();

        $event->description = $description;
        $event->save();

        return $event;
    }
}