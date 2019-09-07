# LaravelMigrationViseVersa

[![Latest Version on Packagist][ico-version]][link-packagist]


## Installation

Via Composer

``` bash
$ composer require yevhenii/laravel-migration-vise-versa
```

## Usage

#### For creating Model from existing table use command:

``` bash
$ php artisan table:model posts
```

Where "posts" is name of table.

Will be created : 
 - model "Post" with fillable array
 
#### For creating Model and Migration from existing table use command:
 
 ``` bash
 $ php artisan table:model posts --m
 ```
 
 Where "posts" is name of table.
 
 Will be created : 
  - model "Post" and migration "create_posts_table"

#### For creating Migration from existing table use command:

``` bash
$ php artisan table:migration posts
```

Where "posts" is name of table.

Will be created : 
 - migration file "create_posts_table"

#### For creating Migration and Model from existing table use command:

``` bash
$ php artisan table:migration posts --m
```

Where "posts" is name of table.

Will be created : 
 - migration file "create_posts_table" and "Post" Model
 
## Security

If you discover any security related issues, please email author email instead of using the issue tracker.


## License

license. Please see the [license file](license.md) for more information.

[link-packagist]: https://packagist.org/packages/yevhenii/laravel-migration-vise-versa
[link-downloads]: https://packagist.org/packages/yevhenii/laravel-migration-vise-versa
[link-author]: https://github.com/zenia9012
