<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThumbnailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnail:run {id}';

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
        $video = DB::table('tbl_videos')->where('id',$this->argument('id'))->first();
        if($video->popular_thumbnail == 0){
             $thumbnailWithHighView = DB::table('tbl_video_thumbnail')->where('video_id',$video->id)->orderBy('view','DESC')->first();
             if($thumbnailWithHighView){
                 DB::table('tbl_videos')->where('id',$video->id)->update(['popular_thumbnail' => $thumbnailWithHighView->id]);
             }
         }
        return 0;
    }
}
