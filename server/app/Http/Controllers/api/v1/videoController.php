<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\VideoCollection;
use App\Http\Resources\v1\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Traits\fileStorageTrait;
use Illuminate\Support\Facades\DB;
use Abrouter\Client\Client;

class videoController extends Controller
{
    use fileStorageTrait;
    public $video;
    public function __construct(Video $video){
        $this->video = $video;
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'video' => 'required',
        ]);
        $data = array(
            'name' => $request->name,
            'description' => $request->description,
            'video_path' => $this->storageFile($request,'video','videos','video'),
            'user_id' => auth()->user()->id
        );

        $newVideo = $this->video->create($data);
        if($request->image){
            foreach($request->image as $image){
                $newVideo->thumbnail()->create([
                    'image_path' => $this->storageMultipleFile($image,'image','video_thumbnail')
                ]);
            }
        }else{
            $newVideo->thumbnail()->create([
                'image_path' => '/storage/video/videos/1/tuXi4UxLk91LzlS0UYOu.jpg'
            ]);
        }
        return response()->json([
            'code' => 200,
            'data' => new VideoResource($newVideo)
        ],200);
    }

    public function index(Request $request){
        if($request->input('take')){
            $data = $this->video->take($request->input('take'))->get();
        }else if($request->input('paginate')){
            $data = $this->video->paginate($request->input('paginate'));
        }else{
            $data = $this->video->all();
        }
        return  new VideoCollection($data);
    }
    public function show(Request $request, Client $client){
        $videoItem = $this->video->find($request->id);
        if($request->input('thumbnail')) {
            if($videoItem->thumbnail->contains('id',$request->input('thumbnail'))){
                $thumbnail = DB::table('tbl_video_thumbnail')->where('id',$request->input('thumbnail'))->first();
                DB::table('tbl_video_thumbnail')->where('id',$request->input('thumbnail'))->update(['view' => $thumbnail->view + 1]);
            }
        }
        if($videoItem){
            return response()->json([
                'code' => 200,
                'data' => new VideoResource($videoItem)
            ],200);
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'not found'
            ],404);
        }
    }
    public function update(Request $request){
        $videoItem = $this->video->find($request->id);
        if($videoItem){
            $request->validate([
                'name' => 'required',
                'description' => 'required'
            ]);
            $data = array(
                'name' => $request->name,
                'description' => $request->description
            );
            $this->video->find($request->id)->update($data);
            $videoItem = $this->video->find($request->id);
            return response()->json([
                'code' => 200,
                'data' => new VideoResource($videoItem)
            ],200);
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'not found'
            ],404);
        }
    }
    public function delete(Request $request){
        $videoItem = $this->video->find($request->id);
        if($videoItem){
            $videoItem->thumbnail()->delete();
            $this->video->find($request->id)->delete();
            return response()->json([
                'code' => 200,
                'data' => new VideoResource($videoItem)
            ],200);
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'not found'
            ],404);
        }
    }
    public function searchResult(Request $request){
        if($request->input('key')){
            $videos = $this->video->where('name','like','%'.$request->input('key').'%')->get();
            if(empty($videos)){
                return response()->json([
                    'code' => 404,
                    'message' => 'not found'
                ],404);
            }

            return response()->json([
                'code' => 200,
                'data' => new VideoCollection($videos)
            ],200);
        }
        return response()->json([
            'code' => 400,
            'message' => 'key not empty !'
        ],400);
        
            
        
    }
}
