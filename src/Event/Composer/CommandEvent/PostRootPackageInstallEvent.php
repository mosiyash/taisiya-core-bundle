<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostRootPackageInstallEvent extends ComposerEvent
{
    const NAME = 'composer.commands.post_root_package_install_event';
}
