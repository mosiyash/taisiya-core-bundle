<?php

namespace Taisiya\CoreBundle;

use JBZoo\PimpleDumper\PimpleDumper;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class App extends \Slim\App
{
    /**
     * {@inheritdoc}
     */
    public function __construct($container = [])
    {
        parent::__construct($container);

        $this->getContainer()['event_dispatcher'] = function (Container $pimple) {
            return new EventDispatcher();
        };

        if (class_exists(PimpleDumper::class)) {
            $this->getContainer()->register(new PimpleDumper());
        }

        $this->connectBundles();
    }

    final private function connectBundles(): void
    {
    }
}
