<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\CS\Config\Config;
use Symfony\CS\Finder;

$finder = Finder::create()
    ->files()
    ->in('src')
//    ->in('tests')
    ->name('*.php');

return Config::create()
    ->level(\Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->finder($finder);
