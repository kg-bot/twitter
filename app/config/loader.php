<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();

/**
 * Namespaces
 */
$loader->registerNamespaces(
    [
        'Models\Posts' => 'app/models/posts/',
        'Models\Users' => 'app/models/users/',
        'Twitter\Controllers' => 'app/controllers/',
        'App' => 'app/',
    ]
)->register();
