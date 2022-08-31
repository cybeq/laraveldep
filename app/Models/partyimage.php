<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partyimage extends Model
{
    protected $table = 'partygallery';
    protected $primaryKey = 'id';
    protected $fillable = ['url', 'party_id'];
    use HasFactory;
}
