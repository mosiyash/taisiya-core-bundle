<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class PostPackageInstallEvent extends ComposerEvent
{
    const NAME = 'composer.packages.post_package_install_event';
}
