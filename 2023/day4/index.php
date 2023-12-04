<?php

$lines = file(sprintf('%s/%s', __DIR__, isset($argv[2]) ? 'test.txt' : 'input.txt'));

var_dump($lines);