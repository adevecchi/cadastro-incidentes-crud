<?php

use \Slim\App;
use \App\Controllers\HomeController as Home;
use \App\Controllers\IncidentesController as Incidentes;

$app->get('/', Home::class . ':index');

$app->group('/api', function (App $app) {

    $app->get('/incidentes/pagina/{pagina:[0-9]+}', Incidentes::class . ':getIncidentesPorPagina');

    $app->get('/incidentes/{id:[0-9]+}', Incidentes::class . ':getIncidentes');

    $app->post('/incidentes', Incidentes::class . ':addIncidentes');

    $app->put('/incidentes/{id:[0-9]+}', Incidentes::class . ':updateIncidentes');

    $app->delete('/incidentes/{id:[0-9]+}', Incidentes::class . ':deleteIncidentes');
});