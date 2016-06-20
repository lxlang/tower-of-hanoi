<?php

require_once "vendor/autoload.php";

$Hanoi = new TowerOfHanoi(30);

// add moveNumbers as targets, so their state will be saved and be available after calculation
$Hanoi->addTargets([
    175970000,
    247560000,
    553600000,
]);

//start gathering facts and values
$Hanoi->start();

//get fetch your values
$disc = $Hanoi->getMovedDisc(553600000);
$from = $Hanoi->getFrom(175970000);
$to = $Hanoi->getTo(247560000);

print_r([
    'disc' => $disc,
    'from' => $from,
    'to' => $to,
]);