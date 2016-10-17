<?php

namespace Taisiya\CoreBundle\Event;

use Taisiya\CoreBundle\App;

abstract class ComposerEvent extends \Symfony\Component\EventDispatcher\Event
{
    /**
     * @var App
     */
    private $app;

    /**
     * ComposerEvent constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
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
