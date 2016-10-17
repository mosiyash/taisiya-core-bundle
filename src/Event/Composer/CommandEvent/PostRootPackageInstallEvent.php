<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PostRootPackageInstallEvent extends Event
{
    const NAME = 'composer.commands.post_root_package_install_event';
}
