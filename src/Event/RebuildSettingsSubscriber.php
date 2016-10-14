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
                'onComposerCommandEvent',
            ],
        ];
    }

    /**
     * @param CommandEvent $event
     */
    public function onComposerCommandEvent(CommandEvent $event): void
    {

    }
}
