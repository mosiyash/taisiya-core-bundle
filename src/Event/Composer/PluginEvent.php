<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PluginEvent extends ComposerEvent
{
    const NAME = 'composer.plugin_event';
}
