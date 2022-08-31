<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $table = 'party';
    protected $primaryKey = 'id';
    protected $fillable = ['owner_id', 'public', 'minage', 'maxage', ',maxcount',
        'image', 'goal', 'place', 'city', 'region', 'title', 'why', 'start_time'
        ];


    use HasFactory;
}
