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
