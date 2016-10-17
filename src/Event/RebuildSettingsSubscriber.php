<?php

namespace Taisiya\CoreBundle\Event;

use Taisiya\CoreBundle\Event\Composer\CommandEvent;

class RebuildSettingsSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            CommandEvent::NAME => [
                ['rebuildSettings'],
            ],
        ];
    }

    /**
     * @param CommandEvent $event
     */
    public function rebuildSettings(CommandEvent $event): void
    {
        var_dump($event);
    }
}
