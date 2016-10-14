<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class PreInstallCmdEvent extends Event
{
    const NAME = 'composer.pre_install_cmd_event';
}
