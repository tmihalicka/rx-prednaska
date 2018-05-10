<?php

use React\EventLoop\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

\Rx\Scheduler::setDefaultFactory(function () use ($loop) {
    return new Rx\Scheduler\EventLoopScheduler($loop);
});


[$evenStream, $oddStream] = \Rx\Observable::range(1, 20)
    ->partition(function ($i) {
        return $i % 2 === 0;
    });



$evenStream = $evenStream->map(function (int $i) {
    return $i * 10;
});


$oddStream = $oddStream->map(function (int $i) {
   return $i * 10;
});



$mergedStream = $evenStream->merge($oddStream)
    ->reduce(function (int $acc, int $i) {
        return $acc + $i;
    });


$mergedStream->subscribe(function ($i){
    echo $i.PHP_EOL;
});


$loop->run();