<?php

namespace Taisiya\CoreBundle\Composer\Event;

use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventDispatcher;
use Taisiya\CoreBundle\App;
use Taisiya\CoreBundle\Composer\ScriptHandler;
use Taisiya\CoreBundle\Event\Config\RebuildSettingsEvent;

final class DefaultCommandSubscriber implements DefaultCommandSubscriberInterface
{
    const EVENT_CONFIG_REBUILD_SETTINGS = 'config.rebuild_settings';

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptHandler::EVENT_DEFAULT_COMMAND => 'defaultCommandCallback',
        ];
    }

    /**
     * @param Event $event
     */
    public static function defaultCommandCallback(Event $event): void
    {
//        /** @var App $app */
//        $app = $event->getArguments()['app'];
//
//        /** @var EventDispatcher $dispatcher */
//        $dispatcher = $event->getComposer()->getEventDispatcher();
//
//        $rebuildSettingsEvent = new Event(self::EVENT_CONFIG_REBUILD_SETTINGS, ['app' => $app]);
//
//        $dispatcher->dispatch(self::EVENT_CONFIG_REBUILD_SETTINGS, $rebuildSettingsEvent);

        /** @var App $app */
        $app = $event->getArguments()['app'];

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $app->getContainer()['event_dispatcher'];

        $rebuildSettingsEvent = new RebuildSettingsEvent();

        $dispatcher->dispatch(RebuildSettingsEvent::NAME, $rebuildSettingsEvent);
    }
}
