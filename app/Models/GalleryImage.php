<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $table = 'photos';
    protected $primaryKey = 'id';
    protected $fillable = ['url', 'user_id'];
    use HasFactory;
}
