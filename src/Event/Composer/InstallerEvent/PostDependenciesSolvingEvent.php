<?php

namespace Taisiya\CoreBundle\Event\Composer\InstallerEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostDependenciesSolvingEvent extends ComposerEvent
{
    const NAME = 'composer.installer.post_dependencies_solving_event';
}
