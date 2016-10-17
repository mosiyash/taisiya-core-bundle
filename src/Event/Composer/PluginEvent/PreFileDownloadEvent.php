<?php

namespace Taisiya\CoreBundle\Event\Composer\PluginEvent;

use Taisiya\CoreBundle\Event\Event;

class PreFileDownloadEvent extends Event
{
    const NAME = 'composer.plugins.pre_file_download_event';
}
