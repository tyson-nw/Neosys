<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spell extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'slug',
        'license',
        'tier',
        'classes',
        'casting_time',
        'target',
        'defense',
        'duration',
        'concentration',
        'details',
        'higher_cast',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
}
