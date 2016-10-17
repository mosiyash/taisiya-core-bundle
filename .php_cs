<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\CS\Config\Config;
use Symfony\CS\Finder;

$finder = Finder::create()
    ->files()
    ->in('src')
    ->in('app')
    ->in('bin')
//    ->in('tests')
    ->name('*.php');

return Config::create()
    ->level(\Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        'align_double_arrow',
        'align_equals',
        'ordered_use',
        'phpdoc_order',
        'short_array_syntax',
        'short_echo_tag',
    ])
    ->finder($finder);
