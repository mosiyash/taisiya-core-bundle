<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class PreArchiveCmdEvent extends Event
{
    const NAME = 'composer.pre_archive_cmd_event';
}
