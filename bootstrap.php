<?php

use Taisiya\CoreBundle\App;
use Taisiya\CoreBundle\Console;

defined('TAISIYA_ROOT') || define('TAISIYA_ROOT', __DIR__);

require_once TAISIYA_ROOT.'/vendor/autoload.php';

$app = new App(['settings' => require_once TAISIYA_ROOT.'/app/config/settings.php']);

$console = new Console($app);
$app->setConsole($console);

return $app;
