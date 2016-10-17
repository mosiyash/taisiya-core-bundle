<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class PostPackageUninstallEvent extends ComposerEvent
{
    const NAME = 'composer.packages.post_package_uninstall_event';
}
