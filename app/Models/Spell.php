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
        'source',
        'tier',
        'archetypes',
        'casting_time',
        'target',
        'defense',
        'duration',
        'concentration',
        'details',
        'higher_cast',
    ];

    protected $anchorToGlossary = TRUE;
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
}
