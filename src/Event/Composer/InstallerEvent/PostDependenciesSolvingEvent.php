<?php

namespace Taisiya\CoreBundle\Event\Composer\InstallerEvent;

use Taisiya\CoreBundle\Event\Event;

class PostDependenciesSolvingEvent extends Event
{
    const NAME = 'composer.installer.post_dependencies_solving_event';
}
