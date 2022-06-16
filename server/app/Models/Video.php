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
    public function getDisplayThumbnail($thumbnails,$popularThumbnail){
        if($popularThumbnail->resource == null){
            $displayThumbnail = $thumbnails[0];
            for( $i = 0; $i < $thumbnails->count(); $i++){
                if(Redis::get($thumbnails[$i]->id)){
                    if(Redis::get($thumbnails[$i]->id) < Redis::get($displayThumbnail->id)){
                        $displayThumbnail = $thumbnails[$i];
                    }
                }else{
                    Redis::set($thumbnails[$i]->id, 0);
                    $displayThumbnail = $thumbnails[$i];
                }
            }
            Redis::set($displayThumbnail->id, Redis::get($displayThumbnail->id) + 1);
            return $displayThumbnail;
        }
        $displayThumbnail = $popularThumbnail;
        return $displayThumbnail;
    }
}
