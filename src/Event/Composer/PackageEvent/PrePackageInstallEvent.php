<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class PrePackageInstallEvent extends ComposerEvent
{
    const NAME = 'composer.packages.pre_package_install_event';
}
