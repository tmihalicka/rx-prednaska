<?php

require_once __DIR__ . '/../vendor/autoload.php';

$loop = \React\EventLoop\Factory::create();

class StreamTextProvider {
    public function getStreamText(string $path, \React\EventLoop\LoopInterface $loop)
    {
        $stream = new \React\Stream\ReadableResourceStream(fopen($path, 'rb'), $loop);

        return \React\Promise\Stream\buffer($stream);
    }
}


$streamTextProvider = new StreamTextProvider();
$textStream = $streamTextProvider->getStreamText(__DIR__ . '/testfile.txt', $loop);

$promiseObservable = Rx\React\Promise::toObservable($textStream);

$promiseObservable->map(function (string $text) {
    return explode(' ', $text);
})->subscribe(function ($text) {
    var_dump($text);
});



$loop->run();


