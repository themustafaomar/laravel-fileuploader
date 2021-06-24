## Installation

You can install it via [composer](https://getcomposer.org/)

    $ composer require mustafaomar/laravel-fileuploader

## Publishing

Publishing config file `fileuploader.php`
```bash
php artisan vendor:publish --tag=fileuploader-config
```

If you intend to store urls in database via this package, you need to publish the migration and model
```bash
php artisan vendor:publish --tag=fileuploader-migrations
```

If you want publish all
```bash
php artisan vendor:publish --provider="FileUploader\FileUploaderServiceProvider"
```

## Configuration

**`disk`**: A filesystem's disk

**`table`**: The table you want to store urls in

**`model`**: The model class

**`url_column`**: The name of the column you want to store the image link

## Usage

There are serveral ways to start using `laravel-fileuploader`

### Uploadable trait

You can use `Uploadable` in your controller and we're done, you now have access to the `uploader` method, example.

TestController.php

```php
use FileUploader\Traits\Uploadable;

class TestController extends Controller
{
    use Uploadable;
    
    public function store(Request $request)
    {
        $this->uploader()->save($request->file('image'))->to('/products');
    }
}
```

**Notice**: This image will be saved to the storage, and to be more specific it depends on how you're configuring the disk option in the `fileuploader.php` and the default disk is `public`
So, this file will be stored in: `/laravel-app/storage/app/public/products/[hashname]`

#### Getting the url

You may want to get the url to store it in the database, you can return the url as following.

```php
public function store(Request $request)
{
    $this->uploader()->save($request->file('image'))->to('/products')->getUrl(); // /storage/products/[hashname]
}
```

Now you can use `asset(URL)` method to show this image somewhere.

You can also quickly pass the image to the `uploader` method as the first argument, and path as the second.

```php
$this->uploader($request->image, '/products')->getUrl();
```

### Using Facade

```php
use FileUploader\Facades\FileUploader;

public function store(Request $request)
{
    $url = FileUploader::save($request->file('image'))->to('/products')->getUrl();
}
```

### Using app and make method

Just wanted to mention that you can use `make` method to resolve the `fileuploader` from the container.

```php
public function store(Request $request)
{
    app()->make('file.uploader')->save($request->file('images'))->to('/path/to');

    // OR
    app('file.uploader')->save($request->file('images'))->to('/path/to');
}
```

## Saving many files at once

You can of course, pass an array of images to the `uploader` method or using `saveMany` method, let's give it a try.

```php
public function store(Request $request)
{
    $this->uploader($request->images, '/products');
    
    // OR
    
    $this->uploader()->saveMany($request->file('images'))->to('/products')->getUrls(); // Returns: \Illuminate\Support\Collection
}
```

## Saving urls in database

You can save the files in disk and save the generated urls in the database with one line of code, just don't forget to publish the migrations

**Notice**: I assume you have a model for example `Product` and each product has many images, and in order make this work

you have to add a relation within that `Product` like so:

```php

// Product.php

public function media()
{
    return $this->morphMany(Media::class, 'mediable');
}
```

Now you have to pass the newly created `Product` model to `toDatabase` method, see this example

```php
public function store(Request $request)
{
    $product = Product::create($request->all());

    // If you want to add other columns to media table feel free to do that
    // Then you will need to pass these additional columns to Database method as the second paramater
    $this->uploader($request->file('images'), '/products')
         ->toDatabase($product, [
            'other_column' => $request->other_column
         ]);
}
```

Sometimes you may want to get the urls and do whatever you want with them.

```php
public function store(Request $request)
{
    $product = Product::create($request->all());

    $product->media()->saveMany(
        $this->uploader($request->file('images'), '/products')->getUrls()
             ->map(function ($url) {
                return new MyMediaClass(['media_url' => $url]);
             });
    );
}
```
