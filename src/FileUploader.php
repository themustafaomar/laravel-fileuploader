<?php

namespace FileUploader;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use FileUploader\Contracts\FileUploaderInterface;

class FileUploader implements FileUploaderInterface
{
    /**
     * @var $file
     * 
     * The file to work with
     */
    protected $file;

    /**
     * @var $url
     * 
     * Url
     */
    protected $url;

    /**
     * @var $options
     * 
     * Options
     */
    protected $options;

    /**
     * Create new instance of FileUploader
     */
    public function __construct(UploadedFile $file, array $options)
    {
        $this->file = $file;
        $this->options = $options;
    }

    /**
     * Store the file in a given pre-configured disk
     * 
     * @param string $path
     * @return \App\FileUploader\FileUploader
     */
    public function to($path = '/', $return_url = false)
    {
        $this->url = $this->file->store($path, $this->options['disk']);

        if ($return_url) {
            return $this->getUrl();
        }

        return $this;
    }

    /**
     * Save the url in the database
     * 
     * @param \Illuminate\Database\Eloquent\Model|Closure $model
     */
    public function toDatabase(Model $model)
    {
        return $model->media()->create([
            $this->options['url_column'] => $this->getUrl()
        ]);
    }

    /**
     * Get the pre-configured model class with columns for saving
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        $options = $this->options;

        return new $options['model']([
            $options['url_column'] => $this->getUrl()
        ]);
    }

    /**
     * Get url
     * 
     * @return string
     */
    public function getUrl()
    {
        return Storage::disk($this->options['disk'])->url($this->url);
    }

    /**
     * Get the file name
     * 
     * @return string
     */
    protected function getFilename()
    {
        return $this->file->hashName();
    }
}
