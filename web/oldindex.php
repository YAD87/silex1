




    $app->get('/', function () use ($app) {
    return $app['twig']->render('index.html');
})->bind('index');