<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\MDtoHTML;

class Source extends Model
{
    use HasFactory, MDtoHTML;

    protected $fillable =[
        'title',
        'slug',
        'license',
        'content',
    ];

    protected $tableofcontents = TRUE;
    protected $tableofcontentslevel = 1;
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
