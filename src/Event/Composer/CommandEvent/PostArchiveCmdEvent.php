<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class PostArchiveCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.post_archive_cmd_event';
}
