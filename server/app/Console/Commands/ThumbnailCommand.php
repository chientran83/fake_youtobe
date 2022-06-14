<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ThumbnailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnail:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $videos = DB::table('tbl_videos')->get();
       foreach($videos as $video){
            $thumbnailWithHighView = DB::table('tbl_video_thumbnail')->where('video_id',$video->id)->orderBy('view','DESC')->first();
            if($thumbnailWithHighView){
                DB::table('tbl_videos')->where('id',$video->id)->update(['popular_thumbnail' => $thumbnailWithHighView->id]);
            }
        }
        return 0;
    }
}
