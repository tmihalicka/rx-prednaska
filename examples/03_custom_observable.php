<?php

require_once __DIR__ . '/../vendor/autoload.php';

use React\EventLoop\Factory;
use Rx\SchedulerInterface;


$loop = Factory::create();

\Rx\Scheduler::setDefaultFactory(function () use ($loop) {
    return new Rx\Scheduler\EventLoopScheduler($loop);
});

$randomFun = function(): int {
    return random_int(1, 10);
};

$customObservable = new class($randomFun, 100, 100, \Rx\Scheduler::getDefault()) extends \Rx\Observable {

    private $randomFunction;
    private $interval;
    private $scheduler;
    /**
     * @var int
     */
    private $maxNumbers;

    /**
     * @param Closure $randomFunction
     * @param int $interval
     * @param int $maxNumbers
     * @param SchedulerInterface $scheduler
     */
    public function __construct(Closure $randomFunction, int $interval, int $maxNumbers, SchedulerInterface $scheduler)
    {
        $this->randomFunction = $randomFunction;
        $this->interval = $interval;
        $this->scheduler = $scheduler;
        $this->maxNumbers = $maxNumbers;
    }

    protected  function _subscribe(\Rx\ObserverInterface $observer): \Rx\DisposableInterface
    {
        $counter = 0;
        return $this->scheduler->schedulePeriodic(function () use (&$observer, &$counter) {


            $number = $this->randomFunction;
            $intNum = (int) $number();


            if ($counter < $this->maxNumbers) {
                $observer->onNext($intNum);
                $counter++;
            } else {
                $observer->onCompleted();
            }

        },
            $this->interval,
            $this->interval
        );
    }
};


$customObservable->map(function (int $i) {
    return $i * 5;
})->doOnNext(function ($e){
    dump($e);
    return $e;
})->reduce(function (int $acc, $i) {
    return $acc + $i;
})->subscribe(function ($e) {
    echo 'stream result is => ' . $e;
    echo PHP_EOL;
}, function ($e) {
    echo 'ooops';
    echo PHP_EOL;
}, function () {
    echo 'stream is complete now!';
    echo PHP_EOL;
});



$loop->run();