<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\ComposerEvent;

class CommandEvent extends ComposerEvent
{
    const NAME = 'composer.command_event';
}
