<?php

namespace Taisiya\CoreBundle\Event\Composer\InstallerEvent;

use Taisiya\CoreBundle\Event\Event;

class PreDependenciesSolvingEvent extends Event
{
    const NAME = 'composer.installer.pre_dependencies_solving_event';
}
