<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/Application.php';
require_once __DIR__.'/../app/FormType.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Extension\Core\Type\FormType;


$app = new Silex\Application();

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views',
));
$app->register(new Silex\Provider\FormServiceProvider());


$app->match('/', function (Request $request) use ($app) {
    // some default data for when the form is displayed the first time
    $data = array(
        'name' => 'Ссылка',
        'email' => 'Время',
        'pass'=>'Пароль',
    );

    $form = $app['form.factory']->createBuilder(FormType::class,$data)
        ->add('name')
        ->add('email')
        ->add('pass')
        ->getForm();

        $form->handleRequest($request);

        return $app['twig']->render('index.twig', array('form' => $form->createView()));
    });



// 404 - Page not found

$app['debug'] = true;

$app->run();