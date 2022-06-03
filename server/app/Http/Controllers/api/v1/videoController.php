<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\videoCollection;
use App\Http\Resources\v1\videoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Traits\fileStorageTrait;

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
            'image' => 'required',
            'video' => 'required',
        ]);
        $data = array(
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $this->storageFile($request,'image','videos','image'),
            'video_path' => $this->storageFile($request,'video','videos','video'),
            'user_id' => auth()->user()->id
        );

        $newVideo = $this->video->create($data);
        return response()->json([
            'code' => 200,
            'data' => new videoResource($newVideo)
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
        return  new videoCollection($data);
    }
    
    public function show(Request $request){
        $videoItem = $this->video->find($request->id);
        if($videoItem){
            return response()->json([
                'code' => 200,
                'data' => new videoResource($videoItem)
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
            if($request->hasFile('image')){
                $data['image_path'] = $this->storageFile($request,'image','videos','image');
            }
            $this->video->find($request->id)->update($data);
            $videoItem = $this->video->find($request->id);
            return response()->json([
                'code' => 200,
                'data' => new videoResource($videoItem)
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
            $this->video->find($request->id)->delete();
            return response()->json([
                'code' => 200,
                'data' => new videoResource($videoItem)
            ],200);
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'not found'
            ],404);
        }
    }
}
