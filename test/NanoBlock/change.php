<?php

require __DIR__ . '/../autoload.php';

use MikeRow\NanoPHP\NanoTool;

// Owner data
$private_key = '';
$public_key  = '';
$account     = '';

// Block data
$change_difficulty = 'fffffff800000000';
$representative    = '';

// Initialize NanoRPC and NanoBlock
$nanorpc   = new MikeRow\NanoPHP\NanoRPC();
$nanoblock = new MikeRow\NanoPHP\NanoBlock($private_key);

// Get previous block data
$account_info = $nanorpc->account_info(['account' => $account]);
$block_info   = $nanorpc->block_info([
    'json_block' => true,
    'hash' => $account_info['frontier']
]);

// Generate work
$work = NanoTool::work($account_info['frontier'], $change_difficulty);

// Build block
$nanoblock->setPrev($account_info['frontier'], $block_info['contents']);
$nanoblock->setWork($work);
$nanoblock->change($representative);

// Publish block
$process = $nanorpc->process([
    'json_block' => 'true',
    'block' => $nanoblock->block
]);

// Results and debug
if ($nanorpc->error) {
    echo $nanorpc->error . PHP_EOL;
}

var_dump($process);
