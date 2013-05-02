# Bcrypt

[![Build Status](https://secure.travis-ci.org/kherge/Bcrypt.png?branch=master)](http://travis-ci.org/kherge/Bcrypt)

Provides a bcrypt function for PHP.

## Installation

To install Bcrypt, you must add it to the list of dependencies in your [`composer.json`][Composer] file.

    $ php composer.phar require kherge/bcrypt=2.*

## Example

```php
$encoded = bcrypt('test');
// $2y$10$JKjL8xFIoy4rdQLw3j26L.zEFs9IWb3tGEsDElPkDmN/.ngm46zYu

echo 'Verified? ', bcrypt_verify('test', $encoded) ? 'Yes' : 'No', "\n";
// Verified? Yes
```

Please see [the wiki][wiki] for more detailed usage information.

[Composer]: http://getcomposer.org/
[wiki]: https://github.com/kherge/RunkitTestCase/wiki
