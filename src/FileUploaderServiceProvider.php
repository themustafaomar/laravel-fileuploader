<?php

namespace FileUploader;

use Illuminate\Support\ServiceProvider;

class FileUploaderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/fileuploader.php', 'fileuploader'
        );

        $this->app->bind('file.uploader', function ($app) {
            return new FileUploaderManager($app->make('config')->get('fileuploader'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->configurePublishing();
        }
    }

    /**
     * Configure publishing for the package
     */
    protected function configurePublishing()
    {
        $this->publishes([
            __DIR__.'/../config/fileuploader.php' => config_path('fileuploader.php'),
        ], 'fileuploader-config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_media_table.stub' => database_path(
                'migrations/'.date('Y_m_d_His', time()).'_create_media_table.php'
            ),
            __DIR__.'/Models/Media.php' => app_path('Models/Media.php'),
        ], 'fileuploader-migrations');
    }
}
