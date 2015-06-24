php-classic
===========

PHP libraries to be used as helpers in any project

[![Build Status](https://travis-ci.org/joni2back/php-classic.svg?branch=master)](https://travis-ci.org/joni2back/php-classic)

#### Include the lib or use PSR-4
```php
//in your app bootstrap
require_once __DIR__ . '/php-classic/src/autoloader.php'; 
```
#### Usages
```php
use PHPClassic\Shell;
use PHPClassic\ConsoleOutput;

$shell = new Shell;
$output = new ConsoleOutput;

$shell->execute('ls', array(__DIR__, '-la'));
$output
  ->setColor('yellow', null, 'bold')
  ->write($shell->getOutput());
```
