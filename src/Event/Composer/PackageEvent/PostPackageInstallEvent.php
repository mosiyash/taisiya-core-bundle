<?php

namespace Taisiya\CoreBundle\Event\Composer\PackageEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostPackageInstallEvent extends ComposerEvent
{
    const NAME = 'composer.packages.post_package_install_event';
}
