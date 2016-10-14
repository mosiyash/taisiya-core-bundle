<?php

namespace Taisiya\CoreBundle;

final class App extends \Slim\App
{
    /**
     * {@inheritdoc}
     */
    public function __construct($container = [])
    {
        parent::__construct($container);

        $this->connectBundles();
    }

    final private function connectBundles(): void
    {
    }
}
