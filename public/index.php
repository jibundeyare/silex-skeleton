<?php

use Silex\Application;
use SilexPhpView\ViewServiceProvider;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Yaml\Yaml;

require __DIR__.'/../vendor/autoload.php';

Debug::enable();

$connectionParams = Yaml::parseFile(__DIR__.'/../config/db.yml');

$app = new Application();

// $app['debug'] = true;

$app->register(new ViewServiceProvider(), [
    'view.path' => __DIR__.'/../templates',
]);

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

