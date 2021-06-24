<?php

namespace FileUploader\Contracts;

use Illuminate\Database\Eloquent\Model;

interface FileUploaderInterface
{
    /**
     * Store a file somewhere
     * 
     * @var string $path
     * @return self
     */
    public function to($path = '/');

    /**
     * Store the urls in the database
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Support\Collection
     */
    public function toDatabase(Model $model);

    /**
     * Get the url of the stored file
     * 
     * @return string
     */
    public function getUrl();
}
