<?php
define('APP_DIR', __DIR__ . '/app');

use App\ModuloThree;

require_once APP_DIR . '/bootstrap.php';
$modThree = new ModuloThree();
try {
    $modThree->setInput('110');
    echo $modThree->result() . "\n";
    $modThree->setInput('1010');
    echo $modThree->result() . "\n";
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}