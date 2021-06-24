<?php

namespace FileUploader;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use FileUploader\Contracts\FileUploaderManyInterface;

class FileUploaderMany implements FileUploaderManyInterface
{
    /**
     * @var \Illuminate\Support\Collection $files
     * 
     * An array of files
     */
    protected $files;

    /**
     * @var array $options
     * 
     * The config options
     */
    protected $options;

    /**
     * @var \Illuminate\Support\Collection
     * 
     * The urls of stored images
     */
    protected $urls = [];

    /**
     * Create a new instance
     */
    public function __construct($files, $options)
    {
        $this->files = $files;
        $this->options = $options;
    }

    /**
     * Store a file somewhere
     * 
     * @var string $path
     * @return this
     */
    public function to($path = '/')
    {
        $this->urls = new Collection();

        $this->files->each(function ($file) use ($path) {
            $this->urls->add($file->store($path, $this->getDisk()));
        });

        return $this;
    }

    /**
     * Store the urls in the database
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function toDatabase(Model $model, $columns = [])
    {
        return $model->media()->saveMany($this->getModels($columns));
    }

    /**
     * Get the urls of the stored files
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getUrls()
    {
        return new Collection($this->urls);
    }

    /**
     * Get a collection of image model
     * 
     * @return \Illuminate\Support\Collection
     */
    protected function getModels($columns)
    {
        return $this->urls->map(function ($path) use ($columns) {
            return new $this->options['model'](array_merge(
                [$this->options['url_column'] => $this->getUrl($path)],
                $columns
            ));
        });
    }

    /**
     * Get a url from a given path
     * 
     * @return string
     */
    protected function getUrl($path)
    {
        return Storage::disk($this->getDisk())->url($path);
    }

    /**
     * Get the disk
     * 
     * @return string
     */
    protected function getDisk()
    {
        return $this->options['disk'];
    }
}
