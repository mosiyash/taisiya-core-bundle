<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostPackageUpdateEvent extends ComposerEvent
{
    const NAME = 'composer.packages.post_package_update_event';
}
