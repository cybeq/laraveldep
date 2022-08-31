<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfoModel extends Model
{
    use HasFactory;
    protected $table = 'personal';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'alcohol', 'drugs', 'kids', 'smokes', 'hobby', 'job'];

}
