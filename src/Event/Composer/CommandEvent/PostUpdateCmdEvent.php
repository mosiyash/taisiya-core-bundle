<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostUpdateCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.post_update_cmd_event';
}
