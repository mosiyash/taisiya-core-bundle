<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Event;

class PrePackageUpdateEvent extends Event
{
    const NAME = 'composer.packages.pre_package_update_event';
}
