<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyMan extends Model
{    protected $table = 'partypeople';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'party_id', 'okay'];
    use HasFactory;
}
