<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class InstallerEvent extends Event
{
    const NAME = 'composer.installer_event';
}
