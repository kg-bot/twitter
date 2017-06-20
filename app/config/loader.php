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
        'Twitter\Models\Posts' => $config->application->modelsDir .'Posts/',
        'Twitter\Models\Users' => $config->application->modelsDir .'Users/',
        'Twitter\Controllers' => $config->application->controllersDir,
        'Twitter\Library\Helpers' => $config->application->libraryDir .'/helpers/',
        'Twitter\Library\Forms' => $config->application->libraryDir .'Forms/',
    ]
);
$loader->register();
