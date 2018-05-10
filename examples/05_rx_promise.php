<?php

require_once __DIR__ . '/../vendor/autoload.php';


class Processor {
    public function process(\React\Promise\PromiseInterface $promise)
    {
        return $promise
            ->then('trim')
            ->then(function (string $text) {
                return str_replace(' ', '-', $text);
            })
            ->then('strtolower');
    }
}

class StreamTextProvider {
    public function getStreamText(string $path, \React\EventLoop\LoopInterface $loop)
    {
        $stream = new \React\Stream\ReadableResourceStream(fopen($path, 'rb'), $loop);

        return \React\Promise\Stream\buffer($stream);
    }
}


$loop = \React\EventLoop\Factory::create();


$processor = new Processor();
$streamText = new StreamTextProvider();
$bufferedText = $streamText->getStreamText(__DIR__ . '/testfile.txt', $loop);

$processor->process($bufferedText)
    ->then(function (string $text) {
        var_dump($text);
    });

$loop->run();

