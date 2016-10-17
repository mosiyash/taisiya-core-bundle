<?php

namespace Taisiya\CoreBundle\Event\Composer\InstallerEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PreDependenciesSolvingEvent extends ComposerEvent
{
    const NAME = 'composer.installer.pre_dependencies_solving_event';
}
