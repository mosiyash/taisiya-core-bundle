<?php

namespace Taisiya\CoreBundle\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

class CoreServiceProvider implements ServiceProviderInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * CoreServiceProvider constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function register(Container $pimple)
    {
        $pimple['app'] = function (Container $pimple) {
            return $this->app;
        };
    }
}
