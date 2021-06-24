<?php

namespace FileUploader\Traits;

use FileUploader\Facades\FileUploader;

trait Uploadable
{
    /**
     * Quickly start uploading files or get the instance
     * 
     * @param mixed $files
     * @return \FileUploader\FileUploaderManager
     */
    public function uploader($files = false, $path = '/')
    {
        $uploader = FileUploader::getInstance();

        if ($files instanceof \Illuminate\Http\UploadedFile) {
            return $uploader->save($files)->to($path);
        } else if (is_array($files)) {
            return $uploader->saveMany($files)->to($path);
        }

        return $uploader;
    }
}
