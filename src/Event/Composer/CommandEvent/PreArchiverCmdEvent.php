<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class PreArchiverCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.pre_archive_cmd_event';
}
