<?php

namespace Taisiya\CoreBundle\Event\Config;

use Taisiya\CoreBundle\Event\Event;

class RebuildSettingsEvent extends Event
{
    const NAME = 'config.rebuild_settings';
}
