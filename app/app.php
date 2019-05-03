<?php

declare(strict_types=1);

namespace App;

use App\ServiceProvider\ControllerServiceProvider;
use App\ServiceProvider\MiddlewareServiceProvider;
use App\ServiceProvider\RouterServiceProvider;
use Chubbyphp\Framework\Application;
use Chubbyphp\Framework\ErrorHandler;
use Chubbyphp\Framework\ExceptionHandler;
use Chubbyphp\Framework\Middleware\MiddlewareDispatcher;
use Chubbyphp\Framework\Router\FastRouteRouter;
use Pimple\Container;
use Psr\Log\NullLogger;

require __DIR__.'/bootstrap.php';

set_error_handler([ErrorHandler::class, 'handle']);

/** @var Container $container */
$container = require __DIR__.'/container.php';
$container->register(new ControllerServiceProvider());
$container->register(new MiddlewareServiceProvider());
$container->register(new RouterServiceProvider());

$app = new Application(
    $container[FastRouteRouter::class],
    new MiddlewareDispatcher(),
    new ExceptionHandler($container['api-http.response.factory'], new NullLogger(), $container['debug'])
);

return $app;
