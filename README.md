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

###  Configurations

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
