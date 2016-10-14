<?php

namespace Taisiya\CoreBundle;

use Symfony\Component\Console\Application;
use Taisiya\CoreBundle\Command\RebuildInternalCacheCommand;

final class Console extends Application
{
    /**
     * @var App
     */
    private $app;

    public function __construct(App $app, $name = 'Taisiya Console', $version = 'UNKNOWN')
    {
        $this->app = $app;
        parent::__construct($name, $version);
    }

    /**
     * @return App
     */
    public function getApp(): App
    {
        return $this->app;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCommands()
    {
        $commands = [
            new RebuildInternalCacheCommand($this->app),
        ];

        return array_merge(parent::getDefaultCommands(), $commands);
    }
}
