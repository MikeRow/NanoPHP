<?php

require __DIR__ . '/../autoload.php';

use MikeRow\NanoPHP\NanoTool;

$burn = NanoTool::string2burn('he11o', '1', '1');

var_dump($burn);
