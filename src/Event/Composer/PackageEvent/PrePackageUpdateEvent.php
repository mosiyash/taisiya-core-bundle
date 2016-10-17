<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PrePackageUpdateEvent extends ComposerEvent
{
    const NAME = 'composer.packages.pre_package_update_event';
}
