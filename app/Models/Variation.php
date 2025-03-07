<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'value',
        'code',
        'extra',
        'active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
