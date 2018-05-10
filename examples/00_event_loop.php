<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Create Event Loop
$loop = React\EventLoop\Factory::create();

$tick1 = 0;
$tick2 = 0;

// Add Timer to event loop
$loop->addPeriodicTimer(1, function () use (&$tick1) {
    $tick1++;
    echo "Tick => 1 sec =>  " . $tick1 . "\n";
});

// Add Another Timer to event loop
$loop->addPeriodicTimer(10, function () use (&$tick2) {
    $tick2++;
    echo "Tick => 10 sec =>  " . $tick2 . "\n";
});

// Run Event Loop
$loop->run();