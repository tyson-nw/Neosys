<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\MDtoHTML;

class Page extends Model
{
    use HasFactory, SoftDeletes, MDtoHTML;

    protected $fillable =[
        'title',
        'slug',
        'license',
        'content'
    ];

    public function getRouteKeyName(){
        return 'slug';
    }
}
