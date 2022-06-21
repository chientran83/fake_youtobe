<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','video_path','like','dislike','view','user_id','popular_thumbnail'];
    protected $table = 'tbl_videos';
    protected $primaryKey = 'id';

    public function thumbnail(){
        return $this->hasMany(video_thumbnail::class,'video_id');
    }
    public function popularThumbnail(){
        return $this->belongsTo(video_thumbnail::class,'popular_thumbnail');
    }
    public function user(){
        return $this->hasOne(User::class,'user_id');
    }
    public function getDisplayThumbnail(){
        if(empty($this->popularThumbnail)){
            $displayThumbnail = $this->thumbnail[0];
            for( $i = 0; $i < $this->thumbnail->count(); $i++){
                if(Redis::get($this->thumbnail[$i]->id)){
                    if(Redis::get($this->thumbnail[$i]->id) < Redis::get($displayThumbnail->id)){
                        $displayThumbnail = $this->thumbnail[$i];
                    }
                }else{
                    Redis::set($this->thumbnail[$i]->id, 0);
                    $displayThumbnail = $this->thumbnail[$i];
                }
            }
            Redis::set($displayThumbnail->id, Redis::get($displayThumbnail->id) + 1);
            return $displayThumbnail;
        }else{
            $displayThumbnail = $this->popularThumbnail;
            return $displayThumbnail;
        }

    }
}
