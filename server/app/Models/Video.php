<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','image_path','video_path','like','dislike','view','user_id'];
    protected $table = 'tbl_videos';
    protected $primaryKey = 'id';
}
