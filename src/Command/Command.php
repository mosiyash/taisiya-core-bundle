<?php

namespace Taisiya\CoreBundle\Command;

use Taisiya\CoreBundle\App;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var App
     */
    private $app;

    public function __construct(App $app, $name = null)
    {
        parent::__construct($name);

        $this->app = $app;
    }

    /**
     * @return App
     */
    public function getApp(): App
    {
        return $this->app;
    }
}
