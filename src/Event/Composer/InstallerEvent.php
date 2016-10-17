<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\ComposerEvent;

class InstallerEvent extends ComposerEvent
{
    const NAME = 'composer.installer_event';
}
