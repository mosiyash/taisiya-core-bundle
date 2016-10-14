<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class PostStatusCmdEvent extends Event
{
    const NAME = 'composer.post_status_cmd_event';
}
