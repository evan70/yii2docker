<?php

/**
 * Root directory of the project
 */
$root = dirname(__DIR__);

/**
 * Default app aliases, use alias() function to with it
 */
$aliases = [
    '@app' => $root . '/app',

    '@public' => $root . '/public',
    '@resources' => $root . '/resources',
    '@views' => '@resources/views',
    '@assets' => '@public/assets',
    '@storage' => '@public/storage',
    '@runtime' => $root . '/runtime',

    '@vendor' => $root . '/vendor',
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',

    // @web -> base URL
    // @webroot -> base path
];

foreach ($aliases as $key => $path) {
    alias($key, $path);
}