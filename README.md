# Toolbox [![Build Status](https://travis-ci.org/Lc5/Toolbox.svg?branch=master)](https://travis-ci.org/Lc5/Toolbox)
Set of development classes and scripts.

## Installation

```
$ git clone https://github.com/Lc5/Toolbox.git
$ cd Toolbox
$ composer install
```

## LoggingSoapClient
 
A SOAP client which logs every request and response using any PSR-3 logger. Can be used out of the box, as it comes
bundled with Monolog and custom ```MessageXmlFormatter```, which pretty-formats logged XML message.

### Usage:
 
```php
use Lc5\Toolbox\LoggingSoapClient\LoggingSoapClient;
use Lc5\Toolbox\LoggingSoapClient\TraceableSoapClient;
use Lc5\Toolbox\LoggingSoapClient\MessageXmlFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$handler = new StreamHandler('path/to/your.log');
$handler->setFormatter(new MessageXmlFormatter());

$logger = new Logger('soap');
$logger->pushHandler($handler);

$soapClient = new LoggingSoapClient(new TraceableSoapClient('http://example.com'), $logger);

```
## Timer

A simple timer used mainly for development purposes.

### Usage:

```php
use Lc5\Toolbox\Timer;

$timer = new Timer();

$timer->start();

//some code to benchmark

echo $timer->getTime() . PHP_EOL; //still running

//more code to benchmark

$timer->stop();

echo $timer->getTime() . PHP_EOL;
```

## AbstractTypedCollection:

An abstract class used to create strictly typed collections implemented as a type-checking wrapper around ```ArrayObject```.
The type of elements in collection is defined by extending ```AbstractTypedCollection``` and implementing abstract
```AbstractTypedCollection::getType``` method. It should return the type as a string, which can be any class name or one
of the internal types in a form recognised by internal [gettype()](http://php.net/manual/en/function.gettype.php) function
(```"boolean", "integer", "double", "string", "array", "object", "resource", "NULL"```). ```\UnexpectedValueException```
will be thrown, when trying to add element with invalid type.
        
### Usage:
  
```php
use Lc5\Toolbox\TypedCollection\AbstractTypedCollection;

class stdClassCollection extends AbstractTypedCollection
{
    public function getType()
    {
        return '\stdClass'; //can be any class or internal type
    }
}

$elements = [new \stdClass(), new \stdClass()];

$collection   = new stdClassCollection($elements);
$collection[] = new \stdClass();

try {
    $collection[] = 'invalid element';
} catch (\UnexpectedValueException $e) {
    echo $e->getMessage(); //Invalid element type: string. Only \stdClass is allowed.
}

try {
    $collection = new stdClassCollection(['invalid', new \stdClass()]);
} catch (\UnexpectedValueException $e) {
    echo $e->getMessage(); //Invalid element type: string. Only \stdClass is allowed.
}

```

## TypedCollection:

A strict typed collection based on ArrayObject. The type of elements in collection is defined using constructor
argument, which can be any class name or one of the internal types in a form recognised by internal
[gettype()](http://php.net/manual/en/function.gettype.php) function (```"boolean", "integer", "double", "string",
"array", "object", "resource", "NULL"```). ```\UnexpectedValueException``` will be thrown, when trying to add element
with invalid type.

### Usage:

```php
use Lc5\Toolbox\TypedCollection\TypedCollection;

$elements = [new \stdClass(), new \stdClass()];

$collection = new TypedCollection('\stdClass', $elements);

```
The behavior is identical as in ```AbstractTypedCollection```.
