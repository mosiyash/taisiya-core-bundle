<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class PostUpdateCmdEvent extends Event
{
    const NAME = 'composer.post_update_cmd_event';
}
