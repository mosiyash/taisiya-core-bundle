<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostAutoloadDumpEvent extends ComposerEvent
{
    const NAME = 'composer.commands.post_autoload_dump_event';
}
