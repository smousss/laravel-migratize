![Migratize](https://user-images.githubusercontent.com/3613731/233783189-d8343695-d7a0-4778-a0f1-83d44148aae7.png)

# Enjoy the convenience of migrations again

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smousss/laravel-migratize.svg?style=flat-square)](https://packagist.org/packages/smousss/laravel-migratize)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smousss/laravel-migratize/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smousss/laravel-migratize/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smousss/laravel-migratize.svg?style=flat-square)](https://packagist.org/packages/smousss/laravel-migratize)

Whether you are using MariaDB, MySQL, Oracle, PostgreSQL, SQLite, SQL server, or anything else, Smousss generates the missing migrations based on what's currently in your database using the power of GPT-4.

## Installation

Install the package via Composer:

```bash
composer require smousss/laravel-migratize
```

Publish the config file:

```bash
php artisan vendor:publish --tag=migratize-config
```

## Usage

First, [generate a secret key](https://smousss.com/dashboard) on smousss.com.

Then, generate your migrations:

```php
php artisan smousss:migratize
```

## Credit

Migratize for Laravel has been developed by [Benjamin Crozat](https://benjamincrozat.com) for [Smousss](https://smousss.com) ([Twitter](https://twitter.com/benjamincrozat)).

## License

[MIT](LICENSE.md)
