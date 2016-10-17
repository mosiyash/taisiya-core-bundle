<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostStatusCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.post_status_cmd_event';
}
