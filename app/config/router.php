<?php

$router = $di->getRouter();

// Define your routes here
$router->add(
    'delete/own/:int',
    [
        'controller' => 'delete',
        'action' => 'own',
    ]
);

$router->handle();
