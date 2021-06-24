<?php

return [

    /*
    |--------------------------------------------------------------------------
    | A filesystem's disk
    |--------------------------------------------------------------------------
    |
    | You can add any supported disk within the `filesystems`.`disks` array config
    |
    */
    'disk' => 'public',

    /*
    |--------------------------------------------------------------------------
    | The table you want to store urls in
    |--------------------------------------------------------------------------
    */

    'table' => 'media',

    /*
    |--------------------------------------------------------------------------
    | The model class
    |--------------------------------------------------------------------------
    */

    'model' => \App\Models\Media::class,

    /*
    |--------------------------------------------------------------------------
    | The name of the column you want to store the image link
    |--------------------------------------------------------------------------
    */

    'url_column' => 'url',

];