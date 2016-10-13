<?php

use Slim\App;

defined('TAISIYA_ROOT') || define('TAISIYA_ROOT', __DIR__);

require ROOT_DIR.'/vendor/autoload.php';

$app = new App(require ROOT_DIR.'/app/config/settings.php');

return $app;
