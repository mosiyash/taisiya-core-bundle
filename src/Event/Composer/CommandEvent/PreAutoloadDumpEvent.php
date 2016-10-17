<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PreAutoloadDumpEvent extends ComposerEvent
{
    const NAME = 'composer.commands.pre_autoload_dump_event';
}
