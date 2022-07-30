#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

use App\Commands\GetTelegramUpdates;

$tu = new GetTelegramUpdates;
$tu->test();