<?php

use Str;
use Storage;
use Illuminate\Http\UploadedFile;

trait UploadFile {

    /**
     * 
     */
    public function upload(UploadedFile $file, $folder = null, $filename = null, $disk = 'local')
    {
        $name = $filename ??  Str::random(20).'.'.$file->getClientOriginalExtension();
        $folder = $folder ?? 'public/uploads';
        return $file->storeAs($folder, $name, $disk);
    }
}