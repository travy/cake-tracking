# Cake Tracking Plugin

[![Build Status](https://travis-ci.org/travy/cake-tracking.svg?branch=develop)](https://travis-ci.org/travy/cake-tracking)

## Description

The Cake Tracking Plugin provides Middleware which will record all Request made to a web application.  All logging can
be customized per application but there is also a default logger which will write to the file system.

In addition, external IP addresses can be blacklisted from the site by adding the address to a blacklist file.

## Installation

Add the package to your CakePHP projects `composer.json`

```shell
composer require travy/cake-tracking:1.0
```

Next, be sure to add the plugin to the `config/bootstrap.php` file by executing the following command in the command prompt

```shell
bin/cake plugin load cake-tracking
```

Now the Middleware can be loaded into the application pipeline by appending it to the MiddlewareQueue found in
`src/Application.php'

```php
class Application extends BaseApplication
{
    public function middleware($middlewareQueue)
    {
        $middlewareQueue
            ->add(ErrorHandlerMiddleware::class)
            ->add(AssetMiddleware::class)
            ->add(new RoutingMiddleware($this))
                
            //  add the TrackingMiddleware to the queue
            ->add(new \CakeTracking\Middleware\TrackingMiddleware());

        return $middlewareQueue;
    }
}
```

Finally, you should be able to add any custom configuration necessary to complete the environment.

If you want to use a custom Logger or blacklisting solution (perhaps to store data in a database)
then you just need to create a class which implements either `TrackingLoggerInterface` or `BlacklistRepositoryInterface`.
Then before adding the Middleware to the MiddlewareQueue, you can specify your custom classes
using the built in setter calls.

```php
class Application extends BaseApplication
{
    public function middleware($middlewareQueue)
    {
        //  supply the custom classes to the TrackingMiddleware object
        $trackingMiddleware = new \CakeTracking\Middleware\TrackingMiddleware();
        $trackingMiddleware->setBlacklistRepository(new BlacklistDatabaseRepository($configs));
        $trackingMiddleware->setLoggingOperation(new TrackingDatabaseLoggin($configs));
    
        $middlewareQueue
            ->add(ErrorHandlerMiddleware::class)
            ->add(AssetMiddleware::class)
            ->add(new RoutingMiddleware($this))
                
            //  supply the instantiated tracker to the queue
            ->add($trackingMiddleware);

        return $middlewareQueue;
    }
}
```

##  Configurations

The following configurations are optional but will be useful for system setup.

In `config/app.php` add the following:

```txt
'CakeTracking' => [
    'LogFile' => LOGS . 'bamboo.txt',
    'Blacklist' => LOGS . 'blacklist.txt',
],
```

The LogFile configuration will specify where all Requests should be logged.

Blacklist specifies the location of the blacklist on the system.
