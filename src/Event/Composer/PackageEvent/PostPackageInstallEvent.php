<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Event;

class PostPackageInstallEvent extends Event
{
    const NAME = 'composer.packages.post_package_install_event';
}
