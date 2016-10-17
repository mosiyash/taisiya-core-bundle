<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PackageEvent extends ComposerEvent
{
    const NAME = 'composer.package_event';
}
