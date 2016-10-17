<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PrePackageUninstallEvent extends ComposerEvent
{
    const NAME = 'composer.packages.pre_package_uninstall_event';
}
