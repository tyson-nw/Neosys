<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\MDtoHTML;

class Monster extends Model
{
    use HasFactory, MDtoHTML;
    protected $fillable =[
        'title',
        'slug',
        'license',
        'source',
        'source_slug',
        'content'
    ];

    protected $anchorToGlossary = TRUE;

    public function getRouteKeyName(){
        return 'slug';
    }
}
