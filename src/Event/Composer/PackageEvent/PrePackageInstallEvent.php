<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Event;

class PrePackageInstallEvent extends Event
{
    const NAME = 'composer.packages.pre_package_install_event';
}
