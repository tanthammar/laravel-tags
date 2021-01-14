# Spatie tags without Spatie laravel translatable
* name col = string, not json
* slug col = string, not json
* does not use Spatie laravel-translatable package

# Use the `type` column for translations
I love Spatie tags, but my app requires **_both translated tags and generic tags_** that disregards language settings.

# Installation
Add this to `composer.json`
```php 
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/tanthammar/laravel-tags"
    },
```

Add this to `composer.json`
```
"spatie/laravel-tags": "dev-tina as 3.0.2"
```

Terminal
```
composer update
```

# Create tags with translations
This fork uses the `type` column to **_optionally_** set the language.
You have to set the language when you create a tag if you want to retrieve it in a defined language.

Example, create tags in English
```php 
$model->syncTagsWithType([...], 'en');
```
### Use **snake-casing** for the type with the language as suffix
Example create tags in English with type `foo`
```php 
$model->syncTagsWithType([...], 'foo-en');
```
Example create tags in Swedish with type `foo`
```php 
$model->syncTagsWithType([...], 'foo-sv');
```

# Get translated tags
* You have to set a language in the `type` col when creating the tag, in order to later retrieve it, in a specific locale
* This fork has a modified version of `tagsTranslated()`
* If you don't pass the `$locale` attribute, the method falls back to `app()->getLocale()`
* Function: `tagsTranslated($type = null, $locale = null)`

Example, get tags in **_current locale_**
```php
$model->tagsTranslated();
```
Example, get tags in English
```php
$model->tagsTranslated('en');
```
Example, get tags in Swedish
```php
$model->tagsTranslated('sv');
```
Example, get tags with type `foo` in **_current locale_**
```php
$model->tagsTranslated('foo');
```
Example, get tags with type `foo` with specified language (this example = English)
```php
$model->tagsTranslated('foo', 'en');
```

# Compatible with Spatie Nova Tags field
* Follow the same strategy as described when creating tags to **optionally** set the language with the `->type()` method.
* Remember that you have to create relationships for **_each tag type_**, on the Model, if you want to use **_multiple_** tag fields in Nova.
* https://github.com/spatie/nova-tags-field

Example
```php
// in your Nova resource

public function fields(Request $request)
{
    return [
        // Create tags with category 'foo' in English
        Tags::make('Tags', 'foo_en')->type('foo-en'),

        // Create tags with category 'foo' in Swedish
        Tags::make('Tags', 'foo_sv')->type('foo-sv'),
    ];
}

// in your Model
 public function foo_en()
{
    return $this
        ->tags()
        ->where('type', 'foo-en');
}

public function foo_sv()
{
    return $this
        ->tags()
        ->where('type', 'foo-sv');
}
```

# Read the parent package docs:

--------------
# Add tags and taggable behaviour to a Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-tags.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-tags)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/spatie/laravel-tags/run-tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-tags.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-tags)

This package offers taggable behaviour for your models. After the package is installed the only thing you have to do is add the `HasTags` trait to an Eloquent model to make it taggable. 

But we didn't stop with the regular tagging capabilities you find in every package. Laravel Tags comes with batteries included. Out of the box it has support for [translating tags](https://docs.spatie.be/laravel-tags/v2/advanced-usage/adding-translations), [multiple tag types](https://docs.spatie.be/laravel-tags/v2/advanced-usage/using-types) and [sorting capabilities](https://docs.spatie.be/laravel-tags/v2/advanced-usage/sorting-tags).

You'll find the documentation on https://docs.spatie.be/laravel-tags/v2/introduction/.

Here are some code examples:

```php
//create a model with some tags, don't forget to put "tags" on $fillable array on referred model
$newsItem = NewsItem::create([
   'name' => 'The Article Title',
   'tags' => ['first tag', 'second tag'], //tags will be created if they don't exist
]);

//attaching tags
$newsItem->attachTag('third tag');
$newsItem->attachTag('third tag','some_type');
$newsItem->attachTags(['fourth tag', 'fifth tag']);
$newsItem->attachTags(['fourth_tag','fifth_tag'],'some_type');

//detaching tags
$newsItem->detachTags('third tag');
$newsItem->detachTags('third tag','some_type');
$newsItem->detachTags(['fourth tag', 'fifth tag']);
$newsItem->detachTags(['fourth tag', 'fifth tag'],'some_type');

//syncing tags
$newsItem->syncTags(['first tag', 'second tag']); // all other tags on this model will be detached

//syncing tags with a type
$newsItem->syncTagsWithType(['category 1', 'category 2'], 'categories'); 
$newsItem->syncTagsWithType(['topic 1', 'topic 2'], 'topics'); 

//retrieving tags with a type
$newsItem->tagsWithType('categories'); 
$newsItem->tagsWithType('topics'); 

//retrieving models that have any of the given tags
NewsItem::withAnyTags(['first tag', 'second tag'])->get();

//retrieve models that have all of the given tags
NewsItem::withAllTags(['first tag', 'second tag'])->get();

//translating a tag
$tag = Tag::findOrCreate('my tag');
$tag->setTranslation('name', 'fr', 'mon tag');
$tag->setTranslation('name', 'nl', 'mijn tag');
$tag->save();

//getting translations
$tag->translate('name'); //returns my name
$tag->translate('name', 'fr'); //returns mon tag (optional locale param)

//convenient translations through taggable models
$newsItem->tagsTranslated();// returns tags with slug_translated and name_translated properties
$newsItem->tagsTranslated('fr');// returns tags with slug_translated and name_translated properties set for specified locale

//using tag types
$tag = Tag::findOrCreate('tag 1', 'my type');

//tags have slugs
$tag = Tag::findOrCreate('yet another tag');
$tag->slug; //returns "yet-another-tag"

//tags are sortable
$tag = Tag::findOrCreate('my tag');
$tag->order_column; //returns 1
$tag2 = Tag::findOrCreate('another tag');
$tag2->order_column; //returns 2

//manipulating the order of tags
$tag->swapOrder($anotherTag);
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-tags.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-tags)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Requirements

This package requires Laravel 5.8 or higher, PHP 7.2 or higher and a database that supports `json` fields and MySQL compatible functions.

## Installation

You can install the package via composer:

``` bash
composer require spatie/laravel-tags
```

The package will automatically register itself.

You can publish the migration with:
```bash
php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="migrations"
```

After the migration has been published you can create the `tags` and `taggables` tables by running the migrations:

```bash
php artisan migrate
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [

    /*
     * The given function generates a URL friendly "slug" from the tag name property before saving it.
     * Defaults to Str::slug (https://laravel.com/docs/5.8/helpers#method-str-slug)
     */
    'slugger' => null, 
];
```

## Documentation
You'll find the documentation on [https://docs.spatie.be/laravel-tags/v2](https://docs.spatie.be/laravel-tags/v2).

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving the `laravel-tags` package? Feel free to [create an issue on GitHub](https://github.com/spatie/laravel-tags/issues), we'll try to address it as soon as possible.

If you've found a bug regarding security please mail [freek@spatie.be](mailto:freek@spatie.be) instead of using the issue tracker.

## Testing

1. Copy `.env.example` to `.env` and fill in your database credentials.
2. Run `composer test`.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
