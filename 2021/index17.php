<?php

$input = file_get_contents('input.txt');

$target = explode(': ', $input);
$target = explode(', ', end($target));

$x = explode('..', substr($target[0], 2));
$y = explode('..', substr($target[1], 2));

$inside = 0;

function isInside($x, $y, $xStart, $yStart, $xEnd, $yEnd) {
    return $x >= $xStart && $x <= $xEnd && $y >= $yStart && $y <= $yEnd;
}


for ($i = $x[1]; $i > 0; $i--) {
    for ($j = abs($y[0]); $j >= $y[0]; $j--) {
        $currentX = 0;
        $currentY = 0;
        $velocityX = $i;
        $velocityY = $j;
        while ($currentX <= $x[1] && $currentY >= $y[0]) {
            if (isInside($currentX, $currentY, $x[0], $y[0], $x[1], $y[1])) {
                $inside++;
                break;
            }
            $currentX += $velocityX;
            $currentY += $velocityY;
            $velocityY--;
            if ($velocityX > 0) {
                $velocityX--;
            }
        }
    }
}

echo $inside . PHP_EOL;