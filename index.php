#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

$kernel = new App\Kernel($argv);
$kernel->run();