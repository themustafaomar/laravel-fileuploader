<?php

namespace FileUploader\Contracts;

use Illuminate\Database\Eloquent\Model;

interface FileUploaderManyInterface
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
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function toDatabase(Model $model, $columns = []);

    /**
     * Get the urls of the stored files
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getUrls();
}
