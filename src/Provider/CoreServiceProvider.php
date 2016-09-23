<?php

namespace Taisiya\CoreBundle\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CoreServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        return $pimple;
    }
}
