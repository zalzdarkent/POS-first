<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Database\factories\UnitFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return UnitFactory::new();
    }
}
