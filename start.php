<?php

require_once "vendor/autoload.php";

$Hanoi = new TowerOfHanoi(30);
// add needed values of the tower
$Hanoi->addTargets([
    20000,
    100000,
    110000,
    1000000,
    11040000,
    33010000,
    33160000,
    175970000,
    212610000,
    247560000,
    266720000,
    315200000,
    315280000,
    397820000,
    553600000,
    554860000,
    663250000,
    675840000,
    728960000,
    815030000,
    839680000,
    883060000,
    970890000,
    987520000,
    1032960000,
    1033010000,
]);

//start gathering facts and values
$Hanoi->start();

//make calculations
$D = $Hanoi->getMovedDisc(553600000) - $Hanoi->getMovedDisc(554860000);
$E = $Hanoi->getMovedDisc(728960000) - $Hanoi->getFrom(175970000) - $Hanoi->getTo(212610000) - $Hanoi->getTo(33010000) - $Hanoi->getFrom(1000000);
$F = $Hanoi->getTo(247560000) + $Hanoi->getMovedDisc(663250000) - $Hanoi->getMovedDisc(883060000) + $Hanoi->getTo(33160000);
$G = $Hanoi->getMovedDisc(315280000) - $Hanoi->getMovedDisc(883060000) - $Hanoi->getTo(100000);
$H = $Hanoi->getMovedDisc(675840000) + $Hanoi->getFrom(1032960000) - $Hanoi->getMovedDisc(839680000) - $Hanoi->getTo(397820000);
$I = $Hanoi->getMovedDisc(315200000) - $Hanoi->getMovedDisc(11040000) - $Hanoi->getTo(987520000) + $Hanoi->getMovedDisc(815030000);
$J = $Hanoi->getMovedDisc(110000) - $Hanoi->getTo(20000);
$K = $Hanoi->getTo(970890000) + $Hanoi->getTo(266720000) + $Hanoi->getFrom(1033010000);

//echo the calculated Coordinates
echo "\n\nFinale: N 50° 3{$D}.{$E}{$F}{$G} E 8° 4{$H}.{$I}{$J}{$K}";