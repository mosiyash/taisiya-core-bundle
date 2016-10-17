<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostCreateProjectCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.post_create_project_cmd_event';
}
