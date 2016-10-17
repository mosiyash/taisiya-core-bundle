<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Event;

class PrePackageUninstallEvent extends Event
{
    const NAME = 'composer.packages.pre_package_uninstall_event';
}
