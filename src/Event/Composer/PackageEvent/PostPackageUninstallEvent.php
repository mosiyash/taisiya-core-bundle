<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Event;

class PostPackageUninstallEvent extends Event
{
    const NAME = 'composer.packages.post_package_uninstall_event';
}
