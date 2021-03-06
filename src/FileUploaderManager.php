<?php

namespace FileUploader;

use FileUploader\FileUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use FileUploader\Contracts\FileUploaderManagerInterface;

class FileUploaderManager implements FileUploaderManagerInterface
{
    /**
     * @var $config
     * 
     * The file uploading config
     */
    protected array $config;

    /**
     * Create new instance of FileUploaderManager
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Handle a file
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * 
     * @return mixed
     */
    public function save(UploadedFile $file)
    {
        return new FileUploader($file, $this->config);
    }

    /**
     * Handle an array of files
     * 
     * @param \Illuminate\Http\UploadedFile[] $files
     * 
     * @return mixed
     */
    public function saveMany(array $files)
    {
        return new FileUploaderMany(
            new Collection($files), $this->config
        );
    }

    /**
     * Get an instance of this class
     * 
     * @return this
     */
    public function getInstance()
    {
        return $this;
    }
}
