<?php

use React\EventLoop\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

\Rx\Scheduler::setDefaultFactory(function () use ($loop) {
    return new Rx\Scheduler\EventLoopScheduler($loop);
});


\Rx\Observable::range(1, 20)
    ->filter(function (int $e) {
        return $e % 2 === 0;
    })
    ->subscribe(function ($e) {
        echo $e.PHP_EOL;
    });



$loop->run();