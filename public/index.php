<?php

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SessionServiceProvider;
use SilexPhpView\ViewServiceProvider;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();

$app['debug'] = true;

if ($app['debug']) {
    Debug::enable();
}

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    return new Response('We are sorry, but something went terribly wrong.');
});

$parameters = Yaml::parseFile(__DIR__.'/../config/parameters.yml');

$app->register(new DoctrineServiceProvider(), [
    'db.options' => $parameters['db'],
]);

$app->register(new ViewServiceProvider(), [
    'view.path' => __DIR__.'/../templates',
]);

$app->register(new SessionServiceProvider());

// home
$app->get('/', function() use($app) {
    $message = 'Hello Silex!';

    return $app['view']->render('home.php', [
        'message' => $message,
    ]);
});

// contact
$app->get('/contact', function() use($app) {
    return $app['view']->render('contact.php', [
    ]);
});

$app->run();

