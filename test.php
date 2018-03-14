<?php

require_once __DIR__ . '/vendor/autoload.php';


class IntNum
{
    private $num;

    public function __construct(int $num)
    {
        $this->num = $num;
    }

    public function getNum()
    {

    }
}

// Phunkie
ImmList(1, 2, 3, 4, 5, 6, 7, 8, 9, 0)
    ->filter(function (int $i) {
        return $i % 2 === 0;
    })
    ->reduce(function (int $acc, int $i) {
        return $acc + $i;
    });

// Vannila PHP
$array = array_filter([1, 2, 3, 4, 5, 6, 7, 8, 9, 0], function (int $i) {
    return $i % 2 === 0;
});

$array = array_reduce($array, function (int $acc, int $i) {
    return $acc + $i;
}, 0);

var_dump($array);