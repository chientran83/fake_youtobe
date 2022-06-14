<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Abrouter\Client\Client;
use App\Service\RandomThumbnail;

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
        // $displayThumbnail = $thumbnail[rand(0, count($thumbnail)-1)];
        if($thumbnails){
            $currentDisplayThumbnail = VideoThumbnailResource::collection($this->thumbnail)->where('display',1)->first();
            if($currentDisplayThumbnail){
                $ExistDisplayThumbnail = false;
                if($thumbnails[count($thumbnails)-1]->display == 1){
                    DB::table('tbl_video_thumbnail')->where('id',$thumbnails[0]->id)->update(['display' => 1]);
                    $displayThumbnail = $thumbnails[0];
                    DB::table('tbl_video_thumbnail')->where('id',$thumbnails[count($thumbnails)-1]->id)->update(['display' => 0]);
                    //update to 1, that end update to 0
                }else{
                    for($i = 0;$i < count($thumbnails);$i++){
                        if($ExistDisplayThumbnail == false){
                            if($thumbnails[$i]->display == 1){
                                $ExistDisplayThumbnail = true;
                                DB::table('tbl_video_thumbnail')->where('id',$thumbnails[$i]->id)->update(['display' => 0]);
                                //update to 0,
                            }
                        }else{
                            DB::table('tbl_video_thumbnail')->where('id',$thumbnails[$i]->id)->update(['display' => 1]);
                                //update to 1,
                                $displayThumbnail = $thumbnails[$i];
                                break;
                        }
                    }
                }
                    
            }else{
                DB::table('tbl_video_thumbnail')->where('id',$thumbnails[0]->id)->update(['display' => 1]);
                $displayThumbnail = $thumbnails[0];
            }
        }else{
            $displayThumbnail = null;
        }
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
            'displayThumbnail' =>  $displayThumbnail,
            'created_at' => $this->created_at
        ];
    }

}
