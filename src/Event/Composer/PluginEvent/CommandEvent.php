<?php

namespace Taisiya\CoreBundle\Event\Composer\PluginEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class CommandEvent extends ComposerEvent
{
    const NAME = 'composer.plugins.command_event';
}
