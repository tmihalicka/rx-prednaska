<?php

require_once __DIR__ . '/../vendor/autoload.php';

$deferred = new \React\Promise\Deferred();
$promise = $deferred->promise();

$promise->done(function () {
    echo 'Promise fulfilled';
}, function () {
    echo  'Promise rejected';
});

//$deferred->resolve();
$deferred->reject();