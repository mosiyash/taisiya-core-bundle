<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class PreUpdateCmdEvent extends Event
{
    const NAME = 'composer.pre_update_cmd_event';
}
