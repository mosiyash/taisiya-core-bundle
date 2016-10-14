<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class PostArchiveCmdEvent extends Event
{
    const NAME = 'composer.post_archive_cmd_event';
}
