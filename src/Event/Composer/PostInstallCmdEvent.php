<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class PostInstallCmdEvent extends Event
{
    const NAME = 'composer.post_install_cmd_event';
}
