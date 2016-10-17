<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Event;

class PostPackageUpdateEvent extends Event
{
    const NAME = 'composer.packages.post_package_update_event';
}
