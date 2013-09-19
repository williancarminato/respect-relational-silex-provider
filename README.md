Respect Relational Service Provider
===================================

Provides Respect Relational Mapper to use as services on Silex applications.

Features
--------

  - Awesome Relational database persistence tool, see [Respect/Relational](https://github.com/Respect/Relational)
  - Multiple databases connections

Requirements
------------

  - PHP 5.3+
  - Respect/Relational

Instalation
-----------

Package available on [Composer](). Autoloading with [composer](http://getcomposer.org/) is [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) compatible.

Usage
-----

To use the provider, register `RespectRelationalServiceProvider` and specify at least one connection.

```php
<?php 
    use Silex\Application;
    use Carminato\Silex\Provider\Respect\RespectRelationalServiceProvider;

    $app = new Application;
    
    $app->register(new RespectRelationalServiceProvider(), array(
            'respect.pdo.instances' => array(new \PDO('sqlite::memory:'))
        )
    );
```

The default Mapper will now be accessible with `respect.mapper` in the app container.

```php
<?php
    $mapper = $app['respect.mapper'];
```

You can pass as many `respect.pdo.instances` as you want.

```php
<?php 
    use Silex\Application;
    use Carminato\Silex\Provider\Respect\RespectRelationalServiceProvider;

    $app = new Application;
    
    $app->register(new RespectRelationalServiceProvider(), array(
            'respect.pdo.instances' => array(
                'mymapper1' => new \PDO('sqlite::memory:'),
                'mymapper2' => new \PDO('sqlite::memory:')
            )
        )
    );
```

And then access each one with his respective array key using the `respect.mappers`.

```php
<?php
    $mapper1 = $app['respect.mappers']['mymapper1']
    $mapper2 = $app['respect.mappers']['mymapper2']
```

Enjoy!
------