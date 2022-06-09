<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_thumbnail extends Model
{
    use HasFactory;
    protected $fillable = ['image_path','video_id','view'];
    protected $table = 'tbl_video_thumbnail';
    protected $primaryKey = 'id';
}
