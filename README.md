# Notitia Visum

[![Build status][Master image]][Master]
[![Coverage Status][Master coverage image]][Master coverage]
[![Latest Stable Version][Stable version image]][Stable version]
[![License][License image]][License]

Notitia Visum is a BREAD (browse, read, edit, add, delete) generator for [Laravel](https://laravel.com/)

### Usage

Brows usage:

```php
/**
 * Inside a controller action
 */
return (new NotitiaVisum())
    ->table('users')
    ->browse();
```

You can add a raw where like this:

```php
return (new NotitiaVisum())
    ->table('users')
    ->whereRaw('role = \'admin\'')
    ->browse();
```

If you want to filter the fields to render in the table, you can add an array of fields:

```php
return (new NotitiaVisum())
    ->table('users')
    ->whereRaw('role = \'admin\'')
    ->browse(['id', 'first_name', 'role']);
```

By default the title on the table is the table name on the database but you can override it like this:

```php
return (new NotitiaVisum())
    ->table('users')
    ->title('System Users')
    ->browse(['id', 'first_name', 'role']);
```

### Tests

```bash
$ vendor/bin/phpunit
```

### Authors

[Adro Rocker](https://github.com/adrorocker)

  [Master]: https://travis-ci.org/adrosoftware/notitia-visum/
  [Master image]: https://travis-ci.org/adrosoftware/notitia-visum.svg?branch=master
  [Master coverage]: https://coveralls.io/github/adrosoftware/notitia-visum
  [Master coverage image]: https://coveralls.io/repos/github/adrosoftware/notitia-visum/badge.svg?branch=master
  [Stable version]: https://packagist.org/packages/adrosoftware/notitia-visum
  [Stable version image]: https://poser.pugx.org/adrosoftware/notitia-visum/v/stable
  [License]: https://packagist.org/packages/adrosoftware/notitia-visum
  [License image]: https://poser.pugx.org/adrosoftware/notitia-visum/license