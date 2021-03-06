<?php
    namespace App\Traits;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    trait fileStorageTrait {
        public function storageFile($request,$type,$folder,$fiel){
            if($request->hasFile($fiel)){
                $file = $request->file($fiel);
                $hash_name = Str::random(20).'.'.$file->extension();
                $path = $file->storeAs('public/'.$type.'/'.$folder.'/'.auth()->user()->id, $hash_name);
                return  Storage::url($path);
            }
            return null;
        }

        public function storageMultipleFile($file,$type,$folder){
            if($file){
                $hash_name = Str::random(20).'.'.$file->extension();
                $path = $file->storeAs('public/'.$type.'/'.$folder.'/'.auth()->user()->id, $hash_name);
                return  Storage::url($path);
            }
            return null;
        }
    }
?>