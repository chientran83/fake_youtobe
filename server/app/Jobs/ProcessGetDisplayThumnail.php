<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessGetDisplayThumnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if( $this->video->popular_thumbnail == 0){
             $thumbnailWithHighView = DB::table('tbl_video_thumbnail')->where('video_id', $this->video->id)->orderBy('view','DESC')->first();
             if($thumbnailWithHighView){
                $this->video->update(['popular_thumbnail' => $thumbnailWithHighView->id]);
             }
         }
    }
}
