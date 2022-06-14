<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Abrouter\Client\Client;
use App\Service\RandomThumbnail;
use Illuminate\Support\Facades\Redis;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $thumbnails = VideoThumbnailResource::collection($this->thumbnail);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'video_path' => $this->video_path,
            'view' => $this->view,
            'like' => $this->like,
            'dislikes' => $this->dislikes,
            'user' => DB::table('users')->where('id',$this->user_id)->first(),
            'thumbnail' => $thumbnails,
            'displayThumbnail' => $this->getDisplayThumbnail($thumbnails),
            'created_at' => $this->created_at
        ];
    }

    public function getDisplayThumbnail($thumbnails){
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

}
