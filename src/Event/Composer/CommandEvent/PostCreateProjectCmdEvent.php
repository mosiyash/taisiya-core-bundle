<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PostCreateProjectCmdEvent extends Event
{
    const NAME = 'composer.commands.post_create_project_cmd_event';
}
