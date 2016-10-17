<?php

namespace Taisiya\CoreBundle\Event\Composer\PluginEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PreFileDownloadEvent extends ComposerEvent
{
    const NAME = 'composer.plugins.pre_file_download_event';
}
