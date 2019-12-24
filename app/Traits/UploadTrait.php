<?php

use Str;
use Illuminate\Http\UploadedFile;

trait UploadTrait {

    /**
     * 
     */
    public function upload(UploadedFile $file, $folder = null, $filename = null, $visibility)
    {
        $name = $filename ??  Str::random(20).'.'.$file->getClientOriginalExtension();
        $folder = $folder ?? 'public/uploads';
        $options = [
            'visibility' => $visibility
        ];
        return $file->storeAs($folder, $name, $options);
    }
}