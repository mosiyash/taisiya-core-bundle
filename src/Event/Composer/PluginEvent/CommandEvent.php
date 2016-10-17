<?php

namespace Taisiya\CoreBundle\Event\Composer\PluginEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class CommandEvent extends ComposerEvent
{
    const NAME = 'composer.plugins.command_event';
}
