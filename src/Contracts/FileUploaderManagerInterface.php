<?php

namespace FileUploader\Contracts;

use Illuminate\Http\UploadedFile;

interface FileUploaderManagerInterface
{
    /**
     * Handle an array of files
     * 
     * @param \Illuminate\Http\UploadedFile $file an array of files
     * 
     * @return mixed
     */
    public function save(UploadedFile $file);

    /**
     * Handle an array of files
     * 
     * @param \Illuminate\Http\UploadedFile[] $files an array of files
     * 
     * @return mixed
     */
    public function saveMany(array $files);

    /**
     * Get an instance of this class
     * 
     * @return this
     */
    public function getInstance();
}
