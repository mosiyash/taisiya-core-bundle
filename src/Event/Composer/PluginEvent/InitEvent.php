<?php

namespace Taisiya\CoreBundle\Event\Composer\PluginEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class InitEvent extends ComposerEvent
{
    const NAME = 'composer.plugins.init_event';
}
