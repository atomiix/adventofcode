<?php

$key = 'yzbqklnj';

for ($i = 0;;$i++) {
    if (str_starts_with(md5($key.$i), '000000')) {
        echo $i . PHP_EOL;
        break;
    }
}