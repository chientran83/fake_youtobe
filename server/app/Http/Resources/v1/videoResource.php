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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'video_path' => $this->video_path,
            'view' => $this->view,
            'like' => $this->like,
            'dislikes' => $this->dislikes,
            'user' => DB::table('users')->where('id',$this->user_id)->first(),
            'displayThumbnail' => $this->getDisplayThumbnail(),
            'created_at' => $this->created_at
        ];
    }
    

}
