<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PreArchiverCmdEvent extends Event
{
    const NAME = 'composer.commands.pre_archive_cmd_event';
}
